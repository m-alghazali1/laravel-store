<!DOCTYPE html>
<html>
<head>
    <title>Stripe Checkout</title>
</head>
<body>
    <h2>ادفع 10 دولار</h2>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('checkout.charge') }}" method="POST" id="payment-form">
        @csrf
        <script
            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
            data-key="{{ env('STRIPE_KEY') }}"
            data-amount="1000"
            data-name="Laravel Test Store"
            data-description="Test Payment"
            data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
            data-locale="auto"
            data-currency="usd">
        </script>
    </form>
</body>
</html>
