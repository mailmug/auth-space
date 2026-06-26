<div x-data="registerForm" class="min-h-screen flex items-center justify-center bg-white p-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
        <!-- Header with icon -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-100 text-blue-600 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900"><?php _e('Create Account', 'auth-space') ?></h2>
            <p class="text-sm text-gray-500 mt-1"><?php _e('Get started with your free account', 'auth-space') ?></p>
        </div>

        <form method="post" novalidate @submit.prevent="submitRegisterForm" action="" class="space-y-5">
            <!-- Username -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    <?php _e('Username', 'auth-space') ?>
                </label>
                <input type="text" x-model="username" name="username" autocomplete="username" placeholder="Enter your username"
                    @input.debounce.500ms="validateInput('username')"
                    :class="errors.username
                        ? 'border-red-500 focus:ring-red-500'
                        : 'border-gray-300 focus:ring-blue-500'"
                    class="w-full rounded-lg border px-4 py-2 text-sm
                        focus:outline-none focus:ring-2 focus:border-transparent
                        transition duration-200 ease-in-out placeholder-gray-400"
                    required
                >
                <p
                    x-show="errors.username"
                    x-text="errors.username"
                    x-transition
                    class="mt-1 text-sm text-red-600"
                ></p>
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    <?php _e('Email', 'auth-space') ?>
                </label>
                <input
                    type="email"
                    x-model="email"
                    name="email"
                    autocomplete="email"
                    placeholder="you@example.com"
                    @input.debounce.500ms="validateInput('email')"
                    :class="errors.email
                        ? 'border-red-500 focus:ring-red-500'
                        : 'border-gray-300 focus:ring-blue-500'"
                    class="w-full rounded-lg border px-4 py-2 text-sm
                        focus:outline-none focus:ring-2 focus:border-transparent
                        transition duration-200 ease-in-out placeholder-gray-400"
                    required
                >
                <p
                    x-show="errors.email"
                    x-text="errors.email"
                    x-transition
                    class="mt-1 text-sm text-red-600"
                ></p>
            </div>

            <!-- Password -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    <?php _e('Password', 'auth-space') ?>
                </label>
                <input type="password" x-model="password" name="password" placeholder="••••••••" autocomplete="new-password"
                    @input.debounce.500ms="validateInput('password')"
                    :class="errors.password
                        ? 'border-red-500 focus:ring-red-500'
                        : 'border-gray-300 focus:ring-blue-500'"
                    class="w-full rounded-lg border px-4 py-2 text-sm
                        focus:outline-none focus:ring-2 focus:border-transparent
                        transition duration-200 ease-in-out placeholder-gray-400"
                    required
                >
                <p
                    x-show="errors.password"
                    x-text="errors.password"
                    x-transition
                    class="mt-1 text-sm text-red-600"
                ></p>
            </div>

            <!-- Confirm Password -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    <?php _e('Confirm Password', 'auth-space') ?>
                </label>
                <input type="password" x-model="confirm_password" name="confirm_password" placeholder="••••••••" autocomplete="new-password"
                    @input.debounce.500ms="validateInput('confirm_password')"
                    :class="errors.confirm_password
                        ? 'border-red-500 focus:ring-red-500'
                        : 'border-gray-300 focus:ring-blue-500'"
                    class="w-full rounded-lg border px-4 py-2 text-sm
                        focus:outline-none focus:ring-2 focus:border-transparent
                        transition duration-200 ease-in-out placeholder-gray-400"
                    required
                >
                <p
                    x-show="errors.confirm_password"
                    x-text="errors.confirm_password"
                    x-transition
                    class="mt-1 text-sm text-red-600"
                ></p>
            </div>

            <!-- Submit Button -->
            <button 
                type="submit"
                :disabled="loading"
                class="w-full cursor-pointer rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white
                    hover:bg-blue-700 active:bg-blue-800
                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                    transition-colors duration-200"
            >
                <span x-show="!loading">
                    <?php _e('Register', 'auth-space') ?>
                </span>

                <span x-show="loading" class="flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 animate-spin" viewBox="0 0 24 24" fill="none">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                    <?php _e('Loading...', 'auth-space') ?>
                </span>
            </button>
        </form>

        <!-- Optional footer link -->
        <p class="text-sm text-center text-gray-500 mt-6">
            <?php _e('Already have an account?', 'auth-space') ?>
            <a href="#" class="text-blue-600 hover:text-blue-800 font-medium transition-colors duration-200">
                <?php _e('Sign in', 'auth-space') ?>
            </a>
        </p>
    </div>
</div>