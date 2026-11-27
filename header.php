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

 </nav>
