import '../css/style.css';

import Alpine from 'alpinejs';
import registerForm from './register';

Alpine.prefix("asx-");
Alpine.data('authSpaceRegisterForm', registerForm);
Alpine.start();


