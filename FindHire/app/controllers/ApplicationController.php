<?php
// ApplicationController.php

class ApplicationController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getApplicantApplications($applicantId) {
        // Adjust the column name if necessary
        $sql = "SELECT * FROM applications WHERE user_id = :applicantId"; // <-- Change 'applicant_id' to 'user_id' or your actual column name
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':applicantId', $applicantId);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if ($this->pdo) {
            // Prepare and execute the SQL query
            $stmt = $this->pdo->prepare("SELECT * FROM applications WHERE applicant_id = ?");
            $stmt->execute([$applicantId]);
            
            // Fetch the results
            $applications = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Debug: print out the query result
            if ($applications) {
                echo "<pre>";
                print_r($applications); // Debugging line
                echo "</pre>";
            } else {
                echo "No applications found for this applicant.";
            }

            return $applications;
        } else {
            die('Database connection not available.');
        }
    }
}
?>