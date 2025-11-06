<!-- the form for the madlibs project -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mad Libs</title>
    <link rel="stylesheet" 
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" 
          integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" 
          crossorigin="anonymous">
    <link rel="stylesheet"
          href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" 
          integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" 
          crossorigin="anonymous">
  </head>
  <body>
   
<div class="container mt-5">
    <h1 class ="text-center">Mad Libs Game</h1>
    <div class='card'>
 <div class='card-body'>
    <form class = "madlibform bg-secondary p-4" action="<?=$_SERVER["PHP_SELF"] ?>" method="POST">
        <label for="noun">Noun:</label>
        <input type="text" name="noun" id="noun" required><br>

        <label for="verb">Verb:</label>
        <input type="text" name="verb" id="verb" required><br>

        <label for="adjective">Adjective:</label>
        <input type="text" name="adjective" id="adjective" required><br>

        <label for="adverb">Adverb:</label>
        <input type="text" name="adverb" id="adverb" required><br>
        
        <br>

        <button type="submit" class="btn btn-primary" 
        name="submit">create your madlibs game here!</button>
    </form>
</div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" 
            integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" 
            integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" 
            crossorigin="anonymous"></script>
</html>
</body>

<hr>
<h2 class="text-center">Your list of stories</h2>
<?php
require_once "Madlibsconnection.php";
// Check if the form is submitted
if (isset($_POST["submit"]))
{
    // Get user input
    $noun = $_POST["noun"];
    $verb = $_POST["verb"];
    $adjective = $_POST["adjective"];
    $adverb = $_POST["adverb"];
    if (empty($noun) || empty($verb) || empty($adverb) || empty($adjective))
    {
        //display an error message if any input is missing
        echo "<p>Please fill in all the fields.</p>";
    }
    else
    {
        // Create the new story
        $fullstory = "On a <strong>$adjective</strong> day, 
        I decided to <strong>$verb</strong> my favorite <strong>$noun</strong> while <strong>$adverb</strong> dancing in the park. 
        Everyone around me joined in, and we all had a great time!";
        ($dbc = mysqli_connect("localhost", "student", "student", "Madlibs")) or trigger_error("Error connecting to MySQL server.");
        $query = "INSERT INTO MadlibwordsandStories (noun, verb, adjective, adverb, fullstory) VALUES ('$noun', '$verb', '$adjective', '$adverb', '$fullstory')";
        ($result = mysqli_query($dbc, $query)) or trigger_error("Error querying database.");

        // Retrieve and display all stories from the database
        $query = "SELECT fullstory FROM MadlibwordsandStories order by id desc";
        ($result = mysqli_query($dbc, $query)) or trigger_error("Error querying database.");

        while ($row = mysqli_fetch_array($result))
        {
            echo "<p>" . $row["fullstory"] . "</p><br>";
        }
        // Close the database connection
        mysqli_close($dbc);
    }
}

?>
