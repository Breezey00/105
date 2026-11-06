<?php
    // ===== Form processing =====
    // so they return blank when they have none inputted in them yet, so the page can load initially
    $fullname = $email = $reason = $message = "";
    $errors = [];
    $sent = false;

    // whenever the form is submitted that is a method $_POST
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // the form's post 
        $fullname = trim($_POST["fullname"] ?? "");
        $email = trim($_POST["email"] ?? "");
        $reason = trim($_POST["reason"] ?? "");
        $message = trim($_POST["message"] ?? "");

        /* 1st, that fullname isn't empty;2nd, that an email is in the right format;
        3rd, message is at least 10 characters; 4th, only without errors can the sent be set to true */
        if ($fullname === "") {
            $errors[] = "Full name is required.";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "A valid email address is required.";
        }
        if (strlen($message) < 10) {
            $errors[] = "Message must be at least 10 characters.";
        }
        // if the errors array is empty
        if (empty($errors)) {
            $sent = true;
        }

    }
?>

<!DOCTYPE html>
<html lang="en">
 
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Contact - Coenn Johan Capalihan</title>
        <link rel="stylesheet" href="styles.css">
    </head>`

    <body>

        <main>

        <?php

            /* HTML and PHP is read by the compiler top to bottom and left to right. 
                That means that if siteTitle is to have a value on being called you have to set it up before 
                the php is implemented */
            $siteTitle = "Coenn Johan Caapalihan";
            // include calls the other file/code-set to be read by the compiler in a certain part of the code
            include "header.php";
        ?>

            <h2>Contact Me</h2>

            <!-- an id is given so that it can be singled out from other files like js and css and be subject to their modifications
                  no validate disables the auto-validate set on forms by default by the browser -->
            <!-- to the contact.php page (and associated js file/s, via first being stored in the $_POST superglobal array -->
            <!-- the output shown depends on if the value of $sent is true or false-->
            <?php if ($sent) { ?>
            <div id="result">
            <p>Thank you, <?php echo htmlspecialchars($fullname); ?>!</p>
            <p>We will reply to <?php echo htmlspecialchars($email); ?>.</p>
            </div>
            <?php } else { ?>

            <form id="contactForm" method="post" action="contact.php" novalidate>
                
                <fieldset >
                    <legend>Send a Message</legend>

                    <?php if (!empty($errors)) { ?>
                    
                        <!-- The list appears when there are errors(when $errors array is not empty)-->
                        <ul class="form-errors">
                            <?php foreach ($errors as $e) { ?>
                            <li><?php echo $e; ?></li>
                            <?php } ?>
                        </ul>
                    <?php } ?>

                    <label for="fullname">Full Name</label>
                        <!-- to simply put into html characters the contents of every $property -->
                        <input type="text" id="fullname" name="fullname" required
                        value="<?php echo htmlspecialchars($fullname); ?>">


                    <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" required
                        value="<?php echo htmlspecialchars($email); ?>">
                        
                    <label for="reason">Reason for Contact</label>
                        <select id="reason" name="reason">
                            <option value="general">General Question</option>
                            <option value="project">Project Inquiry</option>
                            <option value="other">Other</option>
                        </select>

                    <p>Preferred Reply:</p>
                    <section class = "field">
                        <label><input type="radio" name="reply" value="email" checked> Email</label>
                        <label><input type="radio" name="reply" value="phone"> Phone</label>
                        <label>
                            <input type="checkbox" name= "consent" id = "allow" required>
                            I agree to be contacted.                
                        </label>
                    </section>

                    <label for="message">
                        Your Message
                    </label>

                    <textarea id="message" name="message" rows="5" required><?php echo
                    htmlspecialchars($message); ?></textarea>

                    </textarea>

                    <p id="charCount">
                        0 characters
                    </p>

                    <!--Errors will show on this list just above the button (so the user can see what's up) -->
                    <ul id="formErrors" class="form-errors"></ul>

                    <button type="submit" id = "butt" disabled>Send Message</button>
                </fieldset>
            </form>
            <?php } ?>


            <div id="result"></div>

            <section class = "card table-wrap"> 
                <h2>When You Can Reach Me</h2>
                <table>
                    <caption>My Weekly Availability</caption>
                    <tr>
                        <th>Day</th>
                        <th>Time</th>
                        <th>Mode</th>
                    </tr>
                    <tr>
                        <td>Monday</td>
                        <td>9:00-11:00 AM</td>
                        <td>Online</td>
                    </tr>
                    <tr>
                        <td>Wednesday</td>
                        <td>1:00-3:00 PM</td>
                        <td>In person</td>
                    </tr>
                    <tr>
                        <td>Friday</td>
                        <td>10:00-12:00 NN</td>
                        <td>Online</td>
                    </tr>
                    <tr>
                        <td>Saturday</td>
                        <td>By appointment</td>
                        <td>Online</td>
                    </tr>
                </table>



            </section>
        </main>

        <?php include "footer.php"; ?>

        <!-- so there is actually something valid in the inputs before being submitted as a and into a request-->
        <?php if (!$sent) { ?>
       <script src="form.js"></script>
        <?php } ?>
</body>

</html>
