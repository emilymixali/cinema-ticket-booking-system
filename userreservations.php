<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

try {
    
    $userDb = new PDO('mysql:host=localhost;dbname=user_db', 'root', '');
    $userDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $userDb->prepare("SELECT UserID FROM users WHERE Username = :Username");
    $stmt->bindParam(':Username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
       
        $reservationsDb = new PDO('mysql:host=localhost;dbname=reservations_db', 'root', '');
        $reservationsDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $reservationsDb->prepare("SELECT * FROM reservation WHERE UserID = :UserID");
        $stmt->bindParam(':UserID', $user['UserID']);
        $stmt->execute();

        $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $reservations = [];
        echo 'No user found for the provided username.';
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    die();
}
if ($user) {
   
    $reservationsDb = new PDO('mysql:host=localhost;dbname=reservations_db', 'root', '');
    $reservationsDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $reservationsDb->prepare("SELECT * FROM reservation WHERE UserID = :UserID");
    $stmt->bindParam(':UserID', $user['UserID']);
    $stmt->execute();

    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Now connect to the movies_db
    $moviesDb = new PDO('mysql:host=localhost;dbname=movies_db', 'root', '');
    $moviesDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch the movie title for each reservation
    foreach ($reservations as $key => $reservation) {
        $stmt = $moviesDb->prepare("SELECT Title FROM movies WHERE MovieID = :MovieID");
        $stmt->bindParam(':MovieID', $reservation['MovieID']);
        $stmt->execute();
        $movie = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($movie) {
            $reservations[$key]['Title'] = $movie['Title']; 
        } else {
            $reservations[$key]['Title'] = 'Unknown Title'; 
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Reservations</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleuserreservations.css">
</head>
<body>
    <header>
        <h1>My Reservations</h1>
    </header>
    
    <nav>
    
    <a href="index.php" class="btn btn-custom">Movies</a>
    <a href="userreservations.php"  class="btn btn-custom">My Reservations</a>
    <a href="logout.php" class="btn btn-custom">Logout</a>
    <a href="change_password.php" class="btn btn-custom">Change Password</a>
</nav>

<main>
    <h2>Your Reservations</h2>

    <?php
    if (count($reservations) > 0) {
        foreach ($reservations as $reservation) {
            echo '<div class="card">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">Movie: ' . htmlspecialchars($reservation['Title']) . '</h5>';
            echo '<p class="card-text">Show Time: ' . htmlspecialchars($reservation['ShowTime']) . '</p>';
            echo '<p class="card-text">Number of Tickets: ' . htmlspecialchars($reservation['Tickets']) . '</p>';
            echo '<p class="card-text">Status: ' . htmlspecialchars($reservation['Situation']) . '</p>';

            if ($reservation['Situation'] === "Cancelled") {
                echo '<p class="text-danger">Unfortunately, your reservation had to be cancelled due to insufficient ticket availability. If you need assistance, please contact us by phone. Thank you and sorry for the inconvenience.</p>';
            } elseif ($reservation['Situation'] === "Verified") {
                echo '<p class="text-success">Your reservation has been verified. Your tickets are: ';
                for ($i = 0; $i < $reservation['Tickets']; $i++) {
                    echo '<span class="badge badge-secondary">#' . rand(1000, 9999) . '</span> ';
                }
                echo '</p>';
            }
            echo '</div>';
            echo '</div><br>';
        }
    } else {
        echo '<p>You have not made any reservations yet.</p>';
    }
    ?>
</main>


    <footer>
        
    </footer>
</body>
</html>
