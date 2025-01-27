<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Orders</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS (after Bootstrap CSS) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/shopMVC2/public/css/style.css">
</head>
<style>
    /* Custom styles for static price summary and accordion */
    .static-summary {
        position: sticky;
        top: 0;
        background: #fff;
        padding: 20px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .accordion-button:focus {
        box-shadow: none;
    }

    .cart-summary {
        margin-top: 20px;
    }

    .custom-btn {
        padding: 12px 20px;
        font-size: 16px;
        font-weight: bold;
        text-transform: uppercase;
        border-radius: 30px;
        margin-top: 20px;
        box-shadow: 0 4px 8px rgba(0, 128, 0, 0.2);
        transition: all 0.3s ease;
    }

    .custom-btn:hover {
        background-color: #28a745;
        transform: translateY(-2px);
    }

    .custom-btn:disabled {
        background-color: #d6d6d6;
        cursor: not-allowed;
    }

    body {
        background-color: #f5f5f5;
        font-family: Arial, sans-serif;
    }

    .cart-item {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        padding: 15px;
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .cart-item img {
        width: 150px;
        height: auto;
        border-radius: 8px;
    }

    .cart-item-details {
        flex-grow: 1;
        margin-left: 20px;
    }

    .cart-item-details h5 {
        font-size: 18px;
        margin-bottom: 5px;
    }

    .cart-item-details p {
        margin: 0;
    }

    .cart-item-details .text-success {
        font-weight: bold;
    }

    .cart-item-actions {
        display: flex;
        flex-direction: column;
        gap: 10px;
        text-align: center;
    }

    .cart-item-actions .quantity-controls {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .cart-item-actions .quantity-controls span {
        min-width: 30px;
        text-align: center;
        font-size: 14px;
        font-weight: bold;
    }

    .cart-summary {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        padding: 20px;
        position: sticky;
        top: 20px;
    }

    .cart-summary h5 {
        margin-bottom: 20px;
        font-weight: bold;
    }

    .cart-summary p {
        margin: 0;
    }

    .cart-summary .total {
        font-size: 18px;
        font-weight: bold;
        color: #333;
    }

    .cart-summary .text-success {
        font-size: 14px;
        font-weight: bold;
    }

    .custom-btn {
        padding: 12px 20px;
        font-size: 16px;
        font-weight: bold;
        text-transform: uppercase;
        border-radius: 30px;
        margin-top: 20px;
        box-shadow: 0 4px 8px rgba(0, 128, 0, 0.2);
        transition: all 0.3s ease;
    }

    .custom-btn:hover {
        background-color: #28a745;
        transform: translateY(-2px);
    }

    .custom-btn:disabled {
        background-color: #d6d6d6;
        cursor: not-allowed;
    }

    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f8f9fa;
    }

    .payment-container {
        max-width: 600px;
        margin: 50px auto;
        padding: 20px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .payment-timer {
        font-size: 16px;
        color: #ff5722;
        text-align: center;
        margin-bottom: 20px;
    }

    .payment-methods .payment-option {
        margin: 10px 0;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .payment-methods label {
        font-size: 14px;
        font-weight: bold;
        cursor: pointer;
    }

    .payment-methods .sub-options {
        margin-left: 20px;
        display: none;
    }

    .payment-methods input[type="radio"]:checked+label+.sub-options {
        display: block;
    }

    .price-details {
        border-top: 1px solid #ddd;
        margin-top: 20px;
        padding-top: 10px;
    }

    .price-details p,
    .price-details h4 {
        margin: 10px 0;
        font-size: 14px;
    }

    .price-details h4 {
        font-size: 18px;
        color: #333;
    }
</style>

@include('inc.header')
<div class="container my-5">
    <h1 class="text-center mb-4">Your Orders</h1>

    @if(!empty($cartItems))
    <div class="row">
        <!-- Order Summary Accordion -->
        <div class="col-md-8">
            <div class="accordion" id="orderAccordion">
                <!-- Order Summary -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#orderSummary" aria-expanded="false" aria-controls="orderSummary">
                            <strong>Order Summary</strong>
                        </button>
                    </h2>
                    <div id="orderSummary" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#orderAccordion">
                        <div class="accordion-body">
                            @foreach($cartItems as $item)
                            <div class="cart-item">
                                <img src="{{ asset('storage/' . $item->product->images->first()->image_path) }}" alt="{{ $item->product_name }}" class="img-fluid">
                                <div class="cart-item-details">
                                    <h5>{{ $item->product->name  }}</h5>
                                    <p class="text-muted">{{ $item->product_description }}</p>
                                    <p>
                                        <span class="text-muted text-decoration-line-through">Rs {{ number_format($item->original_price, 2) }}</span>
                                        <span class="text-success">Rs {{ number_format($item->product->price, 2) }}</span>
                                        <span class="text-danger">(% off)</span>
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Delivery Address -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#deliveryAddress" aria-expanded="false" aria-controls="deliveryAddress">
                            <strong>Delivery Address</strong>
                        </button>
                    </h2>
                    <div id="deliveryAddress" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#orderAccordion">
                        <div class="accordion-body">
                            @foreach($addresses as $address)
                            @php
                            $addressParts = explode(',', $address->address);
                            @endphp
                            <div class="cart-item d-flex justify-content-between align-items-center">
                                <p class="mb-0"><span class="text-primary">{{ $address->address }}</span></p>
                                <div class="d-flex align-items-center">
                                    <form method="POST" action="{{ route('user.addAddress') }}" id="addressForm" class="mb-0">
                                        @csrf
                                        <input type="hidden" name="selected_address_id" value="{{ $address->id }}">
                                        <button class="btn btn-outline-success btn-sm" type="submit">Select</button>
                                    </form>
                                    <button type="button" class="btn btn-outline-primary btn-sm me-2 edit-address-btn"
                                        data-id="{{ $address->id }}"
                                        data-line1="{{ isset($addressParts[0]) ? trim($addressParts[0]) : '' }}"
                                        data-city="{{ isset($addressParts[1]) ? trim($addressParts[1]) : '' }}"
                                        data-state="{{ isset($addressParts[2]) ? trim($addressParts[2]) : '' }}"
                                        data-zip="{{ isset($addressParts[3]) ? trim($addressParts[3]) : '' }}"
                                        data-country="{{ isset($addressParts[4]) ? trim($addressParts[4]) : '' }}"
                                        data-bs-toggle="modal" data-bs-target="#editAddressModal">
                                        Edit
                                    </button>


                                    @include('address.editAddress')

                                    <!-- Delete Button: Pass the address ID to the modal -->
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAddressModal"
                                        onclick="deleteAddress('{{ $address->id }}')">
                                        Delete
                                    </button>


                                    @include('address.deleteAddress')


                                </div>
                            </div>
                            @endforeach
                            <div class="text-center mt-4">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addressModal">
                                    Add Address
                                </button>
                            </div>
                            @include('address.addAddress')
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#paymentMethod" aria-expanded="false" aria-controls="paymentMethod">
                            <strong>Payment Method</strong>
                        </button>
                    </h2>
                    <div id="paymentMethod" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#orderAccordion">
                        <div class="accordion-body">
                            <div class="payment-methods">
                                <div class="payment-option">
                                    <input type="radio" id="upi" name="payment" value="UPI" />
                                    <label for="upi">UPI</label>
                                </div>

                                <div class="payment-option">
                                    <input type="radio" id="paypal" name="payment" value="PayPal" />
                                    <label for="paypal">PayPal</label>
                                </div>

                                <div class="payment-option">
                                    <input type="radio" id="stripe" name="payment" value="Stripe" />
                                    <label for="stripe">Stripe</label>
                                </div>

                                <div class="payment-option">
                                    <input type="radio" id="cod" name="payment" value="COD" />
                                    <label for="cod">Cash on Delivery</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary -->
        <div class="col-md-4">
            <div class="cart-summary">
                <h5>PRICE DETAILS</h5>
                <hr>
                <div class="d-flex justify-content-between">
                    <p>Price ({{ $totalItems }} items)</p>
                    <p>Rs {{ number_format($totalPrice, 2) }}</p>
                </div>
                <div class="d-flex justify-content-between">
                    <p>Discount</p>
                    <p class="text-success">- Rs 0</p>
                </div>
                <div class="d-flex justify-content-between">
                    <p>Delivery Charges</p>
                    <p class="text-success">Free</p>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <h6>Total Amount</h6>
                    <h6>Rs {{ number_format($totalPrice - 0, 2) }}</h6>
                </div>
                <div class="text-center mt-4">
                    <form action="{{ route('payment') }}" method="POST">
                        @csrf
                        <input type="hidden" id="selectedAddressText" name="selected_address_id">
                        <input type="hidden" id="selectedPaymentMethod" name="payment_method">
                        <button class="btn btn-success btn-lg">Proceed to Payment</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    @else
    <div class="text-center">
        <p>Your cart is empty. Add products to the cart to proceed.</p>
    </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit-address-btn');

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Declare and initialize all variables
                const id = this.dataset.id || '';
                const line1 = this.dataset.line1 || '';
                const city = this.dataset.city || '';
                const state = this.dataset.state || '';
                const zip = this.dataset.zip || '';
                const country = this.dataset.country || '';

                // Log values to ensure they are correctly captured
                console.log({
                    id,
                    line1,
                    city,
                    state,
                    zip,
                    country
                });



                // Populate modal fields
                document.getElementById('editAddressId').value = id;
                document.getElementById('editLine1').value = line1;
                document.getElementById('editCity').value = city;
                document.getElementById('editState').value = state;
                document.getElementById('editZip').value = zip;
                document.getElementById('editCountry').value = country;

                const form = document.getElementById('editAddressForm');
                form.action = `/addresses/update/${id}`;
            });
        });
    });

    function deleteAddress(id) {
        // Set the form action with the correct ID
        const deleteForm = document.getElementById('deleteAddressForm');
        deleteForm.action = `/addresses/delete/${id}`;

        // Open the modal
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteAddressModal'));
        deleteModal.show();
    }

    document.querySelectorAll('.btn-outline-success').forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault();
        const addressText = this.closest('.cart-item').querySelector('p span').textContent.trim(); // Get the address text
        document.getElementById('selectedAddressText').value = addressText; // Set it in the hidden field
        alert(`Address selected: ${addressText}`);
    });
});

document.querySelectorAll('input[name="payment"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const paymentMethod = this.value; // Get selected payment method
        document.getElementById('selectedPaymentMethod').value = paymentMethod; // Set it in the hidden field
        alert('Payment method selected successfully!');
    });
});

</script>