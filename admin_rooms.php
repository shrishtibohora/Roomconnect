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

$sql = "SELECT rooms.*, owners.name AS owner_name
        FROM rooms
        LEFT JOIN owners ON rooms.owner_id = owners.id
        ORDER BY rooms.id DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Rooms - RoomConnect</title>

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
            <h2 class="fw-bold">Manage Rooms</h2>

            <p class="text-muted">
                View and manage all rooms listed by property owners.
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
                            <th>Image</th>
                            <th>Room Title</th>
                            <th>Owner</th>
                            <th>Location</th>
                            <th>Room Type</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Created Date</th>
                            <th>Action</th>
                        </tr>

                    </thead>

                    <tbody>

                    <?php if ($result->num_rows > 0): ?>

                        <?php while ($room = $result->fetch_assoc()): ?>

                            <tr>

                                <td>
                                    <?php echo $room["id"]; ?>
                                </td>

                                <!-- Room Image -->
                                <td>

                                    <?php if (!empty($room["image"])): ?>

                                        <img src="<?php echo htmlspecialchars($room["image"]); ?>"
                                             alt="Room Image"
                                             width="80"
                                             height="60"
                                             style="object-fit: cover; border-radius: 5px;">

                                    <?php else: ?>

                                        <span class="text-muted">
                                            No Image
                                        </span>

                                    <?php endif; ?>

                                </td>

                                <td>
                                    <?php echo htmlspecialchars($room["title"]); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($room["owner_name"] ?? "Unknown"); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($room["location"]); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($room["room_type"]); ?>
                                </td>

                                <td>
                                    Rs. <?php echo number_format($room["price"], 2); ?>
                                </td>

                                <td>

                                    <?php if ($room["status"] == "Available"): ?>

                                        <span class="badge bg-success">
                                            Available
                                        </span>

                                    <?php else: ?>

                                        <span class="badge bg-secondary">
                                            <?php echo htmlspecialchars($room["status"]); ?>
                                        </span>

                                    <?php endif; ?>

                                </td>

                                <td>
                                    <?php echo $room["created_at"]; ?>
                                </td>

                                <!-- ACTION -->
                                <td>
                                    <a href="admin_delete_room.php?id=<?php echo $room["id"]; ?>"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Are you sure you want to delete <?php echo htmlspecialchars($room["title"], ENT_QUOTES); ?>?');">
                                        Delete
                                    </a>
                                </td>

                            </tr>

                        <?php endwhile; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="10" class="text-center text-muted">
                                No rooms listed yet.
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