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

$user_id = $_SESSION["user_id"];

$sql = "SELECT bookings.*,
               rooms.title AS room_title,
               rooms.location,
               rooms.price,
               rooms.room_type
        FROM bookings
        JOIN rooms ON bookings.room_id = rooms.id
        WHERE bookings.user_id = '$user_id'
        ORDER BY bookings.id DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>User Dashboard - RoomConnect</title>

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

        <div>

            <a href="rooms.php"
               class="btn btn-outline-primary me-2">
                Find Rooms
            </a>

            <a href="logout.php"
               class="btn btn-outline-danger">
                Logout
            </a>

        </div>

    </div>

</nav>


<div class="container py-5">

    <h1 class="fw-bold">
        User Dashboard
    </h1>

    <p class="text-muted mb-4">
        Welcome, <?php echo htmlspecialchars($_SESSION["user_name"]); ?>!
    </p>


    <div class="card shadow-sm">

        <div class="card-body">

            <h4 class="fw-bold mb-4">
                My Booking Requests
            </h4>


            <?php if ($result->num_rows > 0): ?>

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead>

                            <tr>
                                <th>Room</th>
                                <th>Location</th>
                                <th>Type</th>
                                <th>Rent</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php while ($booking = $result->fetch_assoc()): ?>

                                <tr>

                                    <td>
                                        <strong>
                                            <?php echo htmlspecialchars($booking["room_title"]); ?>
                                        </strong>
                                    </td>

                                    <td>
                                        <?php echo htmlspecialchars($booking["location"]); ?>
                                    </td>

                                    <td>
                                        <?php echo htmlspecialchars($booking["room_type"]); ?>
                                    </td>

                                    <td>
                                        Rs. <?php echo htmlspecialchars($booking["price"]); ?>
                                    </td>

                                    <td>
                                        <?php echo htmlspecialchars($booking["booking_date"]); ?>
                                    </td>

                                    <td>

                                        <?php if ($booking["status"] == "Accepted"): ?>

                                            <span class="badge bg-success">
                                                Accepted
                                            </span>

                                        <?php elseif ($booking["status"] == "Rejected"): ?>

                                            <span class="badge bg-danger">
                                                Rejected
                                            </span>

                                        <?php else: ?>

                                            <span class="badge bg-warning text-dark">
                                                Pending
                                            </span>

                                        <?php endif; ?>

                                    </td>

                                </tr>

                            <?php endwhile; ?>

                        </tbody>

                    </table>

                </div>

            <?php else: ?>

                <div class="alert alert-info">
                    You haven't made any booking requests yet.
                </div>

                <a href="rooms.php" class="btn btn-primary">
                    Find a Room
                </a>

            <?php endif; ?>

        </div>

    </div>

</div>

</body>
</html>

<?php
$conn->close();
?>