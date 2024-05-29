<?php
include 'db_connect.php'; // Include the connection script

function createFeedbackTable($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS feedback (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        rating INT NOT NULL,
        feedback TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    if ($conn->query($sql) === TRUE) {
        echo "Table 'feedback' created successfully";
    } else {
        error_log("Error creating table: " . $conn->error);
        echo "There was an issue creating the table. Please try again later.";
    }
}

function insertFeedback($name, $email, $rating, $feedback, $conn) {
    $stmt = $conn->prepare("INSERT INTO feedback (name, email, rating, feedback) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $name, $email, $rating, $feedback);
    if ($stmt->execute()) {
        echo "New feedback submitted successfully";
    } else {
        error_log("Error inserting feedback: " . $stmt->error);
        echo "There was an issue submitting the feedback. Please try again later.";
    }
    $stmt->close();
}

function updateFeedback($id, $name, $email, $rating, $feedback, $conn) {
    $stmt = $conn->prepare("UPDATE feedback SET name = ?, email = ?, rating = ?, feedback = ? WHERE id = ?");
    $stmt->bind_param("ssisi", $name, $email, $rating, $feedback, $id);
    if ($stmt->execute()) {
        echo "Feedback updated successfully";
    } else {
        error_log("Error updating feedback: " . $stmt->error);
        echo "There was an issue updating the feedback. Please try again later.";
    }
    $stmt->close();
}

function deleteFeedback($id, $conn) {
    $stmt = $conn->prepare("DELETE FROM feedback WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "Feedback deleted successfully";
    } else {
        error_log("Error deleting feedback: " . $stmt->error);
        echo "There was an issue deleting the feedback. Please try again later.";
    }
    $stmt->close();
}

$conn->close();
?>
