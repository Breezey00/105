<?php
session_start();
include "db.php";
$siteTitle = "Coenn Johan Capalihan";

// If someone not logged in tries to visit this page they will be redirected to the login page
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// The id comes from the session so no one can just bypass the entire login system just by using the hotbar
$id = $_SESSION["user_id"];
$stmt = $conn->prepare( "SELECT fullname, email, role, photo, created_at FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
    die("Account not found.");
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My Profile - Coenn Johan Capalihan</title>
        <link rel="stylesheet" href="styles.css">
    </head>

    <body>
        <?php include "header.php"; ?>
        <main>
            <h2>My Profile</h2>
            <div class="card">
                <!-- The browser finds the photo in the uploads folder as matched with the file name stored there.-->
                <img src="uploads/<?php echo htmlspecialchars($user["photo"]); ?>" alt="Profile photo" class="profile-photo">
                
                <h3><?php echo htmlspecialchars($user["fullname"]); ?></h3>
                <p>Email: <?php echo htmlspecialchars($user["email"]); ?></p>
                <p>Account type: <?php echo htmlspecialchars($user["role"]); ?></p>
                <p>Member since: <?php echo $user["created_at"]; ?></p>
            </div>
        </main>

        <?php include "footer.php"; ?>
    </body>
</html>