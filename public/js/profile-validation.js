/**
 * Complete Profile Form Validation
 */
function initProfileForm() {
    const form = document.getElementById('profileForm');
    if (!form) return;

    const tailleInput = document.getElementById('taille');
    const poidsInput = document.getElementById('poids');
    const tailleError = document.getElementById('tailleError');
    const poidsError = document.getElementById('poidsError');

    function validateTaille(){
        const val = tailleInput.value.trim();
        const num = parseFloat(val);
        if(!val || isNaN(num) || num <= 0){
            tailleInput.classList.add('is-invalid');
            tailleError.style.display = 'block';
            return false;
        }
        tailleInput.classList.remove('is-invalid');
        tailleError.style.display = 'none';
        return true;
    }

    function validatePoids(){
        const val = poidsInput.value.trim();
        const num = parseFloat(val);
        if(!val || isNaN(num) || num <= 0){
            poidsInput.classList.add('is-invalid');
            poidsError.style.display = 'block';
            return false;
        }
        poidsInput.classList.remove('is-invalid');
        poidsError.style.display = 'none';
        return true;
    }

    tailleInput.addEventListener('blur', validateTaille);
    poidsInput.addEventListener('blur', validatePoids);

    form.addEventListener('submit', function(e){
        if(!validateTaille() || !validatePoids()){
            e.preventDefault();
        }
    });
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', initProfileForm);
