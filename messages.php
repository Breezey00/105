<?php
    include "db.php";
    $siteTitle = "Coenn Johan Capalihan";

    $delete = (String) ($_GET["delete"] ?? '');
    if ($delete === "yes"){?> <!--checks if a deleteion signal is sent -->
      
       <script> alert( "Message deleted!"); </script> 
        <!--added js alert to indicate deletion -->
   <?php 

    }

    // it gets every row and bind param isn't needed because files are retrieved and not stored
    $result = $conn->query("SELECT * FROM messages ORDER BY id DESC");
?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Messages - Coenn Johan Capalihan</title>
        <link rel="stylesheet" href="styles.css">
    </head>

    <body>
    <?php include "header.php"; ?>
    
        <main>

        <h2>Messages Received</h2>
        <div class="table-wrap">
            <table>
                
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Reason</th>
                    <th>Message</th>
                    <th>Sent At</th>
                    <th>Actions</th>
                </tr>

                <!-- the loop runs so long as there are unread rows still in the db -->
                <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row["fullname"]); ?></td>
                    <td><?php echo htmlspecialchars($row["email"]); ?></td>
                    <td><?php echo htmlspecialchars($row["reason"]); ?></td>
                    <td><?php echo htmlspecialchars($row["message"]); ?></td>
                    <td><?php echo htmlspecialchars($row["created_at"]); ?></td>
                    <!--Added another colum to show in messages the time a message 
                    was created( or atleast the exact time it was inputted in the database) -->
                    
                    <!-- The id(primary key) of the selected returned row -->
                    <td>
                        <a href="edit.php?id=<?php echo $row["id"]; ?>">Edit</a>

                        <!-- id is the variable that the created methods work with and is 
                         basically the info you use to change the data through edits and deletes and thus must be protected(in the digital sense: "hidden); and what confiurm() does is show a dialogue box -->
                        <form method="post" action="delete.php" onsubmit="return confirm('Delete this message?');">

                            <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
                            <button type="submit" class="delete-btn">Delete</button>

                        </form>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
        </main>

    <?php include "footer.php"; ?>
    </body>

</html>