@extends('layouts.app')
@section('content')

<div class="max-w-3xl mx-auto p-6 bg-white rounded-2xl shadow mt-10">

    <h1 class="text-3xl font-bold text-[#654321] mb-6 text-center">Checkout</h1>

    <form id="checkout-form" action="{{ route('checkout.place') }}" method="POST">
        @csrf

      <input type="hidden" name="product_ids" value="{{ implode(',', $items->pluck('product.id')->toArray()) }}">
<input type="hidden" name="total_amount" value="{{ $total }}">

        <input type="hidden" id="payment_method" name="payment_method" value="cash">

        <!-- NAME -->
        <div class="mb-3">
            <label class="block font-semibold">Name</label>
            <input type="text" name="name" value="{{ auth()->user()->name }}" class="w-full border rounded px-3 py-2" required>
        </div>

        <!-- ADDRESS -->
        <div class="mb-3">
            <label class="block font-semibold">Address</label>
            <input type="text" name="address" class="w-full border rounded px-3 py-2" required>
        </div>

        <!-- CITY -->
        <div class="mb-3">
            <label class="block font-semibold">City</label>
            <input type="text" name="city" class="w-full border rounded px-3 py-2" required>
        </div>

        <!-- PHONE -->
        <div class="mb-3">
            <label class="block font-semibold">Phone</label>
            <input type="text" name="phone" value="{{ auth()->user()->phone ?? '' }}" class="w-full border rounded px-3 py-2" required>
        </div>

        <!-- PAYMENT METHOD -->
        <div class="mb-3">
            <label class="block font-semibold">Payment Method</label>
            <select id="payment-select" class="w-full border rounded px-3 py-2">
                <option value="cash" selected>Cash On Delivery</option>
                <option value="online">Online</option>
            </select>
        </div>

        <!-- ORDER SUMMARY -->
        <div class="mt-4 p-4 border rounded">
            <h2 class="font-semibold mb-2">Order Summary</h2>
            @foreach($items as $item)
                <p>{{ $item->product->name }} - ₹{{ $item->product->price }}</p>
            @endforeach
            <p class="font-bold mt-2">Total: ₹{{ $total }}</p>
        </div>

        <!-- SUBMIT -->
        <div class="text-center mt-6">
            <button type="submit" class="bg-[#654321] text-white px-6 py-3 rounded-xl">
                Place Order
            </button>
        </div>

    </form>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
document.getElementById('payment-select').addEventListener('change', function() {
    document.getElementById('payment_method').value = this.value;
});



document.getElementById('checkout-form').addEventListener('submit', function(e){
    let paymentType = document.getElementById('payment_method').value;
    if(paymentType === 'online'){
        e.preventDefault(); // form submit rok do

        let productIds = "{{ implode(',', $items->pluck('product.id')->toArray()) }}";
        let totalAmount = {{ $total }};

        fetch("{{ route('payment.create') }}", {
            method: 'POST',
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ amount: totalAmount })
        })
        .then(res => res.json())
        .then(data => {
            let options = {
                key: data.key,
                amount: data.amount * 100,
                currency: "INR",
                name: "Your Store",
                description: "Order Payment",
                order_id: data.orderId,
                handler: function(response){
                    fetch("{{ route('payment.verify') }}", {
                        method: 'POST',
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            razorpay_order_id: response.razorpay_order_id,
                            razorpay_payment_id: response.razorpay_payment_id,
                            razorpay_signature: response.razorpay_signature,
                            product_ids: productIds,
                            total_amount: totalAmount,
                            name: document.querySelector('input[name="name"]').value,
                            address: document.querySelector('input[name="address"]').value,
                            city: document.querySelector('input[name="city"]').value,
                            phone: document.querySelector('input[name="phone"]').value
                        })
                    })
                    .then(res => res.json())
                    .then(res => {
                        if(res.success){
                            window.location.href = "/order/success/" + res.orderId;
                        } else {
                            alert(res.message);
                        }
                    });
                },
                theme: { color: "#3399cc" }
            };
            let rzp = new Razorpay(options);
            rzp.open();
        });
    }
});
</script>

@endsection
