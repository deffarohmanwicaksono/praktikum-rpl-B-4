const togglePasswordButton = document.getElementById('togglePasswordButton');
const passwordInput = document.getElementById('password');
const passwordIcon = document.getElementById('passwordIcon');

const loginForm = document.getElementById('loginForm');
const loginButton = document.getElementById('loginButton');
const loginButtonText = document.getElementById('loginButtonText');

/* =========================================================
   Toggle Password Visibility
   ========================================================= */
if (togglePasswordButton && passwordInput && passwordIcon) {

    togglePasswordButton.addEventListener('click', () => {

        const isPasswordHidden = passwordInput.type === 'password';

        passwordInput.type = isPasswordHidden
            ? 'text'
            : 'password';

        passwordIcon.className = isPasswordHidden
            ? 'bi bi-eye-slash'
            : 'bi bi-eye';
    });
}
