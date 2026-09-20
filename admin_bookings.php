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

$sql = "SELECT 
            bookings.id,
            bookings.booking_date,
            bookings.status,
            users.name AS user_name,
            users.email AS user_email,
            rooms.title AS room_title,
            rooms.location,
            owners.name AS owner_name
        FROM bookings
        LEFT JOIN users ON bookings.user_id = users.id
        LEFT JOIN rooms ON bookings.room_id = rooms.id
        LEFT JOIN owners ON rooms.owner_id = owners.id
        ORDER BY bookings.id DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Bookings - RoomConnect</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-dark bg-dark">
    <div class="container">

        <a class="navbar-brand fw-bold" href="admin_dashboard.php">
            🏠 RoomConnect Admin
        </a>

        <a href="admin_logout.php" class="btn btn-danger btn-sm">
            Logout
        </a>

    </div>
</nav>


<!-- Main Content -->
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold">Manage Bookings</h2>

            <p class="text-muted">
                View all booking requests made by users.
            </p>
        </div>

        <a href="admin_dashboard.php" class="btn btn-secondary">
            ← Back to Dashboard
        </a>

    </div>


    <div class="card shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-dark">

                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Email</th>
                            <th>Room</th>
                            <th>Location</th>
                            <th>Owner</th>
                            <th>Booking Date</th>
                            <th>Status</th>
                        </tr>

                    </thead>

                    <tbody>

                    <?php if ($result->num_rows > 0): ?>

                        <?php while ($booking = $result->fetch_assoc()): ?>

                            <tr>

                                <td>
                                    <?php echo $booking["id"]; ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($booking["user_name"] ?? "Unknown"); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($booking["user_email"] ?? "Unknown"); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($booking["room_title"] ?? "Unknown"); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($booking["location"] ?? "Unknown"); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($booking["owner_name"] ?? "Unknown"); ?>
                                </td>

                                <td>
                                    <?php echo $booking["booking_date"]; ?>
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
                                            <?php echo htmlspecialchars($booking["status"]); ?>
                                        </span>

                                    <?php endif; ?>

                                </td>

                            </tr>

                        <?php endwhile; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                No booking requests yet.
                            </td>
                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

</body>
</html>             