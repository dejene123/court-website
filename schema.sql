-- Run once in shaggar_court_db (api-chat.php also creates this automatically)
CREATE TABLE IF NOT EXISTS qa_questions (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    question TEXT NOT NULL,
    answer TEXT NULL,
    status ENUM('pending','answered') NOT NULL DEFAULT 'pending',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    answered_at DATETIME NULL,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status (status)
) CHARACTER SET utf8mb4;
