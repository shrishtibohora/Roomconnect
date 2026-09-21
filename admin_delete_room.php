<?php
session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: admin_login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "roomconnect");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

if (isset($_GET["id"])) {

    $room_id = intval($_GET["id"]);

    $stmt = $conn->prepare("DELETE FROM rooms WHERE id = ?");
    $stmt->bind_param("i", $room_id);

    if ($stmt->execute()) {
        header("Location: admin_rooms.php?message=deleted");
        exit();
    } else {
        echo "Unable to delete room.";
    }

    $stmt->close();
}

$conn->close();
?>