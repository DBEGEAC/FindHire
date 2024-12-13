<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/FindHire/app/config/db.php';
require_once dirname(__FILE__) . '/../models/Job.php';

class JobController {

    // Method to create a new job post
    public function createJob($title, $description, $qualifications, $deadline) {
        Job::createJobPost($title, $description, $qualifications, $deadline);
        header("Location: dashboard_hr.php");
    }

    // Method to get all job posts
    public function getJobs() {
        return Job::getAllJobs();
    }

    // Method to get a specific job post
    public function getJob($job_id) {
        return Job::getJobById($job_id);
    }
}
?>