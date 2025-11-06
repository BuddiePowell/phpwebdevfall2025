<?php
require_once "bloggingconnectiondb.php";
require_once "authorizeacess.php";
?>

<?php
// display a messege saying the ppost was updated
$message = isset($_GET["updated"]) ? "The following post was updated!" : "";

// Handle form submission for updating the post
if (isset($_POST["submit"])) {
    $id = $_POST["id"];
    $title = $_POST["title"];
    $content = $_POST["content"];

    ($dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)) or
        trigger_error(
            "Error connecting to MySQL server for blog" . DB_NAME,
            E_USER_ERROR
        );

    $query = "UPDATE blog SET title = '$title', content = '$content' WHERE id = $id";
    mysqli_query($dbc, $query) or
        trigger_error("Error updating database blogapp", E_USER_ERROR);

    mysqli_close($dbc);

    // Redirect back to the edit page with success message
    header("Location: editblogpost.php?id=" . $id . "&updated=1");
    exit();
}

// Fetch post data for editing via the get method
$post = null;
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    ($dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)) or
        trigger_error(
            "Error connecting to MySQL server for blog" . DB_NAME,
            E_USER_ERROR
        );

    $query = "SELECT id, title, content FROM blog WHERE id = $id";
    ($result = mysqli_query($dbc, $query)) or
        trigger_error("Error querying database blogapp", E_USER_ERROR);
    $post = mysqli_fetch_assoc($result);
    mysqli_close($dbc);

    if (!$post) {
        echo "<p>Post not found.</p>";
        exit();
    }
}

// Fetch all posts for listing if no id is provided
$posts = [];
if (!isset($_GET["id"])) {
    ($dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)) or
        trigger_error(
            "Error connecting to MySQL server for blog" . DB_NAME,
            E_USER_ERROR
        );
    //
    $query = "SELECT id, title FROM blog ORDER BY id DESC";
    ($result = mysqli_query($dbc, $query)) or
        trigger_error("Error querying database blogapp", E_USER_ERROR);

    while ($row = mysqli_fetch_assoc($result)) {
        $posts[] = $row;
    }

    mysqli_close($dbc);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog Post</title>
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
        <h1>Edit Blog Post</h1>
        <?php if ($message): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
        
        <?php if ($post): ?>
            <form class ="needs-validation"  nonvalidate method="POST" action="<?= $_SERVER[
                "PHP_SELF"
            ] ?>"> 
                <input type="hidden" name="id" value="<?php echo $post[
                    "id"
                ]; ?>">
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" class="form-control" name="title" id="title" value="<?php echo $post[
                        "title"
                    ]; ?>" required>
                    <div class="invalid-feedback">
                Please provide a title  .
              </div>
                </div>
                <div class="form-group">
                    <label for="content">Content:</label>
                    <textarea class="form-control" name="content" id="content" rows="5" required><?php echo $post[
                        "content"
                    ]; ?></textarea>
                    <div class="invalid-feedback">
                Please  input text into the feild
              </div>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Update Post</button>
            </form>
        <?php elseif (!empty($posts)): ?>
            <h2>Select a Post to Edit</h2>
            <ul class="list-group">
                <?php foreach ($posts as $p): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?php echo $p["title"]; ?>
                        <a href="editblogpost.php?id=<?php echo $p[
                            "id"
                        ]; ?>" class="btn btn-primary btn-sm">Edit</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No posts found to edit.</p>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
</body>
</html>
