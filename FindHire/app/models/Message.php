<?php
require_once 'app/config/db.php';

class Message {

    // Send a message
    public static function sendMessage($sender_id, $recipient_id, $message) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO messages (sender_id, recipient_id, message) VALUES (?, ?, ?)");
        $stmt->execute([$sender_id, $recipient_id, $message]);
    }

    // Get all messages for a user
    public static function getMessagesForUser($user_id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM messages WHERE recipient_id = ? OR sender_id = ?");
        $stmt->execute([$user_id, $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
