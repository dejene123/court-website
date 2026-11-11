<?php
require_once 'db.php';

// Fetch all folders for the sidebar
$foldersStmt = $pdo->query("SELECT * FROM folders ORDER BY id ASC");
$folders = $foldersStmt->fetchAll();

// Get current selected folder from URL (?folder=slug)
$currentFolder = isset($_GET['folder']) ? $_GET['folder'] : 'all';

// Fetch publications based on selected folder
if ($currentFolder !== 'all') {
    $pubStmt = $pdo->prepare("SELECT * FROM laws_publications WHERE doc_url = ?");
    $pubStmt->execute([$currentFolder]);
} else {
    $pubStmt = $pdo->query("SELECT * FROM laws_publications ORDER BY id DESC");
}
$publications = $pubStmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="om">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laws And Publications - Mana Murtii Ol'aanaa Magaalaa Shaashamannee</title>

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

        /* LAYOUT CONTAINER (SIDEBAR + GRID) */
        .main-layout {
            max-width: 1280px;
            margin: 30px auto;
            padding: 0 15px;
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 25px;
            flex-grow: 1;
            width: 100%;
        }

        /* FOLDERS SIDEBAR */
        .folders-sidebar {
            background-color: var(--sidebar-bg);
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            padding: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            height: fit-content;
        }

        .folders-title {
            font-size: 0.9rem;
            font-weight: bold;
            color: var(--main-nav-bg);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 2px solid #e2e8f0;
        }

        .folder-list {
            list-style: none;
        }

        .folder-item {
            margin-bottom: 6px;
        }

        .folder-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            font-size: 0.85rem;
            color: #475569;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .folder-link i {
            color: #0284c7;
            font-size: 0.95rem;
        }

        .folder-link:hover {
            background-color: #f1f5f9;
            color: #0f172a;
        }

        .folder-link.active {
            background-color: #0284c7;
            color: #ffffff;
            font-weight: bold;
        }

        .folder-link.active i {
            color: #ffffff;
        }

        /* DOCUMENTS GRID */
        .documents-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            align-content: start;
        }

        /* ATTRACTIVE PDF CARD DESIGN */
        .doc-card {
            background-color: var(--card-bg);
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            transition: all 0.3s ease;
            position: relative;
            cursor: pointer;
        }

        .doc-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 20px -3px rgba(0, 0, 0, 0.12), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            border-color: #38bdf8;
        }

        .doc-icon-box {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            height: 160px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid #f1f5f9;
            padding: 20px;
            position: relative;
        }

        .pdf-symbol {
            width: 64px;
            height: 80px;
            background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
            border-radius: 6px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-weight: bold;
            box-shadow: 0 6px 12px rgba(225, 29, 72, 0.25);
            position: relative;
            transition: transform 0.3s ease;
        }

        .doc-card:hover .pdf-symbol {
            transform: scale(1.08);
        }

        .pdf-symbol::before {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            border-width: 0 16px 16px 0;
            border-style: solid;
            border-color: #ffffff #cbd5e1;
            display: block;
            width: 0;
            border-bottom-left-radius: 4px;
        }

        .pdf-symbol i {
            font-size: 30px;
            margin-bottom: 4px;
        }

        .pdf-symbol span {
            font-size: 0.6rem;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .pdf-action-overlay {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(12, 35, 64, 0.85);
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.68rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 4px;
            opacity: 0;
            transform: translateY(-5px);
            transition: all 0.2s ease;
        }

        .doc-card:hover .pdf-action-overlay {
            opacity: 1;
            transform: translateY(0);
        }

        .doc-footer {
            padding: 14px;
            background-color: #ffffff;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            justify-content: space-between;
        }

        .doc-title {
            font-size: 0.85rem;
            color: #0f172a;
            font-weight: 600;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-bottom: 8px;
            transition: color 0.2s;
        }

        .doc-card:hover .doc-title {
            color: #0284c7;
        }

        .doc-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.72rem;
            color: #64748b;
            border-top: 1px solid #f1f5f9;
            padding-top: 8px;
        }

        /* PDF VIEWER MODAL POPUP STYLES */
        #pdfModal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(4px);
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal-content {
            background-color: #ffffff;
            width: 100%;
            max-width: 1000px;
            height: 90vh;
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            animation: modalScaleIn 0.3s ease;
        }

        @keyframes modalScaleIn {
            from { transform: scale(0.95); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .modal-header {
            background-color: var(--main-nav-bg);
            color: white;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-title {
            font-size: 0.95rem;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 80%;
        }

        .modal-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .modal-btn-download {
            background-color: #0284c7;
            color: white;
            padding: 5px 12px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: background 0.2s;
        }

        .modal-btn-download:hover {
            background-color: #0369a1;
        }

        .modal-close {
            background: none;
            border: none;
            color: #94a3b8;
            font-size: 1.25rem;
            cursor: pointer;
            transition: color 0.2s;
        }

        .modal-close:hover {
            color: white;
        }

        .modal-body {
            flex-grow: 1;
            background-color: #e2e8f0;
        }

        .modal-body iframe {
            width: 100%;
            height: 100%;
            border: none;
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
        @media (max-width: 1024px) {
            .documents-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .main-layout {
                grid-template-columns: 1fr;
            }
            .documents-grid {
                grid-template-columns: 1fr;
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

    <!-- 3. MAIN CONTENT LAYOUT (FOLDERS SIDEBAR + DOCS GRID) -->
    <div class="main-layout">
        
        <!-- FOLDERS SIDEBAR -->
        <aside class="folders-sidebar">
            <div class="folders-title">Folders</div>
            <ul class="folder-list">
                <li class="folder-item">
                    <a href="laws.php?folder=all" class="folder-link <?= $currentFolder === 'all' ? 'active' : '' ?>">
                        <i class="fas fa-folder-open"></i>
                        <span>Hunda (All Documents)</span>
                    </a>
                </li>
                <?php foreach ($folders as $folder): ?>
                    <li class="folder-item">
                        <a href="laws.php?folder=<?= htmlspecialchars($folder['slug']) ?>" class="folder-link <?= $currentFolder === $folder['slug'] ? 'active' : '' ?>">
                            <i class="fas fa-folder"></i>
                            <span><?= htmlspecialchars($folder['folder_name']) ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </aside>

        <!-- PUBLICATIONS / DOCUMENTS GRID -->
        <main>
            <div class="documents-grid">
                <?php if (count($publications) > 0): ?>
                    <?php foreach ($publications as $pub): ?>
                        <div class="doc-card" onclick="openPdfModal('<?= htmlspecialchars($pub['doc_url'], ENT_QUOTES) ?>', '<?= htmlspecialchars($pub['title'], ENT_QUOTES) ?>')">
                            <div class="doc-icon-box">
                                <div class="pdf-action-overlay">
                                    <i class="fas fa-eye"></i> View PDF
                                </div>
                                <div class="pdf-symbol">
                                    <i class="fa-solid fa-file-pdf"></i>
                                    <span>PDF</span>
                                </div>
                            </div>
                            <div class="doc-footer">
                                <div class="doc-title" title="<?= htmlspecialchars($pub['title']) ?>">
                                    <?= htmlspecialchars($pub['title']) ?>
                                </div>
                                <div class="doc-meta">
                                    <span><i class="far fa-calendar-alt"></i> <?= htmlspecialchars($pub['date'] ?? '2026') ?></span>
                                    <span style="color: #0284c7; font-weight: 600;"><i class="fas fa-external-link-alt"></i> Preview</span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div style="grid-column: 1 / -1; padding: 50px; text-align: center; color: #475569; background: #ffffff; border-radius: 8px; border: 1px solid #e2e8f0;">
                        <i class="fas fa-folder-open" style="font-size: 40px; color: #cbd5e1; margin-bottom: 12px; display: block;"></i>
                        <p style="font-size: 0.95rem; font-weight: 500;">No documents found in this folder.</p>
                    </div>
                <?php endif; ?>
            </div>
        </main>

    </div>

    <!-- PDF VIEWER MODAL -->
    <div id="pdfModal" onclick="closePdfModal(event)">
        <div class="modal-content" onclick="event.stopPropagation()">
            <div class="modal-header">
                <div class="modal-title" id="modalPdfTitle">Document Preview</div>
                <div class="modal-actions">
                    <a id="modalDownloadBtn" href="#" target="_blank" class="modal-btn-download">
                        <i class="fas fa-download"></i> Open in New Tab
                    </a>
                    <button class="modal-close" onclick="closePdfModal()">&times;</button>
                </div>
            </div>
            <div class="modal-body">
                <iframe id="pdfIframe" src=""></iframe>
            </div>
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
            © 2026 <strong>Shaashamannee City Court.</strong>| ✆ 6902 | ✉ mmoshhrm@gmail.com
        </div>
    </footer>

    <!-- JavaScript for PDF Modal Handling -->
    <script>
        function openPdfModal(pdfUrl, pdfTitle) {
            const modal = document.getElementById('pdfModal');
            const iframe = document.getElementById('pdfIframe');
            const titleEl = document.getElementById('modalPdfTitle');
            const downloadBtn = document.getElementById('modalDownloadBtn');

            iframe.src = pdfUrl;
            titleEl.textContent = pdfTitle;
            downloadBtn.href = pdfUrl;
            modal.style.display = 'flex';
        }

        function closePdfModal() {
            const modal = document.getElementById('pdfModal');
            const iframe = document.getElementById('pdfIframe');
            
            modal.style.display = 'none';
            iframe.src = ''; // Clear iframe source to stop background PDF audio/rendering
        }

        // Close modal when pressing ESC key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closePdfModal();
            }
        });
    </script>

</body>
</html>