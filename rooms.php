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

$sql = "SELECT * FROM rooms
        WHERE status = 'Available'
        ORDER BY id DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Find Rooms - RoomConnect</title>

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

        <div class="ms-auto">

            <span class="me-3">
                Hello, <?php echo htmlspecialchars($_SESSION["user_name"]); ?>
            </span>

            <a href="logout.php" class="btn btn-outline-danger">
                Logout
            </a>

        </div>

    </div>

</nav>


<!-- Header -->
<section class="py-5">

    <div class="container text-center">

        <h1 class="fw-bold">
            Find Your Perfect Room
        </h1>

        <p class="text-muted">
            Explore available rooms listed on RoomConnect.
        </p>

    </div>

</section>


<!-- Rooms -->
<section class="container pb-5">

    <div class="row g-4">

        <?php if ($result->num_rows > 0): ?>

            <?php while ($room = $result->fetch_assoc()): ?>

                <div class="col-md-6 col-lg-4">

                    <div class="card shadow-sm h-100">
                        <img src="uploads/<?php echo htmlspecialchars($room["image"]); ?>"
                            class="card-img-top"
                             style="height: 220px; object-fit: cover;"
                                 alt="Room Image">

                        <div class="card-body">

                            <span class="badge bg-success mb-3">
                                Available
                            </span>

                            <h4 class="card-title">
                                <?php echo htmlspecialchars($room["title"]); ?>
                            </h4>

                            <p class="text-muted">
                                📍 <?php echo htmlspecialchars($room["location"]); ?>
                            </p>

                            <p>
                                <strong>Type:</strong>
                                <?php echo htmlspecialchars($room["room_type"]); ?>
                            </p>

                            <p class="text-muted">
                                <?php echo htmlspecialchars($room["description"]); ?>
                            </p>

                            <div class="d-flex justify-content-between
                                        align-items-center mt-3">

                                <strong class="text-primary">
                                    Rs. <?php echo htmlspecialchars($room["price"]); ?>/month
                                </strong>

                                <a href="room-details.php?id=<?php echo $room["id"]; ?>"
                                   class="btn btn-outline-primary">

                                    View Details

                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            <?php endwhile; ?>

        <?php else: ?>

            <div class="col-12">

                <div class="alert alert-info text-center">

                    No rooms are currently available.

                </div>

            </div>

        <?php endif; ?>

    </div>

</section>


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