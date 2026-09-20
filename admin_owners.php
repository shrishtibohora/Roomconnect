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

$sql = "SELECT id, name, email, phone, created_at 
        FROM owners 
        ORDER BY id DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Owners - RoomConnect</title>

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
            <h2 class="fw-bold">Manage Owners</h2>

            <p class="text-muted">
                View all registered property owners.
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
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Registered Date</th>
                        </tr>

                    </thead>

                    <tbody>

                    <?php if ($result->num_rows > 0): ?>

                        <?php while ($owner = $result->fetch_assoc()): ?>

                            <tr>

                                <td>
                                    <?php echo $owner["id"]; ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($owner["name"]); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($owner["email"]); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($owner["phone"] ?? "N/A"); ?>
                                </td>

                                <td>
                                    <?php echo $owner["created_at"]; ?>
                                </td>

                            </tr>

                        <?php endwhile; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                No owners registered yet.
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