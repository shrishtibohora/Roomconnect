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

$sql = "SELECT bookings.*, 
               rooms.title AS room_title,
               rooms.location,
               rooms.price,
               users.name AS user_name,
               users.email AS user_email
        FROM bookings
        JOIN rooms ON bookings.room_id = rooms.id
        JOIN users ON bookings.user_id = users.id
        WHERE rooms.owner_id = '$owner_id'
        ORDER BY bookings.id DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Booking Requests - RoomConnect</title>

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

    <h1 class="fw-bold mb-2">
        Booking Requests
    </h1>

    <p class="text-muted mb-4">
        Manage booking requests for your rooms.
    </p>


    <?php if ($result->num_rows > 0): ?>

        <div class="row g-4">

            <?php while ($booking = $result->fetch_assoc()): ?>

                <div class="col-md-6">

                    <div class="card shadow-sm h-100">

                        <div class="card-body">

                            <div class="d-flex justify-content-between">

                                <h4>
                                    <?php echo htmlspecialchars($booking["room_title"]); ?>
                                </h4>

                                <span class="badge
                                    <?php
                                    if ($booking["status"] == "Accepted") {
                                        echo "bg-success";
                                    } elseif ($booking["status"] == "Rejected") {
                                        echo "bg-danger";
                                    } else {
                                        echo "bg-warning text-dark";
                                    }
                                    ?>">

                                    <?php echo htmlspecialchars($booking["status"]); ?>

                                </span>

                            </div>


                            <p class="text-muted">
                                📍 <?php echo htmlspecialchars($booking["location"]); ?>
                            </p>

                            <p>
                                <strong>Rent:</strong>
                                Rs. <?php echo htmlspecialchars($booking["price"]); ?>/month
                            </p>

                            <hr>


                            <h5>Applicant Information</h5>

                            <p>
                                <strong>Name:</strong>
                                <?php echo htmlspecialchars($booking["user_name"]); ?>
                            </p>

                            <p>
                                <strong>Email:</strong>
                                <?php echo htmlspecialchars($booking["user_email"]); ?>
                            </p>

                            <p class="text-muted">
                                Requested on:
                                <?php echo htmlspecialchars($booking["booking_date"]); ?>
                            </p>


                            <?php if ($booking["status"] == "Pending"): ?>

                                <div class="d-flex gap-2 mt-3">

                                    <a href="update-booking.php?id=<?php echo $booking["id"]; ?>&status=Accepted"
                                       class="btn btn-success">

                                        Accept

                                    </a>

                                    <a href="update-booking.php?id=<?php echo $booking["id"]; ?>&status=Rejected"
                                       class="btn btn-danger">

                                        Reject

                                    </a>

                                </div>

                            <?php endif; ?>

                        </div>

                    </div>

                </div>

            <?php endwhile; ?>

        </div>

    <?php else: ?>

        <div class="alert alert-info text-center">

            No booking requests yet.

        </div>

    <?php endif; ?>

</div>

</body>
</html>

<?php
$conn->close();
?>