import { apiRequest } from './api-request';

export default () => ({

    username: '',
    email: '',
    password:'',
    confirm_password:'',
    passwordVisible: false,
    confirmPasswordVisible: false,
    errors: {},

    togglePassword() {
        this.passwordVisible = !this.passwordVisible;
    },

    toggleConfirmPassword() {
        this.confirmPasswordVisible =
            !this.confirmPasswordVisible;
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