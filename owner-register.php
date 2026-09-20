<?php
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $password = $_POST["password"];

    $conn = new mysqli("localhost", "root", "", "roomconnect");

    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO owners (name, email, password, phone)
            VALUES ('$name', '$email', '$hashed_password', '$phone')";

    if ($conn->query($sql) === TRUE) {
        $message = "Owner registration successful!";
    } else {
        $message = "Error: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Owner Registration - RoomConnect</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="container">

    <div class="row justify-content-center mt-5">

        <div class="col-md-6">

            <div class="card shadow p-4">

                <h2 class="text-center mb-4">
                    Register as Room Owner
                </h2>

                <?php if ($message != ""): ?>

                    <div class="alert alert-info">
                        <?php echo $message; ?>
                    </div>

                <?php endif; ?>

                <form method="POST">

                    <div class="mb-3">
                        <label class="form-label">Full Name</label>

                        <input type="text"
                               name="name"
                               class="form-control"
                               placeholder="Enter your name"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>

                        <input type="email"
                               name="email"
                               class="form-control"
                               placeholder="Enter your email"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone</label>

                        <input type="tel"
                               name="phone"
                               class="form-control"
                               placeholder="Enter your phone number"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>

                        <input type="password"
                               name="password"
                               class="form-control"
                               placeholder="Create a password"
                               required>
                    </div>

                    <button type="submit"
                            class="btn btn-primary w-100">
                        Register as Owner
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

</body>
</html>