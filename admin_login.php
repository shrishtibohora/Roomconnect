<?php
session_start();

$conn = new mysqli("localhost", "root", "", "roomconnect");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // Strong password validation
    if (strlen($password) < 8) {

        $error = "Password must be at least 8 characters.";

    } elseif (!preg_match("/[A-Z]/", $password)) {

        $error = "Password must contain at least one uppercase letter.";

    } elseif (!preg_match("/[a-z]/", $password)) {

        $error = "Password must contain at least one lowercase letter.";

    } elseif (!preg_match("/[0-9]/", $password)) {

        $error = "Password must contain at least one number.";

    } elseif (!preg_match("/[\W_]/", $password)) {

        $error = "Password must contain at least one special character.";

    } else {

        $sql = "SELECT * FROM admins WHERE email = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows == 1) {

            $admin = $result->fetch_assoc();

            // Existing plain-text password checking
            if ($password == $admin["password"]) {

                $_SESSION["admin_id"] = $admin["id"];
                $_SESSION["admin_name"] = $admin["name"];

                header("Location: admin_dashboard.php");
                exit();

            } else {

                $error = "Incorrect email or password.";

            }

        } else {

            $error = "Incorrect email or password.";

        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Admin Login - RoomConnect</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-box {
            background: white;
            width: 350px;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 8px 0 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }

    </style>

</head>

<body>

<div class="login-box">

    <h2>Admin Login</h2>

    <?php if ($error != ""): ?>

        <div class="error">
            <?php echo htmlspecialchars($error); ?>
        </div>

    <?php endif; ?>

    <form method="POST">

        <label>Email</label>

        <input
            type="email"
            name="email"
            placeholder="Enter admin email"
            required
        >

        <label>Password</label>

        <input
            type="password"
            name="password"
            placeholder="Enter strong password"
            required
        >

        <button type="submit">
            Login
        </button>

    </form>

</div>

</body>

</html>