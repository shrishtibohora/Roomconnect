```php
<?php
session_start();

$message = "";
$message_type = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = strtolower(trim($_POST["email"] ?? ""));
    $password = $_POST["password"] ?? "";

    $errors = [];

    // Email validation
    if ($email === "") {

        $errors[] = "Email is required.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $errors[] = "Please enter a valid email address.";
    }

    // Password validation
    if ($password === "") {

        $errors[] = "Password is required.";
    }


    if (empty($errors)) {

        $conn = new mysqli(
            "localhost",
            "root",
            "",
            "roomconnect"
        );

        if ($conn->connect_error) {
            die("Database connection failed: " . $conn->connect_error);
        }

        // Prepared statement
        $stmt = $conn->prepare(
            "SELECT id, name, email, password
             FROM owners
             WHERE email = ?"
        );

        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 1) {

            $owner = $result->fetch_assoc();

            // Check password
            if (password_verify($password, $owner["password"])) {

                session_regenerate_id(true);

                $_SESSION["owner_id"] = $owner["id"];
                $_SESSION["owner_name"] = $owner["name"];
                $_SESSION["owner_email"] = $owner["email"];

                header("Location: owner/dashboard.php");
                exit();

            } else {

                $message = "Incorrect email or password.";
                $message_type = "danger";
            }

        } else {

            $message = "Incorrect email or password.";
            $message_type = "danger";
        }

        $stmt->close();
        $conn->close();

    } else {

        $message = implode("<br>", $errors);
        $message_type = "danger";
    }
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

                    <div class="alert alert-<?php echo $message_type; ?>">
                        <?php echo $message; ?>
                    </div>

                <?php endif; ?>


                <form method="POST">

                    <!-- EMAIL -->

                    <div class="mb-3">

                        <label class="form-label">
                            Email
                        </label>

                        <input type="email"
                               name="email"
                               class="form-control"
                               placeholder="Enter your email"
                               value="<?php echo htmlspecialchars($email ?? ''); ?>"
                               required>

                    </div>


                    <!-- PASSWORD -->

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
```
