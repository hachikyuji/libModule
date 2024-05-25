<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home | PLM Library</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            position: relative;
            margin: 0;
            font-family: 'Figtree', sans-serif;
            min-height: 100vh;
            background-color: #f3f4f6; /* Fallback background color */
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background-image: url('/images/Plm1.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
            opacity: 0.4;
            z-index: -1; /* Place the pseudo-element behind other content */
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .header {
            font-size: 2.5rem; /* Adjust the font size for the header */
            font-weight: 600;
            color: #1E40AF; /* Set the color to blue */
            margin-bottom: 20px; /* Adjust margin as needed */
        }

        .login-button {
            display: block;
            width: 50%;
            max-width: 200px;
            background-color: rgba(252, 211, 77, 1);
            color: #fff;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 10px;
            border-radius: 0.375rem;
            text-align: center;
            text-decoration: none;
        }
    </style>
</head>
<body class="antialiased">
    <div class="login-container">
        @if (Route::has('login'))
            <div class="lg:p-36 md:p-52 sm:20 p-8 w-full lg:w-1/2 flex flex-col items-center">
                @auth
                    @if(auth()->user()->account_type == 'admin')
                        <a href="{{ url('/dashboard') }}" class="header mb-4">Welcome Back!</a>
                    @elseif(auth()->user()->account_type == 'patron')
                        <a href="{{ url('/patron_dashboard') }}" class="header mb-4">Welcome Back!</a>
                    @else
                        <!-- Handle other account types or provide a default action -->
                        <p>Unknown account type</p>
                    @endif
                @else
                    <h1 class="header mb-4" style="text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);">PLM LIBRARY</h1>
                    <a href="{{ route('login') }}" class="login-button">Log In</a>
                    <div class="mt-4 text-center bg-white bg-opacity-50 rounded">
                        <p class="mt-4 text-center text-gray-600" >
                         Or <a href="{{ route('plm_library') }}" class="text-blue-500">browse PLM library</a> without signing in
                    </p>
                    </div>
                @endauth
            </div>
        @endif
    </div>
</body>
</html>
