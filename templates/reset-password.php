<?php defined( 'ABSPATH' ) || exit; ?>

<div asx-data="authSpaceResetForm" class="min-h-screen flex items-center justify-center bg-white p-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-100 text-blue-600 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-8 h-8"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="1.5">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M12 11.25v2.25m0 3h.008v.008H12v-.008zm-6.75-6.75h13.5A1.5 1.5 0 0120.25 12v6.75A1.5 1.5 0 0118.75 20.25H5.25A1.5 1.5 0 013.75 18.75V12a1.5 1.5 0 011.5-1.5zm2.25 0V7.5a4.5 4.5 0 119 0v2.25"/>
                </svg>
            </div>

            <h2 class="text-2xl font-bold text-gray-900 mb-4">
                <?php esc_html_e( 'Reset Password', 'auth-space' ); ?>
            </h2>

            <p class="text-sm text-gray-500">
                <?php esc_html_e( 'Choose a new password for your account.', 'auth-space' ); ?>
            </p>
        </div>

        <form
            method="post"
            novalidate
            asx-on:submit.prevent="submitResetForm"
            class="space-y-5"
        >
            <input
                type="text"
                name="username"
                asx-model="login"
                autocomplete="username"
                class="hidden"
                aria-hidden="true"
                asx-init="login = '<?php echo esc_js($_GET['login'] ?? ''); ?>'"
            />

            <input
                type="hidden"
                asx-model="key"
                class="hidden"
                aria-hidden="true"
                asx-init="key = '<?php echo esc_js($_GET['key'] ?? ''); ?>'"
            />

            <!-- New Password -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    <?php esc_html_e( 'New Password', 'auth-space' ); ?>
                </label>

                <input
                    type="password"
                    name="password"
                    asx-model="password"
                    placeholder="<?php esc_attr_e( 'Enter your new password', 'auth-space' ); ?>"
                    autocomplete="new-password"
                    asx-on:input.debounce.500ms="validateInput('password')"
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
                    class="mt-1 text-sm text-red-600"
                ></p>
            </div>

            <!-- Confirm Password -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    <?php esc_html_e( 'Confirm Password', 'auth-space' ); ?>
                </label>

                <input
                    type="password"
                    name="confirm_password"
                    asx-model="confirmPassword"
                    placeholder="<?php esc_attr_e( 'Confirm your new password', 'auth-space' ); ?>"
                    autocomplete="new-password"
                    asx-on:input.debounce.500ms="validateInput('confirmPassword')"
                    :class="errors.confirmPassword
                        ? 'border-red-500 focus:ring-red-500'
                        : 'border-gray-300 focus:ring-blue-500'"
                    class="w-full rounded-lg border px-4 py-2 text-sm
                           focus:outline-none focus:ring-2 focus:border-transparent
                           transition duration-200 ease-in-out placeholder-gray-400"
                    required
                >

                <p
                    asx-show="errors.confirmPassword"
                    asx-text="errors.confirmPassword"
                    class="mt-1 text-sm text-red-600"
                ></p>
            </div>

            <p
                asx-show="errors.general"
                asx-text="errors.general"
                class="text-sm text-red-600 text-center"
            ></p>

            <!-- Submit -->
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
                    <?php esc_html_e( 'Reset Password', 'auth-space' ); ?>
                </span>

                <span asx-show="loading" class="flex items-center justify-center gap-2">
                    <svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-25"/>
                        <path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.4 0 0 5.4 0 12h4z"/>
                    </svg>
                    <?php esc_html_e( 'Updating...', 'auth-space' ); ?>
                </span>
            </button>

            <p
                asx-show="successMsg"
                asx-text="successMsg"
                class="mt-1 text-sm text-green-600 text-center"
            ></p>
        </form>

        <p class="text-sm text-center text-gray-500 mt-6">
            <a
                href="<?php echo esc_url( wp_login_url() ); ?>"
                class="text-blue-600 hover:text-blue-800 font-medium transition-colors duration-200"
            >
                <?php esc_html_e( 'Back to Login', 'auth-space' ); ?>
            </a>
        </p>
    </div>
</div>