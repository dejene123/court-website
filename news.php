<!DOCTYPE html>
<html lang="om">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News - Mana Murtii Ol'aanaa Magaalaa Shaashamannee</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* CSS RESET & EXACT PALETTE STYLES */
        :root {
            --main-nav-bg: #0c2340;
            --body-bg: #f0f4f8;
            --sidebar-bg: #ffffff;
            --card-bg: #ffffff;
            --adobe-red: #e11d48;
            --footer-bg: #008cdb;
            --footer-dark: #005f96;
            --text-dark: #1f2937;
            --red-text: #d9534f;
            --accent-blue: #0284c7;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', Arial, Helvetica, sans-serif;
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

        /* NORMAL LAYOUT CONTAINER */
        .main-layout {
            max-width: auto;
            margin: 30px auto;
            padding: 0 15px;
            display: block;
            flex-grow: 1;
            width: 100%;
        }

        /* NORMAL NEWS LIST CONTAINER */
        .news-container {
            display: block;
            width: 100%;
        }

        /* ATTRACTIVE NEWS CARD DESIGN WITH ZOOM-IN & ZOOM-OUT EFFECT */
        .doc-card {
            background-color: var(--card-bg);
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 6px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -4px rgba(0, 0, 0, 0.03);
            display: block;
            margin-bottom: 35px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
        }

        .doc-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 18px 30px -5px rgba(0, 0, 0, 0.15), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            border-color: var(--accent-blue);
        }

        /* IMAGE WRAPPER WITH FIXED 800PX HEIGHT & ZOOM EFFECT */
        .news-img-wrapper {
            width: 100%;
            height: 800px; /* Exact height requirement */
            overflow: hidden;
            position: relative;
            background-color: #0b1329;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .news-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.7s cubic-bezier(0.25, 1, 0.5, 1); /* Smooth zoom-in / zoom-out animation */
        }

        /* Zoom-in effect on hover */
        .doc-card:hover .news-img-wrapper img {
            transform: scale(1.07); 
        }

        .doc-footer {
            padding: 28px;
            background-color: #ffffff;
            display: block;
        }

        /* DATE AT THE TOP OF THE TITLE */
        .news-date-top {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--accent-blue);
            background-color: #e0f2fe;
            padding: 5px 12px;
            border-radius: 20px;
            margin-bottom: 12px;
        }

        .doc-title {
            font-size: 1.35rem;
            color: #0f172a;
            font-weight: bold; /* Bold Title Requirement */
            line-height: 1.4;
            margin-bottom: 12px;
            transition: color 0.2s;
        }

        .doc-card:hover .doc-title {
            color: var(--accent-blue);
        }

        .news-summary {
            font-size: 1rem;
            color: #334155;
            font-weight: 500;
            line-height: 1.6;
            margin-bottom: 14px;
        }

        .news-content {
            font-size: 0.92rem;
            color: #64748b;
            line-height: 1.7;
            margin-bottom: 20px;
        }

        /* READ MORE / READ LESS STYLING */
        .read-more-btn {
            background: none;
            border: none;
            color: var(--accent-blue);
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            padding: 0;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 20px;
            transition: color 0.2s;
        }

        .read-more-btn:hover {
            color: #0369a1;
            text-decoration: underline;
        }

        .full-content {
            display: none;
        }

        .doc-meta {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            font-size: 0.8rem;
            color: #94a3b8;
            border-top: 1px solid #f1f5f9;
            padding-top: 14px;
        }

        /* FOOTER AREA */
        footer {
            background-color: var(--footer-bg);
            color: #ffffff;
            margin-top: 50px;
            padding-top: 30px;
        }

        .footer-container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 20px 30px 20px;
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
            padding: 12px;
            font-size: 0.75rem;
            color: #ffffff;
        }

        /* RESPONSIVE LAYOUT */
        @media (max-width: 768px) {
            .news-img-wrapper {
                height: 400px; /* Adjust height automatically for smaller mobile screens while retaining layout balance */
            }
            .footer-container {
                grid-template-columns: repeat(2, 1fr);
            }
            .header-container {
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .footer-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <!-- 1. HEADER SECTION -->
   

    <!-- 2. MAIN NAVIGATION BAR -->
    <nav>
        <?php 
        if (file_exists('header.php')) {
            require_once('header.php');
        } else {
            echo '<div class="nav-container"><ul class="nav-menu"><li><a href="index.php">Mataa Fakkii</a></li><li class="active"><a href="laws.php">Laws & Publications</a></li></ul></div>';
        }
        ?>
    </nav>

    <!-- 3. MAIN CONTENT LAYOUT (NORMAL BLOCK FLOW) -->
    <div class="main-layout">
        
        <!-- PUBLICATIONS / NEWS NORMAL LIST CONTAINER -->
        <div class="news-container">
            <?php
            // Database connection configuration
            $host = 'localhost';
            $db   = 'shaggar_court_db';
            $user = 'root'; // Update with your database username
            $pass = '';     // Update with your database password

            try {
                $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Fetch image, date, title, summary, and content from the news table
                $stmt = $pdo->query("SELECT image_path, publish_date, title, summary, content FROM news ORDER BY publish_date DESC");
                
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $image_path   = htmlspecialchars($row['image_path']);
                    $publish_date    = htmlspecialchars($row['publish_date']);
                    $title   = htmlspecialchars($row['title']);
                    $summary = htmlspecialchars($row['summary']);
                    $content = htmlspecialchars($row['content']);

                    echo '
                    <div class="doc-card">
                        <div class="news-img-wrapper">
                            <img src="' . $image_path . '" alt="">
                        </div>
                        <div class="doc-footer">
                            <div class="news-date-top">
                                <i class="far fa-calendar-alt"></i> ' . $publish_date . '
                            </div>
                            <h3 class="doc-title">' . $title . '</h3>
                            <p class="news-summary">' . $summary . '</p>
                            <div class="news-content-wrapper">
                                <button type="button" class="read-more-btn" onclick="toggleReadMore(this)">
                                    <span>Read More</span> <i class="fas fa-chevron-down text-xs"></i>
                                </button>
                                <div class="full-content" style="display: none;">' . $content . '</div>
                            </div>
                            <div class="doc-meta">
                                <span><i class="fas fa-newspaper text-info"></i> Shashemene City High Court</span>
                            </div>
                        </div>
                    </div>';
                }
            } catch (PDOException $e) {
                echo '<p style="color: red; padding: 20px; background: #fff; border-radius: 8px;">Database connection failed: ' . htmlspecialchars($e->getMessage()) . '</p>';
            }
            ?>
        </div>

    </div>

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
            © 2026 <strong>Shaashamannee City High Court.</strong>| ✆ 6902 | ✉ mmoshhrm@gmail.com
        </div>
    </footer>

    <!-- JavaScript for Read More / Read Less Toggle -->
    <script>
        function toggleReadMore(button) {
            const wrapper = button.closest('.doc-footer');
            const fullContent = wrapper.querySelector('.full-content');
            const btnText = button.querySelector('span');
            const icon = button.querySelector('i');

            if (fullContent.style.display === 'none' || fullContent.style.display === '') {
                fullContent.style.display = 'block';
                btnText.textContent = 'Read Less';
                icon.className = 'fas fa-chevron-up text-xs';
            } else {
                fullContent.style.display = 'none';
                btnText.textContent = 'Read More';
                icon.className = 'fas fa-chevron-down text-xs';
            }
        }
    </script>

</body>
</html>