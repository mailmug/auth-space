import Alpine from 'alpinejs';
import '../css/style.css';
import registerForm from './register';

window.Alpine = Alpine;
Alpine.data('registerForm', registerForm);

Alpine.start();