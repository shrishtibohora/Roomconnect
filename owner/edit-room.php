<?php
session_start();

if (!isset($_SESSION["owner_id"])) {
    header("Location: ../owner-login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "roomconnect");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$owner_id = $_SESSION["owner_id"];

if (!isset($_GET["id"])) {
    header("Location: my-rooms.php");
    exit();
}

$room_id = $_GET["id"];

$sql = "SELECT * FROM rooms
        WHERE id = '$room_id' AND owner_id = '$owner_id'";

$result = $conn->query($sql);

if ($result->num_rows != 1) {
    header("Location: my-rooms.php");
    exit();
}

$room = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST["title"];
    $location = $_POST["location"];
    $room_type = $_POST["room_type"];
    $price = $_POST["price"];
    $description = $_POST["description"];
    $status = $_POST["status"];

    $update = "UPDATE rooms SET
               title = '$title',
               location = '$location',
               room_type = '$room_type',
               price = '$price',
               description = '$description',
               status = '$status'
               WHERE id = '$room_id'
               AND owner_id = '$owner_id'";

    if ($conn->query($update) === TRUE) {
        header("Location: my-rooms.php");
        exit();
    } else {
        echo "Error updating room: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Room - RoomConnect</title>

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

        <a href="my-rooms.php" class="btn btn-outline-primary">
            My Rooms
        </a>

    </div>

</nav>


<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-7">

            <div class="card shadow-sm p-4">

                <h2 class="fw-bold mb-4">
                    Edit Room
                </h2>

                <form method="POST">

                    <div class="mb-3">

                        <label class="form-label">
                            Room Title
                        </label>

                        <input type="text"
                               name="title"
                               class="form-control"
                               value="<?php echo htmlspecialchars($room["title"]); ?>"
                               required>

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Location
                        </label>

                        <input type="text"
                               name="location"
                               class="form-control"
                               value="<?php echo htmlspecialchars($room["location"]); ?>"
                               required>

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Room Type
                        </label>

                        <select name="room_type"
                                class="form-select"
                                required>

                            <option value="Single Room"
                                <?php if ($room["room_type"] == "Single Room") echo "selected"; ?>>
                                Single Room
                            </option>

                            <option value="Shared Room"
                                <?php if ($room["room_type"] == "Shared Room") echo "selected"; ?>>
                                Shared Room
                            </option>

                            <option value="Flat"
                                <?php if ($room["room_type"] == "Flat") echo "selected"; ?>>
                                Flat
                            </option>

                        </select>

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Monthly Rent
                        </label>

                        <input type="number"
                               name="price"
                               class="form-control"
                               value="<?php echo htmlspecialchars($room["price"]); ?>"
                               required>

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Description
                        </label>

                        <textarea name="description"
                                  class="form-control"
                                  rows="5"
                                  required><?php echo htmlspecialchars($room["description"]); ?></textarea>

                    </div>


                    <div class="mb-4">

                        <label class="form-label">
                            Status
                        </label>

                        <select name="status"
                                class="form-select">

                            <option value="Available"
                                <?php if ($room["status"] == "Available") echo "selected"; ?>>
                                Available
                            </option>

                            <option value="Booked"
                                <?php if ($room["status"] == "Booked") echo "selected"; ?>>
                                Booked
                            </option>

                        </select>

                    </div>


                    <button type="submit"
                            class="btn btn-primary w-100">

                        Update Room

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

</body>
</html>

<?php
$conn->close();
?>