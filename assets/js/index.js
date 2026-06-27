import '../css/style.css';

import Alpine from 'alpinejs';
import registerForm from './register';
import loginForm from './login';

Alpine.prefix("asx-");
Alpine.data('authSpaceRegisterForm', registerForm);
Alpine.data('authSpaceLoginForm', loginForm);
Alpine.start();


