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

                    /* Count Users */
         $user_count = $conn->query("SELECT COUNT(*) AS total FROM users")
                    ->fetch_assoc()["total"];

           /* Count Owners */
          $owner_count = $conn->query("SELECT COUNT(*) AS total FROM owners")
                     ->fetch_assoc()["total"];

                     /* Count Rooms */
            $room_count = $conn->query("SELECT COUNT(*) AS total FROM rooms")
                    ->fetch_assoc()["total"];

               /* Count Bookings */
              $booking_count = $conn->query("SELECT COUNT(*) AS total FROM bookings")
                       ->fetch_assoc()["total"];
              ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard - RoomConnect</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-dark bg-dark">
    <div class="container">

        <a class="navbar-brand fw-bold" href="admin_dashboard.php">
            🏠 RoomConnect Admin
        </a>

        <div class="d-flex align-items-center">

            <span class="text-white me-3">
                Welcome, <?php echo htmlspecialchars($_SESSION["admin_name"]); ?>
            </span>

            <a href="admin_logout.php" class="btn btn-danger btn-sm">
                Logout
            </a>

        </div>

    </div>
</nav>


<!-- Dashboard -->
<div class="container py-5">

    <div class="mb-4">
        <h2 class="fw-bold">Admin Dashboard</h2>

        <p class="text-muted">
            Manage users, owners, rooms and booking requests.
        </p>
    </div>


    <!-- Dashboard Cards -->
    <div class="row g-4">

        <!-- Users -->
        <div class="col-md-6 col-lg-3">

            <div class="card shadow-sm h-100">

                <div class="card-body text-center">

                    <div class="fs-1">👤</div>

                    <h5 class="card-title mt-2">
                        Users
                    </h5>
                    <h2 class="fw-bold">
                         <?php echo $user_count; ?>
                        </h2>

                    <p class="text-muted">
                        Manage registered users.
                    </p>

                    <a href="admin_users.php" class="btn btn-primary">
                      Manage Users
                          </a>

                </div>

            </div>

        </div>


        <!-- Owners -->
        <div class="col-md-6 col-lg-3">

            <div class="card shadow-sm h-100">

                <div class="card-body text-center">

                    <div class="fs-1">🏠</div>

                    <h5 class="card-title mt-2">
                        Owners
                    </h5>
                   <h2 class="fw-bold">
                        <?php echo $owner_count; ?>
                     </h2>
                    <p class="text-muted">
                        Manage property owners.
                    </p>

                    <a href="admin_owners.php" class="btn btn-primary">
                        Manage Owners
                    </a>

                </div>

            </div>

        </div>


        <!-- Rooms -->
        <div class="col-md-6 col-lg-3">

            <div class="card shadow-sm h-100">

                <div class="card-body text-center">

                    <div class="fs-1">🛏️</div>

                    <h5 class="card-title mt-2">
                        Rooms
                    </h5>
                    <h2 class="fw-bold">
                          <?php echo $room_count; ?>
                      </h2>

                    <p class="text-muted">
                        Manage listed rooms.
                    </p>

                    <a href="admin_rooms.php" class="btn btn-primary">
                        Manage Rooms
                    </a>

                </div>

            </div>

        </div>


        <!-- Bookings -->
        <div class="col-md-6 col-lg-3">

            <div class="card shadow-sm h-100">

                <div class="card-body text-center">

                    <div class="fs-1">📋</div>

                    <h5 class="card-title mt-2">
                        Bookings
                    </h5>
                    <h2 class="fw-bold">
                        <?php echo $booking_count; ?>

                    <p class="text-muted">
                        View booking requests.
                    </p>

                    <a href="admin_bookings.php" class="btn btn-primary">
                        Manage Bookings
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>