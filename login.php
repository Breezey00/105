<?php
session_start();
include "db.php";
$siteTitle = "Coenn Johan Capalihan";

// ===== Log in =====
$email = "";
$errors = [];
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    // The account is found depending on which email matches
    $stmt = $conn->prepare(
    "SELECT id, fullname, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    // Password verify compares the entered password in login.php to the hash stored in the database that is returned from when the SELECT query was done via
    //the email. It translates the new entry and see if they match and return a true if so.
    if ($user && password_verify($password, $user["password"])) {

        // The session remembers the user's: id,fullname and role
        session_regenerate_id(true);
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["fullname"] = $user["fullname"];
        $_SESSION["role"] = $user["role"];

    // After logging in admin accounts are sent to messages while profile accounts are sent to profile.php
    if ($user["role"] === "admin") {
        header("Location: messages.php");
    } else {
        header("Location: profile.php");
    }
    exit;

    } else {
        // The error does not clarify what's wrong to keep privacy and to reduce the amount of clues that are available to penetrators. And also so no one outside the system can know which emails have accounts.

        $errors[] = "Wrong email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Coenn Johan B Capalihan</title>
        <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php include "header.php"; ?>
    <main>
    <h2>Log In</h2>
        <form method="post" action="login.php">
            <fieldset>
                <legend>Your Account</legend>

                <?php if (!empty($errors)) { ?>
                    <ul class="form-errors">
                    <?php foreach ($errors as $e) { ?>
                    <li><?php echo $e; ?></li>
                    <?php } ?>
                    </ul>
                <?php } ?>

                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">

                <label for="password">Password</label>
                <input type="password" id="password" name="password">
                
                <button type="submit">Log In</button>
                <p>No account yet? <a href="register.php">Register</a></p>
        </fieldset>
    </form>
    </main>

    <?php include "footer.php"; ?>
</body>
</html>