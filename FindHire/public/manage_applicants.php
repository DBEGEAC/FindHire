<?php
session_start();

// Ensure the user is logged in and has 'hr' role
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'hr') {
    header("Location: login.php");
    exit();
}

require_once '../app/config/db.php';

// Get job_id from the query string
if (isset($_GET['job_id'])) {
    $job_id = $_GET['job_id'];

    // Fetch applicants for the specific job post
    // Make sure the column names match your database schema
    $stmt = $conn->prepare("
        SELECT a.user_name, a.email, a.applicant_id 
        FROM applicants a
        JOIN job_applications ja ON a.applicant_id = ja.applicant_id
        WHERE ja.job_id = ?");
    
    $stmt->bind_param("i", $job_id); // Bind job_id to the query
    $stmt->execute();
    $applicants = $stmt->get_result();
} else {
    echo "No job selected.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Applicants</title>
</head>
<body>
    <h1>Manage Applicants for Job ID: <?php echo htmlspecialchars($job_id); ?></h1>

    <?php if ($applicants->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Applicant Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($applicant = $applicants->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($applicant['user_name']); ?></td>
                        <td><?php echo htmlspecialchars($applicant['email']); ?></td>
                        <td>
                            <!-- You can add more actions here, e.g., Accept, Reject -->
                            <a href="accept_application.php?applicant_id=<?php echo $applicant['applicant_id']; ?>&job_id=<?php echo $job_id; ?>">Accept</a> |
                            <a href="reject_application.php?applicant_id=<?php echo $applicant['applicant_id']; ?>&job_id=<?php echo $job_id; ?>">Reject</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No applicants for this job yet.</p>
    <?php endif; ?>

    <a href="hr_dashboard.php">Back to HR Dashboard</a>
</body>
</html>
