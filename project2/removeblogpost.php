<?php
require_once("bloggingconnectiondb.php");
require_once("authorizeacess.php");



// Handle form submission for removing the post
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    
     $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
        or trigger_error('Error connecting to MySQL server for blog' . DB_NAME, E_USER_ERROR);
    
    
    
    $query = "DELETE FROM blog WHERE id = $id";
    mysqli_query($dbc, $query)
        or trigger_error('Error deleting from database blogapp', E_USER_ERROR);
    
    mysqli_close($dbc);
    
    // Redirect back to home or show success
    header('Location: index.php');
    exit();
}

// Fetch all posts for selection 
 $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
        or trigger_error('Error connecting to MySQL server for blog' . DB_NAME, E_USER_ERROR);

$query = "SELECT * FROM blog ORDER BY id DESC";
$result = mysqli_query($dbc, $query)
    or trigger_error('Error querying database blogapp', E_USER_ERROR);
$posts = [];
while ($row = mysqli_fetch_assoc($result)) {
    $posts[] = $row;
}
mysqli_close($dbc);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remove Blog Post</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" 
          integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" 
          crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" 
          integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" 
          crossorigin="anonymous">
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
        <h1>Remove Blog Post</h1>
        
        <?php if (!empty($posts)): ?>
            <p>Here are your blog posts. Select one to remove:</p>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $post): ?>
                        <tr>
                            <td><?php echo $post['id']; ?></td>
                            <td><?php echo $post['title']; ?></td>
                            <td><?php echo $post['creation_date']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="mt-4">
                <div class="form-group">
                    <label for="postSelect">Select a post to remove:</label>
                    <select class="form-control" id="postSelect" name="id" required>
                        <option value="">Choose a post...</option>
                        <?php foreach ($posts as $post): ?>
                            <option value="<?php echo $post['id']; ?>">
                                <?php echo $post['id'] . ' - ' . $post['title']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" name="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to remove the selected post?')">Remove Selected Post</button>
            </form>
        <?php else: ?>
            <p>No posts available to remove.</p>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous"></script>
</body>
</html>
