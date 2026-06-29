import { apiRequest } from './api-request';

export default () => ({
    email: '',
    errors: [], 
    loading: false,
    successMsg: '',

    hasErrors() {
        return Object.values(this.errors).some(error => error);
    },

    async submitForgotForm(){
      
        if (this.hasErrors()) {
            return;
        }

        this.loading = true;

        try {
            const response = await apiRequest(
                '/auth-space/v1/forgot-password',
                {
                    method: 'POST',
                    body: JSON.stringify({email: this.email}),
                }
            );

            if (response.success) {
                this.email = '';
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
        const value = this[`${field}`];
        delete this.errors[field];
        delete this.errors['general'];
    }

});