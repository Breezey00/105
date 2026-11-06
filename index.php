

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Coenn Johan B Capalihan</title>
        <link rel="stylesheet" href="styles.css">
    </head>

    <body> 
    
    <?php

        /* HTML and PHP is read by the compiler top to bottom and left to right. 
            That means that if siteTitle is to have a value on being called you have to set it up before 
            the php is implemented */
        $siteTitle = "Coenn Johan B Capalihan";

        // include calls the other file/code-set to be read by the compiler in a certain part of the code
        include "header.php";
    ?>
       
     <main>

            <section class = "cards">   

                <div class = "card">
                    <img src="images/barney.png" alt = "dinosawr" width="150" id = "profilepic">
                    <h1>Coenn Johan B Capalihan</h1>
                    <h2>BSIT 4C (3B)</h2>
                    <h2>I'm interested in <strong> Sociology</strong>. And I believe in the power of <em>Computing Technology</em>.</h2>         
                </div>

            
                <hr> 

                <div class = "card">
                    <!-- This is section says what I can do -->
                    <h2>My Top 5 Skills: </h2>
                    <ol type="a">
                        <li>Organizing</li>
                        <li>Documenting</li>
                        <li>Analyzing</li>
                        <li>Planning</li>
                        <li>Preparing</li>
                    </ol> 
                </div>

                <hr>

                <div class = "card">
                    
                    <h2>Hobbies:</h2>
                    <ul>
                        <li>Running</li>
                        <li>Playing Video Games</li>
                        <li>Singing</li>
                        <li>Reading</li>
                        <li>Writing</li>
                    </ul>     
                </div>
                     
                <hr>
            
                <div class = "card">
                    
                    <h2>Courses This Term</h2>
                    <?php
                        // an array with indexes called "title" and "note"
                        $courses = [
                        ["title" => "ICT 105", "note" => "This subject is about the structure of webpages and the coding languages used in making them such as HTML, CSS, JavaScript and PHP and the Software involved in running them"],
                        ["title" => "ICT 104", "note" => "This subject is about Java and the basics of Object Oriented Programming"],
                        ["title" => "IT 107", "note" => "This subject is about how computers communicate through each other; the protocols, the conventions, addressing and topologies that allow for networks"]
                        ];
                    ?>

                    <dl>
                        <!-- for every index in the main array it retrieves and outputs the title and note -->
                        <?php foreach ($courses as $c) { ?>
                            <dt><?php echo $c["title"]; ?></dt>
                            <dd><?php echo $c["note"]; ?></dd>
                        <?php } ?>
                    </dl>          
                </div>

                <hr>
        
                <div class = "card">
                    
                    <h2>Connect With Me</h2>
                        <a href = "https://www.youtube.com/watch?v=LyW_cOi-cSQ" target ="_blank"> Favorite Video</a><br>
                        <a href ="mailto:c.coennjohan@gmail.com">Email Me</a><br>
                        <a href ="#">Top</a>
                </div>
                
        </section>
  

            <section>

                <h2>My Projects</h2>
                <label for="search">Filter projects</label>
                <input type="text" id="search" placeholder="Type a title...">
                
                <p id="count"></p>
                <div id= "projects" class="cards"></div>

            </section>   

            <?php include "footer.php"; ?>

            <script src = "script.js"> </script>

        </main>

    </body>

</html>