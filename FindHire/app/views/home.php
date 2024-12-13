<?php include '../../public/layout/header.php'; ?>

<h1>Welcome to FindHire</h1>

<?php if (isset($_SESSION['user_id']) && $_SESSION['role'] == 'applicant'): ?>
    <h2>Available Job Posts</h2>
    <ul>
        <?php
        require_once '../app/controllers/JobController.php';
        $jobController = new JobController();
        $jobs = $jobController->getJobs();
        foreach ($jobs as $job):
        ?>
            <li>
                <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                <p><?php echo htmlspecialchars($job['description']); ?></p>
                <a href="apply_job.php?job_id=<?php echo $job['job_id']; ?>">Apply Now</a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php elseif (isset($_SESSION['user_id']) && $_SESSION['role'] == 'hr'): ?>
    <h2>Manage Job Posts</h2>
    <a href="job_post.php">Create New Job Post</a>
<?php else: ?>
    <p>Please log in to view job posts.</p>
<?php endif; ?>

<?php include '../../public/layout/footer.php'; ?>
