<?php
function showMovies($db) {
    try {
        $stmt = $db->query("SELECT * FROM movies");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        return "Movie retrieval error: " . $e->getMessage();
    }
}

?>