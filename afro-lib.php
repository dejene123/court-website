<?php
// Shared settings + helpers (AfroMessage + MySQL). Include with require_once.

// ================== SETTINGS ==================
const AFRO_TOKEN   = 'YOUR_AFROMESSAGE_API_TOKEN';
const AFRO_FROM    = '';      // Identifier ID (optional)
const AFRO_SENDER  = '';      // Approved sender name (optional)
const AFRO_BASE    = 'https://api.afromessage.com/api';

const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PASS = '';
const DB_NAME = 'shaggar_court_db';

// Table X = your case/appointment view
const CASE_VIEW      = 'vwrcaseappointment';
const CASE_NUM_COL   = 'CaseNumber';
const APPT_TEXT_COL  = 'DateAppointedAmh';   // date shown to the person (Ethiopian date text)
const APPT_DATE_COL  = 'DateAppointed';      // REAL DATE/DATETIME column used to find upcoming appointments  <-- CHANGE to your actual column name
const REMIND_DAYS_BEFORE = 1;                // send when appointment is within this many days
const CRON_SECRET    = 'change-this-long-random-string';
// ==============================================

function db() {
    static $c = null;
    if ($c === null) {
        $c = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($c->connect_error) { die('Database error: ' . htmlspecialchars($c->connect_error)); }
        $c->set_charset('utf8mb4');
    }
    return $c;
}

function h($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }

function normalize_phone($p) {
    $p = preg_replace('/[^\d+]/', '', (string)$p);
    if (preg_match('/^0([79]\d{8})$/', $p, $m))     return '+251' . $m[1];
    if (preg_match('/^251([79]\d{8})$/', $p, $m))   return '+251' . $m[1];
    if (preg_match('/^\+251([79]\d{8})$/', $p, $m)) return '+251' . $m[1];
    if (preg_match('/^([79]\d{8})$/', $p, $m))      return '+251' . $m[1];
    return null;
}

function afro_send_one($to, $message) {
    $payload = ['to' => $to, 'message' => $message];
    if (AFRO_FROM !== '')   $payload['from'] = AFRO_FROM;
    if (AFRO_SENDER !== '') $payload['sender'] = AFRO_SENDER;

    $ch = curl_init(AFRO_BASE . '/send');
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . AFRO_TOKEN, 'Content-Type: application/json'],
    ]);
    $body = curl_exec($ch);
    $err  = curl_error($ch);
    $code = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    $json = json_decode((string)$body, true);
    $ok = $err === '' && $code === 200 && is_array($json) && (($json['acknowledge'] ?? '') === 'success');
    return ['ok' => $ok, 'error' => $err ?: (string)$body];
}

function check_identifiers() {
    foreach ([CASE_VIEW, CASE_NUM_COL, APPT_TEXT_COL, APPT_DATE_COL] as $i) {
        if (!preg_match('/^[A-Za-z0-9_]+$/', $i)) { die('Invalid table/column name in settings.'); }
    }
}
