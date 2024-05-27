<?php
include 'db_connect.php'; // Include the connection script

function createUserTable($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS user (
        id BIGINT AUTO_INCREMENT PRIMARY KEY,
        emri VARCHAR(255),
        mbiemri VARCHAR(255),
        email VARCHAR(255) UNIQUE NOT NULL,
        username VARCHAR(255) UNIQUE NOT NULL,
        passHash VARCHAR(255) NOT NULL,
        salt VARCHAR(255) NOT NULL,
        mosha INT,
        student BOOLEAN,
        telefoni VARCHAR(20)
    )";

    if ($conn->query($sql) === TRUE) {
        echo "Table 'user' created successfully";
    } else {
        error_log("Error creating table: " . $conn->error);
        echo "There was an issue creating the table. Please try again later.";
    }
}

function createBiletatTable($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS biletat (
        id BIGINT AUTO_INCREMENT PRIMARY KEY,
        tipi VARCHAR(255) UNIQUE NOT NULL,
        cmimi NUMERIC(10, 2)
    )";

    if ($conn->query($sql) === TRUE) {
        echo "Table 'biletat' created successfully";
    } else {
        error_log("Error creating table: " . $conn->error);
        echo "There was an issue creating the table. Please try again later.";
    }
}

function createShitjetTable($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS shitjet (
        id BIGINT AUTO_INCREMENT PRIMARY KEY,
        time TIME,
        date DATE,
        userId BIGINT,
        performancaId BIGINT,
        biletaId BIGINT,
        sasia INT,
        totali NUMERIC(10, 2),
        kaPerfunduar BOOLEAN,
        FOREIGN KEY (userId) REFERENCES user(id),
        FOREIGN KEY (performancaId) REFERENCES performances(id),
        FOREIGN KEY (biletaId) REFERENCES biletat(id)
    )";

    if ($conn->query($sql) === TRUE) {
        echo "Table 'shitjet' created successfully";
    } else {
        error_log("Error creating table: " . $conn->error);
        echo "There was an issue creating the table. Please try again later.";
    }
}

function insertUser($emri, $mbiemri, $email, $username, $passHash, $salt, $mosha, $student, $telefoni, $conn) {
    $stmt = $conn->prepare("INSERT INTO user (emri, mbiemri, email, username, passHash, salt, mosha, student, telefoni) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssibs", $emri, $mbiemri, $email, $username, $passHash, $salt, $mosha, $student, $telefoni);
    if ($stmt->execute()) {
        echo "New user created successfully";
    } else {
        error_log("Error inserting user: " . $stmt->error);
        echo "There was an issue creating the user. Please try again later.";
    }
    $stmt->close();
}

function insertTicket($tipi, $cmimi, $conn) {
    $stmt = $conn->prepare("INSERT INTO biletat (tipi, cmimi) VALUES (?, ?)");
    $stmt->bind_param("sd", $tipi, $cmimi);
    if ($stmt->execute()) {
        echo "New ticket created successfully";
    } else {
        error_log("Error inserting ticket: " . $stmt->error);
        echo "There was an issue creating the ticket. Please try again later.";
    }
    $stmt->close();
}

function insertSale($time, $date, $userId, $performancaId, $biletaId, $sasia, $totali, $kaPerfunduar, $conn) {
    $stmt = $conn->prepare("INSERT INTO shitjet (time, date, userId, performancaId, biletaId, sasia, totali, kaPerfunduar) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiisiidb", $time, $date, $userId, $performancaId, $biletaId, $sasia, $totali, $kaPerfunduar);
    if ($stmt->execute()) {
        echo "New sale created successfully";
    } else {
        error_log("Error inserting sale: " . $stmt->error);
        echo "There was an issue creating the sale. Please try again later.";
    }
    $stmt->close();
}

function updateUser($id, $emri, $mbiemri, $email, $username, $passHash, $salt, $mosha, $student, $telefoni, $conn) {
    $stmt = $conn->prepare("UPDATE user SET emri = ?, mbiemri = ?, email = ?, username = ?, passHash = ?, salt = ?, mosha = ?, student = ?, telefoni = ? WHERE id = ?");
    $stmt->bind_param("ssssssibsi", $emri, $mbiemri, $email, $username, $passHash, $salt, $mosha, $student, $telefoni, $id);
    if ($stmt->execute()) {
        echo "User updated successfully";
    } else {
        error_log("Error updating user: " . $stmt->error);
        echo "There was an issue updating the user. Please try again later.";
    }
    $stmt->close();
}

function updateTicket($id, $tipi, $cmimi, $conn) {
    $stmt = $conn->prepare("UPDATE biletat SET tipi = ?, cmimi = ? WHERE id = ?");
    $stmt->bind_param("sdi", $tipi, $cmimi, $id);
    if ($stmt->execute()) {
        echo "Ticket updated successfully";
    } else {
        error_log("Error updating ticket: " . $stmt->error);
        echo "There was an issue updating the ticket. Please try again later.";
    }
    $stmt->close();
}

function updateSale($id, $time, $date, $userId, $performancaId, $biletaId, $sasia, $totali, $kaPerfunduar, $conn) {
    $stmt = $conn->prepare("UPDATE shitjet SET time = ?, date = ?, userId = ?, performancaId = ?, biletaId = ?, sasia = ?, totali = ?, kaPerfunduar = ? WHERE id = ?");
    $stmt->bind_param("ssiiiidbi", $time, $date, $userId, $performancaId, $biletaId, $sasia, $totali, $kaPerfunduar, $id);
    if ($stmt->execute()) {
        echo "Sale updated successfully";
    } else {
        error_log("Error updating sale: " . $stmt->error);
        echo "There was an issue updating the sale. Please try again later.";
    }
    $stmt->close();
}

function deleteUser($id, $conn) {
    $stmt = $conn->prepare("DELETE FROM user WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "User deleted successfully";
    } else {
        error_log("Error deleting user: " . $stmt->error);
        echo "There was an issue deleting the user. Please try again later.";
    }
    $stmt->close();
}

function deleteTicket($id, $conn) {
    $stmt = $conn->prepare("DELETE FROM biletat WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "Ticket deleted successfully";
    } else {
        error_log("Error deleting ticket: " . $stmt->error);
        echo "There was an issue deleting the ticket. Please try again later.";
    }
    $stmt->close();
}

function deleteSale($id, $conn) {
    $stmt = $conn->prepare("DELETE FROM shitjet WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "Sale deleted successfully";
    } else {
        error_log("Error deleting sale: " . $stmt->error);
        echo "There was an issue deleting the sale. Please try again later.";
    }
    $stmt->close();
}

$conn->close();
?>
