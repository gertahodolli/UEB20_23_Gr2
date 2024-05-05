<?php
include 'db_connect.php'; // Include the connection script

function createStafTable($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS staf (
        id SERIAL PRIMARY KEY,
        emri VARCHAR(255),
        mbiemri VARCHAR(255),
        pozita VARCHAR(255),
        email VARCHAR(255),
        tel VARCHAR(20),
        age INT
    )";
    
    if ($conn->query($sql) === TRUE) {
        echo "Table 'staf' created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }
}

function createAplikoTable($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS apliko (
        id SERIAL PRIMARY KEY,
        emriDheMbiemri VARCHAR(255),
        pozita VARCHAR(255),
        email VARCHAR(255),
        tel VARCHAR(20),
        mosha INT,
        koment TEXT
    )";
    
    if ($conn->query($sql) === TRUE) {
        echo "Table 'apliko' created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }
}

function insertStaff($emri, $mbiemri, $pozita, $email, $tel, $age, $conn) {
    $stmt = $conn->prepare("INSERT INTO staf (emri, mbiemri, pozita, email, tel, age) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $emri, $mbiemri, $pozita, $email, $tel, $age);
    if ($stmt->execute()) {
        echo "New staff member created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

function insertApplication($emriDheMbiemri, $pozita, $email, $tel, $mosha, $koment, $conn) {
    $stmt = $conn->prepare("INSERT INTO apliko (emriDheMbiemri, pozita, email, tel, mosha, koment) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssis", $emriDheMbiemri, $pozita, $email, $tel, $mosha, $koment);
    if ($stmt->execute()) {
        echo "New application submitted successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

function updateStaff($id, $emri, $mbiemri, $pozita, $email, $tel, $age, $conn) {
    $stmt = $conn->prepare("UPDATE staf SET emri = ?, mbiemri = ?, pozita = ?, email = ?, tel = ?, age = ? WHERE id = ?");
    $stmt->bind_param("ssssssi", $emri, $mbiemri, $pozita, $email, $tel, $age, $id);
    if ($stmt->execute()) {
        echo "Staff member updated successfully";
    } else {
        echo "Error updating staff: " . $stmt->error;
    }
    $stmt->close();
}

function updateApplication($id, $emriDheMbiemri, $pozita, $email, $tel, $mosha, $koment, $conn) {
    $stmt = $conn->prepare("UPDATE apliko SET emriDheMbiemri = ?, pozita = ?, email = ?, tel = ?, mosha = ?, koment = ? WHERE id = ?");
    $stmt->bind_param("ssssisi", $emriDheMbiemri, $pozita, $email, $tel, $mosha, $koment, $id);
    if ($stmt->execute()) {
        echo "Application updated successfully";
    } else {
        echo "Error updating application: " . $stmt->error;
    }
    $stmt->close();
}

function deleteStaff($id, $conn) {
    $stmt = $conn->prepare("DELETE FROM staf WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "Staff member deleted successfully";
    } else {
        echo "Error deleting staff: " . $stmt->error;
    }
    $stmt->close();
}

function deleteApplication($id, $conn) {
    $stmt = $conn->prepare("DELETE FROM apliko WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "Application deleted successfully";
    } else {
        echo "Error deleting application: " . $stmt->error;
    }
    $stmt->close();
}


$conn->close();
?>