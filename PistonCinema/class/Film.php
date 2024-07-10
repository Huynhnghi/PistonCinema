<?php

class Film {
    public $CODE_FILM;
    public $NAME_FILM;
    public $DIRECTOR;
    public $ACTOR;
    public $CODE_TYPE;
    public $PREMIERE;
    public $TIME;
    public $CODE_LANGUAGE;
    public $RATED;
    public $IMAGES;
    public $DISCRIPTION;

    public static function searchFilmByKeyword($pdo, $keyword) {
        $sql = "SELECT * FROM film WHERE NAME_FILM LIKE :keyword OR DIRECTOR LIKE :keyword OR ACTOR LIKE :keyword";
        $stmt = $pdo->prepare($sql);
        $keyword = "%{$keyword}%";
        $stmt->bindParam(":keyword", $keyword, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $films = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $films;
        }
        return null;
    }

    public static function getAllFilms($pdo)
    {
        $sql = "SELECT * FROM film ";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute()) {
            $films = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $films;
        }
        return null;
    }

    public static function getCodeFilm($pdo)
        {
            $sql = "SELECT CODE_FILM FROM film ";
            $stmt = $pdo->prepare($sql);

            if ($stmt->execute()) {
                $cus = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $cus;
            }
            return null;
        }

    public static function DelFilm($pdo, $code)
    {
        $sql = "DELETE FROM film WHERE CODE_FILM = :code";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":code", $code, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false; 
        }
    }


    public static function getUpcomingFilm($pdo, $PREMIERE)
    {
        $sql = "SELECT * FROM film WHERE PREMIERE > :PREMIERE;";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":PREMIERE", $PREMIERE, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $films = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $films;
        }
        return null;
    }

    public static function getNowShowingFilms($pdo, $PREMIERE)
    {
        $sql = "SELECT * FROM film WHERE PREMIERE < :PREMIERE;";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":PREMIERE", $PREMIERE, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $films = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $films;
        }
        return null;
    }

    public static function getAddFilms($pdo, $codefilm)
    {
        $sql = "INSERT INTO film (CODE_FILM, NAME_FILM, DIRECTOR, ACTOR, CODE_TYPE, PREMIERE, TIME, CODE_LANGUAGE, RATED, IMAGES, DISCRIPTION) 
                VALUES (:CODE_FILM, :NAME_FILM, :DIRECTOR, :ACTOR, :CODE_TYPE, :PREMIERE, :TIME, :CODE_LANGUAGE, :RATED, :IMAGES, :DISCRIPTION)";
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':CODE_FILM', $codefilm['CODE_FILM']);
        $stmt->bindParam(':NAME_FILM', $codefilm['NAME_FILM']);
        $stmt->bindParam(':DIRECTOR', $codefilm['DIRECTOR']);
        $stmt->bindParam(':ACTOR', $codefilm['ACTOR']);
        $stmt->bindParam(':CODE_TYPE', $codefilm['CODE_TYPE']);
        $stmt->bindParam(':PREMIERE', $codefilm['PREMIERE']);
        $stmt->bindParam(':TIME', $codefilm['TIME']);
        $stmt->bindParam(':CODE_LANGUAGE', $codefilm['CODE_LANGUAGE']);
        $stmt->bindParam(':RATED', $codefilm['RATED']);
        $stmt->bindParam(':IMAGES', $codefilm['IMAGES']);
        $stmt->bindParam(':DISCRIPTION', $codefilm['DISCRIPTION'] );
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    

    public static function update($pdo, $filmData)
    {
        $sql = "UPDATE film SET 
            NAME_FILM = :NAME_FILM, 
            DIRECTOR = :DIRECTOR, 
            ACTOR = :ACTOR, 
            CODE_TYPE = :CODE_TYPE, 
            PREMIERE = :PREMIERE, 
            TIME = :TIME, 
            CODE_LANGUAGE = :CODE_LANGUAGE, 
            RATED = :RATED, 
            IMAGES = :IMAGES, 
            DISCRIPTION = :DISCRIPTION
        WHERE CODE_FILM = :CODE_FILM";


        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':CODE_FILM', $filmData['CODE_FILM'], PDO::PARAM_INT);
        $stmt->bindParam(':NAME_FILM', $filmData['NAME_FILM'], PDO::PARAM_STR);
        $stmt->bindParam(':DIRECTOR', $filmData['DIRECTOR'], PDO::PARAM_STR);
        $stmt->bindParam(':ACTOR', $filmData['ACTOR'], PDO::PARAM_STR);
        $stmt->bindParam(':CODE_TYPE', $filmData['CODE_TYPE'], PDO::PARAM_INT);
        $stmt->bindParam(':PREMIERE', $filmData['PREMIERE'], PDO::PARAM_STR);
        $stmt->bindParam(':TIME', $filmData['TIME'], PDO::PARAM_INT);
        $stmt->bindParam(':CODE_LANGUAGE', $filmData['CODE_LANGUAGE'], PDO::PARAM_INT);
        $stmt->bindParam(':RATED', $filmData['RATED'], PDO::PARAM_INT);
        $stmt->bindParam(':IMAGES', $filmData['IMAGES'], PDO::PARAM_STR);
        $stmt->bindParam(':DISCRIPTION', $filmData['DISCRIPTION'], PDO::PARAM_STR);
        if ($stmt->execute()) {
            return $stmt->rowCount() > 0;
        } else {
            return false; 
        }
    }



    public static function getOneByID($pdo, $CODE_FILM) {
        $sql = "SELECT film.*, catogery_film.NAME_CATOGERY, type.NAME, language.NAME_LANGUAGE
                FROM film
                JOIN catogery_film ON film.RATED = catogery_film.CODE_CATOGERY 
                JOIN type ON film.CODE_TYPE = type.CODE
                JOIN language ON film.CODE_LANGUAGE = language.CODE_LANGUAGE
                WHERE film.CODE_FILM = :CODE_FILM";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":CODE_FILM", $CODE_FILM, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $film = $stmt->fetch(PDO::FETCH_ASSOC);
            return $film;
        }
        return null;
    }

    // Trong class Film

        public static function getFilmById($pdo, $filmId) {
            try {
                $query = "SELECT * FROM film WHERE CODE_FILM = :filmId";
                $statement = $pdo->prepare($query);
                $statement->execute(array(':filmId' => $filmId));
                $filmInfo = $statement->fetch(PDO::FETCH_ASSOC);
                return $filmInfo; 
            } catch (PDOException $e) {
                return false; 
            }
        }

        public static function getNameFilm($pdo, $film_id) {
            $stmt = $pdo->prepare("SELECT NAME_FILM FROM film WHERE CODE_FILM = ?");
            $stmt->execute([$film_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function getFilmId() {
            return $this->film_id;
        }

    public static function sessionPage($pdo, $page = 1, $perPage = 8) {
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT * FROM FILM ORDER BY CODE_FILM ASC LIMIT :limit OFFSET :offset";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $totalRecordsQuery = "SELECT COUNT(*) FROM FILM";
            $totalRecords = $pdo->query($totalRecordsQuery)->fetchColumn();
            $totalPages = ceil($totalRecords / $perPage);

            return [
                'data' => $data,
                'totalPages' => $totalPages,
                'currentPage' => $page,
                'perPage' => $perPage
            ];
        }

        return [
            'data' => [],
            'totalPages' => 0,
            'currentPage' => $page,
            'perPage' => $perPage
        ];
    }
    public static function getId($data) {
        $last = end($data);
        return $last['CODE_FILM'];
    }
}
?>
