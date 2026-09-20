
<?php
session_start();

$message = "";
$message_type = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Get and clean input
    $name = trim($_POST["name"] ?? "");
    $email = strtolower(trim($_POST["email"] ?? ""));
    $password = $_POST["password"] ?? "";
    $confirm_password = $_POST["confirm_password"] ?? "";

    $errors = [];

    // -------------------------
    // NAME VALIDATION
    // -------------------------
    if ($name === "") {
        $errors[] = "Full name is required.";
    } elseif (!preg_match("/^[a-zA-Z ]+$/", $name)) {
        $errors[] = "Name must contain letters and spaces only.";
    } elseif (strlen($name) < 2) {
        $errors[] = "Name must be at least 2 characters long.";
    }

    // -------------------------
    // EMAIL VALIDATION
    // -------------------------
    if ($email === "") {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }

    // -------------------------
    // PASSWORD VALIDATION
    // -------------------------
    if ($password === "") {
        $errors[] = "Password is required.";
    } elseif (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    } elseif (!preg_match("/[A-Z]/", $password)) {
        $errors[] = "Password must contain at least one uppercase letter.";
    } elseif (!preg_match("/[a-z]/", $password)) {
        $errors[] = "Password must contain at least one lowercase letter.";
    } elseif (!preg_match("/[0-9]/", $password)) {
        $errors[] = "Password must contain at least one number.";
    } elseif (!preg_match("/[\W_]/", $password)) {
        $errors[] = "Password must contain at least one special character.";
    }

    // -------------------------
    // CONFIRM PASSWORD
    // -------------------------
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    // -------------------------
    // DATABASE
    // -------------------------
    if (empty($errors)) {

        $conn = new mysqli("localhost", "root", "", "roomconnect");

        if ($conn->connect_error) {
            die("Database connection failed: " . $conn->connect_error);
        }

        // Check duplicate email
        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {

            $errors[] = "An account with this email already exists.";

        } else {

            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert user
            $stmt = $conn->prepare(
                "INSERT INTO users (name, email, password)
                 VALUES (?, ?, ?)"
            );

            $stmt->bind_param(
                "sss",
                $name,
                $email,
                $hashed_password
            );

            if ($stmt->execute()) {

                $message = "Registration successful! You can now login.";
                $message_type = "success";

                // Clear form values
                $name = "";
                $email = "";

            } else {

                $errors[] = "Registration failed. Please try again.";
            }

            $stmt->close();
        }

        $check->close();
        $conn->close();
    }

    // Display errors
    if (!empty($errors)) {
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

    <title>Register - RoomConnect</title>

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
                    Create Your Account
                </h2>

                <?php if ($message != ""): ?>

                    <div class="alert alert-<?php echo $message_type; ?>">
                        <?php echo $message; ?>
                    </div>

                <?php endif; ?>


                <form method="POST" novalidate>

                    <!-- NAME -->

                    <div class="mb-3">

                        <label class="form-label">
                            Full Name
                        </label>

                        <input type="text"
                               name="name"
                               class="form-control"
                               placeholder="Enter your full name"
                               value="<?php echo htmlspecialchars($name ?? ''); ?>"
                               pattern="[A-Za-z ]{2,}"
                               title="Name must contain letters and spaces only"
                               required>

                        <small class="text-muted">
                            Letters and spaces only.
                        </small>

                    </div>


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
                               placeholder="Create a password"
                               minlength="8"
                               required>

                        <small class="text-muted">
                            Minimum 8 characters, including uppercase,
                            lowercase, number and special character.
                        </small>

                    </div>


                    <!-- CONFIRM PASSWORD -->

                    <div class="mb-3">

                        <label class="form-label">
                            Confirm Password
                        </label>

                        <input type="password"
                               name="confirm_password"
                               class="form-control"
                               placeholder="Confirm your password"
                               minlength="8"
                               required>

                    </div>


                    <button type="submit"
                            class="btn btn-primary w-100">

                        Register

                    </button>

                </form>


                <p class="text-center mt-3 mb-0">

                    Already have an account?

                    <a href="login.php">
                        Login
                    </a>

                </p>

            </div>

        </div>

    </div>

</div>

</body>
</html>

