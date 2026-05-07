/**
 * Gestion des formulaires multi-étapes
 * Sans changement de page, uniquement des transitions fluides
 */

function initializeMultiStepForm(form, totalSteps, options = {}) {
    if (!form) {
        console.error('Form not found');
        return;
    }

    let currentStep = 1;
    const steps = form.querySelectorAll('.form-step');
    const nextBtn = form.querySelector('#nextBtn');
    const prevBtn = form.querySelector('#prevBtn');
    const progress = form.querySelector('.step-progress');
    const currentStepSpan = form.querySelector('.current-step');

    const onStepChange = typeof options.onStepChange === 'function' ? options.onStepChange : null;

    if (!nextBtn || !prevBtn) {
        console.error('Required form elements not found');
        return;
    }

    // Fonction pour afficher/masquer les étapes
    function showStep(stepNumber) {
        steps.forEach(step => {
            if (parseInt(step.getAttribute('data-step')) === stepNumber) {
                step.style.display = 'block';
            } else {
                step.style.display = 'none';
            }
        });

        // Mise à jour des boutons
        if (stepNumber === 1) {
            prevBtn.style.display = 'none';
            nextBtn.textContent = 'Suivant →';
            nextBtn.type = 'button';
        } else if (stepNumber === totalSteps) {
            prevBtn.style.display = 'block';
            nextBtn.type = 'submit';
            nextBtn.textContent = 'Terminer';
        } else {
            prevBtn.style.display = 'block';
            nextBtn.type = 'button';
            nextBtn.textContent = 'Suivant →';
        }

        // Mise à jour de la barre de progression
        if (progress) {
            const progressPercent = (stepNumber / totalSteps) * 100;
            progress.style.width = progressPercent + '%';
            progress.setAttribute('aria-valuenow', Math.round(progressPercent));
        }

        if (currentStepSpan) {
            currentStepSpan.textContent = stepNumber;
        }

        currentStep = stepNumber;

        if (onStepChange) {
            onStepChange(stepNumber, form);
        }
    }

    // Fonction de validation pour chaque étape
    function validateCurrentStep() {
        const currentStepElement = form.querySelector('[data-step="' + currentStep + '"]');
        if (!currentStepElement) {
            console.error('Current step element not found');
            return false;
        }

        const fields = currentStepElement.querySelectorAll('input[required], select[required], textarea[required]');
        let isValid = true;
        const processedRadioNames = new Set();

        fields.forEach(input => {
            const errorSpanById = input.id ? form.querySelector('#' + input.id + 'Error') : null;
            const errorSpanByName = input.name ? form.querySelector('#' + input.name + 'Error') : null;
            const errorSpan = errorSpanById || errorSpanByName;

            if (errorSpan) {
                errorSpan.style.display = 'none';
            }
            input.classList.remove('is-invalid');

            if (input.type === 'radio') {
                if (processedRadioNames.has(input.name)) {
                    return;
                }
                processedRadioNames.add(input.name);

                const radioGroup = currentStepElement.querySelectorAll('input[type="radio"][name="' + input.name + '"]');
                const isChecked = currentStepElement.querySelector('input[type="radio"][name="' + input.name + '"]:checked');

                if (!isChecked) {
                    isValid = false;
                    if (errorSpan) {
                        errorSpan.style.display = 'block';
                    }
                    radioGroup.forEach(radio => radio.classList.add('is-invalid'));
                }
                return;
            }

            if (input.type === 'checkbox') {
                if (!input.checked) {
                    isValid = false;
                    if (errorSpan) {
                        errorSpan.style.display = 'block';
                    }
                    input.classList.add('is-invalid');
                }
                return;
            }

            if (!input.value || input.value.trim() === '') {
                isValid = false;
                if (errorSpan) {
                    errorSpan.style.display = 'block';
                }
                input.classList.add('is-invalid');
                return;
            }

            // Validation spécifique selon le type
            if (input.type === 'email') {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(input.value)) {
                    isValid = false;
                    if (errorSpan) {
                        errorSpan.style.display = 'block';
                    }
                    input.classList.add('is-invalid');
                }
            }

            if (input.type === 'password') {
                if (input.value.length < 6) {
                    isValid = false;
                    if (errorSpan) {
                        errorSpan.style.display = 'block';
                    }
                    input.classList.add('is-invalid');
                }
            }

            if (input.id === 'nom' || input.id === 'prenom') {
                if (input.value.length < 2) {
                    isValid = false;
                    if (errorSpan) {
                        errorSpan.style.display = 'block';
                    }
                    input.classList.add('is-invalid');
                }
            }

            if (input.id === 'taille' || input.id === 'poids') {
                const numValue = parseFloat(input.value);
                if (isNaN(numValue) || numValue <= 0) {
                    isValid = false;
                    if (errorSpan) {
                        errorSpan.style.display = 'block';
                    }
                    input.classList.add('is-invalid');
                }
            }

            if (input.id === 'password_confirm') {
                const passwordInput = form.querySelector('#password');
                if (passwordInput && input.value !== passwordInput.value) {
                    isValid = false;
                    if (errorSpan) {
                        errorSpan.style.display = 'block';
                    }
                    input.classList.add('is-invalid');
                }
            }
        });

        return isValid;
    }

    // Événement pour le bouton Suivant
    nextBtn.addEventListener('click', function(e) {
        if (nextBtn.type === 'button') {
            e.preventDefault();

            if (validateCurrentStep()) {
                if (currentStep < totalSteps) {
                    showStep(currentStep + 1);
                    // Scroll vers le haut du formulaire
                    form.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        } else if (nextBtn.type === 'submit') {
            if (!validateCurrentStep()) {
                console.log('Form validation failed');
                e.preventDefault();
            }
        }
    });

    // Événement pour le bouton Retour
    prevBtn.addEventListener('click', function(e) {
        e.preventDefault();
        if (currentStep > 1) {
            showStep(currentStep - 1);
            form.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });

    // Empêcher la soumission directe du formulaire
    form.addEventListener('submit', function(e) {
        if (nextBtn.type === 'submit') {
            if (!validateCurrentStep()) {
                e.preventDefault();
            }
        }
    });

    // Afficher la première étape au démarrage
    showStep(1);
}

// Animation de fade-in
const style = document.createElement('style');
style.textContent = `
    .form-step {
        animation: fadeIn 0.3s ease-in;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .progress-text {
        color: white;
        font-weight: bold;
        font-size: 14px;
        line-height: 25px;
    }

    .error-text {
        color: #d32f2f;
        font-size: 12px;
        margin-top: 5px;
    }

    .is-invalid {
        border-color: #d32f2f !important;
    }

    #nextBtn, #prevBtn {
        font-weight: 600;
        transition: all 0.3s ease;
    }

    #nextBtn:hover:not(:disabled), #prevBtn:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    #nextBtn:active:not(:disabled), #prevBtn:active:not(:disabled) {
        transform: translateY(0);
    }
`;
document.head.appendChild(style);
