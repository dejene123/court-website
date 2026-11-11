<?php
require_once 'db.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // Validate role
    $allowed_roles = ['admin', 'president', 'inspection', 'woreda president'];
    if (in_array($role, $allowed_roles)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->execute([$username, $email, $password, $role]);
            $message = "<p style='color: green; text-align:center;'>Registration successful! <a href='login.php'>Log in here</a></p>";
        } catch (\PDOException $e) {
            $message = "<p style='color: red; text-align:center;'>Error: Username or Email already exists.</p>";
        }
    } else {
        $message = "<p style='color: red; text-align:center;'>Invalid role selected.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="om">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Shaashamannee City Court</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --main-nav-bg: #0c2340;
            --body-bg: #bebebe;
            --card-border-bg: #1c4e5e;
            --footer-bg: #008cdb;
            --footer-dark: #005f96;
            --text-dark: #1f2937;
            --red-text: #d9534f;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: Arial, Helvetica, sans-serif; }
        body { background-color: var(--body-bg); color: var(--text-dark); min-height: 100vh; display: flex; flex-direction: column; }
        header { background-color: #d1e0eb; border-bottom: 2px solid #b0c4de; }
        .header-container { max-width: 1280px; margin: 0 auto; padding: 10px 20px; display: flex; align-items: center; justify-content: space-between; }
        .branding-group { display: flex; align-items: center; gap: 15px; }
        .court-logo { width: 75px; height: 75px; border-radius: 50%; background: #ffffff; border: 2px solid #008cdb; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .court-logo i { font-size: 38px; color: #0c2340; }
        .titles-box h1 { font-size: 1.05rem; color: #0c2340; font-weight: bold; }
        .titles-box h2 { font-size: 0.95rem; color: #1a365d; font-weight: 600; }
        nav { background-color: var(--main-nav-bg); }
        .nav-container { max-width: 1280px; margin: 0 auto; display: flex; align-items: center; justify-content: center; }
        .nav-menu { display: flex; list-style: none; }
        .nav-menu li a { display: block; padding: 12px 14px; color: #ffffff; font-size: 0.78rem; text-decoration: none; }
        .nav-menu li a:hover { background-color: rgba(255, 255, 255, 0.1); }
        
        .main-content { max-width: 450px; margin: 40px auto; padding: 25px; background: #133845; border-radius: 6px; box-shadow: 0 4px 10px rgba(0,0,0,0.3); color: #fff; flex-grow: 1; width: 100%; }
        .main-content h2 { text-align: center; margin-bottom: 20px; color: #38bdf8; font-size: 1.4rem; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-size: 0.85rem; }
        .form-group input, .form-group select { width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc; font-size: 0.9rem; }
        .btn-submit { width: 100%; background-color: #008cdb; color: #fff; padding: 10px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 0.95rem; margin-top: 10px; }
        .btn-submit:hover { background-color: #005f96; }
        .auth-links { text-align: center; margin-top: 15px; font-size: 0.85rem; }
        .auth-links a { color: #38bdf8; text-decoration: underline; }

        footer { background-color: var(--footer-bg); color: #ffffff; margin-top: auto; padding-top: 25px; }
        .footer-container { max-width: 1100px; margin: 0 auto; padding: 0 20px 25px 20px; display: grid; grid-template-columns: repeat(4, 1fr); gap: 30px; }
        .footer-col h4 { font-size: 0.9rem; font-weight: bold; margin-bottom: 12px; }
        .footer-col ul { list-style: none; }
        .footer-col ul li { font-size: 0.75rem; margin-bottom: 8px; color: #f0f8ff; }
        .copyright-bar { background-color: var(--footer-dark); text-align: center; padding: 10px; font-size: 0.75rem; color: #ffffff; }
        @media (max-width: 600px) { .footer-container { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <div class="branding-group">
                <div class="court-logo"><i class="fas fa-balance-scale"></i></div>
                <div class="titles-box">
                    <h1>Mana Murtii Waliigalaa Magaalaa Shaashamannee</h1>
                    <h2>Shaashamannee City High Court</h2>
                </div>
            </div>
        </div>
    </header>

    <nav>
        <div class="nav-container">
            <ul class="nav-menu">
                <li><a href="index.php">Home</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php" style="background-color: rgba(255,255,255,0.1);">Register</a></li>
            </ul>
        </div>
    </nav>

    <div class="main-content">
        <h2>Account Registration</h2>
        <?php echo $message; ?>
        <form action="register.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="role">Select Role</label>
                <select id="role" name="role" required>
                    <option value="">-- Choose Role --</option>
                    <option value="admin">Admin</option>
                    <option value="president">President</option>
                    <option value="inspection">Inspection</option>
                    <option value="woreda president">Woreda President</option>
                </select>
            </div>
            <button type="submit" class="btn-submit">Register Account</button>
        </form>
        <div class="auth-links">
            Already have an account? <a href="login.php">Log in here</a>
        </div>
    </div>

    <footer>
        <div class="footer-container">
            <div class="footer-col">
                <h4>Contact Us</h4>
                <ul>
                    <li>Shaashamannee</li>
                    <li><strong>Phone:</strong> 8794</li>
                    <li><strong>Email:</strong> mmoshhrm@gmail.com</li>
                </ul>
            </div>
        </div>
        <div class="copyright-bar">
            © 2026 <strong>Shaashamannee City Court.</strong> | ✆ 8794
        </div>
    </footer>
</body>
</html>