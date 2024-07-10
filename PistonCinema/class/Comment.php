<?php
// Comment.php
class Comment {
    public static function getCommentsByFilmId($pdo, $filmId) {
        $stmt = $pdo->prepare('SELECT * FROM comment WHERE film_id = :film_id');
        $stmt->execute(['film_id' => $filmId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAllCmt($pdo)
        {
            $sql = "SELECT * FROM comment";
            $stmt = $pdo->prepare($sql);

            if ($stmt->execute()) {
                $cmt = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $cmt;
            }
            return null;
        }

        public static function addComment($pdo, $filmId, $author, $content) {
            $sql = "INSERT INTO comment (film_id, author, content, time) VALUES (:film_id, :author, :content, NOW())";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute(['film_id' => $filmId, 'author' => $author, 'content' => $content]);
        }
}
?>
