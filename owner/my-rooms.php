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

$owner_id = $_SESSION["owner_id"];

$sql = "SELECT * FROM rooms WHERE owner_id = '$owner_id' ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Rooms - RoomConnect</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet" href="../css/style.css">

</head>

<body>

<nav class="navbar navbar-expand-lg bg-white shadow-sm">

    <div class="container">

        <a class="navbar-brand fw-bold" href="../index.php">
            🏠 RoomConnect
        </a>

        <a href="dashboard.php" class="btn btn-outline-primary">
            Dashboard
        </a>

    </div>

</nav>


<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="fw-bold">My Rooms</h1>

            <p class="text-muted mb-0">
                Manage the rooms you have listed.
            </p>
        </div>

        <a href="add-room.php" class="btn btn-primary">
            + Add New Room
        </a>

    </div>


    <div class="row g-4">

        <?php if ($result->num_rows > 0): ?>

            <?php while ($room = $result->fetch_assoc()): ?>

                <div class="col-md-6 col-lg-4">

                    <div class="card shadow-sm h-100">

                        <div class="card-body">

                            <span class="badge bg-success mb-2">
                                <?php echo htmlspecialchars($room["status"]); ?>
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

                            <h5 class="text-primary">
                                Rs. <?php echo htmlspecialchars($room["price"]); ?>/month
                            </h5>

                            <p class="text-muted">
                                <?php echo htmlspecialchars($room["description"]); ?>
                            </p>

                            <div class="d-flex gap-2 mt-3">

                                <a href="edit-room.php?id=<?php echo $room["id"]; ?>"
                                   class="btn btn-outline-primary">
                                    Edit
                                </a>

                                <a href="delete-room.php?id=<?php echo $room["id"]; ?>"
                                   class="btn btn-outline-danger"
                                   onclick="return confirm('Are you sure you want to delete this room?');">
                                    Delete
                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            <?php endwhile; ?>

        <?php else: ?>

            <div class="col-12">

                <div class="alert alert-info text-center">

                    You haven't added any rooms yet.

                    <br><br>

                    <a href="add-room.php" class="btn btn-primary">
                        Add Your First Room
                    </a>

                </div>

            </div>

        <?php endif; ?>

    </div>

</div>


</body>
</html>

<?php
$conn->close();
?>