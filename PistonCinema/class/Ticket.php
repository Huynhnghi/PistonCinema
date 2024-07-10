<?php
    class Ticket{
        public $CODE_TICKET;
        public $CODE_CUSTOMER;
        publIC $SEAT;
        public $SALE_DATE;
        public $CODE_ROOM;
        public $CODE_FILM;

        public static function getAllTicket($pdo)
        {
            $sql = "SELECT * FROM ticket ";
            $stmt = $pdo->prepare($sql);

            if ($stmt->execute()) {
                $ticket = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $ticket;
            }
            return null;
        }

        public static function DelCart($pdo, $code)
        {
            $sql = "DELETE FROM ticket WHERE CODE_TICKET = :code";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":code", $code, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                return true;
            } else {
                return false; 
            }
        }

        public static function getInfoTicket($pdo, $CODE_TICKET){
            $sql=" SELECT ticket.CODE_TICKET, customer.NAME_CUSTOMER, seat.NAME_SEAT, ticket.SALE_DATE, room.CODE_ROOM, film.CODE_FIM
                        FROM ticket 
                        JOIN customer ON ticket.CODE_CUSTOMER = customer.CODE_CUSTOMER
                        JOIN seat ON ticket.SEAT = seat.CODE_SEAT
                        JOIN room ON ticket.CODE_ROOM = room.CODE_ROOM 
                        JOIN film ON ticket.CODE_FILM = film.CODE_FILM
                        WHERE ticket.CODE_TICKET = :CODE_TICKET ";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":CODE_TICKET", $CODE_TICKET, PDO::PARAM_INT);
    
            if ($stmt->execute()) {
                $ticket = $stmt->fetch(PDO::FETCH_ASSOC);
                return $ticket;
            }
            return null;
        }

        public static function addTicket($pdo, $ticket_data) {
            try {
                if (empty($ticket_data) || !is_array($ticket_data)) {
                    throw new InvalidArgumentException("Ticket data is empty or not an array.");
                }
                $sql = "INSERT INTO ticket (CODE_TICKET, CODE_CUSTOMER, SEAT, SALE_DATE, CODE_ROOM, CODE_FILM) 
                        VALUES (:CODE_TICKET, :CODE_CUSTOMER, :SEAT, :SALE_DATE, :CODE_ROOM, :CODE_FILM)";
        
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':CODE_TICKET', $ticket_data['CODE_TICKET'], PDO::PARAM_INT);
                $stmt->bindParam(':CODE_CUSTOMER', $ticket_data['CODE_CUSTOMER'], PDO::PARAM_INT);
                $stmt->bindParam(':SEAT', $ticket_data['SEAT'], PDO::PARAM_STR);
                $stmt->bindParam(':SALE_DATE', $ticket_data['SALE_DATE'], PDO::PARAM_STR);
                $stmt->bindParam(':CODE_ROOM', $ticket_data['CODE_ROOM'], PDO::PARAM_INT);
                $stmt->bindParam(':CODE_FILM', $ticket_data['CODE_FILM'], PDO::PARAM_INT);
        
                return $stmt->execute();
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
                return false; 
            }
        }
        
        
        public static function addSelectedSeat($pdo, $NAME_SEAT, $PRICE) {
            try {
                $sql = "INSERT INTO seat (NAME_SEAT, PRICE) VALUES (:NAME_SEAT, :PRICE)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':NAME_SEAT', $NAME_SEAT, PDO::PARAM_STR);
                $stmt->bindParam(':PRICE', $PRICE, PDO::PARAM_INT);
    
                if ($stmt->execute()) {
                    $seatId = $pdo->lastInsertId();
                    return [
                        'CODE_SEAT' => $CODE_SEAT,
                        'NAME_SEAT' => $NAME_SEAT,
                        'PRICE' => $PRICE
                    ];
                } else {
                    return ['error' => 'Không thể thêm ghế vào cơ sở dữ liệu.'];
                }
            } catch (PDOException $e) {
                return ['error' => 'Lỗi cơ sở dữ liệu: ' . $e->getMessage()];
            }
        }
    }