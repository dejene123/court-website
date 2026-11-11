<?php
require_once 'db.php';

// Fetch the About Us record from shaggar_court_db table 'about_us'
$stmt = $pdo->query("SELECT header_title, mission, vision, values_text, background FROM about_us LIMIT 1");
$about = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="om">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Mana Murtii Ol'aanaa Magaalaa Shaashamannee</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* CSS RESET & EXACT PALETTE STYLES */
        :root {
            --main-nav-bg: #0c2340;
            --body-bg: #bebebe;
            --card-border-bg: #1c4e5e;
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

        .header_titles-box h1 {
            font-size: 1.05rem;
            color: #0c2340;
            font-weight: bold;
        }

        .header_titles-box h2 {
            font-size: 0.95rem;
            color: #1a365d;
            font-weight: 600;
        }

        .header_titles-box h3 {
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

        /* ABOUT US / MAIN CONTENT AREA */
        .main-content {
            max-width: 1200px;
            margin: 30px auto 50px auto;
            padding: 0 15px;
            flex-grow: 1;
            width: 100%;
        }

        .about-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .about-header h2 {
            font-size: 2rem;
            color: var(--main-nav-bg);
            font-weight: 800;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .about-header p {
            font-size: 0.95rem;
            color: #334155;
            max-width: 700px;
            margin: 0 auto;
        }

        .about-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
        }

        .about-card {
            background-image: linear-gradient(to bottom, #1c4e5e, #133845);
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
            color: #ffffff;
            display: flex;
            flex-direction: column;
            /* Smooth zoom-in and zoom-out transition effect */
            transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1), box-shadow 0.4s ease;
            overflow: hidden;
            position: relative;
        }

        /* ZOOM-IN & ZOOM-OUT EFFECT ON CARD HOVER */
        .about-card:hover {
            transform: scale(1.03); /* Zoom in effect */
            box-shadow: 0 12px 24px rgba(0,0,0,0.3);
        }

        .about-card-icon {
            font-size: 2rem;
            color: #38bdf8;
            margin-bottom: 15px;
        }

        .about-card h2 {
            font-size: 1.25rem;
            font-weight: 800;
            margin-bottom: 12px;
            color: #ffffff;
            border-bottom: 2px solid rgba(56, 189, 248, 0.4);
            padding-bottom: 8px;
            letter-spacing: 0.3px;
        }

        .about-card p, .about-card div {
            font-size: 0.9rem;
            line-height: 1.6;
            color: #f0f8ff;
        }

        /* FOOTER AREA */
        footer {
            background-color: var(--footer-bg);
            color: #ffffff;
            margin-top: auto;
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
        @media (max-width: 992px) {
            .about-grid {
                grid-template-columns: 1fr;
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
        <?php require_once('header.php');?>
    </nav>

    <!-- 3. ABOUT US SECTION WITH DYNAMIC DATABASE CONTENT -->
    <main class="main-content">
        <div class="about-header">
            <h3><?php echo htmlspecialchars($about['header_title'] ?? 'About Us'); ?></h3>
            <p>Ergama, mul'ataa fi Duudhaalee Manneen Murtii</p>
        </div>

        <div class="about-grid">
            <!-- Mission Card -->
            <div class="about-card">
                <div class="about-card-icon">
                    <i class="fas fa-bullseye"></i>
                </div>
                <h2>I. ERGAMA</h2>
                <div><?php echo htmlspecialchars_decode($about['mission'] ?? 'Mission details coming soon.'); ?></div>
            </div>

            <!-- Vision Card -->
            <div class="about-card">
                <div class="about-card-icon">
                    <i class="fas fa-eye"></i>
                </div>
                <h2>II. MUL'ATA</h2>
                <div><?php echo htmlspecialchars_decode($about['vision'] ?? 'Vision details coming soon.'); ?></div>
            </div>

            <!-- Values Card -->
            <div class="about-card">
                <div class="about-card-icon">
                    <i class="fas fa-gem"></i>
                </div>
                <h2>III. DUUDHAALEE</h2>
                <div><?php echo htmlspecialchars_decode($about['values_text'] ?? 'Values details coming soon.'); ?></div>
            </div>

            <!-- Background Card -->
            <div class="about-card">
                <div class="about-card-icon">
                    <i class="fas fa-history"></i>
                </div>
                <h2>IV. DUB-DUUBEE</h2>
                <div><?php echo htmlspecialchars_decode($about['background'] ?? 'Background details coming soon.'); ?></div>
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
                    <li><i class="fas fa-chevron-right" style="font-size: 0.6rem;"></i> <a href="#">Eecourt.Shaashamannee City Court</a></li>
                    <li><i class="fas fa-chevron-right" style="font-size: 0.6rem;"></i> <a href="#">Oromia Supreme Court</a></li>
                    <li><i class="fas fa-chevron-right" style="font-size: 0.6rem;"></i> <a href="#">CAS</a></li>
                    <li><i class="fas fa-chevron-right" style="font-size: 0.6rem;"></i> <a href="#">Telegram</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Contact Us</h4>
                <ul>
                    <li>Shaashamannee</li>
                    <li>Shaashamannee , Oromia</li>
                    <li><strong>Phone:</strong> 6902</li>
                    <li><strong>Email:</strong> mmoshhrm@gmail.com</li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Social Media links</h4>
                <ul>
                    <li><i class="fab fa-facebook-f" style="font-size: 0.7rem;"></i> <a href="#">Facebook</a></li>
                    <li><i class="fab fa-google-plus-g" style="font-size: 0.7rem;"></i> <a href="#">Google+</a></li>
                    <li><i class="fab fa-twitter" style="font-size: 0.7rem;"></i> <a href="#">Twitter</a></li>
                    <li><i class="fab fa-telegram-plane" style="font-size: 0.7rem;"></i> <a href="#">Telegram</a></li>
                </ul>
            </div>
        </div>
        <div class="copyright-bar">
            © 2026 <strong>Shaashamannee  City Court.</strong> | ✆ 6902 | ✉ mmoshhrm@gmail.com
        </div>
    </footer>

</body>
</html>