<x-guest-layout>
    <div class="grid md:grid-cols-2 gap-0 -m-8 min-h-[600px]">
        <!-- Left Side - Branding -->
        <div class="hidden md:flex flex-col justify-between bg-gradient-to-br from-teal-800 via-teal-700 to-teal-900 p-12 rounded-l-2xl relative overflow-hidden">
            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-teal-600 rounded-full opacity-20 -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-teal-900 rounded-full opacity-30 -ml-24 -mb-24"></div>

            <!-- Logo -->
            <div class="relative z-10">
                @php
                    $siteLogo = App\Models\SiteSetting::where('key', 'site_logo')->value('value');
                @endphp

                @if($siteLogo)
                    <img src="{{ Storage::url($siteLogo) }}" alt="Fountainhead Logo" class="h-12 w-auto drop-shadow-lg mb-2">
                @else
                    <img src="{{ asset('images/logo.png') }}" alt="Fountainhead Logo" class="h-12 w-auto drop-shadow-lg mb-2">
                @endif
                <h1 class="text-white text-2xl font-bold mt-2">{{ $settings['site_title'] ?? 'FountainHead' }}</h1>
            </div>

            <!-- Center Content -->
            <div class="relative z-10 text-white">
                <h2 class="text-4xl font-bold mb-4 leading-tight">
                    Create Your Account
                </h2>
                <p class="text-teal-100 text-lg leading-relaxed">
                    Join FountainHead and start booking rooms, reserving event spaces, and enjoying our services.
                </p>
            </div>

            <!-- Footer -->
            <div class="relative z-10 text-teal-200 text-sm">
                © {{ date('Y') }} {{ $settings['site_name'] ?? 'FountainHead' }}. All rights reserved.
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="flex flex-col justify-center p-12 bg-white rounded-r-2xl">
            <!-- Mobile Logo -->
            <div class="md:hidden mb-8 text-center">
                @php
                    $siteLogo = App\Models\SiteSetting::where('key', 'site_logo')->value('value');
                @endphp

                @if($siteLogo)
                    <img src="{{ Storage::url($siteLogo) }}" alt="Fountainhead Logo" class="h-12 w-auto mx-auto mb-2">
                @else
                    <img src="{{ asset('images/logo.png') }}" alt="Fountainhead Logo" class="h-12 w-auto mx-auto mb-2">
                @endif
            </div>

            <!-- Header -->
            <div class="mb-8">
                <h3 class="text-3xl font-bold text-gray-900 mb-2">Create Account</h3>
                <p class="text-gray-600">Fill in your information to create your account.</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            @if (session('error'))
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm flex items-start rounded">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-5">                @csrf

                <!-- Full Name -->
                <div>
                    <x-input-label for="name" :value="__('Full Name')" />

                    <x-text-input
                        id="name"
                        class="block mt-1 w-full"
                        type="text"
                        name="name"
                        :value="old('name')"
                        required
                        autofocus
                        placeholder="Your full name"
                    />

                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />

                    <x-text-input
                        id="email"
                        class="block mt-1 w-full"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autocomplete="username"
                        placeholder="you@example.com"
                    />

                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" />

                    <x-text-input
                        id="password"
                        class="block mt-1 w-full"
                        type="password"
                        name="password"
                        required
                        autocomplete="new-password"
                        placeholder="••••••••"
                    />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label
                        for="password_confirmation"
                        :value="__('Confirm Password')" />

                    <x-text-input
                        id="password_confirmation"
                        class="block mt-1 w-full"
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="••••••••"
                    />

                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ms-3">
                        {{ __('Create Account') }}
                    </x-primary-button>
                </div>

                <div class="mt-6 text-center">

                    <span class="text-sm text-gray-500">

                        Already have an account?

                    </span>

                    <a href="{{ route('login') }}"
                        class="text-teal-600 hover:text-teal-700 font-semibold">

                        Sign In

                    </a>

                </div>
            </form>

            <!-- Mobile Footer -->
            <div class="md:hidden mt-8 pt-6 border-t border-gray-200 text-center">
                <p class="text-xs text-gray-500">
                    © {{ date('Y') }} {{ $settings['site_name'] ?? 'FountainHead' }}. All rights reserved.
                </p>
            </div>
        </div>
    </div>

    <style>
        /* Icon color transition on input focus - PERSISTEN! */
        .group:focus-within svg {
            color: #0d9488 !important; /* teal-600 */
        }

        /* Ensure icons stay visible */
        .absolute svg {
            z-index: 10;
            pointer-events: none;
        }

        /* Custom primary button styling */
        .ms-3 {
            background: linear-gradient(to right, #0d9488, #14b8a6);
            border: none;
            padding: 0.625rem 1.5rem;
            font-weight: 600;
            transition: all 0.2s ease-in-out;
        }

        .ms-3:hover {
            background: linear-gradient(to right, #0f766e, #0d9488);
            transform: translateY(-1px);
            box-shadow: 0 10px 25px -5px rgba(13, 148, 136, 0.4);
        }

        .ms-3:active {
            transform: scale(0.98);
        }

        /* Input styling with icon padding */
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
        }

        /* Checkbox styling */
        input[type="checkbox"]:checked {
            background-color: #0d9488;
            border-color: #0d9488;
        }

        input[type="checkbox"]:focus {
            ring-color: #0d9488;
        }
    </style>
</x-guest-layout>
