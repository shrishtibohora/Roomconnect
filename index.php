<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>RoomConnect - Find Your Perfect Room</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<!-- Navbar -->
<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-white shadow-sm">
    <div class="container">

        <a class="navbar-brand fw-bold" href="index.php">
            🏠 RoomConnect
        </a>

        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarMenu">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="navbarMenu">

            <ul class="navbar-nav ms-auto align-items-lg-center">

                <li class="nav-item">
                    <a class="nav-link active" href="index.php">
                        Home
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="rooms.php">
                        Rooms
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="about.php">
                        About
                    </a>
                </li>


                <!-- Login Dropdown -->
                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle"
                       href="#"
                       role="button"
                       data-bs-toggle="dropdown">

                        Login

                    </a>

                    <ul class="dropdown-menu">

                        <li>
                            <a class="dropdown-item" href="login.php">
                                User Login
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="owner-login.php">
                                Owner Login
                            </a>
                        </li>

                    </ul>

                </li>


                <!-- Register Dropdown -->
                <li class="nav-item dropdown ms-lg-2">

                    <a class="btn btn-primary dropdown-toggle"
                       href="#"
                       role="button"
                       data-bs-toggle="dropdown">

                        Register

                    </a>

                    <ul class="dropdown-menu">

                        <li>
                            <a class="dropdown-item" href="register.php">
                                Register as User
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="owner-register.php">
                                Register as Owner
                            </a>
                        </li>

                    </ul>

                </li>

            </ul>

        </div>

    </div>
</nav>


<!-- Hero Section -->
<section class="hero-section">
    <div class="container">

        <div class="row align-items-center">

            <div class="col-lg-6">

                <h1 class="display-4 fw-bold">
                    Find a Room You'll Love
                </h1>

                <p class="lead mt-3">
                    Discover affordable and comfortable rooms
                    and connect with trusted room owners.
                </p>

                <a href="rooms.php" class="btn btn-primary btn-lg mt-3">
                    Find Rooms
                </a>

            </div>

            <div class="col-lg-6 text-center">

                <div class="hero-placeholder">
                    🏠
                </div>

            </div>

        </div>

    </div>
</section>


<!-- Search Section -->
<section class="search-section">

    <div class="container">

        <div class="search-box shadow">

            <h3 class="text-center mb-4">
                Find Your Perfect Room
            </h3>

            <form>

                <div class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label">Location</label>
                        <input type="text"
                               class="form-control"
                               placeholder="e.g. Butwal">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Room Type</label>

                        <select class="form-select">
                            <option>Any Type</option>
                            <option>Single Room</option>
                            <option>Shared Room</option>
                            <option>Flat</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Maximum Price</label>

                        <input type="number"
                               class="form-control"
                               placeholder="Rs.">
                    </div>

                    <div class="col-md-2 d-flex align-items-end">

                        <button type="submit"
                                class="btn btn-primary w-100">
                            Search
                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

</section>


<!-- Featured Rooms -->
<section class="py-5">

    <div class="container">

        <div class="text-center mb-5">

            <h2 class="fw-bold">
                Featured Rooms
            </h2>

            <p class="text-muted">
                Explore some of the available rooms
            </p>

        </div>


        <div class="row g-4">

            <!-- Room 1 -->
            <div class="col-md-4">

                <div class="card room-card shadow-sm">

                    <div class="room-image">
                        🏠
                    </div>

                    <div class="card-body">

                        <h5 class="card-title">
                            Comfortable Single Room
                        </h5>

                        <p class="text-muted mb-2">
                            📍 Butwal
                        </p>

                        <h5 class="text-primary">
                            Rs. 8,000/month
                        </h5>

                        <a href="room-details.php"
                           class="btn btn-outline-primary mt-2">
                            View Details
                        </a>

                    </div>

                </div>

            </div>


            <!-- Room 2 -->
            <div class="col-md-4">

                <div class="card room-card shadow-sm">

                    <div class="room-image">
                        🏡
                    </div>

                    <div class="card-body">

                        <h5 class="card-title">
                            Spacious Shared Room
                        </h5>

                        <p class="text-muted mb-2">
                            📍 Tilottama
                        </p>

                        <h5 class="text-primary">
                            Rs. 6,500/month
                        </h5>

                        <a href="room-details.php"
                           class="btn btn-outline-primary mt-2">
                            View Details
                        </a>

                    </div>

                </div>

            </div>


            <!-- Room 3 -->
            <div class="col-md-4">

                <div class="card room-card shadow-sm">

                    <div class="room-image">
                        🏢
                    </div>

                    <div class="card-body">

                        <h5 class="card-title">
                            Modern Room Near College
                        </h5>

                        <p class="text-muted mb-2">
                            📍 Butwal
                        </p>

                        <h5 class="text-primary">
                            Rs. 9,000/month
                        </h5>

                        <a href="room-details.php"
                           class="btn btn-outline-primary mt-2">
                            View Details
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- How It Works -->
<section class="how-section py-5">

    <div class="container">

        <div class="text-center mb-5">

            <h2 class="fw-bold">
                How RoomConnect Works
            </h2>

        </div>

        <div class="row text-center">

            <div class="col-md-4">
                <h3>🔍</h3>
                <h5>Search</h5>
                <p>Search for rooms based on your requirements.</p>
            </div>

            <div class="col-md-4">
                <h3>🏠</h3>
                <h5>Choose</h5>
                <p>View room details and choose a suitable room.</p>
            </div>

            <div class="col-md-4">
                <h3>📩</h3>
                <h5>Connect</h5>
                <p>Send a booking request to the room owner.</p>
            </div>

        </div>

    </div>

</section>


<!-- Footer -->
<footer class="bg-dark text-white text-center py-4">

    <p class="mb-0">
        © 2026 RoomConnect. All Rights Reserved.
    </p>

</footer>


<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>