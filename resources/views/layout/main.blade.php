@guest
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sociala - Login</title>
        <!-- Favicon icon -->
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon.png') }}" />
        @vite('resources/css/app.css')
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: 'Inter', sans-serif;
                background-color: #fafafa;
                /* Instagram-style light gray */
            }
        </style>
    </head>

    <body class="min-h-screen flex flex-col items-center justify-center">
        <div class="flex flex-col items-center justify-center w-full max-w-sm">

            <!-- Login Card -->
            <div class="bg-white border border-gray-300 rounded-md w-full p-10">
                <h1 class="text-blue-600 text-4xl font-extrabold text-center mb-8">
                    Sociala.
                </h1>

                <form method="POST" action="{{ route('login') }}">
                    <!-- Email -->
                    <!-- Show general login error -->
                    @if ($errors->any())
                        <div class="bg-red-100 text-red-600 text-sm p-2 rounded mb-3">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    @csrf
                    <div class="mb-3">
                        <input type="text" id="email" name="email"
                            class="bg-gray-50 border border-gray-300 focus:border-gray-400 focus:ring-0 rounded-sm w-full py-2 px-3 text-sm"
                            placeholder="Email or Username" />
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <input type="password" id="password" name="password"
                            class="bg-gray-50 border border-gray-300 focus:border-gray-400 focus:ring-0 rounded-sm w-full py-2 px-3 text-sm"
                            placeholder="Password" />
                    </div>

                    <!-- Submit -->
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold py-2 w-full rounded-md">
                        Log In
                    </button>
                </form>

                <!-- OR Divider -->
                <div class="flex items-center my-4">
                    <div class="flex-grow h-px bg-gray-300"></div>
                    <span class="px-3 text-gray-500 text-xs font-medium">OR</span>
                    <div class="flex-grow h-px bg-gray-300"></div>
                </div>



                <!-- Forgot password -->
                <div class="mt-3 text-center">
                    <a href="#" class="text-xs text-blue-500 hover:underline">Forgot password?</a>
                </div>
            </div>

            <!-- Signup Box -->
            <div class="bg-white border border-gray-300 rounded-md w-full p-6 mt-4 text-center text-sm">
                Don’t have an account?
                <a href="{{ route('register') }}" class="text-blue-500 font-semibold hover:underline">Sign Up</a>
            </div>
        </div>
    </body>

    </html>
@endguest
@auth
    @include('layout.header')
    @include('layout.left-sidebar')
    @yield('content')
    @include('layout.right-sidebar')
    @include('layout.footer')
@endauth
