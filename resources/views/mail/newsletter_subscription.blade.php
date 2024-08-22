<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsletter Subscription</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333333;
        }
        .container {
            background-color: #ffffff;
            margin: 30px auto;
            max-width: 650px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border-left: 1px solid #056F3B; /* Add left border */
            border-right: 1px solid #056F3B; /* Add right border */
        }
        .header {
            background-color: #056F3B;
            padding: 30px 20px;
            text-align: center;
            color: #ffffff;
        }
        .header img {
            max-width: 120px;
            margin-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 18px;
            font-weight: 300;
        }
        .content {
            padding: 30px 40px;
            line-height: 1.8;
            color: #555555;
            text-align: left; /* Align content to the left */
        }
        .content p {
            margin: 15px 0;
            font-size: 16px;
        }
        .content h2 {
            color: #056F3B;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 20px;
        }
        .cta-button {
            display: inline-block;
            background-color: #F99E1F;
            color: #ffffff;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 8px;
            margin-top: 30px;
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s ease;
        }
        .cta-button:hover {
            background-color: #e38c1a;
        }
        .footer {
            background-color: #056F3B;
            color: #ffffff;
            text-align: center;
            padding: 20px;
            font-size: 14px;
        }
        .footer p {
            margin: 5px 0;
            font-size: 11px;
        }
        .footer a {
            color: #F99E1F;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            {{-- <img src="{{ url('/') }}/frontend/images/{{$global['logo']}}" alt="Company Logo"> <!-- Base64 logo --> --}}
            <h1>Welcome to INGO Forum</h1>
            <p>Your Gateway to Impactful Change</p>
        </div>
        <div class="content">
            <h2>Thank You for Subscribing!</h2>
            <p>Dear Subscriber,</p>
            <p>Thank you for subscribing to the INGO Forum newsletter. We’re excited to share our latest updates, insights, and news with you. Expect regular communications filled with valuable content tailored to keep you informed and engaged.</p>
            <p>Stay connected with us and be part of a global network striving to create a better world.</p>
            <p>Best regards,<br>The INGO Forum Team</p>
            <a href="{{ url('/') }}" class="cta-button">Visit Our Website</a>
        </div>
        <div class="footer">
            <p>&copy; 2024 INGO Forum. All rights reserved.</p>
            <p><a href="{{ route('unsubscribe', ['token' => $subscriber->subscription_token]) }}">Unsubscribe</a> | <a href="{{ url('/privacy-policy') }}">Privacy Policy</a></p>
        </div>
    </div>
</body>
</html>
