<?php
require_once("bloggingconnectiondb.php");
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
    or trigger_error('Error connecting to MySQL server for blog' . DB_NAME, E_USER_ERROR);
$query = "SELECT id, title, content, creation_date FROM blog ORDER BY id DESC";
$result = mysqli_query($dbc, $query)
    or trigger_error('Error querying database blogapp', E_USER_ERROR);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" 
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" 
        integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" 
        crossorigin="anonymous">
  <link rel="stylesheet"
        href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" 
        integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" 
        crossorigin="anonymous">
  <title>My Blog</title>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-primary shadow-lg" style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-bottom: 3px solid #0056b3;">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active text-white" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="editblogpost.php">Edit your post</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="removeblogpost.php">Remove a post</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="addblogpost.php">Add post</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

  <div class="container mt-4">
    <h1>Here is my blog!</h1>
    
    <?php
    // Check if there are any posts
    if (mysqli_num_rows($result) > 0) {
        echo '<table class="table table-striped">';
        echo '<thead>';
        echo '<tr>';
        echo '<th scope="col">Title</th>';
        echo '<th scope="col">Content</th>';
        echo '<th scope="col">Posted on</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        
        // Loop through the blog posts and display them in table rows
        while ($row = mysqli_fetch_array($result)) {
            echo '<tr>';
            echo '<td>' . $row['title'] . '</td>';
            echo '<td>' . $row['content'] . '</td>';
            echo '<td>' . $row['creation_date'] . '</td>';
            echo '</tr>';
        }
        
        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>No posts available yet. <a href="addblogpost.php">Add your first post!</a></p>';
    }
    
    // Close the database connection
    mysqli_close($dbc);
    ?>
    
  </div>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
</body>
</html>
