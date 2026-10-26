<?php
class StudentModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Save new students
    public function createStudent($batch_id, $student_name, $mobile, $fee) {
        $query = "INSERT INTO students (batch_id, student_name, mobile, monthly_fee_custom, payment_status) 
                  VALUES (:b_id, :name, :mobile, :fee, 'Unpaid')";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':b_id', $batch_id);
        $stmt->bindParam(':name', $student_name);
        $stmt->bindParam(':mobile', $mobile);
        $stmt->bindParam(':fee', $fee);
        
        return $stmt->execute();
    }

    // Listing of all students ( with Fee tracking)
    public function getAllStudents($user_id) {
        $query = "SELECT students.*, batches.batch_name 
                  FROM students 
                  JOIN batches ON students.batch_id = batches.id 
                  WHERE batches.user_id = :u_id 
                  ORDER BY students.id DESC";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':u_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // --- FEE COLLECTION FEATURE ---
    // Update Payment Status update (Unpaid -> Paid)
    public function updatePaymentStatus($student_id, $status) {
        $query = "UPDATE students SET payment_status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $student_id);
        return $stmt->execute();
    }
}
?>