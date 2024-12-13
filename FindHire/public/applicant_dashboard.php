<?php
session_start();

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include the database connection
require_once '../app/config/db.php';

// Fetch job posts for applicants
$sql = "SELECT * FROM job_posts";  // Fetch all job posts from the job_posts table
$result = $conn->query($sql);

// Check if there are job posts
if ($result->num_rows > 0) {
    $job_posts = [];
    while ($row = $result->fetch_assoc()) {
        $job_posts[] = $row;  // Store job posts in an array
    }
} else {
    $job_posts = [];  // No job posts found
}

// Handle job application submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['apply_job'])) {
    $job_post_id = $_POST['job_post_id'];
    $user_id = $_SESSION['user_id'];

    // Insert job application into the database
    $stmt = $conn->prepare("INSERT INTO job_applications (user_id, job_post_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $job_post_id);
    
    if ($stmt->execute()) {
        echo "You have successfully applied for this job!";
    } else {
        echo "Error applying for the job. Please try again.";
    }

    // Close the statement
    $stmt->close();
}

// Handle message sending
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_message'])) {
    $message = $_POST['message'];
    $receiver_id = 1; // Assuming HR user has ID 1; adjust based on your actual logic

    // Insert message into the database
    $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $_SESSION['user_id'], $receiver_id, $message);
    
    if ($stmt->execute()) {
        echo "Message sent successfully!";
    } else {
        echo "Error sending message.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant Dashboard</title>
</head>
<body>
    <h1>Welcome to FindHire, <?php echo htmlspecialchars($_SESSION['user_name']); ?></h1>
    
    <!-- Job Application Section -->
    <h2>Your Job Applications</h2>

    <?php if (empty($job_posts)): ?>
        <p>No job posts available right now.</p>
    <?php else: ?>
        <h3>Job Posts Available:</h3>
        <table>
            <thead>
                <tr>
                    <th>Job Title</th>
                    <th>Company</th>
                    <th>Location</th>
                    <th>Description</th>
                    <th>Apply</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($job_posts as $job_post): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($job_post['job_title']); ?></td>
                        <td><?php echo htmlspecialchars($job_post['company']); ?></td>
                        <td><?php echo htmlspecialchars($job_post['location']); ?></td>
                        <td><?php echo htmlspecialchars($job_post['description']); ?></td>
                        <td>
                            <form action="applicant_dashboard.php" method="post">
                                <input type="hidden" name="job_post_id" value="<?php echo $job_post['id']; ?>">
                                <button type="submit" name="apply_job">Apply</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <!-- Messaging Section -->
    <h2>Send a Message to HR</h2>
    <form action="applicant_dashboard.php" method="post">
        <textarea name="message" required placeholder="Type your message here..."></textarea><br>
        <button type="submit" name="send_message">Send Message</button>
    </form>

    <!-- Logout Button -->
    <form action="logout.php" method="post">
        <button type="submit">Logout</button>
    </form>
</body>
</html>
