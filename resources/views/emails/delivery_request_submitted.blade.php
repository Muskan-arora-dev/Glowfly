<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Delivery Request Submitted</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fb;
            margin: 0;
            padding: 0;
        }
        .email-wrapper {
            max-width: 600px;
            margin: 30px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            overflow: hidden;
            border-top: 6px solid #2563eb; /* GlowFly blue top stripe */
        }
        .email-header {
            background-color: #2563eb;
            color: #fff;
            padding: 20px;
            text-align: center;
            font-size: 22px;
            font-weight: bold;
        }
        .email-body {
            padding: 25px;
            color: #333;
        }
        .email-body h2 {
            color: #f59e0b; /* orange alert color */
        }
        .email-body p {
            line-height: 1.6;
        }
        .btn {
            display: inline-block;
            padding: 12px 25px;
            margin-top: 20px;
            background-color: #10b981; /* green button */
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }
        .footer {
            padding: 15px;
            text-align: center;
            font-size: 12px;
            color: #999;
            background-color: #f4f7fb;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-header">
            GlowFly Delivery Partner
        </div>
        <div class="email-body">
            <h2>⏳ Your request is under review!</h2>
            <p>Hello <strong>{{ $user->name }}</strong>,</p>
            <p>Thank you for applying to become a delivery partner with <strong>GlowFly</strong>.</p>
            <p>Your request has been successfully submitted and is now <strong>under review</strong> by our team.</p>
            <p>Once approved, you can start delivering and earning with GlowFly.</p>

            <a href="{{ route('home') }}" class="btn">Visit GlowFly</a>
        </div>
        <div class="footer">
            GlowFly Team &copy; {{ date('Y') }}
        </div>
    </div>
</body>
</html>
