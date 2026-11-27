<?php
    session_start();
    include "db.php";
    $siteTitle = "Coenn Johan Capalihan";

    // ===== Register a new account =====
    // to not have any default values that would otherwise create an account on default. And so that there would be no surprises for the registrerer
    $fullname = $email = "";
    $errors = [];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // the values come from the necessary inputs from register.php
        $fullname = trim($_POST["fullname"] ?? "");
        $email = trim($_POST["email"] ?? "");
        $password = $_POST["password"] ?? "";

        if ($fullname === "") {
            $errors[] = "Full name is required.";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "A valid email address is required.";
        }

        if (strlen($password) < 8) {
            $errors[] = "Password must be at least 8 characters.";
        }

        // the email is found to have already been used by checking the actual database that stores the emails used in the accounts
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        if ($stmt->get_result()->fetch_assoc()) {
            $errors[] = "That email is already registered.";
        }
        // ===== Check the photo =====
        //$_FILES hold files in a "photo" array, while the following if statements check whether there is a file uploaded and attached to the photo[],
        // and if there are errors that challenge the fact that it's a "photo". And it checks if it is the right size.
        $photo = $_FILES["photo"] ?? null;
        if (!$photo || $photo["error"] === UPLOAD_ERR_NO_FILE) {
            $errors[] = "Please choose a profile photo.";

        } elseif ($photo["error"] !== UPLOAD_ERR_OK) {
         $errors[] = "The photo could not be uploaded. Try a smaller file.";

        } else {
        //  strtlower makes the filename into lowercase; that the file is in a png,jpeg, or png;
        // that the photosize is not more than 2MB, and if the image is really an image in a file by checking if it has length and width.
        $ext = strtolower(pathinfo($photo["name"], PATHINFO_EXTENSION));
            if (!in_array($ext, ["jpg", "jpeg", "png"])) {
                    $errors[] = "Photo must be a JPG or PNG file.";

            } elseif ($photo["size"] > 2 * 1024 * 1024) {
                    $errors[] = "Photo must be 2 MB or smaller.";

            } elseif (getimagesize($photo["tmp_name"]) === false) {
                    $errors[] = "That file is not a real image.";
                }
        }

            // ===== Save the photo =====
        if (empty($errors)) {
            // Photos get a new name in so that any files with similar names don't conflict or overwrite each other's uploads, and where it sis stored in an "uploads/" folder
            $photoName = uniqid("user_") . "." . $ext;
            $target = "uploads/" . $photoName;

            if (!move_uploaded_file($photo["tmp_name"], $target)) {
                $errors[] = "The photo could not be saved. Check your uploads folder.";
            }
        }

        // ===== Save the account =====
        if (empty($errors)) {
            // The password hash is a sort of encryption that takes the original String and "translates" it into another language that is decodable by a key. 
            //passwords are hashed as to not be easily usable and revealed when a breach happens.
            $hash = password_hash($password, PASSWORD_DEFAULT);

            // the values stored are $fullname, $email, $hash,and  $photoName; and they are stored in the order as they are written

            $stmt = $conn->prepare( "INSERT INTO users (fullname, email, password, photo) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $fullname, $email, $hash, $photoName);
            if ($stmt->execute()) {
                header("Location: login.php");
                exit;
            } else {
                $errors[] = "Your account could not be created. Please try again.";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Register - Coenn Johan Capalihan</title>
        <link rel="stylesheet" href="styles.css">
    </head>

    <body>

        <?php include "header.php"; ?>
        
        <main>
            <h2>Create an Account</h2>

            <!-- enctype is set because files are going to be among the files sent to the form. It allows for the form to understand and accept files -->
            <form method="post" action="register.php" enctype="multipart/form-data">
                <fieldset>
                    <legend>Your Details</legend>
                    
                    <?php if (!empty($errors)) { ?>
                        <ul class="form-errors">
                        <?php foreach ($errors as $e) { ?>
                        <li><?php echo $e; ?></li>
                        <?php } ?>
                        </ul>
                    <?php } ?>

                    <label for="fullname">Full Name</label>
                    <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($fullname);
                     ?>">

                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); 
                    ?>">

                    <label for="password">Password (at least 8 characters)</label>
                    <input type="password" id="password" name="password">

                    <!-- "accept" checks for suffixes to ensure that only the accepted files can be fed into the machines as safe guards to crtain errors or exploits -->
                    <label for="photo">Profile Photo (JPG or PNG, up to 2 MB)</label>
                    <input type="file" id="photo" name="photo" accept=".jpg,.jpeg,.png">

                    <button type="submit">Register</button>
                    <p>Already have an account? 
                        <a href="login.php">Log in</a></p>

                </fieldset>
            </form>
        </main>
        <?php include "footer.php"; ?>
    </body>
</html>