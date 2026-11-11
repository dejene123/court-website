<?php
require_once 'db.php';

// Active filter category from URL parameter (?cat=all | ?cat=news | ?cat=presidents)
$filter = isset($_GET['cat']) ? strtolower($_GET['cat']) : 'all';

if ($filter !== 'all' && in_array($filter, ['news', 'presidents', 'events'])) {
    $stmt = $pdo->prepare("SELECT * FROM news ");
    $stmt->execute([$filter]);
} else {
    $stmt = $pdo->query("SELECT * FROM news ORDER BY id ASC");
}

$photos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="om">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galaarii / Gallery - Mana Murtii Ol'aanaa Magaalaa Shaashamannee</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* CSS RESET & EXACT PALETTE STYLES */
        :root {
            --top-bg: #c9d6df;
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

        .nav-menu li.has-dropdown > a::after {
            content: ' \25BE';
            font-size: 0.7rem;
        }

        /* CATEGORY FILTER TABS */
        .filter-bar {
            max-width: 1280px;
            margin: 15px auto 5px auto;
            display: flex;
            justify-content: center;
            gap: 20px;
            font-size: 0.85rem;
        }

        .filter-tab {
            color: #103050;
            font-weight: 500;
            padding: 4px 10px;
            border-radius: 4px;
            transition: all 0.2s ease;
        }

        .filter-tab.active,
        .filter-tab:hover {
            color: #000000;
            font-weight: bold;
            text-decoration: underline;
        }

        /* GALLERY GRID AREA */
        .main-content {
            max-width: 1200px;
            margin: 10px auto 40px auto;
            padding: 0 15px;
            flex-grow: 1;
            width: 100%;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .photo-card {
            background-color: var(--card-border-bg);
            border-radius: 4px;
            padding: 6px 12px 6px 6px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .photo-card:hover {
            transform: translateY(-2px);
        }

        .photo-wrapper {
            width: 100%;
            height: 200px;
            overflow: hidden;
            border-radius: 2px;
            background-color: #000;
        }

        .photo-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        /* LIGHTBOX POPUP MODAL */
        .lightbox-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            inset: 0;
            background-color: rgba(0,0,0,0.85);
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .lightbox-modal.active {
            display: flex;
        }

        .lightbox-content {
            max-width: 900px;
            max-height: 85vh;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 5px 25px rgba(0,0,0,0.5);
            position: relative;
        }

        .lightbox-content img {
            width: 100%;
            height: auto;
            display: block;
        }

        .lightbox-close {
            position: absolute;
            top: 15px;
            right: 20px;
            color: #fff;
            font-size: 30px;
            font-weight: bold;
            cursor: pointer;
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
            .gallery-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .footer-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .gallery-grid {
                grid-template-columns: 1fr;
            }
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
   

    <!-- 3. CATEGORY FILTER TABS -->
  

    <!-- 4. GALLERY GRID AREA -->
    <main class="main-content">
        <div class="gallery-grid">
            <?php if (count($photos) > 0): ?>
                <?php foreach ($photos as $photo): ?>
                    <div class="photo-card" onclick="openLightbox('<?= htmlspecialchars($photo['image_path']) ?>')">
                        <div class="photo-wrapper">
                            <img src="<?= htmlspecialchars($photo['image_path']) ?>" alt="<?= htmlspecialchars($photo['title']) ?>" loading="lazy">
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #555;">
                    No gallery photos found for this filter.
                </div>
            <?php endif; ?>
        </div>
    </main>

    <!-- 5. LIGHTBOX MODAL POPUP -->
    <div id="lightbox" class="lightbox-modal" onclick="closeLightbox()">
        <span class="lightbox-close">&times;</span>
        <div class="lightbox-content" onclick="event.stopPropagation()">
            <img id="lightbox-img" src="" alt="Full Resolution Image">
        </div>
    </div>

    <!-- 6. FOOTER SECTION -->
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

    <!-- LIGHTBOX JS SCRIPT -->
    <script>
        function openLightbox(url) {
            document.getElementById('lightbox-img').src = url;
            document.getElementById('lightbox').classList.add('active');
        }

        function closeLightbox() {
            document.getElementById('lightbox').classList.remove('active');
        }
    </script>
</body>
</html>