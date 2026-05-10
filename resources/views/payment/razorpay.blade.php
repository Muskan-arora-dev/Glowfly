<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<button id="rzp-button" class="px-6 py-3 bg-blue-600 text-white rounded-lg">
    Pay Now
</button>

<script>
var options = {
    "key": "{{ $key }}",
    "amount": "{{ $order->total_amount * 100 }}",
    "currency": "INR",
    "name": "Your Store",
    "description": "Order Payment",
    "order_id": "{{ $razorpayOrder['id'] }}",

    "handler": function (response){
        window.location.href = "/payment/success/{{ $order->id }}?payment_id=" + response.razorpay_payment_id;
    },

    "theme": { "color": "#3399cc" }
};

document.getElementById('rzp-button').onclick = function(e){
    e.preventDefault();
    var rzp = new Razorpay(options);
    rzp.open();
}
</script>
