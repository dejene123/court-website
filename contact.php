<?php
require_once 'db.php';

$successMessage = '';
$errorMessage = '';

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $department = trim($_POST['department'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $attachmentPath = null;

    if (empty($fullName) || empty($department) || empty($message)) {
        $errorMessage = "Maaloo bakkeewwan barbaachisoo guutaa (Please fill in required fields).";
    } else {
        // Handle File Upload if present
        if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $fileName = time() . '_' . basename($_FILES['attachment']['name']);
            $targetFilePath = $uploadDir . $fileName;
            if (move_uploaded_file($_FILES['attachment']['tmp_name'], $targetFilePath)) {
                $attachmentPath = $targetFilePath;
            }
        }

        try {
            $stmt = $pdo->prepare("INSERT INTO feedback_submissions (full_name, email, phone, department, message, attachment_path) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$fullName, $email, $phone, $department, $message, $attachmentPath]);
            $successMessage = "Galatoomaa! Yaadi yookiin eeruun keessan milkaa'inaan dhiyaateera.";
        } catch (PDOException $e) {
            $errorMessage = "Dogoggorri uumameera: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="om">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saanduqa Yaadaa fi Eeruu Naamusaa</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* CSS RESET & EXACT PALETTE STYLES */
        :root {
            --main-nav-bg: #0c2340;
            --body-bg: #bebebe;
            --card-border-blue: #38bdf8;
            --footer-bg: #008cdb;
            --footer-dark: #005f96;
            --text-dark: #1f2937;
            --red-text: #d9534f;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            background-color: var(--body-bg);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* HEADER AREA */
        header {
            background-color: #d1e0eb;
            border-bottom: 2px solid #b0c4de;
        }

        .header-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .branding-group {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .court-logo {
            width: 75px;
            height: 75px;
            border-radius: 50%;
            background: #ffffff;
            border: 2px solid #008cdb;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .court-logo i {
            font-size: 38px;
            color: #0c2340;
        }

        .titles-box h1 {
            font-size: 1.05rem;
            color: #0c2340;
            font-weight: bold;
        }

        .titles-box h2 {
            font-size: 0.95rem;
            color: #1a365d;
            font-weight: 600;
        }

        .titles-box h3 {
            font-size: 0.85rem;
            color: #2b6cb0;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-call {
            background-color: #ffffff;
            border: 1px solid #d1d5db;
            color: #1f2937;
            padding: 7px 20px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: bold;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .btn-call span {
            color: var(--red-text);
            font-weight: bold;
        }

        .btn-ecourt {
            background-color: #ffffff;
            border: 1.5px solid #008cdb;
            color: #0c2340;
            padding: 7px 22px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: bold;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        /* NAVIGATION BAR */
        nav {
            background-color: var(--main-nav-bg);
        }

        .nav-container {
            max-width: 1280px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: auto;
        }

        .nav-menu {
            display: flex;
            list-style: none;
        }

        .nav-menu li a {
            display: block;
            padding: 12px 14px;
            color: #ffffff;
            font-size: 0.78rem;
            white-space: nowrap;
        }

        .nav-menu li a:hover,
        .nav-menu li.active a {
            background-color: rgba(255, 255, 255, 0.1);
        }

        /* MAIN CONTENT AREA */
        .main-content {
            max-width: 950px;
            margin: 35px auto;
            padding: 0 15px;
            flex-grow: 1;
            width: 100%;
        }

        .contact-card {
            background-color: #ffffff;
            border: 3px solid var(--card-border-blue);
            border-radius: 12px;
            padding: 40px 50px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }

        .contact-card h2 {
            text-align: center;
            font-size: 1.4rem;
            color: #111827;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full-width {
            grid-column: span 2;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 0.9rem;
            color: #334155;
            background-color: #ffffff;
            outline: none;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            border-color: #0284c7;
            box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.1);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 140px;
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 16px;
        }

        .file-upload-box {
            display: flex;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            overflow: hidden;
            background-color: #f8fafc;
        }

        .file-btn {
            background-color: #e2e8f0;
            color: #334155;
            padding: 10px 20px;
            font-size: 0.85rem;
            font-weight: bold;
            cursor: pointer;
            border: none;
            border-right: 1px solid #cbd5e1;
        }

        .file-name-display {
            padding: 10px 15px;
            font-size: 0.85rem;
            color: #64748b;
            align-self: center;
        }

        .file-upload-box input[type="file"] {
            display: none;
        }

        .submit-container {
            text-align: center;
            margin-top: 25px;
        }

        .btn-submit {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            padding: 12px 35px;
            border-radius: 25px;
            font-size: 0.95rem;
            font-weight: bold;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 2px 6px rgba(0,123,255,0.3);
            transition: background-color 0.2s;
        }

        .btn-submit:hover {
            background-color: #0056b3;
        }

        .form-footer-note {
            text-align: center;
            font-size: 0.8rem;
            color: #475569;
            margin-top: 25px;
            line-height: 1.5;
        }

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 0.85rem;
            text-align: center;
        }

        .alert-error {
            background-color: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 0.85rem;
            text-align: center;
        }

        /* FOOTER AREA */
        footer {
            background-color: var(--footer-bg);
            color: #ffffff;
            margin-top: 40px;
            padding-top: 25px;
        }

        .footer-container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 20px 25px 20px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
        }

        .footer-col h4 {
            font-size: 0.9rem;
            font-weight: bold;
            margin-bottom: 12px;
        }

        .footer-col ul {
            list-style: none;
        }

        .footer-col ul li {
            font-size: 0.75rem;
            margin-bottom: 8px;
            color: #f0f8ff;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .footer-col ul li a:hover {
            text-decoration: underline;
        }

        .copyright-bar {
            background-color: var(--footer-dark);
            text-align: center;
            padding: 10px;
            font-size: 0.75rem;
            color: #ffffff;
        }

        /* RESPONSIVE LAYOUT */
        @media (max-width: 800px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            .form-group.full-width {
                grid-column: span 1;
            }
            .contact-card {
                padding: 25px 20px;
            }
            .footer-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .footer-container {
                grid-template-columns: 1fr;
            }
            .header-container {
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }
        }
    </style>
</head>
<body>

    <!-- 1. HEADER SECTION -->
 

    <!-- 2. MAIN NAVIGATION BAR -->
    <nav>
           <?php 
        
            require_once('header.php');
			?>
       
    </nav>

    <!-- 3. MAIN CONTENT AREA (CONTACT / FEEDBACK FORM CARD) -->
    <main class="main-content">
        <div class="contact-card">
            <h2>Saanduqa Yaadaa fi Eeruu Naamusaa</h2>

            <?php if (!empty($successMessage)): ?>
                <div class="alert-success"><?= htmlspecialchars($successMessage) ?></div>
            <?php endif; ?>
            <?php if (!empty($errorMessage)): ?>
                <div class="alert-error"><?= htmlspecialchars($errorMessage) ?></div>
            <?php endif; ?>

            <form action="contact.php" method="POST" enctype="multipart/form-data">
                <div class="form-grid">
                    <div class="form-group">
                        <input type="text" name="full_name" placeholder="Maqaa Guutuu Galmeessi" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Email (Optional)" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="text" name="phone" placeholder="Lakk. Bilbilaa (Optional)" class="form-control">
                    </div>
                    <div class="form-group">
                        <select name="department" class="form-control" required>
                            <option value="MMO Magaalaa Shaashamannee">MMO Magaalaa Shaashamannee</option>
                            <option value="Waajjira Naamusa">Waajjira Naamusa Ispeeksinii</option>
                            <option value="Waajjira Pirezdaantii">Waajjira Pirezdaantii</option>
                        </select>
                    </div>
                    <div class="form-group full-width">
                        <textarea name="message" placeholder="Yaada keessan / Lakk Galmee" class="form-control" required></textarea>
                    </div>
                    <div class="form-group full-width">
                        <label style="font-size: 0.85rem; font-weight: bold; color: #334155; margin-bottom: 6px;">Attach a file (PDF, DOC/DOCX, Image, MP3/WAV):</label>
                        <div class="file-upload-box">
                            <button type="button" class="file-btn" onclick="document.getElementById('file-input').click()">Browse...</button>
                            <span id="file-chosen" class="file-name-display">No file selected.</span>
                            <input type="file" id="file-input" name="attachment" onchange="updateFileName(this)">
                        </div>
                    </div>
                </div>

                <div class="submit-container">
                    <button type="submit" class="btn-submit">
                        <i class="fa-solid fa-paper-plane"></i> Olkaayi
                    </button>
                </div>
            </form>

            <div class="form-footer-note">
                Kabajamoo Abbaa Dhimmaa Kenyaa Eeruun keessan kallattuumaan Pirezidaantii Mana Murtii Ol'aanaa Magaalaa Shaashamannee fi Waajjira Naamusa Ispeeksinii bira deema. Yaada Keessaniif Galatoomaa!
            </div>
        </div>
    </main>

    <!-- 4. FOOTER SECTION -->
    <footer>
        <div class="footer-container">
            <div class="footer-col">
                <h4>Our services</h4>
                <ul>
                    <li><i class="fas fa-chevron-right" style="font-size: 0.6rem;"></i> <a href="#">E-filing</a></li>
                    <li><i class="fas fa-chevron-right" style="font-size: 0.6rem;"></i> <a href="#">Video Conference</a></li>
                    <li><i class="fas fa-chevron-right" style="font-size: 0.6rem;"></i> <a href="#">Hiikaa Afaanii</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Related Links</h4>
                <ul>
                    <li><i class="fas fa-chevron-right" style="font-size: 0.6rem;"></i> <a href="#">Eecourt.ShaashamanneeCity Court</a></li>
                    <li><i class="fas fa-chevron-right" style="font-size: 0.6rem;"></i> <a href="#">Oromia Supreme Court</a></li>
                    <li><i class="fas fa-chevron-right" style="font-size: 0.6rem;"></i> <a href="#">CAS</a></li>
                    <li><i class="fas fa-chevron-right" style="font-size: 0.6rem;"></i> <a href="#">Telegram</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Contact Us</h4>
                <ul>
                    <li>Shaashamannee</li>
                    <li>Shaashamannee, Oromia</li>
                    <li><strong>Phone:</strong> 6902</li>
                    <li><strong>Email:</strong> mmoshhrm@gmail.com</li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Social Media links</h4>
                <ul>
                    <li><i class="fab fa-facebook-f" style="font-size: 0.7rem;"></i> <a href="#">f</a></li>
                    <li><i class="fab fa-google-plus-g" style="font-size: 0.7rem;"></i> <a href="#">G+</a></li>
                    <li><i class="fab fa-twitter" style="font-size: 0.7rem;"></i> <a href="#"></a></li>
                    <li><i class="fab fa-telegram-plane" style="font-size: 0.7rem;"></i> <a href="#">Telegram</a></li>
                </ul>
            </div>
        </div>
        <div class="copyright-bar">
            © 2026 <strong>Shaashamannee City Court.</strong> | ✆ 6902 | ✉ mmoshhrm@gmail.com
        </div>
    </footer>

    <!-- SCRIPT FOR FILE NAME DISPLAY -->
    <script>
        function updateFileName(input) {
            const fileChosen = document.getElementById('file-chosen');
            if (input.files && input.files.length > 0) {
                fileChosen.textContent = input.files[0].name;
            } else {
                fileChosen.textContent = 'No file selected.';
            }
        }
    </script>

</body>
</html>