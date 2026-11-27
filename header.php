     <!-- header and nav gets their own file so that you can 
     just make one file you can "call" to show the same outputs 
     instead of having typing them repeatedly line after line -->
 
 <header>
            <h1><?php echo $siteTitle; ?></h1>
 </header>

 <nav class = "navbar">
            <a href="index.php">Home</a>
            <a href="contact.php">Contact</a>
            <!-- the links the vistors see are:
                    admin - index, contact, messages, logout
                    else(not logged in) - index, contact, login, register
             -->
            <?php if (isset($_SESSION["user_id"])) { ?>

                <?php if ($_SESSION["role"] === "admin") { ?>
                 <a href="messages.php">Messages</a>
                <?php } ?>

                <a href="profile.php">My Profile</a>
                <a href="logout.php">Logout</a>

            <?php } else { ?>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
                
            <?php } ?>

            <?php if(isset($_SESSION["user_id"])){ ?> 
            <!--if statement make sure image and greeting only shows up when session is active with an account-->
            <?php

                include "db.php";
                $siteTitle = "Coenn Johan Capalihan";

                // The id comes from the session so no one can just bypass the entire login system just by using the hotbar
                $id = $_SESSION["user_id"];
                $stmt = $conn->prepare( "SELECT fullname, email, role, photo, created_at FROM users WHERE id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $user = $stmt->get_result()->fetch_assoc();

            ?>
            <!-- Created new div for the image and greetings segment -->
            <div class = "greetings">
            <h3>Hello, <?php echo htmlspecialchars($user["fullname"]); ?>!</h3>
            <img src="uploads/<?php echo htmlspecialchars($user["photo"]); ?>" alt="Menu photo" class="menu-photo">
            <div>
                <?php } ?>
 </nav>

 