<?php defined( 'ABSPATH' ) || exit; ?>
<div asx-data="authSpaceLoginForm" class="min-h-screen flex items-center justify-center bg-white p-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
        <!-- Header with icon -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-100 text-blue-600 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">
                <?php esc_html_e('Sign In', 'auth-space') ?>
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                <?php esc_html_e('Welcome back! Please login to your account.', 'auth-space') ?>
            </p>
        </div>

        <form method="post" novalidate asx-on:submit.prevent="submitLoginForm" action="" class="space-y-5">
            <!-- Username -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    <?php esc_html_e('Username', 'auth-space') ?>
                </label>
                <input type="text" asx-model="username" name="username" autocomplete="username" placeholder="Enter your username"
                    asx-on:input.debounce.250ms="validateInput('username')"
                    :class="errors.username
                        ? 'border-red-500 focus:ring-red-500'
                        : 'border-gray-300 focus:ring-blue-500'"
                    class="w-full rounded-lg border px-4 py-2 text-sm
                        focus:outline-none focus:ring-2 focus:border-transparent
                        transition duration-200 ease-in-out placeholder-gray-400"
                    required
                >
                <p
                    asx-show="errors.username"
                    asx-text="errors.username"
                    asx-transition
                    class="mt-1 text-sm text-red-600"
                ></p>
            </div>

            <!-- Password -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    <?php esc_html_e('Password', 'auth-space') ?>
                </label>
                <input type="password" asx-model="password" name="password" placeholder="••••••••" autocomplete="new-password"
                    asx-on:input.debounce.250ms="validateInput('password')"
                    :class="errors.password
                        ? 'border-red-500 focus:ring-red-500'
                        : 'border-gray-300 focus:ring-blue-500'"
                    class="w-full rounded-lg border px-4 py-2 text-sm
                        focus:outline-none focus:ring-2 focus:border-transparent
                        transition duration-200 ease-in-out placeholder-gray-400"
                    required
                >
                <p
                    asx-show="errors.password"
                    asx-text="errors.password"
                    asx-transition
                    class="mt-1 text-sm text-red-600"
                ></p>
            </div>

            <p
                asx-show="errors.general"
                asx-text="errors.general"
                asx-transition
                class="mt-1 text-sm text-red-600 text-center"
            ></p>

            <!-- Submit Button -->
            <button 
                type="submit"
                asx-bind:disabled="loading || hasErrors()"
                class="w-full cursor-pointer rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white
                    hover:bg-blue-700 active:bg-blue-800
                    disabled:opacity-75 disabled:cursor-not-allowed disabled:bg-blue-500
                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                    transition-colors duration-200"
            >
                <span asx-show="!loading">
                    <?php esc_html_e('Login', 'auth-space') ?>
                </span>

                <span asx-show="loading" class="flex items-center justify-center gap-2">
                    <svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-25"/>
                        <path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.4 0 0 5.4 0 12h4z"/>
                    </svg>
                    <?php esc_html_e( 'Signing in...', 'auth-space' ); ?>
                </span>
            </button>
        </form>

        <!-- Footer link -->
        <p class="text-sm text-center text-gray-500 mt-6">
            <?php esc_html_e( "Don't have an account?", 'auth-space' ); ?>

            <a
                href="#"
                class="text-blue-600 hover:text-blue-800 font-medium transition-colors duration-200 "
            >
                <?php esc_html_e( 'Create one', 'auth-space' ); ?>
            </a>
        </p>
    </div>
</div>