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


// Search and filter values
$location = isset($_GET["location"]) ? trim($_GET["location"]) : "";
$room_type = isset($_GET["room_type"]) ? $_GET["room_type"] : "";
$max_price = isset($_GET["max_price"]) ? $_GET["max_price"] : "";


// Base query
$sql = "SELECT * FROM rooms WHERE status = 'Available'";


// Location filter
if ($location != "") {
    $location_safe = $conn->real_escape_string($location);

    $sql .= " AND location LIKE '%$location_safe%'";
}


// Room type filter
if ($room_type != "") {
    $room_type_safe = $conn->real_escape_string($room_type);

    $sql .= " AND room_type = '$room_type_safe'";
}


// Maximum price filter
if ($max_price != "") {
    $max_price_safe = $conn->real_escape_string($max_price);

    $sql .= " AND price <= '$max_price_safe'";
}


$sql .= " ORDER BY id DESC";

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

            <a href="user-dashboard.php"
               class="btn btn-outline-primary me-2">
                Dashboard
            </a>

            <a href="logout.php"
               class="btn btn-outline-danger">
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
            Search and filter available rooms on RoomConnect.
        </p>

    </div>

</section>


<!-- Search and Filter -->
<section class="container mb-5">

    <div class="card shadow-sm p-4">

        <form method="GET">

            <div class="row g-3 align-items-end">


                <!-- Location -->
                <div class="col-md-4">

                    <label class="form-label fw-semibold">
                        Location
                    </label>

                    <input type="text"
                           name="location"
                           class="form-control"
                           placeholder="e.g. Butwal"
                           value="<?php echo htmlspecialchars($location); ?>">

                </div>


                <!-- Room Type -->
                <div class="col-md-3">

                    <label class="form-label fw-semibold">
                        Room Type
                    </label>

                    <select name="room_type"
                            class="form-select">

                        <option value="">
                            All Types
                        </option>

                        <option value="Single Room"
                            <?php if ($room_type == "Single Room") echo "selected"; ?>>
                            Single Room
                        </option>

                        <option value="Shared Room"
                            <?php if ($room_type == "Shared Room") echo "selected"; ?>>
                            Shared Room
                        </option>

                        <option value="Flat"
                            <?php if ($room_type == "Flat") echo "selected"; ?>>
                            Flat
                        </option>

                    </select>

                </div>


                <!-- Maximum Price -->
                <div class="col-md-3">

                    <label class="form-label fw-semibold">
                        Maximum Rent
                    </label>

                    <input type="number"
                           name="max_price"
                           class="form-control"
                           placeholder="e.g. 10000"
                           min="0"
                           value="<?php echo htmlspecialchars($max_price); ?>">

                </div>


                <!-- Search Button -->
                <div class="col-md-2">

                    <button type="submit"
                            class="btn btn-primary w-100">

                        🔍 Search

                    </button>

                </div>

            </div>

        </form>


        <!-- Clear Filters -->

        <?php if ($location != "" || $room_type != "" || $max_price != ""): ?>

            <div class="mt-3">

                <a href="rooms.php"
                   class="btn btn-sm btn-outline-secondary">

                    Clear Filters

                </a>

            </div>

        <?php endif; ?>

    </div>

</section>


<!-- Rooms -->
<section class="container pb-5">

    <div class="row g-4">

        <?php if ($result->num_rows > 0): ?>

            <?php while ($room = $result->fetch_assoc()): ?>

                <div class="col-md-6 col-lg-4">

                    <div class="card shadow-sm h-100">

                        <!-- Room Image -->
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

                    No rooms found matching your search.

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