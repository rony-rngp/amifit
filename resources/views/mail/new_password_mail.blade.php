<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set New Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background-color: #4CAF50;
            color: #fff;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .email-body {
            margin: 20px 0;
            font-size: 16px;
            color: #333;
        }
        .email-footer {
            text-align: center;
            padding: 20px;
            font-size: 14px;
            color: #777;
        }
        .button {
            background-color: #4CAF50;
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
            font-weight: bold;
        }
        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<div class="email-container">
    <!-- Header Section -->
    <div class="email-header">
        <h1>Set Your New Password</h1>
    </div>

    <!-- Body Section -->
    <div class="email-body">
        <p>Hello, {{ $user->name }}</p>
        <p>Thank you for registering with us! To complete your registration, please click the button below to set your new password:</p>

        <div style="text-align: center">
            <a href="{{ route('user.set_new_password', ['user_id' => \Illuminate\Support\Facades\Crypt::encrypt($user->id), 'password' => base64_encode($password)]) }}" target="_blank" class="button">Set New Password</a>
        </div>

        <p>If you did not register for an account, please ignore this email.</p>
    </div>

    <!-- Footer Section -->
    <div class="email-footer">
        <p>Thank you,<br>{{ get_settings('website_name') }}</p>
    </div>
</div>
</body>
</html>
