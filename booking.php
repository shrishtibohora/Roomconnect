<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "roomconnect");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

if (!isset($_GET["room_id"])) {
    header("Location: rooms.php");
    exit();
}

$room_id = $_GET["room_id"];
$user_id = $_SESSION["user_id"];

$sql = "SELECT rooms.*, owners.name AS owner_name
        FROM rooms
        JOIN owners ON rooms.owner_id = owners.id
        WHERE rooms.id = '$room_id'";

$result = $conn->query($sql);

if ($result->num_rows != 1) {
    echo "Room not found.";
    exit();
}

$room = $result->fetch_assoc();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $check = "SELECT * FROM bookings
              WHERE room_id = '$room_id'
              AND user_id = '$user_id'
              AND status = 'Pending'";

    $check_result = $conn->query($check);

    if ($check_result->num_rows > 0) {

        $message = "You have already requested this room.";

    } else {

        $insert = "INSERT INTO bookings (room_id, user_id)
                   VALUES ('$room_id', '$user_id')";

        if ($conn->query($insert) === TRUE) {
            $message = "Booking request sent successfully!";
        } else {
            $message = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Booking Request - RoomConnect</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<nav class="navbar navbar-expand-lg bg-white shadow-sm">

    <div class="container">

        <a class="navbar-brand fw-bold" href="index.php">
            🏠 RoomConnect
        </a>

        <a href="room-details.php?id=<?php echo $room_id; ?>"
           class="btn btn-outline-primary">

            Back to Room

        </a>

    </div>

</nav>


<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-7">

            <div class="card shadow-sm p-4">

                <h2 class="fw-bold mb-4">
                    Booking Request
                </h2>

                <?php if ($message != ""): ?>

                    <div class="alert alert-info">
                        <?php echo $message; ?>
                    </div>

                <?php endif; ?>


                <div class="mb-4">

                    <h4>
                        <?php echo htmlspecialchars($room["title"]); ?>
                    </h4>

                    <p class="text-muted">
                        📍 <?php echo htmlspecialchars($room["location"]); ?>
                    </p>

                    <p>
                        <strong>Room Type:</strong>
                        <?php echo htmlspecialchars($room["room_type"]); ?>
                    </p>

                    <p>
                        <strong>Monthly Rent:</strong>
                        Rs. <?php echo htmlspecialchars($room["price"]); ?>
                    </p>

                    <p>
                        <strong>Owner:</strong>
                        <?php echo htmlspecialchars($room["owner_name"]); ?>
                    </p>

                </div>


                <?php if ($message != "Booking request sent successfully!"): ?>

                    <form method="POST">

                        <p class="text-muted">
                            Are you sure you want to send a booking
                            request for this room?
                        </p>

                        <button type="submit"
                                class="btn btn-primary w-100">

                            Send Booking Request

                        </button>

                    </form>

                <?php else: ?>

                    <a href="rooms.php"
                       class="btn btn-outline-primary w-100">

                        Back to Rooms

                    </a>

                <?php endif; ?>

            </div>

        </div>

    </div>

</div>

</body>
</html>

<?php
$conn->close();
?>