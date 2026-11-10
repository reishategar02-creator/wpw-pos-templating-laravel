<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout Midtrans</title>
</head>
<body>
<button id="pay-button">Bayar Sekarang</button>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.clientKey') }}"></script>
<script>
document.getElementById('pay-button').addEventListener('click', function () {
    fetch('/checkout', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(res => res.json())
    .then(data => {
        window.snap.pay(data.snap_token, {
            onSuccess: function(result) {
                alert("Pembayaran sukses!");
            },
            onPending: function(result) {
                alert("Menunggu pembayaran...");
            },
            onError: function(result) {
                alert("Pembayaran gagal!");
            }
        });
    });
});
</script>
</body>
</html>