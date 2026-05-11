/**
 * Register Form Validation
 */
function initRegisterForm() {
    const form = document.getElementById('registerForm');
    if (!form) return;

    const nomInput = document.getElementById('nom');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const nomError = document.getElementById('nomError');
    const emailError = document.getElementById('emailError');
    const passwordError = document.getElementById('passwordError');

    function validateNom(){
        const nom = nomInput.value.trim();
        if(!nom || nom.length < 2){
            nomInput.classList.add('is-invalid');
            nomError.style.display = 'block';
            return false;
        }
        nomInput.classList.remove('is-invalid');
        nomError.style.display = 'none';
        return true;
    }

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

    nomInput.addEventListener('blur', validateNom);
    emailInput.addEventListener('blur', validateEmail);
    passwordInput.addEventListener('blur', validatePassword);

    form.addEventListener('submit', function(e){
        if(!validateNom() || !validateEmail() || !validatePassword()){
            e.preventDefault();
        }
    });
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', initRegisterForm);
