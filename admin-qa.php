<?php
// Admin panel: view, add, edit, answer and delete questions (shaggar_court_db.qa_questions)
session_start();

// ---- CHANGE THESE ----
const ADMIN_USER = 'admin';
const ADMIN_PASS = 'ChangeMe@123';
// ----------------------

$conn = new mysqli('localhost', 'root', '', 'shaggar_court_db');
if ($conn->connect_error) { die('Database error: ' . htmlspecialchars($conn->connect_error)); }
$conn->set_charset('utf8mb4');
$conn->query("CREATE TABLE IF NOT EXISTS qa_questions (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    question TEXT NOT NULL,
    answer TEXT NULL,
    status ENUM('pending','answered') NOT NULL DEFAULT 'pending',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    answered_at DATETIME NULL,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status (status)
) CHARACTER SET utf8mb4");

function h($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
if (empty($_SESSION['csrf'])) { $_SESSION['csrf'] = bin2hex(random_bytes(16)); }

$error = '';
$notice = '';

// ---- Login / logout ----
if (isset($_POST['login'])) {
    if (hash_equals(ADMIN_USER, (string)($_POST['user'] ?? '')) && hash_equals(ADMIN_PASS, (string)($_POST['pass'] ?? ''))) {
        session_regenerate_id(true);
        $_SESSION['admin'] = true;
        header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?'));
        exit;
    }
    $error = 'Username ykn password dogoggora.';
}
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?'));
    exit;
}

$isAdmin = !empty($_SESSION['admin']);

// ---- CRUD (admin only, CSRF protected) ----
if ($isAdmin && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if (!hash_equals($_SESSION['csrf'], (string)($_POST['csrf'] ?? ''))) {
        $error = 'Security token invalid.';
    } else {
        $action   = $_POST['action'];
        $id       = (int)($_POST['id'] ?? 0);
        $question = trim((string)($_POST['question'] ?? ''));
        $answer   = trim((string)($_POST['answer'] ?? ''));

        if ($action === 'add' || $action === 'update') {
            if ($question === '') {
                $error = 'Gaaffiin duwwaa ta\'uu hin danda\'u.';
            } else {
                $status = $answer !== '' ? 'answered' : 'pending';
                $ans = $answer !== '' ? $answer : null;
                if ($action === 'add') {
                    $st = $conn->prepare("INSERT INTO qa_questions (question, answer, status, answered_at) VALUES (?, ?, ?, IF(? = 'answered', NOW(), NULL))");
                    $st->bind_param("ssss", $question, $ans, $status, $status);
                    $st->execute();
                    $notice = 'Gaaffiin dabalameera.';
                } else {
                    $st = $conn->prepare("UPDATE qa_questions SET question = ?, answer = ?, status = ?, answered_at = IF(? = 'answered', COALESCE(answered_at, NOW()), NULL) WHERE id = ?");
                    $st->bind_param("ssssi", $question, $ans, $status, $status, $id);
                    $st->execute();
                    $notice = 'Gaaffiin fooyya\'eera.';
                }
                $st->close();
            }
        } elseif ($action === 'delete') {
            $st = $conn->prepare("DELETE FROM qa_questions WHERE id = ?");
            $st->bind_param("i", $id);
            $st->execute();
            $st->close();
            $notice = 'Gaaffiin haqameera.';
        }
    }
}

