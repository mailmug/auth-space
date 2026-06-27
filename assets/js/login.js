import { apiRequest } from './api-request';

export default () => ({
    username: '',
    password:'',
    passwordVisible: false,
    errors: {},
    loading: false,

    togglePassword() {
        this.passwordVisible = !this.passwordVisible;
    },

    hasErrors() {
        return Object.values(this.errors).some(error => error);
    },

    async submitLoginForm(){
      
        if (this.hasErrors()) {
            return;
        }

        let data = {
            username: this.username,
            password: this.password,
        };

        this.loading = true;
        this.$dispatch('auth-space:login:data', data);

        try {
            const response = await apiRequest(
                '/auth-space/v1/login',
                {
                    method: 'POST',
                    body: JSON.stringify(data),
                }
            );

            if (response.success) {
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

    validateInput(field) {
        const value = this[`${field}`];
        delete this.errors[field];
        delete this.errors['general'];
    }

});