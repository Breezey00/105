<?php
// so that the session header could actually be sent for the page http recognizes a session
session_start();

    include "db.php";
    $siteTitle = "Coenn Johan Capalihan";
    // ===== Load or save one message =====

    // so they don't pick out or put unwanted edits from the connected database, 
    // before the user even gets to select which line they want edites
    $id = 0;
    $fullname = $email = $reason = $message = "";
    $errors = [];

    // the If is triggered if the Request method sent to this page was a $_POST 
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // the five values are derived from the edits made in the same file
        //  that are of a $_POST method and sent here on the same page
        $id = (int) ($_POST["id"] ?? 0);
        $fullname = trim($_POST["fullname"] ?? "");
        $email = trim($_POST["email"] ?? "");
        $reason = trim($_POST["reason"] ?? "");
        $message = trim($_POST["message"] ?? "");

        // so that the rules are followed also here because the inputs and restrictions of contact.php do not cover here
        if ($fullname === "") {
            $errors[] = "Full name is required.";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "A valid email address is required.";
        }

        if (strlen($message) < 10) {
            $errors[] = "Message must be at least 10 characters.";
        }

        // Update changes the actual values in the actual sql database via the query it understands
        //  and the "sssi" stands for the datatype adherence of the fields
        if (empty($errors)) {
            $stmt = $conn->prepare(
            "UPDATE messages SET fullname = ?, email = ?, reason = ?, message = ?
            WHERE id = ?");
            $stmt->bind_param("ssssi", $fullname, $email, $reason, $message, $id);
        
            // it goes back to messages.php and exits the process, 
            // or if there are errors it stops the user by showing there's an error instead
            if ($stmt->execute()) {
                header("Location: messages.php");
                exit;

            } else {
                $errors[] = "Your changes could not be saved. Please try again.";
            }
        
        }

    } else {
        // id comes from the meesage.php file when the action of pressing the "edit" button 
        // attached to a row sends it's id; it has (int) to ensure that whatever gets sent is a readable value
        $id = (int) ($_GET["id"] ?? 0);

        // the row where of which was pressed and the id was sent;
        //  "?" is used as a placeholder to say that the value is not assigned yet but is just there so the WHERE could exist; 
        // and bind param ensures that the sent values cannot just be injected by any loopholer
        $stmt = $conn->prepare("SELECT fullname, email, reason, message FROM messages WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();

        // it shows a page that shows "Message not found."
        if (!$row) {
            die("Message not found.");
        }

        $fullname = $row["fullname"];
        $email = $row["email"];
        $reason = $row["reason"];
        $message = $row["message"];
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Message - Juan Dela Cruz</title>
    <link rel="stylesheet" href="styles.css">
</head>


<body>
    <?php include "header.php"; ?>
    <main>

        <h2>Edit Message</h2>
        <form method="post" action="edit.php">
            <fieldset>
                <legend>Message #<?php echo $id; ?></legend>
                    <?php if (!empty($errors)) { ?>
                        <ul class="form-errors">

                        <?php foreach ($errors as $e) { ?>
                            <li><?php echo $e; ?></li>
                        <?php } ?>
                        </ul>
                <?php } ?>

                <!-- It's hidden because it's backend operation info and must be kept private for safety,
                  and the users really don't need that info unless they have other plans -->
                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <label for="fullname">Full Name</label>
                <input type="text" id="fullname" name="fullname"
                    value="<?php echo htmlspecialchars($fullname); ?>">

                <label for="email">Email Address</label>
                <input type="email" id="email" name="email"
                    value="<?php echo htmlspecialchars($email); ?>">

                <!-- the reasons are shown via drop down options -->
                <label for="reason">Reason for Contact</label>
                <select id="reason" name="reason">

                    <option value="General Inquiry"
                        <?php if ($reason === "General Inquiry") { echo "selected"; } ?>>
                        General Question
                    </option>

                    <option value="Project Inquiry"
                        <?php if ($reason === "Project Inquiry") { echo "selected"; } ?>>
                        Project Inquiry
                    </option>

                    <option value="Other"
                        <?php if ($reason === "Other") { echo "selected"; } ?>>
                        Other
                    </option>

                </select>
                
                <label for="message">Your Message</label>
                <textarea id="message" name="message" rows="5">
                    <?php echo htmlspecialchars($message); ?>
                </textarea>

                <button type="submit">Save Changes</button>
                <a href="messages.php">Cancel</a>
            </fieldset>
        </form>
    </main>
<?php include "footer.php"; ?>
</body>
</html>