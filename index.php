<?php

session_start();


if (isset($_SESSION['username'])) {
   
} else {
    
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cinema</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <?php if (isset($_SESSION['username'])): ?>
        <header>
    <h1>Welcome to our Cinema!</h1>
    <nav>
        <a href="logout.php" class="btn btn-secondary">Logout</a> |
        <a href="profile.php" class="btn btn-secondary">Profile</a>
    </nav>
</header>



<body>
    
    <main>
    <h2 >Available Movies</h2>

    <div class="movies-container">

    <?php
    try {
        $db_movies = new PDO('mysql:host=localhost;dbname=movies_db', 'root', '');
        $db_movies->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Database connection error with database 'movies_db': " . $e->getMessage();
    }

    if (isset($_SESSION['username'])) {
       
        $stmt = $db_movies->query("SELECT * FROM movies");
        $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (is_array($movies) && count($movies) > 0) {
            foreach ($movies as $movie) {
                echo "<div class='movie'>";
                echo "<h3>" . $movie['Title'] . "</h3>";
                echo "<img src='data:image/jpeg;base64," . base64_encode($movie['CoverPhoto']) . "' alt='Cover Photo'>";
                echo "<p><strong>Description:</strong> " . $movie['Description'] . "</p>";
                echo "<p><strong>Duration:</strong> " . $movie['Duration'] . " minutes</p>";
                echo "<p><strong>Director:</strong> " . $movie['Director'] . "</p>";
                echo "<p><strong>Actors:</strong> " . $movie['Actor1'] . ", " . $movie['Actor2'] . "</p>";
                echo "<p><strong>Release Year:</strong> " . $movie['ReleaseYear'] . "</p>";
                echo "<p><strong>Genre:</strong> " . $movie['Genre'] . "</p>";
                echo "<a href='reservations.php?movieID=" . urlencode($movie['MovieID']) . "&Title=" . urlencode($movie['Title']) . "&ShowTime=" . urlencode($movie['ShowTime']) . "' class='btn btn-danger reserve-button''>Book Tickets</a>";



                echo "</div>";
            }
        } else {
            echo "There are no available movies.";
        }
    } else {
        
        header("Location: login.php");
        exit;
    }
    ?>
</div>


    <?php endif; ?>
</body>
</html>
