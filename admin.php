<?php

session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Employee') {
    header('Location: login.php');
    exit;
}

$db = new PDO('mysql:host=localhost;dbname=movies_db', 'root', '');
$reservationsDb = new PDO('mysql:host=localhost;dbname=reservations_db', 'root', '');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['formType']) && $_POST['formType'] == 'updateMovieTime') {
        if (isset($_POST['movieID']) && isset($_POST['showTime'])) {
            $movieID = $_POST['movieID'];
            $showTime = $_POST['showTime'];

            $updateSql = "UPDATE movies SET ShowTime = :showTime WHERE MovieID = :movieID";
            $stmt = $db->prepare($updateSql);
            $stmt->bindParam(':showTime', $showTime);
            $stmt->bindParam(':movieID', $movieID);

            if ($stmt->execute()) {
                echo "Update completed successfully!";
            } else {
                echo "Update error: " . $stmt->errorInfo()[2];
            }
        }
    }

    if (isset($_POST['formType']) && $_POST['formType'] == 'updateReservation') {
        if (isset($_POST['reservationID']) && isset($_POST['situation'])) {
            $reservationID = $_POST['reservationID'];
            $situation = $_POST['situation'];

            $updateSql = "UPDATE reservation SET Situation = :situation WHERE ReservationID = :reservationID";
            $stmt = $reservationsDb->prepare($updateSql);
            $stmt->bindParam(':situation', $situation);
            $stmt->bindParam(':reservationID', $reservationID);

            if ($stmt->execute()) {
                echo "Reservation status updated successfully!";
            } else {
                echo "Update error: " . $stmt->errorInfo()[2];
            }
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['formType']) && $_POST['formType'] == 'addMovie') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $duration = $_POST['duration'];
    $coverPhoto = $_POST['coverPhoto'];
    $director = $_POST['director'];
    $actor1 = $_POST['actor1'];
    $actor2 = $_POST['actor2'];
    $releaseYear = $_POST['releaseYear'];
    $genre = $_POST['genre'];

   
    $insertSql = "INSERT INTO movies (Title, Description, Duration, CoverPhoto, Director, Actor1, Actor2, ReleaseYear, Genre) VALUES (:title, :description, :duration, :coverPhoto, :director, :actor1, :actor2, :releaseYear, :genre)";
    $stmt = $db->prepare($insertSql);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':duration', $duration);
    $stmt->bindParam(':coverPhoto', $coverPhoto);
    $stmt->bindParam(':director', $director);
    $stmt->bindParam(':actor1', $actor1);
    $stmt->bindParam(':actor2', $actor2);
    $stmt->bindParam(':releaseYear', $releaseYear);
    $stmt->bindParam(':genre', $genre);

    
    if ($stmt->execute()) {
        echo "The movie was added successfully!";
    } else {
        echo "Movie insert error: " . $stmt->errorInfo()[2];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleadmin.css">
    <title>Admin Dashboard</title>
</head>
<body>
<header class="bg-dark text-white text-center py-4">
<div class="container mt-5">
            <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
        </div>
    </header>
    <div class="card card-body bg-light mb-3">
    
    <form action="admin.php" method="post" class="form-group">
                <input type="hidden" name="formType" value="updateMovieTime">
                <label for="movieID">Select movie (MovieID):</label>
                <select name="movieID" id="movieID" class="form-control mb-3">
                
                <?php
                $sql = "SELECT MovieID, Title FROM movies";
                $stmt = $db->query($sql);
                while ($row = $stmt->fetch()) {
                    echo "<option value='{$row['MovieID']}'>{$row['MovieID']} - {$row['Title']}</option>";
                }
                ?>
            </select>
            <label for="showTime">New show time:</label>
                <input type="time" name="showTime" id="showTime" class="form-control mb-3" required>
                <button type="submit" class="btn btn-success">Update Show Time</button>
            </form>
    </div>

    <div class="card card-body bg-light">
            <form action="admin.php" method="post" class="form-group">
                <input type="hidden" name="formType" value="updateReservation">
                <label for="reservationID">Select Reservation (ReservationID):</label>
                <select name="reservationID" id="reservationID" class="form-control mb-3">
            <?php
$sql = "SELECT ReservationID 
        FROM reservation 
        WHERE Situation IS NULL OR Situation = ''";

$stmt = $reservationsDb->query($sql);
while ($row = $stmt->fetch()) {
    echo "<option value='{$row['ReservationID']}'>Reservation {$row['ReservationID']}</option>";
}
?>

                
            </select>
            <label for="situation">Reservation Status:</label>
                <select name="situation" id="situation" class="form-control mb-3">
                    <option value="Verified">Verified</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
                <button type="submit" class="btn btn-primary">Update Status</button>
            </form>
        </div>

        
<div class="card card-body bg-light mt-5">
    <h2>Add New Movie</h2>
    <form action="admin.php" method="post">
        <input type="hidden" name="formType" value="addMovie">

        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea name="description" id="description" class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <label for="duration">Duration (minutes):</label>
            <input type="number" name="duration" id="duration" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="coverPhoto">Cover Photo (URL):</label>
            <input type="text" name="coverPhoto" id="coverPhoto" class="form-control">
        </div>

        <div class="form-group">
            <label for="director">Director:</label>
            <input type="text" name="director" id="director" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="actor1">Actor 1:</label>
            <input type="text" name="actor1" id="actor1" class="form-control">
        </div>

        <div class="form-group">
            <label for="actor2">Actor 2:</label>
            <input type="text" name="actor2" id="actor2" class="form-control">
        </div>

        <div class="form-group">
            <label for="releaseYear">Release Year:</label>
            <input type="number" name="releaseYear" id="releaseYear" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="genre">Genre:</label>
            <input type="text" name="genre" id="genre" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Add Movie</button>
    </form>
</div>

    
        <a href="logout.php" class="btn btn-warning mt-3">Logout</a>
</body>
</html>
