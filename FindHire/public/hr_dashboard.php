<?php
session_start();

// Ensure the user is logged in and has 'hr' role
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'hr') {
    header("Location: login.php");
    exit();
}

require_once '../app/config/db.php';

// Fetch HR's job posts
$jobPostsStmt = $conn->prepare("SELECT * FROM job_posts WHERE user_id = ? ORDER BY id DESC");
$jobPostsStmt->bind_param("i", $_SESSION['user_id']);
$jobPostsStmt->execute();
$jobPosts = $jobPostsStmt->get_result();

// Fetch messages received by the HR
$messagesStmt = $conn->prepare("SELECT m.message_id, m.sender_id, m.message, m.status, m.date_sent, u.user_name AS applicant_name
                                FROM messages m
                                JOIN users u ON m.sender_id = u.user_id
                                WHERE m.receiver_id = ? ORDER BY m.date_sent DESC");
$messagesStmt->bind_param("i", $_SESSION['user_id']);
$messagesStmt->execute();
$messages = $messagesStmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Dashboard</title>
</head>
<body>
    <h1>Welcome to the HR Dashboard, <?php echo $_SESSION['user_name']; ?></h1>

    <h2>Your Job Posts</h2>
    <?php if ($jobPosts->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Job Title</th>
                    <th>Company</th>
                    <th>Location</th>
                    <th>Description</th>
                    <th>Manage Applicants</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($job = $jobPosts->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($job['job_title']); ?></td>
                        <td><?php echo htmlspecialchars($job['company']); ?></td>
                        <td><?php echo htmlspecialchars($job['location']); ?></td>
                        <td><?php echo htmlspecialchars($job['description']); ?></td>
                        <td>
                            <!-- Correct the Manage Applicants link -->
                            <a href="manage_applicants.php?job_id=<?php echo $job['id']; ?>">Manage Applicants</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>You have not created any job posts yet.</p>
    <?php endif; ?>

    <h2>Your Messages</h2>
    <p>No messages from applicants yet.</p>

    <a href="logout.php">Logout</a>
</body>
</html>