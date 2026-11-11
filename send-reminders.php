<?php
// Sends appointment SMS to registered phones. Run daily (cron) or open in browser with ?key=CRON_SECRET
require_once __DIR__ . '/afro-lib.php';
check_identifiers();

if (PHP_SAPI !== 'cli' && !hash_equals(CRON_SECRET, (string)($_GET['key'] ?? ''))) {
    http_response_code(403); exit('Forbidden');
}
if (AFRO_TOKEN === 'YOUR_AFROMESSAGE_API_TOKEN') { exit('Set AFRO_TOKEN in afro-lib.php first.'); }

$conn = db();
$conn->query("CREATE TABLE IF NOT EXISTS sms_log (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    subscriber_id INT UNSIGNED NOT NULL,
    case_number VARCHAR(100) NOT NULL,
    appointment_date DATE NOT NULL,
    sent_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_sub_date (subscriber_id, appointment_date)
) CHARACTER SET utf8mb4");

$d = APPT_DATE_COL; $cn = CASE_NUM_COL; $tx = APPT_TEXT_COL; $view = CASE_VIEW;

// Table Y (case_subscribers) JOIN table X (view) on case number -> upcoming appointments not yet sent
$sql = "SELECT s.id AS sid, s.phone, s.full_name,
               v.`$cn` AS case_no, v.`$tx` AS appt_text, DATE(v.`$d`) AS appt_date
        FROM case_subscribers s
        JOIN `$view` v ON v.`$cn` = s.case_number
        LEFT JOIN sms_log l ON l.subscriber_id = s.id AND l.appointment_date = DATE(v.`$d`)
        WHERE l.id IS NULL
          AND DATE(v.`$d`) BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL ? DAY)";
$days = REMIND_DAYS_BEFORE;
$st = $conn->prepare($sql);
$st->bind_param("i", $days);
$st->execute();
$rows = $st->get_result();

$sent = 0; $failed = 0;
while ($r = $rows->fetch_assoc()) {
    $text = "Mana Murtii Shaashamannee: Galmee lakk. {$r['case_no']} irratti beellamni keessan guyyaa {$r['appt_text']} ta'a. Maaloo yeroo isaa eegaa ga'aa.";
    $res = afro_send_one($r['phone'], $text);
    if ($res['ok']) {
        $ins = $conn->prepare("INSERT IGNORE INTO sms_log (subscriber_id, case_number, appointment_date) VALUES (?, ?, ?)");
        $ins->bind_param("iss", $r['sid'], $r['case_no'], $r['appt_date']);
        $ins->execute();
        $ins->close();
        $sent++;
    } else {
        $failed++;
        error_log("SMS failed for {$r['phone']}: " . $res['error']);
    }
}
$st->close();
echo "Sent: $sent | Failed: $failed\n";
