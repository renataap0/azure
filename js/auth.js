// Simulação de sistema de autenticação
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            // Simular verificação
            if (email && password) {
                alert('Login realizado com sucesso!');
                document.getElementById('loginModal').classList.remove('active');
                document.querySelector('.user-icon i').className = 'fas fa-user-check';
            } else {
                alert('Por favor, preencha todos os campos.');
            }
        });
    }
    
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const name = document.getElementById('reg-name').value;
            const email = document.getElementById('reg-email').value;
            const password = document.getElementById('reg-password').value;
            const confirm = document.getElementById('reg-confirm').value;
            
            // Validação simples
            if (!name || !email || !password || !confirm) {
                alert('Por favor, preencha todos os campos.');
                return;
            }
            
            if (password !== confirm) {
                alert('As senhas não coincidem.');
                return;
            }
            
            // Simular cadastro
            alert('Cadastro realizado com sucesso! Faça login para continuar.');
            document.getElementById('registerModal').classList.remove('active');
            document.getElementById('loginModal').classList.add('active');
            
            // Limpar formulário
            registerForm.reset();
        });
    }
});