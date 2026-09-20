<?php
session_start();

if (!isset($_SESSION["owner_id"])) {
    header("Location: ../owner-login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Owner Dashboard - RoomConnect</title>

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

       <div class="d-flex align-items-center gap-3">

    <span>
        Welcome, <?php echo htmlspecialchars($_SESSION["owner_name"]); ?>
    </span>

    <a href="../logout.php" class="btn btn-outline-danger">
        Logout
    </a>

</div>

    </div>

</nav>


<div class="container py-5">

    <div class="mb-4">

        <h1 class="fw-bold">
            Owner Dashboard
        </h1>

        <p class="text-muted">
            Manage your rooms and booking requests.
        </p>

    </div>


    <div class="row g-4">


        <!-- Add Room -->
        <div class="col-md-4">

            <div class="card shadow-sm h-100 p-4">

                <h3>🏠</h3>

                <h4>Add Room</h4>

                <p class="text-muted">
                    Add a new room to RoomConnect.
                </p>

                <a href="add-room.php"
                   class="btn btn-primary mt-auto">

                    Add New Room

                </a>

            </div>

        </div>


        <!-- My Rooms -->
        <div class="col-md-4">

            <div class="card shadow-sm h-100 p-4">

                <h3>📋</h3>

                <h4>My Rooms</h4>

                <p class="text-muted">
                    View and manage your listed rooms.
                </p>

                <a href="my-rooms.php"
                   class="btn btn-outline-primary mt-auto">

                    View My Rooms

                </a>

            </div>

        </div>


        <!-- Booking Requests -->
        <div class="col-md-4">

            <div class="card shadow-sm h-100 p-4">

                <h3>📩</h3>

                <h4>Booking Requests</h4>

                <p class="text-muted">
                    View requests from users.
                </p>

                <a href="booking-requests.php"
                   class="btn btn-outline-primary mt-auto">

                    View Requests

                </a>

            </div>

        </div>

    </div>

</div>

</body>
</html>