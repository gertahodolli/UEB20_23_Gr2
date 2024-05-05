<?php
include 'db_connect.php'; // Include the connection script

function createSponsorsTable($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS sponsors (
        id SERIAL PRIMARY KEY,
        emri VARCHAR(255) NOT NULL,
        dataFillimit DATE,
        foto BLOB
    )";
    
    if ($conn->query($sql) === TRUE) {
        echo "Table 'sponsors' created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }
}

function createFeedbackTable($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS feedback (
        id SERIAL PRIMARY KEY,
        emri VARCHAR(255),
        email VARCHAR(255),
        satisfaction INT,
        feedback TEXT
    )";
    
    if ($conn->query($sql) === TRUE) {
        echo "Table 'feedback' created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
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
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

function insertFeedback($emri, $email, $satisfaction, $feedback, $conn) {
    $stmt = $conn->prepare("INSERT INTO feedback (emri, email, satisfaction, feedback) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $emri, $email, $satisfaction, $feedback);
    if ($stmt->execute()) {
        echo "New feedback submitted successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

function updateSponsor($id, $emri, $dataFillimit, $foto, $conn) {
    $stmt = $conn->prepare("UPDATE sponsors SET emri = ?, dataFillimit = ?, foto = ? WHERE id = ?");
    $null = NULL; // Placeholder for BLOB
    $stmt->bind_param("ssbi", $emri, $dataFillimit, $null, $id);
    $stmt->send_long_data(2, $foto);
    if ($stmt->execute()) {
        echo "Sponsor updated successfully";
    } else {
        echo "Error updating sponsor: " . $stmt->error;
    }
    $stmt->close();
}

function updateFeedback($id, $emri, $email, $satisfaction, $feedback, $conn) {
    $stmt = $conn->prepare("UPDATE feedback SET emri = ?, email = ?, satisfaction = ?, feedback = ? WHERE id = ?");
    $stmt->bind_param("ssisi", $emri, $email, $satisfaction, $feedback, $id);
    if ($stmt->execute()) {
        echo "Feedback updated successfully";
    } else {
        echo "Error updating feedback: " . $stmt->error;
    }
    $stmt->close();
}

function deleteSponsor($id, $conn) {
    $stmt = $conn->prepare("DELETE FROM sponsors WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "Sponsor deleted successfully";
    } else {
        echo "Error deleting sponsor: " . $stmt->error;
    }
    $stmt->close();
}

function deleteFeedback($id, $conn) {
    $stmt = $conn->prepare("DELETE FROM feedback WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "Feedback deleted successfully";
    } else {
        echo "Error deleting feedback: " . $conn->error;
    }
    $stmt->close();
}


$conn->close();
?>