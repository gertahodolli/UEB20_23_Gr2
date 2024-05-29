<?php
include 'db_connect.php'; // Include the connection script

function createSponsorsTable($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS sponsors (
        id BIGINT AUTO_INCREMENT PRIMARY KEY,
        emri VARCHAR(255) NOT NULL,
        dataFillimit DATE,
        foto BLOB
    )";

    if ($conn->query($sql) === TRUE) {
        echo "Table 'sponsors' created successfully";
    } else {
        error_log("Error creating table: " . $conn->error);
        echo "There was an issue creating the table. Please try again later.";
    }
}

function createFeedbackTable($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS feedback (
        id BIGINT AUTO_INCREMENT PRIMARY KEY,
        emri VARCHAR(255),
        email VARCHAR(255),
        satisfaction INT,
        feedback TEXT
    )";

    if ($conn->query($sql) === TRUE) {
        echo "Table 'feedback' created successfully";
    } else {
        error_log("Error creating table: " . $conn->error);
        echo "There was an issue creating the table. Please try again later.";
    }
}

function insertSponsor($emri, $dataFillimit, $foto, $conn) {
    $stmt = $conn->prepare("INSERT INTO sponsors (emri, dataFillimit, foto) VALUES (?, ?, ?)");
    $null = NULL; // Placeholder for the BLOB data
    $stmt->bind_param("ssb", $emri, $dataFillimit, $null);
    $stmt->send_long_data(2, $foto);
    if ($stmt->execute()) {
        echo "New sponsor created successfully";
    } else {
        error_log("Error inserting sponsor: " . $stmt->error);
        echo "There was an issue creating the sponsor. Please try again later.";
    }
    $stmt->close();
}

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

function updateSponsor($id, $emri, $dataFillimit, $foto, $conn) {
    $stmt = $conn->prepare("UPDATE sponsors SET emri = ?, dataFillimit = ?, foto = ? WHERE id = ?");
    $null = NULL; // Placeholder for BLOB
    $stmt->bind_param("ssbi", $emri, $dataFillimit, $null, $id);
    $stmt->send_long_data(2, $foto);
    if ($stmt->execute()) {
        echo "Sponsor updated successfully";
    } else {
        error_log("Error updating sponsor: " . $stmt->error);
        echo "There was an issue updating the sponsor. Please try again later.";
    }
    $stmt->close();
}

function updateFeedback($id, $emri, $email, $satisfaction, $feedback, $conn) {
    $stmt = $conn->prepare("UPDATE feedback SET emri = ?, email = ?, satisfaction = ?, feedback = ? WHERE id = ?");
    $stmt->bind_param("ssisi", $emri, $email, $satisfaction, $feedback, $id);
    if ($stmt->execute()) {
        echo "Feedback updated successfully";
    } else {
        error_log("Error updating feedback: " . $stmt->error);
        echo "There was an issue updating the feedback. Please try again later.";
    }
    $stmt->close();
}

function deleteSponsor($id, $conn) {
    $stmt = $conn->prepare("DELETE FROM sponsors WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "Sponsor deleted successfully";
    } else {
        error_log("Error deleting sponsor: " . $stmt->error);
        echo "There was an issue deleting the sponsor. Please try again later.";
    }
    $stmt->close();
}

function deleteFeedback($id, $conn) {
    $stmt = $conn->prepare("DELETE FROM feedback WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "Feedback deleted successfully";
    } else {
        error_log("Error deleting feedback: " . $conn->error);
        echo "There was an issue deleting the feedback. Please try again later.";
    }
    $stmt->close();
}

$conn->close();
?>
