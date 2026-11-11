<?php
// Database Configuration for shaggar_court_db
$host = 'localhost';
$db   = 'shaggar_court_db';
$user = 'root';
$pass = ''; // Galchaa jecha darbii (password) database keessanii

// Connect to MySQL using MySQLi
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['reply' => 'Rakkoo walqabsiisa database: ' . $conn->connect_error]);
    exit();
}

$conn->set_charset('utf8mb4');

// Create the Q&A table automatically if it does not exist yet
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

// Get JSON input from the frontend chat interface
$input = json_decode(file_get_contents('php://input'), true);
$userMessage = isset($input['message']) ? trim($input['message']) : '';
$lowerMessage = strtolower($userMessage);

$responseReply = "";

// --- Q&A: check whether the user is asking for the answer to a saved question (e.g. "deebii #12") ---
$ticketReply = null;
if (preg_match('/^(deebii|answer|#)\s*#?\s*(\d+)$/iu', $userMessage, $m)) {
    $qid = (int)$m[2];
    $st = $conn->prepare("SELECT question, answer, status FROM qa_questions WHERE id = ?");
    $st->bind_param("i", $qid);
    $st->execute();
    $qr = $st->get_result()->fetch_assoc();
    $st->close();
    if ($qr && $qr['status'] === 'answered') {
        $ticketReply = "<b>Gaaffii #" . $qid . ":</b> " . htmlspecialchars($qr['question']) . "<br><b>Deebii:</b> " . nl2br(htmlspecialchars($qr['answer']));
    } else if ($qr) {
        $ticketReply = "Gaaffiin #" . $qid . " ammallee admin tiin deebii hin argane. Maaloo booda deebi'aa ilaalaa.";
    } else {
        $ticketReply = "Gaaffii lakk. #" . $qid . " jedhamu hin argamne.";
    }
}

// --- Q&A: exact match with a question already answered by the administrator ---
$qaAnswer = null;
if ($ticketReply === null && $userMessage !== '') {
    $st = $conn->prepare("SELECT answer FROM qa_questions WHERE status = 'answered' AND LOWER(question) = ? ORDER BY answered_at DESC LIMIT 1");
    $st->bind_param("s", $lowerMessage);
    $st->execute();
    $qr = $st->get_result()->fetch_assoc();
    $st->close();
    if ($qr) { $qaAnswer = $qr['answer']; }
}

