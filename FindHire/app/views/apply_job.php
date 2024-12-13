<?php include 'layout/header.php'; ?>

<h1>Apply for Job</h1>

<?php
$job_id = $_GET['job_id'];
require_once 'app/controllers/JobController.php';
$jobController = new JobController();
$job = $jobController->getJob($job_id);
?>

<h2><?php echo htmlspecialchars($job['title']); ?></h2>
<p><?php echo htmlspecialchars($job['description']); ?></p>

<form action="apply_action.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="job_id" value="<?php echo $job_id; ?>">
    
    <label for="message">Why are you the best candidate?</label>
    <textarea name="message" id="message" required></textarea>
    
    <label for="resume">Upload Resume (PDF only):</label>
    <input type="file" name="resume" id="resume" accept=".pdf" required>
    
    <button type="submit">Apply</button>
</form>

<?php include 'layout/footer.php'; ?>
