/**
 * Login Form Validation
 */
function initLoginForm() {
    const form = document.getElementById('loginForm');
    if (!form) return;

    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const emailError = document.getElementById('emailError');
    const passwordError = document.getElementById('passwordError');

    function validateEmail(){
        const email = emailInput.value.trim();
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if(!email || !re.test(email)){
            emailInput.classList.add('is-invalid');
            emailError.style.display = 'block';
            return false;
        }
        emailInput.classList.remove('is-invalid');
        emailError.style.display = 'none';
        return true;
    }

    function validatePassword(){
        if(!passwordInput.value || passwordInput.value.length < 6){
            passwordInput.classList.add('is-invalid');
            passwordError.style.display = 'block';
            return false;
        }
        passwordInput.classList.remove('is-invalid');
        passwordError.style.display = 'none';
        return true;
    }

    emailInput.addEventListener('blur', validateEmail);
    passwordInput.addEventListener('blur', validatePassword);

    form.addEventListener('submit', function(e){
        if(!validateEmail() || !validatePassword()){
            e.preventDefault();
        }
    });
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', initLoginForm);
