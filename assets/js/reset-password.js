import { apiRequest } from './api-request';

export default () => ({
    password: '',
    confirmPassword: '',
    key: '',
    login: '',

    errors: {},
    loading: false,
    successMsg: '',

    hasErrors() {
        return Object.values(this.errors).some(error => error);
    },

    async submitResetForm() {
        if (this.hasErrors()) {
            return;
        }

        if (this.password !== this.confirmPassword) {
            this.errors.confirmPassword =
                'Passwords do not match.';
            return;
        }

        this.loading = true;
        this.successMsg = '';
        delete this.errors.general;

        try {
            const response = await apiRequest(
                '/auth-space/v1/reset-password',
                {
                    method: 'POST',
                    body: JSON.stringify({
                        login: this.login,
                        key: this.key,
                        password: this.password,
                    }),
                }
            );

            if (response.success) {
                this.password = '';
                this.confirmPassword = '';
                this.successMsg = response.message;
                return;
            }

            if (!response.success && response.errors) {
                this.errors = response.errors;
                return;
            }

            this.errors.general =
                response.message || 'Request failed.';
        } catch (e) {
            this.errors.general =
                e.message || 'Something went wrong.';
        } finally {
            this.loading = false;
        }
    },

    validateInput(field) {
        this.errors = {};

        if (
            field === 'confirmPassword' ||
            field === 'password'
        ) {
            if (
                this.confirmPassword &&
                this.password !== this.confirmPassword
            ) {
                this.errors.confirmPassword =
                    'Passwords do not match.';
            }
        }
    }
});