// ---- Data for the page ----
$editRow = null;
$rows = [];
$counts = ['all' => 0, 'pending' => 0, 'answered' => 0];
if ($isAdmin) {
    if (isset($_GET['edit'])) {
        $eid = (int)$_GET['edit'];
        $st = $conn->prepare("SELECT * FROM qa_questions WHERE id = ?");
        $st->bind_param("i", $eid);
        $st->execute();
        $editRow = $st->get_result()->fetch_assoc();
        $st->close();
    }
    $filter = $_GET['filter'] ?? 'all';
    if (!in_array($filter, ['all', 'pending', 'answered'], true)) { $filter = 'all'; }
    $res = $conn->query("SELECT status, COUNT(*) c FROM qa_questions GROUP BY status");
    while ($r = $res->fetch_assoc()) { $counts[$r['status']] = (int)$r['c']; $counts['all'] += (int)$r['c']; }
    $sql = "SELECT * FROM qa_questions" . ($filter !== 'all' ? " WHERE status = '" . $conn->real_escape_string($filter) . "'" : "") . " ORDER BY (status = 'pending') DESC, created_at DESC";
    $res = $conn->query($sql);
    while ($r = $res->fetch_assoc()) { $rows[] = $r; }
}
?>
<!DOCTYPE html>
<html lang="om">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin - Gaaffii fi Deebii</title>
<style>
  body{font-family:Arial,sans-serif;background:#f3f5f9;margin:0;color:#222}
  .wrap{max-width:900px;margin:0 auto;padding:16px}
  h1{font-size:20px} .card{background:#fff;border-radius:8px;padding:16px;margin-bottom:14px;box-shadow:0 1px 3px rgba(0,0,0,.1)}
  input,textarea{width:100%;padding:8px;border:1px solid #ccc;border-radius:6px;box-sizing:border-box;font:inherit;margin:4px 0 10px}
  button,.btn{background:#1a4d8f;color:#fff;border:0;border-radius:6px;padding:8px 14px;cursor:pointer;text-decoration:none;font-size:14px;display:inline-block}
  .btn.gray{background:#777} .btn.red{background:#c0392b}
  .tabs a{margin-right:8px;text-decoration:none;color:#1a4d8f} .tabs a.on{font-weight:bold;text-decoration:underline}
  .msg{padding:8px 12px;border-radius:6px;margin-bottom:12px} .ok{background:#e3f6e8} .err{background:#fde4e1}
  .badge{font-size:12px;padding:2px 8px;border-radius:10px;color:#fff} .p{background:#e67e22} .a{background:#27ae60}
  .q{white-space:pre-wrap;word-break:break-word} .actions{margin-top:8px} .actions form{display:inline}
  .top{display:flex;justify-content:space-between;align-items:center}
</style>
</head>
<body>
<div class="wrap">
<?php if (!$isAdmin): ?>
  <div class="card" style="max-width:360px;margin:60px auto">
    <h1>Admin Login</h1>
    <?php if ($error): ?><div class="msg err"><?= h($error) ?></div><?php endif; ?>
    <form method="post">
      <label>Username</label><input name="user" required autofocus>
      <label>Password</label><input name="pass" type="password" required>
      <button name="login" value="1">Seeni</button>
    </form>
  </div>
<?php else: ?>
  <div class="top"><h1>Gaaffii fi Deebii (Q&amp;A)</h1><a class="btn gray" href="?logout=1">Ba'i</a></div>
  <?php if ($notice): ?><div class="msg ok"><?= h($notice) ?></div><?php endif; ?>
  <?php if ($error): ?><div class="msg err"><?= h($error) ?></div><?php endif; ?>

  <div class="card">
    <h3><?= $editRow ? 'Gaaffii #' . (int)$editRow['id'] . ' fooyyessi / deebisi' : 'Gaaffii haaraa dabali' ?></h3>
    <form method="post">
      <input type="hidden" name="csrf" value="<?= h($_SESSION['csrf']) ?>">
      <input type="hidden" name="action" value="<?= $editRow ? 'update' : 'add' ?>">
      <?php if ($editRow): ?><input type="hidden" name="id" value="<?= (int)$editRow['id'] ?>"><?php endif; ?>
      <label>Gaaffii</label>
      <textarea name="question" rows="3" required><?= h($editRow['question'] ?? '') ?></textarea>
      <label>Deebii (duwwaa yoo ta'e "pending" ta'a)</label>
      <textarea name="answer" rows="5"><?= h($editRow['answer'] ?? '') ?></textarea>
      <button><?= $editRow ? 'Kaa\'i' : 'Dabali' ?></button>
      <?php if ($editRow): ?><a class="btn gray" href="?">Haqi</a><?php endif; ?>
    </form>
  </div>

  <div class="tabs" style="margin-bottom:10px">
    <a class="<?= $filter === 'all' ? 'on' : '' ?>" href="?filter=all">Hunda (<?= $counts['all'] ?>)</a>
    <a class="<?= $filter === 'pending' ? 'on' : '' ?>" href="?filter=pending">Deebii eegan (<?= $counts['pending'] ?>)</a>
    <a class="<?= $filter === 'answered' ? 'on' : '' ?>" href="?filter=answered">Deebifaman (<?= $counts['answered'] ?>)</a>
  </div>

  <?php if (!$rows): ?><div class="card">Gaaffiin hin jiru.</div><?php endif; ?>
  <?php foreach ($rows as $r): ?>
    <div class="card">
      <span class="badge <?= $r['status'] === 'pending' ? 'p' : 'a' ?>"><?= $r['status'] === 'pending' ? 'Pending' : 'Answered' ?></span>
      <small> #<?= (int)$r['id'] ?> · <?= h($r['created_at']) ?></small>
      <p class="q"><b>G:</b> <?= h($r['question']) ?></p>
      <p class="q"><b>D:</b> <?= $r['answer'] !== null ? h($r['answer']) : '<i>— deebii hin kennamne —</i>' ?></p>
      <div class="actions">
        <a class="btn" href="?edit=<?= (int)$r['id'] ?>&filter=<?= h($filter) ?>"><?= $r['status'] === 'pending' ? 'Deebisi' : 'Fooyyessi' ?></a>
        <form method="post" onsubmit="return confirm('Gaaffii kana haquu barbaaddanii?')">
          <input type="hidden" name="csrf" value="<?= h($_SESSION['csrf']) ?>">
          <input type="hidden" name="action" value="delete">
          <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
          <button class="red">Haqi</button>
        </form>
      </div>
    </div>
  <?php endforeach; ?>
<?php endif; ?>
</div>
</body>
</html>
