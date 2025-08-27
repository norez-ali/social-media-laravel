<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sociala - Verify Email</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon.png') }}" />
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #fafafa;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col items-center justify-center">
    <div class="flex flex-col items-center justify-center w-full max-w-sm">

        <!-- Card -->
        <div class="bg-white border border-gray-300 rounded-md w-full p-10">
            <h1 class="text-blue-600 text-4xl font-extrabold text-center mb-6">
                Sociala.
            </h1>

            <!-- Success Message -->
            @if (session('status') == 'verification-link-sent')
                <div id="success-message"
                    class="bg-green-100 text-green-700 text-sm p-2 rounded mb-3 text-center w-full">
                    A new verification link has been sent to <strong>{{ Auth::user()->email }}</strong>.
                </div>
            @endif

            <!-- Instruction -->
            <p class="text-gray-700 text-sm text-center mb-4">
                Thanks for signing up! Before getting started, please verify your email address by clicking the
                link we just sent to <strong>{{ Auth::user()->email }}</strong>.
            </p>

            <!-- Resend Verification Link -->
            <form method="POST" action="{{ route('verification.send') }}" class="mb-3">
                @csrf
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold py-2 w-full rounded-md">
                    Resend Verification Email
                </button>
            </form>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-semibold py-2 w-full rounded-md">
                    Log Out
                </button>
            </form>
        </div>

        <!-- Back to login -->
        <div class="bg-white border border-gray-300 rounded-md w-full p-6 mt-4 text-center text-sm">
            Already verified? <a href="{{ route('login') }}" class="text-blue-500 font-semibold hover:underline">Log
                In</a>
        </div>
    </div>
</body>

</html>
