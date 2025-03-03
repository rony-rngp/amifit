<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set New Password</title>
    <style>
        /* Basic Reset */
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
        }

        /* Centering the container div */
        .full-page {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            background-color: #f4f4f4;
        }

        .container {
            width: 100%;
            max-width: 600px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            box-sizing: border-box; /* Ensures padding is included in width calculation */
        }

        /* Header Section */
        .header {
            background-color: #4CAF50;
            color: #fff;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }

        /* Content Section */
        .content {
            margin: 20px 0;
            font-size: 16px;
            color: #333;
        }

        /* Footer Section */
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 14px;
            color: #777;
        }

        /* Input Fields */
        .input-field {
            width: 100%;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
            box-sizing: border-box; /* Ensures padding is included in width calculation */
        }

        /* Submit Button */
        .submit-button {
            background-color: #4CAF50;
            color: white;
            padding: 15px 30px;
            border-radius: 5px;
            border: none;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
            box-sizing: border-box; /* Ensures padding is included in width calculation */
        }

        .submit-button:hover {
            background-color: #45a049;
        }

        /* Error Message */
        .error {
            color: red;
            font-size: 14px;
        }
    </style>
</head>
<body>
<!-- Full page container to center the content -->
<div class="full-page">
    <div class="container">
        <!-- Header Section -->
        <div class="header">
            <h1>Set Your New Password</h1>
        </div>

        <!-- Content Section -->
        <div class="content">
            <p>Hello, {{ $user->name }}</p>
            <p>Please enter a new password below to complete your account setup:</p>

            <form method="POST" action="{{ route('user.set_new_password', ['user_id' => \Illuminate\Support\Facades\Crypt::encrypt($user->id), 'password' => base64_encode($password)]) }}" >
                @csrf
                <input type="password" name="password" class="input-field" placeholder="Enter new password" required>
                @error('password')
                <p class="error">{{ $message }}</p>
                @enderror
                <input type="password" name="password_confirmation" class="input-field" placeholder="Confirm new password" required>
                @error('password_confirmation')
                <p class="error">{{ $message }}</p>
                @enderror


                <button type="submit" class="submit-button">Set New Password</button>
            </form>

        </div>

        <!-- Footer Section -->
        <div class="footer">
            <p>Thank you,<br>{{ get_settings('website_name') }}</p>
        </div>
    </div>
</div>
</body>
</html>
