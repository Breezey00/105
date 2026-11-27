<?php
// so that the session header could actually be sent for the page http recognizes a session
session_start();

 // the two checks allow only users with an account or "user_id" and
    //  whether or not the user is an admin or not; this blocks anyone trying to access the pages via the address bar and redirects them when they try to brute access the pages
    if (!isset($_SESSION["user_id"])) {
        header("Location: login.php");
        exit;
    }

    if ($_SESSION["role"] !== "admin") {
        die("Access denied. This page is for the admin only.");
    }

include "db.php";
// id comes from the $_POST submission from contact.php derived from the id of a row,
// while (int) is used to make sure that only int values are inputted
$id = (int) ($_POST["id"] ?? 0);

// the row containing the id that get sent via $_POST, while i means the value is an "integer"
$stmt = $conn->prepare("DELETE FROM messages WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
// return back to the php page and end the delete process(this file's function)
header("Location: messages.php?delete=yes");// added a query string
exit;
?>