@guest
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sociala - Reset Password</title>
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

    <body class="min-h-screen flex items-center justify-center">
        <div class="flex flex-col items-center justify-center w-full max-w-sm">

            <!-- Reset Password Card -->
            <div class="bg-white border border-gray-300 rounded-md w-full p-10 mb-4">
                <h1 class="text-blue-600 text-4xl font-extrabold text-center mb-6">
                    Sociala.
                </h1>

                <p class="text-gray-500 text-center mb-6 text-sm">
                    Set a new password for your account.
                </p>

                <!-- Display Validation Errors -->
                @if ($errors->any())
                    <div class="bg-red-100 text-red-600 text-sm p-2 rounded mb-3">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.store') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">
                    <input type="hidden" name="email" value="{{ old('email', $request->email) }}">

                    <!-- Password -->
                    <div class="mb-3">
                        <input type="password" id="password" name="password"
                            class="bg-gray-50 border border-gray-300 focus:border-gray-400 focus:ring-0 rounded-sm w-full py-2 px-3 text-sm"
                            placeholder="New Password" required autofocus />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-3">
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="bg-gray-50 border border-gray-300 focus:border-gray-400 focus:ring-0 rounded-sm w-full py-2 px-3 text-sm"
                            placeholder="Confirm Password" required />
                    </div>

                    <!-- Submit -->
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold py-2 w-full rounded-md">
                        Reset Password
                    </button>
                </form>
            </div>

            <!-- Back to login -->
            <div class="bg-white border border-gray-300 rounded-md w-full p-6 text-center text-sm">
                Remember your password?
                <a href="{{ route('login') }}" class="text-blue-500 font-semibold hover:underline">Log In</a>
            </div>
        </div>
    </body>

    </html>
@endguest
