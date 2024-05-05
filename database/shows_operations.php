<?php
include 'db_connect.php'; // Include the connection script

function createShfaqjeTable($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS shfaqje (
        id SERIAL PRIMARY KEY,
        emrin VARCHAR(255) NOT NULL,
        regjisorin VARCHAR(255),
        duration VARCHAR(10),
        aktoret VARCHAR(255),
        pershkrimi TEXT,
        foto BLOB,
        video BLOB
    )";
    
    if ($conn->query($sql) === TRUE) {
        echo "Table 'shfaqje' created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }
}

function insertShfaqje($emrin, $regjisorin, $duration, $aktoret, $pershkrimi, $foto, $video, $conn) {
    $stmt = $conn->prepare("INSERT INTO shfaqje (emrin, regjisorin, duration, aktoret, pershkrimi, foto, video) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $null = NULL;
    $stmt->bind_param("sssssss", $emrin, $regjisorin, $duration, $aktoret, $pershkrimi, $null, $null);
    $stmt->send_long_data(5, $foto);
    $stmt->send_long_data(6, $video);
    if ($stmt->execute()) {
        echo "New shfaqje created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

function updateShfaqje($id, $emrin, $regjisorin, $duration, $aktoret, $pershkrimi, $foto, $video, $conn) {
    $stmt = $conn->prepare("UPDATE shfaqje SET emrin = ?, regjisorin = ?, duration = ?, aktoret = ?, pershkrimi = ?, foto = ?, video = ? WHERE id = ?");
    $null = NULL;
    $stmt->bind_param("sssssssi", $emrin, $regjisorin, $duration, $aktoret, $pershkrimi, $null, $null, $id);
    $stmt->send_long_data(5, $foto);
    $stmt->send_long_data(6, $video);
    if ($stmt->execute()) {
        echo "Shfaqje updated successfully";
    } else {
        echo "Error updating shfaqje: " . $stmt->error;
    }
    $stmt->close();
}

function deleteShfaqje($id, $conn) {
    $stmt = $conn->prepare("DELETE FROM shfaqje WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "Shfaqje deleted successfully";
    } else {
        echo "Error deleting shfaqje: " . $stmt->error;
    }
    $stmt->close();
}

function createPerformancesTable($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS performances (
        id SERIAL PRIMARY KEY,
        shfaqje_id INT NOT NULL,
        emri VARCHAR(255) NOT NULL,
        date DATE,
        time TIME,
        foto BLOB,
        FOREIGN KEY (shfaqje_id) REFERENCES shfaqje(id)
    )";
    
    if ($conn->query($sql) === TRUE) {
        echo "Table 'performances' created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }
}

function insertPerformance($shfaqje_id, $emri, $date, $time, $foto, $conn) {
    $stmt = $conn->prepare("INSERT INTO performances (shfaqje_id, emri, date, time, foto) VALUES (?, ?, ?, ?, ?)");
    $null = NULL; // Placeholder for the BLOB data
    $stmt->bind_param("isssb", $shfaqje_id, $emri, $date, $time, $null);
    $stmt->send_long_data(4, $foto); // Handling BLOB data for photo
    if ($stmt->execute()) {
        echo "New performance created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

function updatePerformance($id, $shfaqje_id, $emri, $date, $time, $foto, $conn) {
    $stmt = $conn->prepare("UPDATE performances SET shfaqje_id = ?, emri = ?, date = ?, time = ?, foto = ? WHERE id = ?");
    $null = NULL; // Placeholder for the BLOB data
    $stmt->bind_param("isssbi", $shfaqje_id, $emri, $date, $time, $null, $id);
    $stmt->send_long_data(4, $foto); // Handling BLOB data for photo
    if ($stmt->execute()) {
        echo "Performance updated successfully";
    } else {
        echo "Error updating performance: " . $stmt->error;
    }
    $stmt->close();
}

function deletePerformance($id, $conn) {
    $stmt = $conn->prepare("DELETE FROM performances WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "Performance deleted successfully";
    } else {
        echo "Error deleting performance: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>