if ($ticketReply !== null) {
    $responseReply = $ticketReply;
} else if ($qaAnswer !== null) {
    $responseReply = "<b>Deebii:</b><br>" . nl2br(htmlspecialchars($qaAnswer));
}
// 1. If user asks about Shashemene City High Court, Woreda courts, or general court info
else if (strpos($lowerMessage, 'shashamannee') !== false || strpos($lowerMessage, 'shaashamannee') !== false || strpos($lowerMessage, 'manii murtii') !== false || strpos($lowerMessage, 'mana murtii') !== false || strpos($lowerMessage, 'woreda') !== false || strpos($lowerMessage, 'godina') !== false || strpos($lowerMessage, 'court') !== false) {
    
    if (strpos($lowerMessage, 'woreda') !== false || strpos($lowerMessage, 'godina') !== false) {
        $responseReply = "<b>Odeeffannoo Mana Murtii Aanaa (Woreda Court) fi Ol'aanaa Shaashamannee:</b><br>" .
                         "• <b>Mana Murtii Aanaa Magaalaa Shaashamannee:</b> Dhaddacha jalqabaa irratti dhimmoota sivilii, yakkaa fi bulchiinsaa gadi-aanoo ilaaluun murteessa.<br>" .
                         "• <b>Mana Murtii Ol'aanaa Magaalaa Shaashamannee:</b> Dhaddacha olaanaa dhimmoota Mana Murtii Aanaa irraa dhiyaatan ol-iyyannoon ilaaluu fi dhimmoota aangoo olaanaa qaban kan ilaaluudha.<br>" .
                         "• Tajaajilliwwan kunniin sirna ammayyaa (OICCMS) fayyadamuun tajaajila saffisaa fi iftomina qabu kennuuf gurmaa'aniiru.";
    } else {
        $responseReply = "<b>Odeeffannoo Guutuu Mana Murtii Ol'aanaa Magaalaa Shaashamannee:</b><br>" .
                         "• <b>Kaayyoo:</b> Hawaasaaf tajaajila haqaa wal-qixxummaa, loogii irraa bilisa ta'e fi saffisa qabu kennuu.<br>" .
                         "• <b>Aangoo fi Dhimmoota Ilaalaman:</b> Dhimmoota Sivilii, Yakkaa, Bulchiinsaa fi Ol-iyyannoo manneen murtii aanaa irraa dhiyaatan.<br>" .
                         "• <b>Tajaajiloota fi E-Court:</b> Galmee banuu, hordoffii beellamaa (Case Tracking), fi odeeffannoo dhimmootaa online-dhaan argachuu.<br>" .
                         "• <b>Dokumentoota Barbaachisan:</b> Waraqaa Eenyummaa, Waraqaa Ol-iyyannoo ykn Iyyannoo dhimmaa, fi Ragaalee fiixaan ba'insa qaban.<br>" .
                         "• <b>Sa'aatii Hojii:</b> Wixata - Jimaata: Ganama 2:30 - 6:30 | Waaree Booda 7:30 - 11:30 (Local Time).<br>" .
                         "• <b>Teessoo & Quunnamtii:</b> Shaashamannee, Oromia, Ethiopia | Bilbila: 6902 | Email: mmoshhrm@gmail.com";
    }

} 
// 2. If user asks to track a case, prompt them to enter the CaseNumber
else if (strpos($lowerMessage, 'hordofuu') !== false || strpos($lowerMessage, 'galmee') !== false || strpos($lowerMessage, 'case') !== false || strpos($lowerMessage, 'appointment') !== false) {
    $responseReply = "Maaloo lakkoofsa galmee (Case Number) keessan asitti barreessaa (galchaa):";
} else {
    // 3. Automatically query vwrcaseappointment table/view in shaggar_court_db
    $stmt = $conn->prepare("SELECT CaseNumber, PlaintiffName, DefendantName, CaseStatusName, DateAppointedAmh FROM vwrcaseappointment WHERE CaseNumber = ?");
    $stmt->bind_param("s", $userMessage);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Fetch and format the required fields
        $responseReply = "<b>Odeeffannoo Galmee </b><br>" .
                         "• <b>Lakk. Galmee :</b> " . htmlspecialchars($row['CaseNumber']) . "<br>" .
                         "• <b>Himataa :</b> " . htmlspecialchars($row['PlaintiffName']) . "<br>" .
                         "• <b>Himatamaa:</b> " . htmlspecialchars($row['DefendantName']) . "<br>" .
                         "• <b>Haala Dhimmaa: </b> " . htmlspecialchars($row['CaseStatusName']) . "<br>" .
                         "• <b>Guyyaa Beellamaa :</b> " . htmlspecialchars($row['DateAppointedAmh']);
    } else {
        // Fallback general knowledge responses if not a case number
        if (strpos($lowerMessage, 'oiccms') !== false || strpos($lowerMessage, 'e-court') !== false) {
            $responseReply = "<b>OICCMS (Oromia Integrated Court Case Management System):</b><br>Sirna e-court ammayyaa tajaajila galmee banuu, hordoffii sochii galmee, fi odeeffannoo galmee ittiin kennamuudha.";
        } else if (strpos($lowerMessage, 'sa\'aatii') !== false || strpos($lowerMessage, 'hojii') !== false) {
            $responseReply = "<b>Sa'aatii Hojii Manneen Murtii:</b><br>Wixata - Jimaata: Ganama 2:30-6:30 | Waaree Booda 7:30-11:30 (Local Time)";
        } else if (preg_match('/\s/u', $userMessage) && mb_strlen($userMessage) >= 8) {
            // Looks like a real question (not a case number): look for a similar answered question first
            $like = '%' . str_replace(['%', '_'], ['\\%', '\\_'], $userMessage) . '%';
            $st = $conn->prepare("SELECT answer FROM qa_questions WHERE status = 'answered' AND (question LIKE ? OR ? LIKE CONCAT('%', question, '%')) ORDER BY answered_at DESC LIMIT 1");
            $st->bind_param("ss", $like, $userMessage);
            $st->execute();
            $similar = $st->get_result()->fetch_assoc();
            $st->close();

            if ($similar) {
                $responseReply = "<b>Deebii:</b><br>" . nl2br(htmlspecialchars($similar['answer']));
            } else {
                // Save the question (once) and ask the administrator for an answer
                $q = mb_substr($userMessage, 0, 1000);
                $st = $conn->prepare("SELECT id FROM qa_questions WHERE status = 'pending' AND LOWER(question) = ? LIMIT 1");
                $st->bind_param("s", $lowerMessage);
                $st->execute();
                $existing = $st->get_result()->fetch_assoc();
                $st->close();

                if ($existing) {
                    $newId = (int)$existing['id'];
                } else {
                    $st = $conn->prepare("INSERT INTO qa_questions (question, status) VALUES (?, 'pending')");
                    $st->bind_param("s", $q);
                    $st->execute();
                    $newId = (int)$conn->insert_id;
                    $st->close();
                }
                $responseReply = "Gaaffiin keessan galmaa'eera (<b>#" . $newId . "</b>) fi admin tiif ergameera. " .
                                 "Deebii argachuuf booda <b>deebii #" . $newId . "</b> jedhanii barreessaa.";
            }
        } else {
            // If the input was an invalid case number or unrecognised query
            $responseReply = "Galmee lakk. <b>'" . htmlspecialchars($userMessage) . "'</b> jedhamu argachuu hin dandeenye. Maaloo lakkoofsa galmee sirrii ta'e, ykn gaaffii waa'ee Mana Murtii Shaashamannee fi Aanaa gaafachuu dandeessu irra deebi'uun galchaa.";
        }
    }
    $stmt->close();
}

$conn->close();

// Return response as JSON to the frontend JavaScript
echo json_encode(['reply' => $responseReply]);
?>