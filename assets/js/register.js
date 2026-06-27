import { apiRequest } from './api-request';
import captcha from './captcha';

export default () => ({
    username: '',
    email: '',
    password:'',
    confirm_password:'',
    passwordVisible: false,
    confirmPasswordVisible: false,
    errors: {},
    loading: false,

    togglePassword() {
        this.passwordVisible = !this.passwordVisible;
    },

    toggleConfirmPassword() {
        this.confirmPasswordVisible =
            !this.confirmPasswordVisible;
    },

    hasErrors() {
        return Object.values(this.errors).some(error => error);
    },

    async submitRegisterForm(){
      
        if (this.hasErrors()) {
            return;
        }

        this.loading = true;

        try {
            const response = await apiRequest(
                '/auth-space/v1/register',
                {
                    method: 'POST',
                    body: JSON.stringify({
                        username: this.username,
                        email: this.email,
                        password: this.password,
                        confirm_password: this.confirm_password,
                    }),
                }
            );

            if (response.success) {
                // redirect or show success
                window.location.href = response.redirect;
                return;
            }

            if (!response.success && response.errors) {
                this.errors = response.errors;
                return;
            }

            this.errors.general =
                response.message || 'Registration failed.';
        } catch (e) {
            this.errors.general =
                e.message || 'Something went wrong.';
        } finally {
            this.loading = false;
        }

    },

    async validateInput(field) {
        try {
            const value = this[`${field}`];
       
            const response = await apiRequest(
                '/auth-space/v1/register/validate',
                {
                    method: 'POST',
                    body: JSON.stringify({
                        field,
                        value,
                        password: this.password,
                        confirm_password: this.confirm_password,
                    }),
                }
            );

            this.errors[field] = response.valid
                ? ''
                : response.message;
        } catch (e) {
            this.errors[field] = e.message;
        }
    }
});