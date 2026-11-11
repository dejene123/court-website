<?php
// Database connection to shaggar_court_db
$host = 'localhost';
$db   = 'shaggar_court_db';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Fetch news items from the news table
$stmt = $pdo->query("SELECT * FROM news ORDER BY id DESC");
$newsItems = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="om">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News / Oduu - Mana Murtii Ol'aanaa Magaalaa Shaashamannee</title>

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

        /* NORMAL LAYOUT CONTAINER (Instead of Grid) */
        .main-content {
            max-width: 1200px;
            margin: 20px auto 40px auto;
            padding: 0 0px;
            flex-grow: 1;
            width: 100%;
        }

        .news-container {
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        .staff-card {
            background-color: var(--card-border-bg);
            border-radius: 1px;
            padding: 12px;
            box-shadow: 0 0px 0px rgba(0,0,0,0.15);
            display: flex;
            flex-direction: column;
            background-image: linear-gradient(to bottom, #1c4e5e, #133845);
        }

        .staff-photo-box {
            width: 100%;
            height: 800px; /* Updated image height to 800px */
            background-color: #ffffff;
            border-radius: 4px;
            overflow: hidden;
            position: relative;
        }

        /* Slow motion zoom-in mode for images */
        .staff-photo-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.8s ease-in-out;
        }

        .staff-card:hover .staff-photo-box img {
            transform: scale(1.05);
        }

        .staff-info {
            padding: 15px 8px 8px 8px;
            text-align: left;
            color: #ffffff;
        }

        /* Bold News Title with h1 styling */
        .staff-name h1 {
            font-size: 1.25rem;
            font-weight: bold;
            margin-bottom: 8px;
            color: #ffffff;
        }

        .staff-title {
            font-size: 0.85rem;
            color: #cbd5e1;
            line-height: 1.5;
            margin-bottom: 10px;
        }

        .full-content {
            display: none;
            font-size: 0.85rem;
            color: #e2e8f0;
            line-height: 1.5;
            margin-top: 10px;
            border-top: 1px dashed rgba(255,255,255,0.3);
            padding-top: 10px;
        }

        .read-more-btn {
            color: #60a5fa;
            font-size: 0.8rem;
            font-weight: bold;
            cursor: pointer;
            display: inline-block;
            margin-top: 8px;
        }

        .read-more-btn:hover {
            text-decoration: underline;
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
            .footer-container {
                grid-template-columns: repeat(2, 1fr);
            }
            .staff-photo-box {
                height: 500px; /* Adjust height gracefully on medium screens */
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
            .staff-photo-box {
                height: 350px; /* Adjust height on mobile screens */
            }
        }
    </style>
</head>
<body>

    <!-- 1. HEADER SECTION -->
    

    <!-- 2. NAVIGATION BAR -->
  
      <nav>
        <?php require_once('header.php');?>
    </nav>



    <!-- 3. NORMAL LAYOUT NEWS AREA -->
    <main class="main-content">
        <div class="news-container">
            <?php if (count($newsItems) > 0): ?>
                <?php foreach ($newsItems as $news): ?>
                    <div class="staff-card">
                        <div class="staff-photo-box">
                            <img src="<?= htmlspecialchars($news['image_path']) ?>" alt="" loading="lazy">
							
                        </div>
                        <div class="staff-info">
                            <!-- Bold News Title inside H1 -->
                            <div class="staff-name">
                                <h1><?= htmlspecialchars($news['title']) ?></h1>
                            </div>
                            
                            <!-- Summary / Excerpt -->
                            <div class="staff-title summary-text"><?= htmlspecialchars($news['summary']) ?></div>
                            
                            <!-- Full Content (Hidden initially) -->
                            <div class="full-content"><?= nl2br(htmlspecialchars($news['content'])) ?></div>

                            <!-- "hunda dubbisaa" toggle trigger -->
                            <a href="javascript:void(0);" class="read-more-btn" onclick="toggleNewsContent(this)">read more...</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="text-align: center; padding: 40px; color: #333;">
                    Oduun kamiyyuu hin argamne.
                </div>
            <?php endif; ?>
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
                    <li><strong>Phone:</strong> 8794</li>
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
            © 2026 <strong>Shaashamannee City Court.</strong> | ✆ 8794 | ✉ mmoshhrm@gmail.com
        </div>
    </footer>

    <!-- JavaScript for Expandable Content Toggle -->
    <script>
        function toggleNewsContent(element) {
            const card = element.closest('.staff-info');
            const fullContent = card.querySelector('.full-content');
            const summaryText = card.querySelector('.summary-text');

            if (fullContent.style.display === 'block') {
                fullContent.style.display = 'none';
                summaryText.style.display = 'block';
                element.textContent = 'hunda dubbisaa';
            } else {
                fullContent.style.display = 'block';
                summaryText.style.display = 'none';
                element.textContent = 'gabaabsuuf (Cufi)';
            }
        }
    </script>
</body>
</html>