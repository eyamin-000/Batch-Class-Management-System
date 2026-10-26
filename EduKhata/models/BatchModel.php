<?php
class BatchModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Dashboard summary data (Count batches, students, and total dues)
    public function getSummary($user_id) {
        try {
            //Count Batches
            $query1 = "SELECT COUNT(*) as total_batches FROM batches WHERE user_id = :u_id";
            $stmt1 = $this->conn->prepare($query1);
            $stmt1->bindParam(':u_id', $user_id);
            $stmt1->execute();
            $result1 = $stmt1->fetch(PDO::FETCH_ASSOC);
            $batches = $result1['total_batches'] ?? 0;

            //Count Total Students
            $query2 = "SELECT COUNT(students.id) as total_students FROM students 
                       INNER JOIN batches ON students.batch_id = batches.id 
                       WHERE batches.user_id = :u_id";
            $stmt2 = $this->conn->prepare($query2);
            $stmt2->bindParam(':u_id', $user_id);
            $stmt2->execute();
            $result2 = $stmt2->fetch(PDO::FETCH_ASSOC);
            $students = $result2['total_students'] ?? 0;

            //Calculate Total Pending Dues
            $query3 = "SELECT SUM(students.monthly_fee_custom) as total_dues FROM students 
                       INNER JOIN batches ON students.batch_id = batches.id 
                       WHERE batches.user_id = :u_id AND students.payment_status = 'Unpaid'";
            $stmt3 = $this->conn->prepare($query3);
            $stmt3->bindParam(':u_id', $user_id);
            $stmt3->execute();
            $result3 = $stmt3->fetch(PDO::FETCH_ASSOC);
            $dues = $result3['total_dues'] ?? 0;

            return [
                'batches' => $batches, 
                'students' => $students,
                'dues' => $dues
            ];
            
        } catch (PDOException $e) {
            return ['batches' => 0, 'students' => 0, 'dues' => 0];
        }
    }

    // Create a new batch
    public function createBatch($user_id, $name, $fee) {
        $query = "INSERT INTO batches (user_id, batch_name, monthly_fee) VALUES (:u_id, :name, :fee)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':u_id', $user_id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':fee', $fee);
        return $stmt->execute();
    }
}
?>