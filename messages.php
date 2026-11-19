<?php
    include "db.php";
    $siteTitle = "Juan Dela Cruz";

    // EXPLAIN: Which rows does this query get, and why does it not need bind_param?
    $result = $conn->query("SELECT * FROM messages ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Messages - Juan Dela Cruz</title>
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
                </tr>
                <?php } ?>
            </table>
        </div>
        </main>

    <?php include "footer.php"; ?>
    </body>

</html>