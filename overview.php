<?php
require_once 'db.php';

// Fetch Court Overview content from database
$stmt = $pdo->query("SELECT * FROM court_overview LIMIT 1");
$overview = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="om">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Court Overview - Mana Murtii Ol'aanaa Magaalaa Shaggar / Shegger City High Court</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* CSS RESET & EXACT PALETTE STYLES */
        :root {
            --main-nav-bg: #0c2340;
            --body-bg: #bebebe;
            --card-border-yellow: #facc15;
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

        .nav-menu li.has-dropdown > a::after {
            content: ' \25BE';
            font-size: 0.7rem;
        }

        /* MAIN CONTENT AREA */
        .main-content {
            max-width: 1150px;
            margin: 30px auto;
            padding: 0 15px;
            flex-grow: 1;
            width: 100%;
        }

        .overview-card {
            background-color: #ffffff;
            border: 3px solid var(--card-border-yellow);
            border-radius: 10px;
            padding: 40px 50px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            position: relative;
        }

        .overview-text {
            font-size: 0.92rem;
            line-height: 1.8;
            color: #2d3748;
            text-align: justify;
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
        @media (max-width: 850px) {
            .overview-card {
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
    <header>
        <div class="header-container">
            <div class="branding-group">
                <div class="court-logo">
                    <i class="fas fa-balance-scale"></i>
                </div>
                <div class="titles-box">
                    <h1>Mana Murtii Ol'aanaa Magaalaa Shaggar</h1>
                    <h2>Shaggar City High Court</h2>
                    <h3>የሸገር ከተማ ከፍተኛ ፍርድ ቤት</h3>
                </div>
            </div>
            <div class="header-actions">
                <a href="tel:8794" class="btn-call">
                    <i class="fas fa-phone-alt" style="color: #d9534f;"></i> Call: <span>8794</span>[cite: 7]
                </a>
                <a href="#" class="btn-ecourt">Shaggar E-Court</a>
            </div>
        </div>
    </header>

    <!-- 2. MAIN NAVIGATION BAR -->
    <nav>
        <div class="nav-container">
            <ul class="nav-menu">
                <li><a href="index.php">Home</a>[cite: 7]</li>
                <li><a href="GuestNews.php">News</a>[cite: 7]</li>
                <li><a href="gallery.php">Gallery</a>[cite: 7]</li>
                <li><a href="laws.php">Laws And Publications</a>[cite: 7]</li>
                <li class="has-dropdown"><a href="staff.php">Administration</a>[cite: 7]</li>
                <li class="has-dropdown"><a href="#">Manneen Murtii Aanaa</a>[cite: 7]</li>
                <li class="has-dropdown active"><a href="overview.php">About Us</a>[cite: 7]</li>
                <li><a href="#">Contacts</a>[cite: 7]</li>
                <li><a href="#">Dhagaha Halaalaa (VK)</a>[cite: 7]</li>
            </ul>
        </div>
    </nav>

    <!-- 3. MAIN CONTENT AREA (YELLOW BORDERED OVERVIEW CARD) -->
    <main class="main-content">
        <div class="overview-card">
            <div class="overview-text">
                <?php if ($overview): ?>
                    <?= $overview['content_text'] ?>[cite: 7]
                <?php else: ?>
                    <p>Overview text content not found in database.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <!-- 4. FOOTER SECTION -->
    <footer>
        <div class="footer-container">
            <div class="footer-col">
                <h4>Our services</h4>[cite: 7]
                <ul>
                    <li><i class="fas fa-chevron-right" style="font-size: 0.6rem;"></i> <a href="#">E-filing</a>[cite: 7]</li>
                    <li><i class="fas fa-chevron-right" style="font-size: 0.6rem;"></i> <a href="#">Video Conference</a>[cite: 7]</li>
                    <li><i class="fas fa-chevron-right" style="font-size: 0.6rem;"></i> <a href="#">Hiikaa Afaanii</a>[cite: 7]</li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Related Links</h4>[cite: 7]
                <ul>
                    <li><i class="fas fa-chevron-right" style="font-size: 0.6rem;"></i> <a href="#">Eecourt.ShaggarCity Court</a>[cite: 7]</li>
                    <li><i class="fas fa-chevron-right" style="font-size: 0.6rem;"></i> <a href="#">Oromia Supreme Court</a>[cite: 7]</li>
                    <li><i class="fas fa-chevron-right" style="font-size: 0.6rem;"></i> <a href="#">CAS</a>[cite: 7]</li>
                    <li><i class="fas fa-chevron-right" style="font-size: 0.6rem;"></i> <a href="#">Telegram</a>[cite: 7]</li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Contact Us</h4>[cite: 7]
                <ul>
                    <li>Shaggar</li>[cite: 7]
                    <li>Shaggar, Oromia</li>[cite: 7]
                    <li><strong>Phone:</strong> 8794</li>[cite: 7]
                    <li><strong>Email:</strong> mmoshhrm@gmail.com</li>[cite: 7]
                </ul>
            </div>
            <div class="footer-col">
                <h4>Social Media links</h4>[cite: 7]
                <ul>
                    <li><i class="fab fa-facebook-f" style="font-size: 0.7rem;"></i> <a href="#">f</a>[cite: 7]</li>
                    <li><i class="fab fa-google-plus-g" style="font-size: 0.7rem;"></i> <a href="#">G+</a>[cite: 7]</li>
                    <li><i class="fab fa-twitter" style="font-size: 0.7rem;"></i> <a href="#"></a>[cite: 7]</li>
                    <li><i class="fab fa-telegram-plane" style="font-size: 0.7rem;"></i> <a href="#">Telegram</a>[cite: 7]</li>
                </ul>
            </div>
        </div>
        <div class="copyright-bar">
            © 2026 <strong>Shaggar City Court.</strong> | ✆ 8794 | ✉ mmoshhrm@gmail.com[cite: 7]
        </div>
    </footer>

</body>
</html>