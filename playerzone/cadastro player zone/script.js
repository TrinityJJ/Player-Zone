// DOM Elements
const form = document.getElementById('cadastro-form');
const submitBtn = document.getElementById('submit-btn');
const btnText = document.querySelector('.btn-text');
const spinner = document.querySelector('.spinner');
const successMessage = document.getElementById('success-message');
const passwordInput = document.getElementById('senha');
const passwordStrength = document.getElementById('password-strength');
const cpfInput = document.getElementById('cpf');
const telefoneInput = document.getElementById('telefone');

// Password Strength Checker
passwordInput.addEventListener('input', () => {
    const password = passwordInput.value;
    let strength = 0;
    let feedback = '';

    if (password.length >= 8) strength++;
    if (password.match(/[a-z]/)) strength++;
    if (password.match(/[A-Z]/)) strength++;
    if (password.match(/[0-9]/)) strength++;
    if (password.match(/[^a-zA-Z0-9]/)) strength++;

    switch (strength) {
        case 0:
        case 1:
            feedback = 'Senha muito fraca';
            passwordStrength.className = 'password-strength strength-weak';
            break;
        case 2:
        case 3:
            feedback = 'Senha média';
            passwordStrength.className = 'password-strength strength-medium';
            break;
        case 4:
        case 5:
            feedback = 'Senha forte';
            passwordStrength.className = 'password-strength strength-strong';
            break;
    }

    passwordStrength.textContent = feedback;
});

// CPF Formatting
cpfInput.addEventListener('input', (e) => {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length <= 11) {
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        e.target.value = value;
    }
});

// Phone Number Formatting
telefoneInput.addEventListener('input', (e) => {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length <= 11) {
        value = value.replace(/(\d{2})(\d)/, '($1) $2');
        value = value.replace(/(\d{5})(\d{4})$/, '$1-$2');
        e.target.value = value;
    }
});

// Form Submission
form.addEventListener('submit', (e) => {
    e.preventDefault();
    
    // Basic validation
    const nome = document.getElementById('nome').value.trim();
    const sobrenome = document.getElementById('sobrenome').value.trim();
    const email = document.getElementById('email').value.trim();
    const senha = passwordInput.value;
    const dataNascimento = document.getElementById('data-nascimento').value;
    const telefone = telefoneInput.value;
    const cpf = cpfInput.value;

    if (!nome || !sobrenome || !email || !senha || !dataNascimento || !telefone || !cpf) {
        alert('Por favor, preencha todos os campos.');
        return;
    }

    if (senha.length < 8) {
        alert('A senha deve ter pelo menos 8 caracteres.');
        return;
    }

    // Show loading state
    submitBtn.classList.add('loading');
    btnText.textContent = 'Cadastrando...';
    spinner.classList.remove('hidden');

    // Simulate API call
    setTimeout(() => {
        // Hide loading state
        submitBtn.classList.remove('loading');
        btnText.textContent = 'Cadastrar';
        spinner.classList.add('hidden');

        // Show success message
        successMessage.classList.remove('hidden');
        form.classList.add('hidden');

        // Redirect after 3 seconds
        setTimeout(() => {
            window.location.href = '../index.html';
        }, 3000);
    }, 2000);
});

// Add smooth animations on load
document.addEventListener('DOMContentLoaded', () => {
    const container = document.querySelector('.cadastro-container');
    container.classList.add('fade-in', 'visible');
});

// Utility function for debouncing
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Real-time validation feedback
const inputs = form.querySelectorAll('input[required]');
inputs.forEach(input => {
    input.addEventListener('blur', () => {
        if (input.value.trim() === '') {
            input.style.borderColor = 'var(--danger-color)';
        } else {
            input.style.borderColor = 'var(--success-color)';
        }
    });

    input.addEventListener('focus', () => {
        input.style.borderColor = 'var(--primary-color)';
    });
});

// Social login placeholders
document.querySelectorAll('.social-button').forEach(button => {
    button.addEventListener('click', (e) => {
        e.preventDefault();
        const platform = button.classList[1].replace('social-', '');
        alert(`Login com ${platform.charAt(0).toUpperCase() + platform.slice(1)} em desenvolvimento.`);
    });
});

// Add visual feedback for form interactions
form.addEventListener('input', debounce(() => {
    const isValid = Array.from(inputs).every(input => input.value.trim() !== '');
    submitBtn.style.opacity = isValid ? '1' : '0.7';
}, 300));
