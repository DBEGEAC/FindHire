<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/FindHire/app/config/db.php';

class Job {

    // Create a new job post
    public static function createJobPost($title, $description, $qualifications, $deadline) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO jobs (title, description, qualifications, deadline) VALUES (?, ?, ?, ?)");
        $stmt->execute([$title, $description, $qualifications, $deadline]);
    }

    // Get all job posts
    public static function getAllJobs() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM jobs");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get job by ID
    public static function getJobById($job_id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM jobs WHERE job_id = ?");
        $stmt->execute([$job_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
