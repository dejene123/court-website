<!DOCTYPE html>
<html lang="om">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dhagaha Halaalaa - Manneen Murtii Magaalaa Shaashamannee</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* CSS RESET & EXACT PALETTE STYLES */
        :root {
            --primary-navy: #0e1b4d;
            --secondary-navy: #132768;
            --accent-green: #22c55e;
            --bg-light: #f1f3f6;
            --border-gray: #d1d5db;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            background-color: var(--bg-light);
            color: #1f2937;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* TOP HEADER */
        header {
            background-color: var(--primary-navy);
            border-bottom: 4px solid var(--accent-green);
            padding: 15px 20px;
            text-align: center;
            color: #ffffff;
        }

        .header-inner {
            max-width: 1300px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }

        .header-title {
            font-size: 1.4rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header-subtitle {
            font-size: 0.8rem;
            color: #e2e8f0;
        }

        /* SUB-COURTS NAV GRID */
        .sub-courts-nav {
            background-color: #ffffff;
            border-bottom: 2px solid #e5e7eb;
            padding: 10px 15px;
        }

        .sub-courts-grid {
            max-width: 1350px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 6px;
        }

        /* WELCOME BANNER */
        .welcome-banner {
            max-width: 1320px;
            margin: 20px auto 10px auto;
            width: calc(100% - 30px);
            background-color: var(--secondary-navy);
            color: #ffffff;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .welcome-banner h2 {
            font-size: 1.15rem;
            font-weight: bold;
            color: #4ade80;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .welcome-banner p {
            font-size: 0.8rem;
            color: #cbd5e1;
        }

        /* MAIN CONTENT LAYOUT */
        .main-container {
            max-width: 1320px;
            margin: 0 auto 30px auto;
            padding: 0 15px;
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 20px;
            flex-grow: 1;
            width: 100%;
        }

        /* SIDEBAR CHANNELS WITH ACCORDION SUB-BUTTONS */
        .sidebar-channels {
            background-color: #ffffff;
            border-radius: 8px;
            border: 1px solid var(--border-gray);
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            height: fit-content;
        }

        .section-heading {
            font-size: 0.75rem;
            font-weight: bold;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
            padding-bottom: 6px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .court-dropdown-container {
            margin-bottom: 8px;
        }

        .main-court-btn {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            padding: 11px 14px;
            background-color: #ffffff;
            border: 1.5px solid #0284c7;
            border-radius: 8px;
            color: #0369a1;
            font-size: 0.82rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .main-court-btn:hover {
            background-color: #e0f2fe;
        }

        .sub-buttons-group {
            display: none;
            flex-direction: column;
            gap: 6px;
            padding: 8px 0 4px 12px;
            border-left: 2px solid #bae6fd;
            margin-top: 6px;
            margin-left: 8px;
        }

        .sub-buttons-group.active {
            display: flex;
        }

        .sub-court-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            color: #334155;
            font-size: 0.78rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .sub-court-btn:hover {
            background-color: #0284c7;
            color: #ffffff;
            border-color: #0284c7;
        }

        /* VIDEO STREAM BOX AREA */
        .stream-view-area {
            background-color: #ffffff;
            border-radius: 8px;
            border: 1px solid var(--border-gray);
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 480px;
        }

        .video-box-placeholder {
            width: 100%;
            max-width: 720px;
            height: 400px;
            background-color: var(--secondary-navy);
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            border: 3px solid #1e3a8a;
        }

        .video-box-placeholder h3 {
            font-size: 1.3rem;
            font-weight: bold;
            margin-top: 10px;
            letter-spacing: 0.5px;
        }

        .stream-caption {
            margin-top: 15px;
            font-size: 0.85rem;
            color: #4b5563;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* FOOTER */
        footer {
            background-color: var(--primary-navy);
            color: #ffffff;
            text-align: center;
            padding: 15px 20px;
            border-top: 4px solid var(--accent-green);
            font-size: 0.78rem;
            margin-top: auto;
        }

        footer p {
            margin-bottom: 4px;
        }

        /* RESPONSIVE LAYOUT */
        @media (max-width: 900px) {
            .main-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <!-- 1. TOP HEADER -->
    <header>
        <nav>
        <?php 
            require_once('header.php');
        ?>
    </nav>
    </header>

    <!-- 2. SUB-COURTS NAVIGATION PILLS -->
    <div class="sub-courts-nav">
        <div class="sub-courts-grid"></div>
    </div>

    <!-- 3. WELCOME BANNER -->
    <div class="welcome-banner">
        <h2>
            <i class="fa-solid fa-bullhorn"></i> 
        </h2>
         <h2><p><i class="fa-solid fa-headset"></i> Dhagaha Halaalaa</p> </h2>
    </div>

    <!-- 4. MAIN CONTAINER (SIDEBAR CHANNELS + STREAM PLAYER) -->
    <div class="main-container">
        
        <!-- SIDEBAR CHANNELS -->
        <aside class="sidebar-channels">
            <div class="section-heading">
                <i class="fa-solid fa-headphones"></i> Dhaddachaa Halaalaa
            </div>
            
            <!-- 1. MMO Magaalaa Shaashamannee -->
            <div class="court-dropdown-container">
                <button class="main-court-btn" onclick="toggleSubMenu('sub-mmo')">
                    <span><i class="fa-solid fa-building-columns mr-1"></i> MMO Magaalaa Shaashamannee</span>
                    <i class="fa-solid fa-chevron-down text-xs" id="icon-sub-mmo"></i>
                </button>
                <div class="sub-buttons-group" id="sub-mmo">
                    <a href="https://meet.google.com/nor-byjh-aec" class="sub-court-btn"><i class="fa-solid fa-file-contract"></i> Dhaddacha Hariiroo Hawaasaa</a>
                    <a href="mmo_criminal.php" class="sub-court-btn"><i class="fa-solid fa-gavel"></i> Dhaddachaa Yakkaa</a>
                    <a href="mmo_family.php" class="sub-court-btn"><i class="fa-solid fa-users"></i> Dhaddachaa Maatii</a>
                    
                </div>
            </div>

            <!-- 2. MMAKM Allachee -->
            <div class="court-dropdown-container">
                <button class="main-court-btn" onclick="toggleSubMenu('sub-allachee')">
                    <span><i class="fa-solid fa-building-columns mr-1"></i> MMA Kutaa Magaalaa Allachee</span>
                    <i class="fa-solid fa-chevron-down text-xs" id="icon-sub-allachee"></i>
                </button>
                <div class="sub-buttons-group" id="sub-allachee">
                    <a href="allachee_civil.php" class="sub-court-btn"><i class="fa-solid fa-file-contract"></i> Dhaddachaa Hariiroo Hawaasaa</a>
                    <a href="allachee_criminal.php" class="sub-court-btn"><i class="fa-solid fa-gavel"></i> Dhaddachaa Yakkaa</a>
                    <a href="allachee_family.php" class="sub-court-btn"><i class="fa-solid fa-users"></i> Dhaddachaa Maatii</a>
                    
                </div>
            </div>

            <!-- 3. MMAKM Haruufaa -->
            <div class="court-dropdown-container">
                <button class="main-court-btn" onclick="toggleSubMenu('sub-haruufaa')">
                    <span><i class="fa-solid fa-building-columns mr-1"></i> MMA Kutaa Magaalaa Haruufaa</span>
                    <i class="fa-solid fa-chevron-down text-xs" id="icon-sub-haruufaa"></i>
                </button>
                <div class="sub-buttons-group" id="sub-haruufaa">
                    <a href="haruufaa_civil.php" class="sub-court-btn"><i class="fa-solid fa-file-contract"></i> Dhaddachaa Hariiroo Hawaasaa</a>
                    <a href="haruufaa_criminal.php" class="sub-court-btn"><i class="fa-solid fa-gavel"></i> Dhaddachaa Yakkaa</a>
                    <a href="haruufaa_family.php" class="sub-court-btn"><i class="fa-solid fa-users"></i> Dhaddachaa Maatii</a>
                    
                </div>
            </div>

            <!-- 4. MMAKM Malkaa Sirbaa -->
            <div class="court-dropdown-container">
                <button class="main-court-btn" onclick="toggleSubMenu('sub-malkaa')">
                    <span><i class="fa-solid fa-building-columns mr-1"></i> MMA Kutaa Magaalaa Malkaa Sirbaa</span>
                    <i class="fa-solid fa-chevron-down text-xs" id="icon-sub-malkaa"></i>
                </button>
                <div class="sub-buttons-group" id="sub-malkaa">
                    <a href="malkaa_civil.php" class="sub-court-btn"><i class="fa-solid fa-file-contract"></i> Dhaddachaa Hariiroo Hawaasaa</a>
                    <a href="malkaa_criminal.php" class="sub-court-btn"><i class="fa-solid fa-gavel"></i> Dhaddachaa Yakkaa</a>
                    <a href="malkaa_family.php" class="sub-court-btn"><i class="fa-solid fa-users"></i> Dhaddachaa Maatii</a>
                    
                </div>
            </div>

            <!-- 5. MMAKM Bishaan Gurraachaa -->
            <div class="court-dropdown-container">
                <button class="main-court-btn" onclick="toggleSubMenu('sub-bishaan')">
                    <span><i class="fa-solid fa-building-columns mr-1"></i> MMA Kutaa Magaalaa Bishaan Gurraachaa</span>
                    <i class="fa-solid fa-chevron-down text-xs" id="icon-sub-bishaan"></i>
                </button>
                <div class="sub-buttons-group" id="sub-bishaan">
                    <a href="bishaan_civil.php" class="sub-court-btn"><i class="fa-solid fa-file-contract"></i> Dhaddachaa Hariiroo Hawaasaa</a>
                    <a href="bishaan_criminal.php" class="sub-court-btn"><i class="fa-solid fa-gavel"></i> Dhaddachaa Yakkaa</a>
                    <a href="bishaan_family.php" class="sub-court-btn"><i class="fa-solid fa-users"></i> Dhaddachaa Maatii</a>
                    
                </div>
            </div>

        </aside>

        <!-- MAIN VIDEO STREAM AREA -->
        <main class="stream-view-area">
            <div class="video-box-placeholder" id="video-container">
                <i class="fa-solid fa-video text-4xl text-blue-300 mb-2"></i>
                <h3 id="stream-title">Dhaddachaa Filadhaa</h3>
            </div>
            <div class="stream-caption">
                <i class="fa-solid fa-building-columns text-primary-navy"></i> <span id="stream-caption-text">Tajaajila VK Manneen Murtii Magaalaa Shaashamannee</span>
            </div>
        </main>

    </div>

    <!-- 5. FOOTER -->
    <footer>
        <p>© 2026 Manneen Murtii Magaalaa Shaashamannee</p>
    </footer>

    <!-- INTERACTIVE STREAM SCRIPT -->
    <script>
        function toggleSubMenu(menuId) {
            const subMenu = document.getElementById(menuId);
            const allSubMenus = document.querySelectorAll('.sub-buttons-group');
            
            // Close other open menus
            allSubMenus.forEach(menu => {
                if(menu.id !== menuId) {
                    menu.classList.remove('active');
                }
            });

            // Toggle target menu
            subMenu.classList.toggle('active');
        }

        function loadStream(channelName) {
            document.getElementById('stream-title').textContent = channelName;
            document.getElementById('stream-caption-text').textContent = channelName + ' - Live Audio/Video Stream';
        }
    </script>

</body>
</html>