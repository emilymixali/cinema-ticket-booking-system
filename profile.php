<?php

session_start();


if (!isset($_SESSION['username'])) {
   
    header("Location: login.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        <h1>User Profile</h1>
    </header>
    
    <nav>
    <a href="index.php" class="btn btn-custom">Movies</a>
    <a href="userreservations.php" class="btn btn-custom">My Reservations</a>
    <a href="logout.php" class="btn btn-custom">Logout</a>
    <a href="change_password.php" class="btn btn-custom">Change Password</a>
</nav>



    <main>
    <h2 style="color: rgb(31, 31, 31);">Welcome, <?php echo $_SESSION['username']; ?>!</h2>

       
    </main>

    <footer>
        
    </footer>
</body>
</html>
