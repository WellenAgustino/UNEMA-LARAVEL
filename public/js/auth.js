// Curtain Loader Animation
document.addEventListener('DOMContentLoaded', function() {
    const curtainLoader = document.getElementById('curtainLoader');
    
    setTimeout(() => {
        curtainLoader.style.display = 'none';
    }, 1500);
});

// Form Handling
const loginForm = document.getElementById('loginForm');
const registerForm = document.getElementById('registerForm');

if (loginForm) {
    loginForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const loginBtn = document.getElementById('loginBtn');
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        
        loginBtn.classList.add('loading');
        loginBtn.disabled = true;
        
        try {
            const response = await fetch('/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({
                    email: email,
                    password: password
                })
            });
            
            if (response.ok) {
                window.location.href = '/';
            } else {
                showError('Email atau password salah');
            }
        } catch (error) {
            showError('Terjadi kesalahan. Silakan coba lagi.');
        } finally {
            loginBtn.classList.remove('loading');
            loginBtn.disabled = false;
        }
    });
}

if (registerForm) {
    registerForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const registerBtn = document.getElementById('registerBtn');
        const fullName = document.getElementById('fullName').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPassword').value;
        
        if (password !== confirmPassword) {
            showError('Password tidak cocok');
            return;
        }
        
        registerBtn.classList.add('loading');
        registerBtn.disabled = true;
        
        try {
            const response = await fetch('/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({
                    username: fullName.toLowerCase().replace(/\s+/g, '_'),
                    full_name: fullName,
                    email: email,
                    password: password,
                    password_confirmation: confirmPassword
                })
            });
            
            if (response.ok) {
                showSuccess('Registrasi berhasil! Silakan login.');
                setTimeout(() => {
                    window.location.href = '/login';
                }, 2000);
            } else {
                const data = await response.json();
                showError(data.message || 'Registrasi gagal');
            }
        } catch (error) {
            showError('Terjadi kesalahan. Silakan coba lagi.');
        } finally {
            registerBtn.classList.remove('loading');
            registerBtn.disabled = false;
        }
    });
}

// Show Error Message
function showError(message) {
    const form = loginForm || registerForm;
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message';
    errorDiv.innerHTML = `<i class="fas fa-exclamation-circle"></i><span>${message}</span>`;
    
    form.insertBefore(errorDiv, form.firstChild);
    
    setTimeout(() => {
        errorDiv.remove();
    }, 5000);
}

// Show Success Message
function showSuccess(message) {
    const form = loginForm || registerForm;
    const successDiv = document.createElement('div');
    successDiv.className = 'success-message';
    successDiv.innerHTML = `<i class="fas fa-check-circle"></i><span>${message}</span>`;
    
    form.insertBefore(successDiv, form.firstChild);
}

// Password visibility toggle
document.querySelectorAll('.input-wrapper input[type="password"]').forEach(input => {
    const wrapper = input.parentElement;
    const icon = wrapper.querySelector('i');
    
    icon.style.cursor = 'pointer';
    icon.addEventListener('click', function() {
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-lock');
            icon.classList.add('fa-eye');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-lock');
        }
    });
});

