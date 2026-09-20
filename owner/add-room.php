<?php
session_start();

if (!isset($_SESSION["owner_id"])) {
    header("Location: ../owner-login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST["title"];
    $location = $_POST["location"];
    $room_type = $_POST["room_type"];
    $price = $_POST["price"];
    $description = $_POST["description"];

    // Image upload
    $image = $_FILES["image"]["name"];
    $tmp_name = $_FILES["image"]["tmp_name"];

    $image_name = time() . "_" . basename($image);
    $upload_path = "../uploads/" . $image_name;

    if (move_uploaded_file($tmp_name, $upload_path)) {

        $conn = new mysqli("localhost", "root", "", "roomconnect");

        if ($conn->connect_error) {
            die("Database connection failed: " . $conn->connect_error);
        }

        $owner_id = $_SESSION["owner_id"];

        $sql = "INSERT INTO rooms
                (owner_id, title, location, room_type, price, description, image)
                VALUES
                ('$owner_id', '$title', '$location', '$room_type',
                 '$price', '$description', '$image_name')";

        if ($conn->query($sql) === TRUE) {
            $message = "Room added successfully!";
        } else {
            $message = "Error: " . $conn->error;
        }

        $conn->close();

    } else {
        $message = "Image upload failed.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Room - RoomConnect</title>

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

        <a href="dashboard.php" class="btn btn-outline-primary">
            Dashboard
        </a>

    </div>

</nav>


<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-7">

            <div class="card shadow-sm p-4">

                <h2 class="fw-bold mb-4">
                    Add New Room
                </h2>

                <?php if ($message != ""): ?>

                    <div class="alert alert-info">
                        <?php echo $message; ?>
                    </div>

                <?php endif; ?>


                <form method="POST" enctype="multipart/form-data">

                    <div class="mb-3">

                        <label class="form-label">
                            Room Title
                        </label>

                        <input type="text"
                               name="title"
                               class="form-control"
                               placeholder="e.g. Comfortable Single Room"
                               required>

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Location
                        </label>

                        <input type="text"
                               name="location"
                               class="form-control"
                               placeholder="e.g. Butwal"
                               required>

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Room Type
                        </label>

                        <select name="room_type"
                                class="form-select"
                                required>

                            <option value="">
                                Select Room Type
                            </option>

                            <option value="Single Room">
                                Single Room
                            </option>

                            <option value="Shared Room">
                                Shared Room
                            </option>

                            <option value="Flat">
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
                               placeholder="e.g. 8000"
                               min="0"
                               required>

                    </div>


                    <!-- Room Image -->
                    <div class="mb-3">

                        <label class="form-label">
                            Room Image
                        </label>

                        <input type="file"
                               name="image"
                               class="form-control"
                               accept="image/*"
                               required>

                    </div>


                    <div class="mb-4">

                        <label class="form-label">
                            Room Description
                        </label>

                        <textarea name="description"
                                  class="form-control"
                                  rows="5"
                                  placeholder="Describe the room, facilities, nearby places, etc."
                                  required></textarea>

                    </div>


                    <button type="submit"
                            class="btn btn-primary w-100">

                        Add Room

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

</body>
</html>