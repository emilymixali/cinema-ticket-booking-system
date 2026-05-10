<?php
$dbUser = new PDO('mysql:host=localhost; dbname=user_db', 'root', '');

function getUserID($db, $username) {
    try {
        $stmt = $db->prepare("SELECT UserID FROM users WHERE Username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($row) ? $row['UserID'] : null;
    } catch(PDOException $e) {
        return "Error while fetching user: " . $e->getMessage();
    }
}

$dbReservations = new PDO('mysql:host=localhost; dbname=reservations_db', 'root', '');

function makeReservation($db, $userID, $movieID, $date, $showTime, $ticketCount) {
    try {
        $stmt = $db->prepare("INSERT INTO reservation (UserID, MovieID, ReservationDate, ShowTime, Tickets) VALUES (:userID, :movieID, :date, :showTime, :tickets)");
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':movieID', $movieID);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':showTime', $showTime);
        $stmt->bindParam(':tickets', $ticketCount, PDO::PARAM_INT);
        $stmt->execute();
        return "Successful reservation";
    } catch(PDOException $e) {
        return "Reservation error: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="stylereservations.css">
<title>Book Tickets</title>
</head>
<body>

<?php
if (isset($_GET['movieID']) && isset($_GET['Title']) && isset($_GET['ShowTime'])) {
?>
<div class="reservation-form">
    <h2>Book Tickets</h2>
    <form action="reservations.php" method="post">
    <input type="hidden" name="movieID" value="<?php echo htmlspecialchars($_GET['movieID']); ?>">
    <input type="hidden" name="Title" value="<?php echo htmlspecialchars($_GET['Title']); ?>">
    <input type="hidden" name="ShowTime" value="<?php echo htmlspecialchars($_GET['ShowTime']); ?>">

        <input type="text" name="username" placeholder="Username" required>
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="tel" name="phone" placeholder="Mobile Phone" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="number" name="ticketCount" placeholder="Number of Tickets" required>
        <button type="submit">Reservation</button>
    </form>
</div>
<?php
} 
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username']; 
    $movieID = $_POST['movieID'];
    $showTime = $_POST['ShowTime'];
    $title = $_POST['Title'];

    $name = $_POST['name'];
    $ticketCount = $_POST['ticketCount'];
    $date = date('Y-m-d'); 

    $userID = getUserID($dbUser, $username);
    
    if ($userID) {
        $result = makeReservation($dbReservations, $userID, $movieID, $date, $showTime, $ticketCount);
        if ($result == "Successful reservation") {
            echo "<div class='thank-you-message'>";
            echo "<p>Thank you $name for choosing us.</p>";
            echo "<p>We would like to inform you that we have received your request for $ticketCount tickets for the movie $title at $showTime. You will be updated about the approval through Profile -> Reservations.</p>";
            echo "<p>Have a great day!</p>";
            echo "<a href='index.php' class='return-button'>Return to Home</a>";
            echo "</div>";
        } else {
            echo "<p>Reservation error: $result</p>";
        }
    } else {
        echo "<p>The username you entered was not found. Please check the username and try again.</p>";
    }
}

?>
</body>
</html>
