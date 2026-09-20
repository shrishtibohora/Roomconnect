<?php
session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $conn = new mysqli("localhost", "root", "", "roomconnect");

    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM owners WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {

        $owner = $result->fetch_assoc();

        if (password_verify($password, $owner["password"])) {

            $_SESSION["owner_id"] = $owner["id"];
            $_SESSION["owner_name"] = $owner["name"];
            $_SESSION["owner_email"] = $owner["email"];

            header("Location: owner/dashboard.php");
            exit();

        } else {
            $message = "Incorrect password.";
        }

    } else {
        $message = "No owner account found with this email.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Owner Login - RoomConnect</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<div class="container">

    <div class="row justify-content-center mt-5">

        <div class="col-md-5">

            <div class="card shadow p-4">

                <h2 class="text-center mb-4">
                    Owner Login
                </h2>

                <?php if ($message != ""): ?>

                    <div class="alert alert-danger">
                        <?php echo $message; ?>
                    </div>

                <?php endif; ?>

                <form method="POST">

                    <div class="mb-3">

                        <label class="form-label">
                            Email
                        </label>

                        <input type="email"
                               name="email"
                               class="form-control"
                               placeholder="Enter your email"
                               required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Password
                        </label>

                        <input type="password"
                               name="password"
                               class="form-control"
                               placeholder="Enter your password"
                               required>

                    </div>

                    <button type="submit"
                            class="btn btn-primary w-100">

                        Login

                    </button>

                </form>

                <p class="text-center mt-3">
                    Don't have an owner account?
                    <a href="owner-register.php">
                        Register
                    </a>
                </p>

            </div>

        </div>

    </div>

</div>

</body>
</html>