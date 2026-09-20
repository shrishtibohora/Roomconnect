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

if (!isset($_GET["id"])) {
    header("Location: rooms.php");
    exit();
}

$room_id = $_GET["id"];

$sql = "SELECT rooms.*, owners.name AS owner_name, owners.phone AS owner_phone
        FROM rooms
        JOIN owners ON rooms.owner_id = owners.id
        WHERE rooms.id = '$room_id'";

$result = $conn->query($sql);

if ($result->num_rows != 1) {
    echo "Room not found.";
    exit();
}

$room = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        <?php echo htmlspecialchars($room["title"]); ?> - RoomConnect
    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-white shadow-sm">

    <div class="container">

        <a class="navbar-brand fw-bold" href="index.php">
            🏠 RoomConnect
        </a>

        <a href="rooms.php" class="btn btn-outline-primary">
            ← Back to Rooms
        </a>

    </div>

</nav>


<!-- Room Details -->
<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-9">

            <div class="card shadow-sm">
                <img src="uploads/<?php echo htmlspecialchars($room["image"]); ?>"
                      class="card-img-top"
                           style="height: 400px; object-fit: cover;"
                                 alt="Room Image">

                <div class="card-body p-4">

                    <span class="badge bg-success mb-3">
                        <?php echo htmlspecialchars($room["status"]); ?>
                    </span>


                    <h1 class="fw-bold mb-3">
                        <?php echo htmlspecialchars($room["title"]); ?>
                    </h1>


                    <p class="text-muted fs-5">
                        📍 <?php echo htmlspecialchars($room["location"]); ?>
                    </p>


                    <hr>


                    <div class="row g-4">

                        <div class="col-md-6">

                            <h5>Room Information</h5>

                            <p>
                                <strong>Room Type:</strong>
                                <?php echo htmlspecialchars($room["room_type"]); ?>
                            </p>

                            <p>
                                <strong>Monthly Rent:</strong>
                                Rs. <?php echo htmlspecialchars($room["price"]); ?>
                            </p>

                            <p>
                                <strong>Status:</strong>
                                <?php echo htmlspecialchars($room["status"]); ?>
                            </p>

                        </div>


                        <div class="col-md-6">

                            <h5>Property Owner</h5>

                            <p>
                                <strong>Name:</strong>
                                <?php echo htmlspecialchars($room["owner_name"]); ?>
                            </p>

                            <p>
                                <strong>Phone:</strong>
                                <?php echo htmlspecialchars($room["owner_phone"]); ?>
                            </p>

                        </div>

                    </div>


                    <hr>


                    <h5>Room Description</h5>

                    <p class="text-muted">
                        <?php echo nl2br(htmlspecialchars($room["description"])); ?>
                    </p>


                    <?php if ($room["status"] == "Available"): ?>

                        <div class="mt-4">

                            <a href="booking.php?room_id=<?php echo $room["id"]; ?>"
                               class="btn btn-primary btn-lg">

                                Request to Book

                            </a>

                        </div>

                    <?php else: ?>

                        <div class="alert alert-warning mt-4">
                            This room is currently not available for booking.
                        </div>

                    <?php endif; ?>

                </div>

            </div>

        </div>

    </div>

</div>


<footer class="bg-dark text-white text-center py-4">

    <p class="mb-0">
        © 2026 RoomConnect. All Rights Reserved.
    </p>

</footer>

</body>
</html>

<?php
$conn->close();
?>