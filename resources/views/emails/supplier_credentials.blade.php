<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Supplier Credentials</title>
</head>
<body style="font-family: Arial;">

    <h2>Welcome {{ $supplier->name }}</h2>

    <p>Your supplier account has been created.</p>

    <p><strong>Username:</strong> {{ $username }}</p>
    <p><strong>Password:</strong> {{ $password }}</p>

    <p>Please login and change your password.</p>

    <br>
    <p>Thank you,<br>Glowfly Team</p>

</body>
</html>
