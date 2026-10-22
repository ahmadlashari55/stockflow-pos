@extends('layouts.admin')

@section('title', 'Point of Sale (POS)')

@section('content')
<style>
    .product-card { cursor: pointer; transition: 0.2s; }
    .product-card:hover { transform: scale(1.02); box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
    .cart-table { max-height: 400px; overflow-y: auto; }
</style>

<div class="row">
    <!-- Left Side: Products List -->
    <div class="col-md-7">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <input type="text" id="searchProduct" class="form-control" placeholder="Search products by name or SKU...">
            </div>
            <div class="card-body" style="max-height: 600px; overflow-y: auto;">
                <div class="row g-3" id="productList">
                    @foreach($products as $product)
                    <div class="col-md-4 product-item" data-name="{{ strtolower($product->name) }}" data-sku="{{ strtolower($product->sku) }}">
                        <div class="card product-card h-100" onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->selling_price }}, {{ $product->stock_quantity }})">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" style="height: 100px; object-fit: cover;">
                            @else
                                <div class="bg-light d-flex justify-content-center align-items-center" style="height: 100px;">
                                    <i class="bi bi-image fs-1 text-muted"></i>
                                </div>
                            @endif
                            <div class="card-body p-2 text-center">
                                <h6 class="mb-1 text-truncate" title="{{ $product->name }}">{{ $product->name }}</h6>
                                <small class="text-muted d-block">Stock: {{ $product->stock_quantity }}</small>
                                <strong class="text-success">Rs {{ number_format($product->selling_price, 2) }}</strong>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Right Side: Cart & Checkout -->
    <div class="col-md-5">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white py-3">
                <h5 class="mb-0"><i class="bi bi-cart"></i> Shopping Cart</h5>
            </div>
            <div class="card-body">
                <!-- Customer Select -->
                <div class="mb-3">
                    <label class="form-label">Customer (Optional)</label>
                    <select id="customerId" class="form-select">
                        <option value="">Walk-in Customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->phone }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Cart Items -->
                <div class="cart-table mb-3">
                    <table class="table table-sm table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Item</th>
                                <th width="70">Qty</th>
                                <th>Price</th>
                                <th width="40">Action</th>
                            </tr>
                        </thead>
                        <tbody id="cartItems">
                            <tr><td colspan="4" class="text-center text-muted">Cart is empty</td></tr>
                        </tbody>
                    </table>
                </div>

                <!-- Totals -->
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal:</span>
                    <strong id="subtotal">Rs 0.00</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Discount:</span>
                    <input type="number" id="discount" class="form-control form-control-sm w-25 text-end" value="0" min="0" onchange="updateTotals()">
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-3">
                    <h5>Total:</h5>
                    <h5 class="text-primary" id="totalAmount">Rs 0.00</h5>
                </div>

                <!-- Payment -->
                <div class="mb-3">
                    <label class="form-label">Paid Amount (Cash)</label>
                    <input type="number" id="paidAmount" class="form-control form-control-lg" value="0" min="0" oninput="calculateChange()">
                </div>
                <div class="d-flex justify-content-between mb-3 text-danger">
                    <span>Change Return:</span>
                    <strong id="changeAmount">Rs 0.00</strong>
                </div>

                <button class="btn btn-success w-100 btn-lg" id="checkoutBtn" onclick="processCheckout()" disabled>
                    <i class="bi bi-check-circle"></i> Complete Sale
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let cart = [];
    let discount = 0;

    // 1. Product search function
    document.getElementById('searchProduct').addEventListener('keyup', function() {
        let searchTerm = this.value.toLowerCase();
        let items = document.querySelectorAll('.product-item');
        
        items.forEach(item => {
            let name = item.getAttribute('data-name');
            let sku = item.getAttribute('data-sku');
            if (name.includes(searchTerm) || sku.includes(searchTerm)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    });

    // 2. Add to cart
    function addToCart(id, name, price, maxStock) {
        let existingItem = cart.find(item => item.id === id);
        
        if (existingItem) {
            if (existingItem.qty < maxStock) {
                existingItem.qty++;
            } else {
                alert('Not enough stock available!');
            }
        } else {
            if (maxStock > 0) {
                cart.push({ id: id, name: name, price: price, qty: 1, maxStock: maxStock });
            } else {
                alert('Out of stock!');
                return;
            }
        }
        updateCartUI();
    }

    // 3. Update Cart Table
    function updateCartUI() {
        let tbody = document.getElementById('cartItems');
        tbody.innerHTML = '';

        if (cart.length === 0) {
            tbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted">Cart is empty</td></tr>';
            document.getElementById('checkoutBtn').disabled = true;
            updateTotals();
            return;
        }

        document.getElementById('checkoutBtn').disabled = false;

        cart.forEach((item, index) => {
            tbody.innerHTML += `
                <tr>
                    <td>${item.name}</td>
                    <td>
                        <input type="number" class="form-control form-control-sm text-center" value="${item.qty}" min="1" max="${item.maxStock}" onchange="updateQty(${index}, this.value)">
                    </td>
                    <td>Rs ${(item.price * item.qty).toFixed(2)}</td>
                    <td>
                        <button class="btn btn-sm btn-danger" onclick="removeFromCart(${index})"><i class="bi bi-x"></i></button>
                    </td>
                </tr>
            `;
        });

        updateTotals();
    }

    // 4. Update Quantity
    function updateQty(index, newQty) {
        newQty = parseFloat(newQty);
        if (newQty > cart[index].maxStock) {
            alert('Not enough stock available!');
            cart[index].qty = cart[index].maxStock;
        } else if (newQty <= 0) {
            cart[index].qty = 1;
        } else {
            cart[index].qty = newQty;
        }
        updateCartUI();
    }

    // 5. Remove from cart
    function removeFromCart(index) {
        cart.splice(index, 1);
        updateCartUI();
    }

    // 6. Calculate Totals
    function updateTotals() {
        let subtotal = 0;
        cart.forEach(item => { subtotal += (item.price * item.qty); });
        
        discount = parseFloat(document.getElementById('discount').value) || 0;
        let total = subtotal - discount;
        
        if (total < 0) total = 0;

        document.getElementById('subtotal').innerText = 'Rs ' + subtotal.toFixed(2);
        document.getElementById('totalAmount').innerText = 'Rs ' + total.toFixed(2);
        
        calculateChange();
    }

    // 7. Calculate Change
    function calculateChange() {
        let total = parseFloat(document.getElementById('totalAmount').innerText.replace('Rs ', '')) || 0;
        let paid = parseFloat(document.getElementById('paidAmount').value) || 0;
        let change = paid - total;
        
        document.getElementById('changeAmount').innerText = 'Rs ' + (change > 0 ? change.toFixed(2) : '0.00');
    }

    // 8. AJAX Checkout
    function processCheckout() {
        let total = parseFloat(document.getElementById('totalAmount').innerText.replace('Rs ', '')) || 0;
        let paid = parseFloat(document.getElementById('paidAmount').value) || 0;

        if (cart.length === 0) return alert('Cart is empty!');
        if (paid < total) return alert('Paid amount is less than total!');

        document.getElementById('checkoutBtn').innerHTML = 'Processing...';
        document.getElementById('checkoutBtn').disabled = true;

        let data = {
            customer_id: document.getElementById('customerId').value,
            cart_items: cart,
            discount: document.getElementById('discount').value,
            paid_amount: paid,
            _token: '{{ csrf_token() }}'
        };

        fetch('{{ route('pos.store') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Sale Completed Successfully! Invoice generated.');
                // Hum agle phase mein yahan invoice page par redirect karenge
                window.location.href = '/sales/' + data.sale_id + '/receipt'; 
            } else {
                alert('Error: ' + data.message);
                document.getElementById('checkoutBtn').innerHTML = '<i class="bi bi-check-circle"></i> Complete Sale';
                document.getElementById('checkoutBtn').disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Something went wrong!');
            document.getElementById('checkoutBtn').innerHTML = '<i class="bi bi-check-circle"></i> Complete Sale';
            document.getElementById('checkoutBtn').disabled = false;
        });
    }
</script>
@endpush