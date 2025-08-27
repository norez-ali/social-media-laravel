<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sociala - Verify Email</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favicon.png') }}" />
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #fafafa;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center">
    <div class="flex flex-col items-center justify-center w-full max-w-sm">

        <!-- Card -->
        <div class="bg-white border border-gray-300 rounded-md w-full p-10 mb-4 text-center">
            <h1 class="text-blue-600 text-4xl font-extrabold mb-6">
                Sociala.
            </h1>

            <h2 class="text-lg font-semibold text-gray-800 mb-3">
                Verify Your Email Address
            </h2>

            <p class="text-gray-500 text-sm mb-6">
                Thanks for signing up! Before getting started, please verify your email by clicking on the link
                we just sent to <span
                    class="font-medium text-gray-700">{{ Auth::user()->email ?? 'your email' }}</span>.
                If you didn’t receive it, we will gladly send you another.
            </p>

            @if (session('status') == 'verification-link-sent')
                <div class="bg-green-100 text-green-600 text-sm p-2 rounded mb-3">
                    A new verification link has been sent to your email address.
                </div>
            @endif

            <form method="POST" action="{{ route('verification.send') }}" class="mb-4">
                @csrf
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold py-2 px-4 rounded-md w-full">
                    Resend Verification Email
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-semibold py-2 px-4 rounded-md w-full">
                    Log Out
                </button>
            </form>
        </div>
    </div>
</body>

</html>
