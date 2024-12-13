<?php
session_start();

// Ensure the user is logged in and has 'hr' role
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'hr') {
    header("Location: login.php");
    exit();
}

require_once '../app/config/db.php';

// Get message ID from URL
$message_id = $_GET['message_id'];

// Fetch the message details to know who sent the message
$stmt = $conn->prepare("SELECT m.sender_id, m.message, a.user_name AS applicant_name
                        FROM messages m
                        JOIN applicants a ON m.sender_id = a.applicant_id
                        WHERE m.id = ?");
$stmt->bind_param("i", $message_id);
$stmt->execute();
$result = $stmt->get_result();
$message = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle reply
    $reply_message = $_POST['reply_message'];

    // Insert the reply message into the database
    $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $_SESSION['user_id'], $message['sender_id'], $reply_message);

    if ($stmt->execute()) {
        echo "Reply sent!";
    } else {
        echo "Error sending reply.";
    }

    $stmt->close();

    // Redirect back to the messages page
    header("Location: hr_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reply to Message</title>
</head>
<body>
    <h1>Reply to Message from <?php echo htmlspecialchars($message['applicant_name']); ?></h1>

    <form action="reply_message.php?message_id=<?php echo $message_id; ?>" method="POST">
        <label for="reply_message">Your Reply:</label><br>
        <textarea id="reply_message" name="reply_message" required></textarea><br>
        <button type="submit">Send Reply</button>
    </form>

    <a href="hr_dashboard.php">Back to Messages</a>
</body>
</html>
