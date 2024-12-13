<?php
require_once 'app/config/db.php';

class Application {

    // Apply for a job
    public static function applyForJob($user_id, $job_id, $resume_url) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO applications (user_id, job_id, status, resume_url) VALUES (?, ?, 'pending', ?)");
        $stmt->execute([$user_id, $job_id, $resume_url]);
    }

    // Update application status (accept/reject)
    public static function updateStatus($application_id, $status) {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE applications SET status = ? WHERE application_id = ?");
        $stmt->execute([$status, $application_id]);
    }

    // Get applications for a job
    public static function getApplicationsForJob($job_id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM applications WHERE job_id = ?");
        $stmt->execute([$job_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
