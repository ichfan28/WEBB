<?php
session_start();

// Simulasi data user (tanpa database)
$users = [
    'admin' => [
        'password' => 'admin123',
        'role' => 'admin',
        'nama' => 'Administrator'
    ],
    'staff' => [
        'password' => 'staff123',
        'role' => 'staff',
        'nama' => 'Staff Penjualan'
    ],
    'pelanggan' => [
        'password' => 'pelanggan123',
        'role' => 'pelanggan',
        'nama' => 'Pelanggan Setia'
    ]
];

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (isset($users[$username])) {
        if ($password === $users[$username]['password']) {
            $_SESSION['user'] = [
                'username' => $username,
                'role' => $users[$username]['role'],
                'nama' => $users[$username]['nama']
            ];

            // Redirect berdasarkan role
            switch ($users[$username]['role']) {
                case 'admin':
                    header('Location: admin.php');
                    break;
                case 'staff':
                    header('Location: staff.php');
                    break;
                case 'pelanggan':
                    header('Location: pelanggan.php');
                    break;
                default:
                    header('Location: index.php');
            }
            exit();
        } else {
            $error = 'Password yang Anda masukkan salah!';
        }
    } else {
        $error = 'Username tidak ditemukan!';
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HelmKu - Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* Login Page Styles */
        :root {
            --primary-color: #f8c537;
            --dark-color: #1a1a1a;
            --light-color: #f5f5f5;
            --danger-color: #e74c3c;
            --success-color: #2ecc71;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            line-height: 1.6;
        }

        .login-container {
            display: flex;
            min-height: 100vh;
        }

        .login-left {
            flex: 1;
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
                url('assets/images/login-bg.jpg') no-repeat center center/cover;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 3rem;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .login-left::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: rgba(248, 197, 55, 0.1);
            transform: rotate(15deg);
            z-index: 1;
        }

        .login-left-content {
            position: relative;
            z-index: 2;
            max-width: 500px;
        }

        .login-left h1 {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            color: var(--primary-color);
        }

        .login-left p {
            margin-bottom: 2rem;
            font-size: 1.1rem;
        }

        .login-features {
            margin-top: 3rem;
        }

        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .feature-icon {
            font-size: 1.5rem;
            margin-right: 1rem;
            color: var(--primary-color);
        }

        .login-right {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        .login-form-container {
            background: white;
            padding: 3rem;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            animation: fadeInUp 0.5s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-logo {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-logo img {
            height: 150px;
        }

        .login-form-container h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: var(--dark-color);
            font-size: 1.8rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #555;
        }

        .form-control {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(248, 197, 55, 0.2);
        }

        .password-toggle {
            position: absolute;
            right: 10px;
            top: 35px;
            cursor: pointer;
            color: #777;
        }

        .btn-login {
            width: 100%;
            padding: 1rem;
            background-color: var(--primary-color);
            color: var(--dark-color);
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 1rem;
        }

        .btn-login:hover {
            background-color: #e0b431;
            transform: translateY(-2px);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .login-footer {
            text-align: center;
            margin-top: 2rem;
            color: #777;
        }

        .login-footer a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }

        .alert {
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1.5rem;
            font-weight: 500;
            text-align: center;
        }

        .alert-danger {
            background-color: rgba(231, 76, 60, 0.1);
            color: var(--danger-color);
            border: 1px solid rgba(231, 76, 60, 0.3);
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
        }

        .remember-me input {
            margin-right: 0.5rem;
        }

        .forgot-password a {
            color: #777;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .forgot-password a:hover {
            color: var(--primary-color);
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }

            .login-left {
                padding: 2rem 1.5rem;
                text-align: center;
            }

            .login-left-content {
                max-width: 100%;
            }

            .login-features {
                display: none;
            }

            .login-form-container {
                padding: 2rem;
                box-shadow: none;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-left">
            <div class="login-left-content">
                <h1>Selamat Datang Kembali</h1>
                <p>Masuk ke akun HelmKu Anda untuk mengakses semua fitur eksklusif dan penawaran khusus bagi member
                    kami.</p>

                <div class="login-features">
                    <div class="feature-item">
                        <div class="feature-icon">🛡️</div>
                        <div>
                            <h3>Keamanan Terjamin</h3>
                            <p>Data Anda terlindungi dengan sistem keamanan terbaik</p>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">🚀</div>
                        <div>
                            <h3>Akses Cepat</h3>
                            <p>Proses login cepat dan mudah tanpa hambatan</p>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">🎁</div>
                        <div>
                            <h3>Promo Member</h3>
                            <p>Dapatkan akses ke promo khusus untuk member</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="login-right">
            <div class="login-form-container">
                <div class="login-logo">
                    <img src="helem6.jpeg" alt="HelmKu Logo">
                </div>

                <h2>Masuk ke Akun Anda</h2>

                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <form method="POST" action="login.php">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" class="form-control" required
                            value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                        <span class="password-toggle" id="togglePassword">👁️</span>
                    </div>

                    <div class="remember-forgot">
                        <div class="remember-me">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">Ingat saya</label>
                        </div>
                        <div class="forgot-password">
                            <a href="#">Lupa password?</a>
                        </div>
                    </div>

                    <button type="submit" class="btn-login">MASUK</button>

                    <div class="login-footer">
                        <p>Belum punya akun? <a href="register.php">Daftar sekarang</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.textContent = type === 'password' ? '👁️' : '👁️‍🗨️';
        });

        // Add animation when input is focused
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function () {
                this.parentElement.querySelector('label').style.color = '#f8c537';
            });

            input.addEventListener('blur', function () {
                this.parentElement.querySelector('label').style.color = '#555';
            });
        });

        // Simulate form submission animation
        const form = document.querySelector('form');
        form.addEventListener('submit', function (e) {
            const btn = this.querySelector('.btn-login');
            if (!this.checkValidity()) {
                e.preventDefault();
                btn.textContent = 'Harap isi semua field!';
                btn.style.backgroundColor = '#e74c3c';
                setTimeout(() => {
                    btn.textContent = 'MASUK';
                    btn.style.backgroundColor = '#f8c537';
                }, 2000);
            } else {
                btn.textContent = 'Memproses...';
                btn.style.backgroundColor = '#2ecc71';
            }
        });
    </script>
</body>

</html>