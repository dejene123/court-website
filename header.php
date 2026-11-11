<!DOCTYPE html>
<html lang="om">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mana Murtii Ol'aanaa Magaalaa Shaashamannee / Shashemene City High Court</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts: Inter & Roboto -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            blue: '#003B73',
                            darkBlue: '#0A2540',
                            navy: '#0d1b2a',
                            lightBlue: '#0080FF',
                            accentYellow: '#FFC700',
                            green: '#009933',
                            footerBg: '#002855',
                            footerBottom: '#001D3D'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f6f9;
            color: #333333;
            /* Add padding to prevent content from hiding behind the fixed header/nav */
            padding-top: 110px; 
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #003B73;
            border-radius: 4px;
        }

        /* Card Yellow Glow Frame Effect */
        .yellow-frame-card {
            border: 2px solid #FFC700;
            transition: all 0.3s ease;
        }
        .yellow-frame-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.25);
        }

        /* Service Card Styling */
        .service-card {
            background: #0A3B75;
            transition: all 0.3s ease;
        }
        .service-card:hover {
            background: #002D5E;
            transform: translateY(-3px);
        }

        /* Custom Calendar Grid */
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 2px;
            text-align: center;
        }
    </style>
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">

    <!-- FIXED WRAPPER FOR HEADER & NAVBAR -->
    <div class="fixed top-0 left-0 w-full z-50 shadow-md">
        <!-- TOP HEADER BAR -->
        <header class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2 flex flex-wrap items-center justify-between gap-4">
                
                <!-- Logo & Title -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full border-2 border-brand-blue p-0.5 flex items-center justify-center bg-blue-50 shrink-0">
                        <i class="fa-solid fa-scale-balanced text-brand-blue text-xl sm:text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xs sm:text-base lg:text-lg font-bold text-brand-blue leading-tight">
                            Mana Murtii Ol'aanaa Magaalaa Shaashamannee
                        </h1>
                        <p class="text-[10px] sm:text-xs lg:text-sm font-semibold text-gray-600">
                            Shashemene City High Court
                        </p>
                    </div>
                </div>

                <!-- Call, Action Buttons & Mobile Menu Toggle -->
                <div class="flex items-center space-x-2 sm:space-x-3">
                    <div class="border-2 border-red-500 rounded-full px-2.5 py-1 flex items-center space-x-1.5 text-red-600 font-bold text-xs sm:text-sm">
                        <i class="fa-solid fa-phone-volume animate-pulse"></i>
                        <span>6902</span>
                    </div>

                    <a href="register-sms.php" class="hidden md:flex bg-brand-blue hover:bg-blue-900 text-white font-semibold text-sm px-4 py-1.5 rounded-full border border-blue-400 shadow transition items-center space-x-2">
                        <i class="fa-solid fa-gavel"></i>
                        <span>SMS Service</span>
                    </a>

                    <!-- Mobile Menu Click Button -->
                    <button id="menu-toggle" onclick="toggleMenu()" class="md:hidden bg-brand-blue text-yellow-400 p-2 rounded-lg focus:outline-none hover:bg-blue-900 transition" aria-label="Toggle Menu">
                        <i id="menu-icon" class="fa-solid fa-bars text-lg"></i>
                    </button>
                </div>
            </div>
        </header>

        <!-- MAIN NAVIGATION BAR -->
        <nav class="bg-brand-blue text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Navigation Links container: Hidden by default on mobile, toggles to static block when clicked -->
                <div id="nav-menu" class="hidden md:flex flex-col md:flex-row items-start md:items-center justify-between py-2 md:py-0 md:h-16 text-xs font-semibold uppercase tracking-wider space-y-2 md:space-y-0">
                    <a href="index.php" class="px-3 py-2 text-yellow-400 border-b-2 border-yellow-900 flex items-center space-x-1">
                        <i class="fa-solid fa-house text-sm"></i>
                        <span>Home</span>
                    </a>
                    <a href="news.php" class="px-3 py-2 hover:text-yellow-400 transition">News</a>
                    <a href="gallery.php" class="px-3 py-2 hover:text-yellow-400 transition">Gallery</a>
                    <a href="laws.php" class="px-3 py-2 hover:text-yellow-400 transition">Laws & Publications</a>
                    
                    <a href="staff.php" class="px-3 py-2 hover:text-yellow-400 transition">Staff</a>
                    
                    <!-- MANNEEN MURTII AANAA WITH HOVER DROPDOWN -->
                    <div class="relative group">
                        <a href="#" class="px-3 py-2 hover:text-yellow-400 transition flex items-center space-x-1">
                            <span>Manneen Murtii Aanaa</span>
                            <i class="fa-solid fa-chevron-down text-[10px] ml-1"></i>
                        </a>
                        <div class="absolute left-0 mt-0 w-48 bg-brand-blue border border-blue-400 rounded-md shadow-lg py-1 hidden group-hover:block z-50">
                            <a href="#" class="block px-4 py-2 hover:bg-blue-900 hover:text-yellow-400 transition">ALLACHEE</a>
                            <a href="#" class="block px-4 py-2 hover:bg-blue-900 hover:text-yellow-400 transition">HARUUFAA</a>
                            <a href="#" class="block px-4 py-2 hover:bg-blue-900 hover:text-yellow-400 transition">MALKAA SIRBAA</a>
                            <a href="#" class="block px-4 py-2 hover:bg-blue-900 hover:text-yellow-400 transition">BISHAAN GURRAACHAA</a>
                        </div>
                    </div>

                    <a href="about.php" class="px-3 py-2 hover:text-yellow-400 transition">About Us</a>
					 <a href="register-sms.php" class="px-3 py-2 hover:text-yellow-400 transition">SMS Galmaa'i</a>
                    <a href="contact.php" class="px-3 py-2 hover:text-yellow-400 transition">Contacts</a>
                   <a href="vk.php" class="px-3 py-2 hover:text-yellow-400 transition">Dhagaha Halaalaa (VK)</a>
                </div>
            </div>
        </nav>
    </div>

    <!-- JAVASCRIPT FOR TOGGLING STATIC MENU -->
    <script>
        function toggleMenu() {
            const menu = document.getElementById('nav-menu');
            const icon = document.getElementById('menu-icon');
            
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                menu.classList.add('flex');
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-xmark');
            } else {
                menu.classList.add('hidden');
                menu.classList.remove('flex');
                icon.classList.remove('fa-xmark');
                icon.classList.add('fa-bars');
            }
        }
    </script>
</body>
</html>