/**
 * Multi-step forms helper
 * Usage: initializeMultiStepForm(formElement, totalSteps, { onStepChange })
 */
(function (window, document) {
    'use strict';

    function isEmail(value) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
    }

    function isValidName(value) {
        return /^[A-Za-zÀ-ÖØ-öø-ÿ' -]{2,}$/.test((value || '').trim());
    }

    function setError(input, message) {
        if (!input) return;
        const errorById = input.id ? document.getElementById(input.id + 'Error') : null;
        const errorByName = input.name ? document.getElementById(input.name + 'Error') : null;
        const errorEl = errorById || errorByName;

        input.classList.add('is-invalid');
        if (errorEl) {
            if (message) errorEl.textContent = message;
            errorEl.style.display = 'block';
        }
    }

    function clearError(input) {
        if (!input) return;
        const errorById = input.id ? document.getElementById(input.id + 'Error') : null;
        const errorByName = input.name ? document.getElementById(input.name + 'Error') : null;
        const errorEl = errorById || errorByName;

        input.classList.remove('is-invalid');
        if (errorEl) {
            errorEl.style.display = 'none';
        }
    }

    function validateField(input, form, stepElement) {
        if (!input) return true;

        const value = (input.value || '').trim();

        if (input.type === 'radio') {
            if (!input.required) return true;
            const checked = stepElement.querySelector('input[type="radio"][name="' + input.name + '"]:checked');
            if (!checked) {
                setError(input);
                return false;
            }
            const radios = stepElement.querySelectorAll('input[type="radio"][name="' + input.name + '"]');
            radios.forEach(function (r) { clearError(r); });
            return true;
        }

        if (input.required && value === '') {
            setError(input);
            return false;
        }

        if (input.type === 'email' && value !== '' && !isEmail(value)) {
            setError(input);
            return false;
        }

        if (input.type === 'password' && input.name === 'password' && value !== '' && value.length < 6) {
            setError(input);
            return false;
        }

        if ((input.id === 'nom' || input.id === 'prenom') && value !== '' && !isValidName(value)) {
            setError(input, "Caractères invalides — utilisez uniquement lettres, espaces, - ou '");
            return false;
        }

        if ((input.id === 'taille' || input.id === 'poids') && value !== '') {
            const num = parseFloat(value);
            if (Number.isNaN(num) || num <= 0) {
                setError(input);
                return false;
            }
        }

        if (input.id === 'password_confirm') {
            const pwd = form.querySelector('#password');
            if (pwd && value !== '' && value !== pwd.value) {
                setError(input);
                return false;
            }
        }

        clearError(input);
        return true;
    }

    function validateStep(form, stepIndex) {
        const step = form.querySelector('.form-step[data-step="' + stepIndex + '"]');
        if (!step) return true;

        let valid = true;
        const inputs = step.querySelectorAll('input, select, textarea');
        const handledRadio = new Set();

        inputs.forEach(function (input) {
            if (input.type === 'radio') {
                if (handledRadio.has(input.name)) return;
                handledRadio.add(input.name);
            }

            if (!validateField(input, form, step)) {
                valid = false;
            }
        });

        return valid;
    }

    function updateProgress(form, step, total) {
        const progress = form.querySelector('.step-progress');
        const currentStepText = form.querySelector('.current-step');
        const pct = Math.round((step / total) * 100);

        if (progress) {
            progress.style.width = pct + '%';
            progress.setAttribute('aria-valuenow', String(pct));
        }
        if (currentStepText) currentStepText.textContent = String(step);
    }

    function showStep(form, step, totalSteps) {
        const steps = form.querySelectorAll('.form-step');
        const prevBtn = form.querySelector('#prevBtn');
        const nextBtn = form.querySelector('#nextBtn');

        steps.forEach(function (s) {
            s.style.display = Number(s.getAttribute('data-step')) === step ? '' : 'none';
        });

        if (prevBtn) prevBtn.style.display = step > 1 ? '' : 'none';
        if (nextBtn) nextBtn.textContent = step === totalSteps ? 'Valider' : 'Suivant →';

        updateProgress(form, step, totalSteps);
    }

    function attachRealtimeValidation(form) {
        const fields = form.querySelectorAll('input, select, textarea');

        fields.forEach(function (field) {
            const handler = function () {
                const visibleStep = field.closest('.form-step');
                if (!visibleStep || visibleStep.style.display === 'none') return;
                validateField(field, form, visibleStep);

                if (field.id === 'password') {
                    const confirm = form.querySelector('#password_confirm');
                    if (confirm) {
                        validateField(confirm, form, confirm.closest('.form-step') || visibleStep);
                    }
                }
            };

            field.addEventListener('input', handler);
            field.addEventListener('change', handler);
            field.addEventListener('blur', handler);
        });
    }

    function initializeMultiStepForm(form, totalSteps, options) {
        if (!form) return;

        options = options || {};
        let currentStep = 1;

        const nextBtn = form.querySelector('#nextBtn');
        const prevBtn = form.querySelector('#prevBtn');

        attachRealtimeValidation(form);
        showStep(form, currentStep, totalSteps);

        if (nextBtn) {
            nextBtn.addEventListener('click', function (e) {
                e.preventDefault();

                if (!validateStep(form, currentStep)) return;

                if (currentStep >= totalSteps) {
                    form.submit();
                    return;
                }

                currentStep += 1;
                showStep(form, currentStep, totalSteps);
                if (typeof options.onStepChange === 'function') options.onStepChange(currentStep);
            });
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', function (e) {
                e.preventDefault();
                if (currentStep <= 1) return;
                currentStep -= 1;
                showStep(form, currentStep, totalSteps);
                if (typeof options.onStepChange === 'function') options.onStepChange(currentStep);
            });
        }

        form.addEventListener('keydown', function (e) {
            if (e.key !== 'Enter') return;
            if (document.activeElement && document.activeElement.tagName === 'TEXTAREA') return;
            e.preventDefault();

            if (!validateStep(form, currentStep)) return;

            if (currentStep < totalSteps) {
                if (nextBtn) nextBtn.click();
            } else {
                form.submit();
            }
        });
    }

    window.initializeMultiStepForm = initializeMultiStepForm;
})(window, document);
/**
 * Multi-step forms helper
 * - initializeMultiStepForm(formElement, totalSteps, options)
 * Options: { onStepChange: function(step) }
 */
