<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes, viewport-fit=cover">
    <title>HRM Pulse | Intelligent HR Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #0f172a;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
            overflow-y: auto;
            padding: 20px 0;
        }

        /* Animated Background Grid */
        .grid-bg {
            position: fixed;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(rgba(56, 189, 248, 0.08) 1px, transparent 1px),
                linear-gradient(90deg, rgba(56, 189, 248, 0.08) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: gridMove 20s linear infinite;
            pointer-events: none;
            z-index: 0;
        }

        @keyframes gridMove {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }

        /* Floating Orbs */
        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            z-index: 0;
            pointer-events: none;
        }

        .orb-1 {
            width: min(400px, 70vw);
            height: min(400px, 70vw);
            background: #38bdf8;
            top: -20%;
            left: -20%;
            opacity: 0.3;
            animation: orbFloat 15s ease-in-out infinite;
        }

        .orb-2 {
            width: min(500px, 80vw);
            height: min(500px, 80vw);
            background: #a78bfa;
            bottom: -20%;
            right: -20%;
            opacity: 0.3;
            animation: orbFloat 20s ease-in-out infinite reverse;
        }

        .orb-3 {
            width: min(300px, 60vw);
            height: min(300px, 60vw);
            background: #f472b6;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.15;
            animation: orbPulse 10s ease-in-out infinite;
        }

        @keyframes orbFloat {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(30px, 30px) scale(1.08); }
        }

        @keyframes orbPulse {
            0%, 100% { opacity: 0.15; transform: translate(-50%, -50%) scale(1); }
            50% { opacity: 0.25; transform: translate(-50%, -50%) scale(1.15); }
        }

        /* Main Container */
        .container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 1300px;
            margin: 0 auto;
            padding: 20px 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 48px;
        }

        /* Left Side - Branding */
        .brand-section {
            flex: 1;
            color: white;
            padding: 20px 20px 20px 0;
            animation: slideInLeft 0.8s ease-out;
        }

        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-40px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .brand-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #38bdf8, #a78bfa);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 28px;
            box-shadow: 0 20px 30px -10px rgba(56, 189, 248, 0.3);
            animation: iconPop 0.8s ease-out;
        }

        @keyframes iconPop {
            0% { transform: scale(0); opacity: 0; }
            70% { transform: scale(1.05); }
            100% { transform: scale(1); opacity: 1; }
        }

        .brand-icon i {
            font-size: 34px;
            color: white;
        }

        .brand-title {
            font-size: clamp(36px, 8vw, 52px);
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 16px;
            background: linear-gradient(135deg, #fff, #cbd5e1);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .brand-highlight {
            background: linear-gradient(135deg, #38bdf8, #a78bfa);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .brand-description {
            font-size: clamp(14px, 4vw, 18px);
            color: #94a3b8;
            margin-bottom: 32px;
            line-height: 1.5;
            max-width: 500px;
        }

        /* Stats */
        .stats-container {
            display: flex;
            gap: clamp(20px, 5vw, 40px);
            flex-wrap: wrap;
        }

        .stat-item {
            animation: fadeInUp 0.8s ease-out;
            animation-fill-mode: both;
        }

        .stat-item:nth-child(1) { animation-delay: 0.1s; }
        .stat-item:nth-child(2) { animation-delay: 0.2s; }
        .stat-item:nth-child(3) { animation-delay: 0.3s; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .stat-number {
            font-size: clamp(26px, 6vw, 34px);
            font-weight: 700;
            color: white;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #64748b;
            font-size: clamp(11px, 3.5vw, 14px);
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        /* Right Side - Login Card */
        .login-section {
            flex: 1;
            max-width: 480px;
            width: 100%;
            animation: slideInRight 0.8s ease-out;
        }

        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(40px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .login-card {
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 40px;
            padding: clamp(30px, 6vw, 48px) clamp(20px, 5vw, 40px);
            box-shadow: 0 30px 60px -20px rgba(0, 0, 0, 0.6);
            transition: transform 0.3s ease;
        }

        .login-header {
            text-align: center;
            margin-bottom: clamp(28px, 6vw, 40px);
        }

        .login-header h2 {
            font-size: clamp(26px, 6vw, 34px);
            font-weight: 700;
            color: white;
            margin-bottom: 8px;
        }

        .login-header p {
            color: #94a3b8;
            font-size: clamp(13px, 3.8vw, 16px);
        }

        /* Alert */
        .alert-modern {
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.25);
            border-radius: 24px;
            padding: 14px 18px;
            margin-bottom: 28px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #f87171;
            animation: shake 0.4s ease-in-out;
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.12);
            border: 1px solid rgba(34, 197, 94, 0.25);
            color: #4ade80;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-6px); }
            75% { transform: translateX(6px); }
        }

        .alert-modern i:first-child {
            font-size: 18px;
            flex-shrink: 0;
        }

        .alert-modern span {
            flex: 1;
            font-size: 13px;
            line-height: 1.4;
            word-break: break-word;
        }

        .alert-close {
            cursor: pointer;
            opacity: 0.7;
            transition: opacity 0.2s;
            flex-shrink: 0;
            font-size: 14px;
        }

        .alert-close:hover {
            opacity: 1;
        }

        /* Form Group */
        .form-group {
            margin-bottom: 22px;
        }

        .form-label {
            display: block;
            color: #cbd5e1;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 8px;
            letter-spacing: 0.8px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            font-size: 18px;
            transition: all 0.2s;
            z-index: 2;
            pointer-events: none;
        }

        .form-input {
            width: 100%;
            height: 56px;
            background: rgba(255, 255, 255, 0.03);
            border: 1.5px solid rgba(255, 255, 255, 0.08);
            border-radius: 28px;
            padding: 0 48px 0 52px;
            color: white;
            font-size: 16px;
            font-family: 'Inter', sans-serif;
            transition: all 0.25s;
            -webkit-appearance: none;
        }

        .form-input:focus {
            outline: none;
            border-color: #38bdf8;
            background: rgba(56, 189, 248, 0.06);
            box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.15);
        }

        .form-input:focus + .input-icon {
            color: #38bdf8;
        }

        .password-toggle {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            cursor: pointer;
            font-size: 18px;
            transition: color 0.2s;
            z-index: 2;
            padding: 8px;
            border-radius: 50%;
        }

        .password-toggle:hover {
            color: #38bdf8;
        }

        /* Options */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 24px 0 28px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            color: #94a3b8;
            font-size: 14px;
        }

        .checkbox-wrapper input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #38bdf8;
            margin: 0;
        }

        .forgot-link {
            color: #94a3b8;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.2s;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .forgot-link:hover {
            color: #38bdf8;
        }

        /* Login Button */
        .login-btn {
            width: 100%;
            height: 56px;
            background: linear-gradient(135deg, #38bdf8, #a78bfa);
            border: none;
            border-radius: 30px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: all 0.25s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            box-shadow: 0 8px 20px -8px rgba(56, 189, 248, 0.3);
        }

        .login-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.25), transparent);
            transition: left 0.5s;
        }

        .login-btn:hover::before {
            left: 100%;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 28px -12px rgba(56, 189, 248, 0.45);
        }

        .login-btn:active {
            transform: translateY(1px);
        }

        .login-btn.loading {
            pointer-events: none;
            opacity: 0.85;
        }

        .login-btn.loading i {
            animation: spin 0.9s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Features */
        .features {
            display: flex;
            gap: clamp(12px, 4vw, 20px);
            margin-top: 32px;
            padding-top: 28px;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            justify-content: center;
            flex-wrap: wrap;
        }

        .feature {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #94a3b8;
            font-size: 12px;
            font-weight: 500;
        }

        .feature i {
            color: #38bdf8;
            font-size: 14px;
        }

        /* ========== MOBILE VIEW - HIDE BRAND SECTION ========== */
        @media (max-width: 1024px) {
            .container {
                flex-direction: column;
                gap: 32px;
                padding: 20px;
            }
            
            .brand-section {
                text-align: center;
                padding: 16px 12px;
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            
            .brand-description {
                margin-left: auto;
                margin-right: auto;
                text-align: center;
            }
            
            .stats-container {
                justify-content: center;
                width: 100%;
            }
            
            .login-section {
                max-width: 500px;
                width: 100%;
                margin: 0 auto;
            }
        }

        /* Mobile Devices - Hide brand section completely */
        @media (max-width: 768px) {
            .brand-section {
                display: none !important;
            }
            
            .container {
                padding: 16px;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
            }
            
            .login-section {
                max-width: 450px;
                width: 100%;
                margin: 0 auto;
            }
            
            .login-card {
                padding: 32px 24px;
                border-radius: 32px;
                box-shadow: 0 30px 60px -20px rgba(0, 0, 0, 0.5);
            }
            
            .login-header h2 {
                font-size: 28px;
            }
            
            .login-header p {
                font-size: 14px;
            }
            
            .form-input {
                height: 52px;
                font-size: 15px;
            }
            
            .login-btn {
                height: 52px;
                font-size: 15px;
            }
        }

        /* Small Mobile Devices */
        @media (max-width: 480px) {
            .container {
                padding: 12px;
            }
            
            .login-card {
                padding: 28px 20px;
                border-radius: 28px;
            }
            
            .login-header {
                margin-bottom: 28px;
            }
            
            .login-header h2 {
                font-size: 26px;
            }
            
            .form-group {
                margin-bottom: 20px;
            }
            
            .form-options {
                margin: 20px 0 24px;
            }
            
            .features {
                margin-top: 28px;
                padding-top: 24px;
                gap: 16px;
            }
            
            .feature {
                font-size: 11px;
            }
        }

        /* Extra Small Devices */
        @media (max-width: 380px) {
            .login-card {
                padding: 24px 16px;
                border-radius: 24px;
            }
            
            .login-header h2 {
                font-size: 24px;
            }
            
            .form-input {
                height: 48px;
                font-size: 14px;
                padding: 0 40px 0 48px;
            }
            
            .login-btn {
                height: 48px;
                font-size: 14px;
            }
        }

        /* Landscape Mode on Mobile */
        @media (max-height: 600px) and (orientation: landscape) {
            body {
                padding: 10px 0;
                align-items: center;
            }
            
            .brand-section {
                display: none !important;
            }
            
            .container {
                padding: 10px;
                min-height: auto;
            }
            
            .login-card {
                padding: 20px 24px;
            }
            
            .login-header {
                margin-bottom: 20px;
            }
            
            .login-header h2 {
                font-size: 24px;
            }
            
            .form-group {
                margin-bottom: 16px;
            }
            
            .features {
                margin-top: 20px;
                padding-top: 16px;
            }
        }

        /* Hide scrollbar but keep functionality */
        ::-webkit-scrollbar {
            width: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: #1e293b;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #475569;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #5b6e8c;
        }
        
        /* iOS input fixes */
        input, button {
            border-radius: 28px;
            -webkit-appearance: none;
            appearance: none;
        }
        
        /* Safe area support */
        @supports (padding: max(0px)) {
            .container {
                padding-left: max(16px, env(safe-area-inset-left));
                padding-right: max(16px, env(safe-area-inset-right));
            }
        }
    </style>
</head>
<body>
    <div class="grid-bg"></div>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <div class="container">
        <!-- Left Brand Section - Hidden on mobile (max-width: 768px) -->
        <div class="brand-section">
            <div class="brand-icon">
                <i class="fas fa-chart-pie"></i>
            </div>
            <h1 class="brand-title">
                HRM <span class="brand-highlight">Pulse</span>
            </h1>
            <p class="brand-description">
                Next-gen HR management platform that helps you track, analyze, and optimize your workforce with AI-powered insights.
            </p>
            
            <div class="stats-container">
                <div class="stat-item">
                    <div class="stat-number">98%</div>
                    <div class="stat-label">SATISFACTION</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">24/7</div>
                    <div class="stat-label">SUPPORT</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">2K+</div>
                    <div class="stat-label">ACTIVE USERS</div>
                </div>
            </div>
        </div>

        <!-- Right Login Section -->
        <div class="login-section">
            <div class="login-card">
                <div class="login-header">
                    <h2>Welcome Back</h2>
                    <p>Sign in to access your HR dashboard</p>
                </div>

                <!-- Alert Container -->
                <div id="alertContainer"></div>

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf
                    
                    <!-- Email Field -->
                    <div class="form-group">
                        <label class="form-label">EMAIL ADDRESS</label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" 
                                   class="form-input" 
                                   name="email" 
                                   id="emailInput"
                                   placeholder="Enter your email"
                                   value="{{ old('email') }}"
                                   required 
                                   autofocus>
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div class="form-group">
                        <label class="form-label">PASSWORD</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" 
                                   class="form-input" 
                                   name="password" 
                                   id="passwordInput"
                                   placeholder="Enter your password"
                                   required>
                            <i class="fas fa-eye password-toggle" id="togglePasswordIcon" onclick="togglePassword()"></i>
                        </div>
                    </div>

                    <!-- Options -->
                    <div class="form-options">
                        <label class="checkbox-wrapper">
                            <input type="checkbox" name="remember" id="rememberCheckbox">
                            <span>Remember me</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="forgot-link">
                            <i class="fas fa-key"></i>
                            Forgot Password?
                        </a>
                    </div>

                    <!-- Login Button -->
                    <button type="submit" class="login-btn" id="loginBtn">
                        <i class="fas fa-arrow-right-to-bracket"></i>
                        <span>Sign In</span>
                    </button>

                    <!-- Features -->
                    <div class="features">
                        <div class="feature">
                            <i class="fas fa-shield-haltered"></i>
                            <span>Secure</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-gauge-high"></i>
                            <span>Fast</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-headset"></i>
                            <span>24/7 Support</span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Password Toggle Function
        function togglePassword() {
            const passwordInput = document.getElementById('passwordInput');
            const toggleIcon = document.getElementById('togglePasswordIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Show Alert Function
        function showAlert(message, type = 'error') {
            const alertContainer = document.getElementById('alertContainer');
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert-modern ${type === 'success' ? 'alert-success' : ''}`;
            alertDiv.innerHTML = `
                <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
                <span>${message}</span>
                <i class="fas fa-times alert-close" onclick="this.parentElement.remove()"></i>
            `;
            
            // Remove existing alerts
            const existingAlerts = alertContainer.querySelectorAll('.alert-modern');
            existingAlerts.forEach(alert => alert.remove());
            
            alertContainer.appendChild(alertDiv);
            
            // Auto dismiss after 5 seconds
            setTimeout(() => {
                if (alertDiv && alertDiv.parentElement) {
                    alertDiv.style.transition = 'opacity 0.4s, transform 0.3s';
                    alertDiv.style.opacity = '0';
                    alertDiv.style.transform = 'translateX(15px)';
                    setTimeout(() => {
                        if (alertDiv && alertDiv.parentElement) alertDiv.remove();
                    }, 400);
                }
            }, 5000);
        }

        // Display server-side errors if present
        @if (session('error'))
            showAlert('{{ session('error') }}', 'error');
        @endif

        @if ($errors->any())
            showAlert('{{ $errors->first() }}', 'error');
        @endif

        // Form submission handling
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const email = document.querySelector('input[name="email"]').value.trim();
            const password = document.querySelector('input[name="password"]').value;
            const btn = document.getElementById('loginBtn');
            
            // Client-side validation
            if (!email) {
                e.preventDefault();
                showAlert('Please enter your email address', 'error');
                return false;
            }
            
            if (!password) {
                e.preventDefault();
                showAlert('Please enter your password', 'error');
                return false;
            }
            
            if (!email.includes('@') || !email.includes('.')) {
                e.preventDefault();
                showAlert('Please enter a valid email address', 'error');
                return false;
            }
            
            // Show loading state
            btn.classList.add('loading');
            const originalIcon = btn.querySelector('i').className;
            const originalText = btn.querySelector('span').innerText;
            btn.innerHTML = '<i class="fas fa-circle-notch"></i><span>Authenticating...</span>';
            
            // Restore button if submission fails
            setTimeout(() => {
                if (btn.classList.contains('loading')) {
                    btn.classList.remove('loading');
                    btn.innerHTML = `<i class="${originalIcon}"></i><span>${originalText}</span>`;
                }
            }, 10000);
        });

        // Input focus animations
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('focus', function() {
                const icon = this.parentElement.querySelector('.input-icon');
                if (icon) icon.style.color = '#38bdf8';
            });
            
            input.addEventListener('blur', function() {
                const icon = this.parentElement.querySelector('.input-icon');
                if (icon && !this.value) icon.style.color = '#64748b';
            });
        });

        // Smooth parallax effect
        let ticking = false;
        document.addEventListener('mousemove', function(e) {
            if (!ticking) {
                requestAnimationFrame(function() {
                    const mouseX = e.clientX / window.innerWidth;
                    const mouseY = e.clientY / window.innerHeight;
                    const orb1 = document.querySelector('.orb-1');
                    const orb2 = document.querySelector('.orb-2');
                    if (orb1 && orb2) {
                        orb1.style.transform = `translate(${mouseX * 30}px, ${mouseY * 30}px)`;
                        orb2.style.transform = `translate(${-mouseX * 30}px, ${-mouseY * 30}px)`;
                    }
                    ticking = false;
                });
                ticking = true;
            }
        });
    </script>
</body>
</html>