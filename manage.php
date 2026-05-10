<?php
function manageReservations($db) {
    try {
        $stmt = $db->query("SELECT * FROM reservations JOIN users ON reservations.userID = users.UserID JOIN movies ON reservations.movieID = movies.MovieID");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        return "Reservation management error: " . $e->getMessage();
    }
}

?>