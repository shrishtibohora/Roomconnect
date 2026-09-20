<?php
session_start();

if (!isset($_SESSION["owner_id"])) {
    header("Location: ../owner-login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "roomconnect");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

if (isset($_GET["id"])) {

    $room_id = $_GET["id"];
    $owner_id = $_SESSION["owner_id"];

    $sql = "DELETE FROM rooms
            WHERE id = '$room_id'
            AND owner_id = '$owner_id'";

    $conn->query($sql);
}

$conn->close();

header("Location: my-rooms.php");
exit();
?>