(function(window, document){
    'use strict';

    // Legacy duplicated block disabled intentionally.
    // The active implementation is the one above.
    return;

    function isEmail(value) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
    }

    function validateStep(form, stepIndex) {
        var step = form.querySelector('.form-step[data-step="' + stepIndex + '"]');
        if (!step) return true;

        var valid = true;

        // check required inputs
        var inputs = step.querySelectorAll('input, select, textarea');
        inputs.forEach(function(inp){
            var id = inp.id || (inp.name ? inp.name + 'Field' : null);
            var errEl = id ? document.getElementById(id + 'Error') : null;

            // reset
            inp.classList.remove('is-invalid');
            if (errEl) errEl.style.display = 'none';

            if (inp.hasAttribute('required')) {
                var val = inp.value;
                if (inp.type === 'radio') {
                    // radio handled by group check below
                } else if (!val || val.trim() === '') {
                    valid = false;
                    inp.classList.add('is-invalid');
                    if (errEl) errEl.style.display = 'block';
                }
            }

            if (inp.type === 'email' && inp.value) {
                if (!isEmail(inp.value)) {
                    valid = false;
                    inp.classList.add('is-invalid');
                    if (errEl) errEl.style.display = 'block';
                }
            }

            if (inp.type === 'password' && inp.value) {
                if (inp.name === 'password' && inp.value.length < 6) {
                    valid = false;
                    inp.classList.add('is-invalid');
                    if (errEl) errEl.style.display = 'block';
                }
            }

            // Name validation: no special chars, allow letters, accents, spaces, hyphen and apostrophe
            if ((inp.id === 'nom' || inp.id === 'prenom') && inp.value) {
                var namePattern = /^[A-Za-zÀ-ÖØ-öø-ÿ' -]{2,}$/;
                if (!namePattern.test(inp.value.trim())) {
                    valid = false;
                    inp.classList.add('is-invalid');
                    if (errEl) {
                        errEl.textContent = 'Caractères invalides — utilisez uniquement lettres, espaces, - ou \'';
                        errEl.style.display = 'block';
                    }
                }
            }
        });

        // radio groups: any required radio group must have a checked
        var radios = step.querySelectorAll('input[type="radio"][required]');
        if (radios.length) {
            var groups = {};
            radios.forEach(function(r){ groups[r.name] = true; });
            Object.keys(groups).forEach(function(name){
                var checked = step.querySelector('input[name="' + name + '"]:checked');
                if (!checked) {
                    valid = false;
                    // show a group-level error if exists
                    var err = step.querySelector('#' + name + 'Error') || step.querySelector('.error-text');
                    if (err) err.style.display = 'block';
                }
            });
        }

        return valid;
    }

    function updateProgress(form, step, total) {
        var pct = Math.round((step / total) * 100);
        var bar = form.querySelector('.step-progress');
        if (bar) {
            bar.style.width = pct + '%';
            var cur = bar.querySelector('.current-step');
            if (cur) cur.textContent = step;
        }
    }

    function showStep(form, step, total) {
        var steps = form.querySelectorAll('.form-step');
        steps.forEach(function(s){ s.style.display = 'none'; });
        var cur = form.querySelector('.form-step[data-step="' + step + '"]');
        if (cur) cur.style.display = '';

        // prev/next buttons
        var prev = form.querySelector('#prevBtn');
        var next = form.querySelector('#nextBtn');
        if (prev) prev.style.display = step > 1 ? '' : 'none';
        if (next) next.textContent = (step >= total) ? 'Valider' : 'Suivant →';

        updateProgress(form, step, total);
    }

    function initializeMultiStepForm(form, totalSteps, options) {
        options = options || {};
        var current = 1;

        showStep(form, current, totalSteps);

        var nextBtn = form.querySelector('#nextBtn');
        var prevBtn = form.querySelector('#prevBtn');

        if (nextBtn) {
            nextBtn.addEventListener('click', function(e){
                e.preventDefault();
                // if last step -> submit
                if (current >= totalSteps) {
                    // validate last step before submit
                    if (!validateStep(form, current)) return;
                    form.submit();
                    return;
                }

                // validate current
                if (!validateStep(form, current)) return;

                current++;
                showStep(form, current, totalSteps);
                if (typeof options.onStepChange === 'function') options.onStepChange(current);
            });
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', function(e){
                e.preventDefault();
                if (current <= 1) return;
                current--;
                showStep(form, current, totalSteps);
                if (typeof options.onStepChange === 'function') options.onStepChange(current);
            });
        }

        // allow Enter to move to next step when not on last
        form.addEventListener('keydown', function(ev){
            if (ev.key === 'Enter') {
                var active = form.querySelector('.form-step[data-step="' + current + '"]');
                // if in a textarea, ignore
                if (document.activeElement && document.activeElement.tagName === 'TEXTAREA') return;
                ev.preventDefault();
                if (current < totalSteps) {
                    // trigger next
                    if (nextBtn) nextBtn.click();
                } else {
                    // final step -> let default (submit) proceed if validation passes
                    if (!validateStep(form, current)) return;
                    form.submit();
                }
            }
        });
    }

    // export
    window.initializeMultiStepForm = initializeMultiStepForm;

})(window, document);
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
