<?php
session_start();
// Include file containing the function addTicket and database connection
require 'class/Database.php';
require 'class/Ticket.php';
$db = new Database();
$pdo = $db->getConnect();
$logged_in_customer_id = $_SESSION['username']; // Assuming you store customer ID in session
$selected_seat = $_POST['selectedSeats']; // Assuming you get the selected seat from select_room page

// Assuming you have the sale date as the current date
$current_date = date('Y-m-d');


// Assuming you have the selected room code from select_room page
$selected_room_code = $_POST['selectedRoom']; // Assuming you get the selected room code from select_room page
var_dump($_POST['selectedRoom']);

// Assuming you have the selected film code from the previous page
$selected_film_code = $_POST['CODE_FILM']; // Assuming you get the selected film code from the previous page

// Prepare the $code_ticket array
$code_ticket = [
    'CODE_TICKET' => '', // Assuming this will be auto-generated by the database
    'CODE_CUSTOMER' => $logged_in_customer_id,
    'SEAT' => $selected_seat,
    'SALE_DATE' => $current_date,
    'CODE_ROOM' => $selected_room_code,
    'CODE_FILM' => $selected_film_code
];

// Call the function addTicket
$result = Ticket::addTicket($pdo, $code_ticket);

if ($result) {
    // Ticket added successfully
    echo "Ticket added successfully!";
} else {
    // Error occurred
    echo "Failed to add ticket!";
}
?>
