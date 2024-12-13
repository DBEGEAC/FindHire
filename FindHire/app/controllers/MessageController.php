<?php
require_once 'app/config/db.php';
require_once 'app/models/Message.php';

class MessageController {

    // Method to send a message
    public function sendMessage($sender_id, $recipient_id, $message) {
        Message::sendMessage($sender_id, $recipient_id, $message);
    }

    // Method to get all messages for a user
    public function getMessages($user_id) {
        return Message::getMessagesForUser($user_id);
    }
}
?>
