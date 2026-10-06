// resources/js/components/form-validation.js

/**
 * Form Validation System
 */
class FormValidator {
    constructor(formElement) {
        this.form = formElement;
        this.fields = [];
        this.rules = {};
        this.errors = {};
        this.init();
    }
    
    init() {
        this.fields = Array.from(this.form.querySelectorAll('input, textarea, select'));
        this.parseRules();
        this.attachEvents();
    }
    
    parseRules() {
        this.fields.forEach(field => {
            const rules = [];
            const fieldName = field.name;
            
            if (!fieldName) return;
            
            // Required
            if (field.hasAttribute('required') || field.dataset.required === 'true') {
                rules.push({
                    type: 'required',
                    message: field.dataset.requiredMessage || 'This field is required'
                });
            }
            
            // Email
            if (field.type === 'email' || field.dataset.email === 'true') {
                rules.push({
                    type: 'email',
                    message: field.dataset.emailMessage || 'Please enter a valid email address'
                });
            }
            
            // Min length
            const minLength = field.dataset.minLength || field.getAttribute('minlength');
            if (minLength) {
                rules.push({
                    type: 'minLength',
                    value: parseInt(minLength),
                    message: field.dataset.minLengthMessage || `Minimum ${minLength} characters required`
                });
            }
            
            // Max length
            const maxLength = field.dataset.maxLength || field.getAttribute('maxlength');
            if (maxLength) {
                rules.push({
                    type: 'maxLength',
                    value: parseInt(maxLength),
                    message: field.dataset.maxLengthMessage || `Maximum ${maxLength} characters allowed`
                });
            }
            
            // Pattern
            const pattern = field.dataset.pattern || field.getAttribute('pattern');
            if (pattern) {
                rules.push({
                    type: 'pattern',
                    value: pattern,
                    message: field.dataset.patternMessage || 'Invalid format'
                });
            }
            
            // Phone
            if (field.type === 'tel' || field.dataset.phone === 'true') {
                rules.push({
                    type: 'phone',
                    message: field.dataset.phoneMessage || 'Please enter a valid phone number'
                });
            }
            
            // URL
            if (field.type === 'url' || field.dataset.url === 'true') {
                rules.push({
                    type: 'url',
                    message: field.dataset.urlMessage || 'Please enter a valid URL'
                });
            }
            
            // Custom validation
            if (field.dataset.customValidation) {
                rules.push({
                    type: 'custom',
                    message: field.dataset.customMessage || 'Invalid value'
                });
            }
            
            this.rules[fieldName] = rules;
        });
    }
    
    attachEvents() {
        // Real-time validation on blur
        this.fields.forEach(field => {
            field.addEventListener('blur', () => {
                this.validateField(field);
            });
            
            // Clear error on input
            field.addEventListener('input', () => {
                this.clearFieldError(field);
            });
            
            // Clear error on focus
            field.addEventListener('focus', () => {
                this.clearFieldError(field);
            });
        });
        
        // Form submission
        this.form.addEventListener('submit', (e) => {
            if (!this.validateAll()) {
                e.preventDefault();
                
                // Scroll to first error
                const firstError = this.form.querySelector('.error');
                if (firstError) {
                    firstError.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    firstError.focus();
                }
            }
        });
    }
    
    validateField(field) {
        const fieldName = field.name;
        const rules = this.rules[fieldName] || [];
        const value = field.value.trim();
        
        // Clear previous errors
        this.clearFieldError(field);
        field.classList.remove('success');
        
        // Check all rules
        for (const rule of rules) {
            const validationResult = this.validateRule(rule, value, field);
            
            if (!validationResult.valid) {
                this.showFieldError(field, validationResult.message);
                return false;
            }
        }
        
        // Mark as valid if has value
        if (value) {
            field.classList.add('success');
        }
        
        return true;
    }
    
    validateRule(rule, value, field) {
        switch (rule.type) {
            case 'required':
                return {
                    valid: value.length > 0,
                    message: rule.message
                };
                
            case 'email':
                return {
                    valid: !value || /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value),
                    message: rule.message
                };
                
            case 'minLength':
                return {
                    valid: !value || value.length >= rule.value,
                    message: rule.message
                };
                
            case 'maxLength':
                return {
                    valid: !value || value.length <= rule.value,
                    message: rule.message
                };
                
            case 'pattern':
                try {
                    const regex = new RegExp(rule.value);
                    return {
                        valid: !value || regex.test(value),
                        message: rule.message
                    };
                } catch (e) {
                    return { valid: true, message: '' };
                }
                
            case 'phone':
                return {
                    valid: !value || /^[\d\s\-+()]{7,}$/.test(value),
                    message: rule.message
                };
                
            case 'url':
                try {
                    new URL(value);
                    return { valid: true, message: '' };
                } catch {
                    return {
                        valid: !value || false,
                        message: rule.message
                    };
                }
                
            default:
                return { valid: true, message: '' };
        }
    }
    
    showFieldError(field, message) {
        field.classList.add('error');
        
        // Create error message element
        const errorElement = document.createElement('span');
        errorElement.className = 'form-error-message';
        errorElement.textContent = message;
        errorElement.setAttribute('role', 'alert');
        
        // Insert after field
        field.parentElement.appendChild(errorElement);
        
        // Store error
        this.errors[field.name] = message;
        
        // ARIA attributes
        field.setAttribute('aria-invalid', 'true');
        field.setAttribute('aria-describedby', errorElement.id || '');
    }
    
    clearFieldError(field) {
        field.classList.remove('error');
        
        // Remove error message
        const errorElement = field.parentElement.querySelector('.form-error-message');
        if (errorElement) {
            errorElement.remove();
        }
        
        // Clear stored error
        delete this.errors[field.name];
        
        // ARIA attributes
        field.removeAttribute('aria-invalid');
        field.removeAttribute('aria-describedby');
    }
    
    validateAll() {
        let isValid = true;
        
        this.fields.forEach(field => {
            if (!this.validateField(field)) {
                isValid = false;
            }
        });
        
        return isValid;
    }
    
    reset() {
        this.fields.forEach(field => {
            this.clearFieldError(field);
            field.classList.remove('success', 'error');
        });
        
        this.errors = {};
        this.form.reset();
    }
    
    getErrors() {
        return { ...this.errors };
    }
    
    hasErrors() {
        return Object.keys(this.errors).length > 0;
    }
}

/**
 * Initialize form validation on all forms with data-validate attribute
 */
document.addEventListener('DOMContentLoaded', () => {
    const forms = document.querySelectorAll('form[data-validate]');
    
    forms.forEach(form => {
        form.formValidator = new FormValidator(form);
    });
    
    // Expose to window for direct access
    window.FormValidator = FormValidator;
});

export default FormValidator;