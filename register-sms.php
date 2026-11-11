<?php
// Public page: a party enters their case number + phone number to receive appointment SMS.
session_start();
require_once __DIR__ . '/afro-lib.php';
check_identifiers();
if (empty($_SESSION['csrf'])) { $_SESSION['csrf'] = bin2hex(random_bytes(16)); }

$conn = db();
// Create table Y automatically (see schema-sms.sql)
$conn->query("CREATE TABLE IF NOT EXISTS case_subscribers (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    case_number VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    full_name VARCHAR(150) NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_case_phone (case_number, phone),
    INDEX idx_case (case_number)
) CHARACTER SET utf8mb4");

$msg = ''; $type = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['tries'] = ($_SESSION['tries'] ?? 0) + 1;
    $caseNo = trim((string)($_POST['case_number'] ?? ''));
    $phone  = normalize_phone($_POST['phone'] ?? '');
    $name   = trim((string)($_POST['full_name'] ?? ''));

    if (!hash_equals($_SESSION['csrf'], (string)($_POST['csrf'] ?? ''))) {
        $msg = 'Security token invalid.'; $type = 'err';
    } elseif ($_SESSION['tries'] > 20) {
        $msg = 'Yaalii baay\'ee. Booda yaalaa.'; $type = 'err';
    } elseif ($caseNo === '' || !$phone) {
        $msg = 'Lakkoofsa galmee fi lakkoofsa bilbilaa sirrii galchaa (09XXXXXXXX).'; $type = 'err';
    } else {
        // 1. The case number must exist in table X
        $st = $conn->prepare("SELECT `" . CASE_NUM_COL . "` AS cn, `" . APPT_TEXT_COL . "` AS appt FROM `" . CASE_VIEW . "` WHERE `" . CASE_NUM_COL . "` = ? LIMIT 1");
        $st->bind_param("s", $caseNo);
        $st->execute();
        $case = $st->get_result()->fetch_assoc();
        $st->close();

        if (!$case) {
            $msg = "Galmee lakk. '" . h($caseNo) . "' hin argamne."; $type = 'err';
        } else {
            // 2. Link phone number to the case number in table Y
            $st = $conn->prepare("INSERT IGNORE INTO case_subscribers (case_number, phone, full_name) VALUES (?, ?, ?)");
            $st->bind_param("sss", $case['cn'], $phone, $name);
            $st->execute();
            $isNew = $st->affected_rows > 0;
            $st->close();

            $msg = $isNew ? "Galmaa'eera! Beellamni keessan: " . h($case['appt']) . ". SMS ni argattu."
                          : "Lakkoofsi kun duraan galmaa'eera.";
            $type = 'ok';

            // 3. Confirmation SMS
            if ($isNew && AFRO_TOKEN !== 'YOUR_AFROMESSAGE_API_TOKEN') {
                afro_send_one($phone, "Mana Murtii Ol'aanaa Magaalaa Shaashamannee: Galmee lakk. {$case['cn']} galmaa'eera. Guyyaan beellamaa: {$case['appt']}.");
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="om">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Beellama SMS</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

  /* WRAPPER & MODERN CLEAN CARD STYLING */
  .wrap {
      max-width: 460px;
      margin: 40px auto;
      padding: 0 16px;
      width: 100%;
      flex-grow: 1;
  }

  .card {
      background: var(--card-bg);
      border-radius: 16px;
      padding: 30px;
      box-shadow: 0 10px 25px -5px rgba(12, 35, 64, 0.08), 0 8px 10px -6px rgba(12, 35, 64, 0.04);
      border: 1px solid #e2e8f0;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .card:hover {
      box-shadow: 0 20px 30px -10px rgba(12, 35, 64, 0.12);
  }

  .card h3 {
      font-size: 1.25rem;
      color: var(--main-nav-bg);
      font-weight: 700;
      margin-bottom: 20px;
      text-align: center;
      letter-spacing: -0.2px;
  }

  /* FORM INPUT FIELDS, LABELS & BUTTONS STYLING */
  .form-group {
      margin-bottom: 18px;
  }

  label {
      display: block;
      font-size: 0.82rem;
      font-weight: 600;
      color: #475569;
      margin-bottom: 6px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
  }

  input[type="text"],
  input[type="tel"],
  input[type="password"] {
      width: 100%;
      padding: 12px 16px;
      border: 1.5px solid #cbd5e1;
      border-radius: 10px;
      background-color: #f8fafc;
      font-size: 0.92rem;
      color: var(--text-dark);
      transition: all 0.25s ease;
      box-sizing: border-box;
      outline: none;
  }

  input:focus {
      border-color: var(--accent-blue);
      background-color: #ffffff;
      box-shadow: 0 0 0 4px rgba(2, 132, 199, 0.1);
  }

  button {
      background: linear-gradient(135deg, var(--main-nav-bg) 0%, #1a365d 100%);
      color: #ffffff;
      border: none;
      border-radius: 10px;
      padding: 14px 20px;
      font-size: 0.95rem;
      font-weight: 600;
      width: 100%;
      cursor: pointer;
      box-shadow: 0 4px 12px rgba(12, 35, 64, 0.2);
      transition: all 0.25s ease;
      margin-top: 6px;
  }

  button:hover {
      background: linear-gradient(135deg, #1a365d 0%, #0c2340 100%);
      box-shadow: 0 6px 16px rgba(12, 35, 64, 0.3);
      transform: translateY(-2px);
  }

  button:active {
      transform: translateY(0);
      box-shadow: 0 2px 6px rgba(12, 35, 64, 0.2);
  }

  .msg {
      padding: 12px 16px;
      border-radius: 10px;
      margin-bottom: 20px;
      font-size: 0.88rem;
      font-weight: 500;
      line-height: 1.4;
  } 

  .ok {
      background-color: #e3f6e8;
      color: #15803d;
      border: 1px solid #bbf7d0;
  } 

  .err {
      background-color: #fde4e1;
      color: #b91c1c;
      border: 1px solid #fecaca;
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

  /* RESPONSIVE LAYOUT */
  @media (max-width: 768px) {
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
 <nav>
        <?php 
            require_once('header.php');
        ?>
    </nav>
<div class="wrap">
  <div class="card">
    <h3>Beellama SMS tiin argadhu</h3>
    <?php if ($msg): ?><div class="msg <?= $type ?>"><?= h($msg) ?></div><?php endif; ?>
    <form method="post">
      <input type="hidden" name="csrf" value="<?= h($_SESSION['csrf']) ?>">
      <div class="form-group">
        <label>Lakkoofsa Galmee</label>
        <input type="text" name="case_number" placeholder="Fkn. Lakk. Galmee..." required>
      </div>
      <div class="form-group">
        <label>Lakkoofsa Bilbilaa</label>
        <input type="tel" name="phone" placeholder="09XXXXXXXX" required>
      </div>
      <div class="form-group">
        <label>Maqaa (dirqama miti)</label>
        <input type="text" name="full_name" placeholder="Maqaa keessan guutuu">
      </div>
      <div class="submit-container">
                    <button type="submit" class="btn-submit">
                        <i class="fa-solid fa-paper-plane"></i> Galmeessi
                    </button>
                </div>
    </form>
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
</body>
</html>