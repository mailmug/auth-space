import '../css/style.css';

import Alpine from 'alpinejs';
import registerForm from './register';
import loginForm from './login';
import forgotForm from './forgot-password';
import resetForm from './reset-password';

Alpine.prefix("asx-");
Alpine.data('authSpaceRegisterForm', registerForm);
Alpine.data('authSpaceLoginForm', loginForm);
Alpine.data('authSpaceForgotForm', forgotForm);
Alpine.data('authSpaceResetForm', resetForm);
Alpine.start();


