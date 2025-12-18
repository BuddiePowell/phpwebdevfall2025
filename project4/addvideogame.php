<?php
    session_start(); // Start the session to access $_SESSION
    require_once('pagetitles.php');
    $page_title = ADD_VIDEO_GAME;
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?= $page_title ?></title>
    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
          integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS"
          crossorigin="anonymous">
  </head>
  <body>
  <?php
    require_once('navmenu.php');
  ?>
    <div class="card">
      <div class="card-body">
        <h1><?= $page_title ?></h1>
        <hr/>
        <?php
            $display_add_game_form = true;

            $title = "";
            $purchase_date = "";
            $status = "";
            $rating = "";

            // Check if user is logged in
            if (!isset($_SESSION['user_id'])) {
                // Redirect to login page or show error if not logged in
                header('Location: login.php'); // Adjust to your login page
                exit();
            }
            $user_id = $_SESSION['user_id'];

            // Check for form submission
            if (isset($_POST['add_game_submission'], $_POST['title'],
                      $_POST['purchase_date'], $_POST['status'], $_POST['rating']))
            {
                require_once('videogamedbconnection.php');
                require_once('queryutils.php');

                $title = trim($_POST['title']);
                $purchase_date = trim($_POST['purchase_date']);
                $status = trim($_POST['status']);
                $rating = trim($_POST['rating']);

                // Basic validation
                if (empty($title) || empty($purchase_date) || empty($status) || empty($rating)) {
                    echo "<div class='alert alert-danger'>All fields are required.</div>";
                } elseif (!is_numeric($rating) || $rating < 1 || $rating > 10) {
                    echo "<div class='alert alert-danger'>Rating must be a number between 1 and 10.</div>";
                } else {
                    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                            or trigger_error(
                                    'Error connecting to MySQL server for' . DB_NAME, 
                                    E_USER_ERROR);

                    // query to insert into games table
                    $query = "INSERT INTO games (user_id, title, purchase_date, status, rating) " 
                          . " VALUES (?, ?, ?, ?, ?)";

                    $results = parameterizedQuery($dbc, $query, 'isssi',  $user_id, $title, $purchase_date, $status, $rating)
                            or trigger_error(mysqli_error($dbc), E_USER_ERROR);

                    $display_add_game_form = false;
        ?>
            <div class="alert alert-success">
                <strong>Success!</strong> The following video game details were added to your collection.
            </div>
            <h3 class="text-info">The Following Video Game Details were Added:</h3><br/>

            <h1><?= htmlspecialchars($title) ?></h1>
            <div class="row">
              <div class="col">
                <table class="table table-striped">
                  <tbody>
                  <tr>
                      <th scope="row">Title</th>
                      <td><?= htmlspecialchars($title) ?></td>
                  </tr>
                  <tr>
                      <th scope="row">Purchase Date</th>
                      <td><?= htmlspecialchars($purchase_date) ?></td>
                  </tr>
                  <tr>
                      <th scope="row">Status</th>
                      <td><?= htmlspecialchars($status) ?></td>
                  </tr>
                  <tr>
                      <th scope="row">Rating (1-10)</th>
                      <td><?= htmlspecialchars($rating) ?>/10</td>
                  </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <hr/>
            <p>Would you like to <a href='<?= $_SERVER['PHP_SELF'] ?>'> add another game</a>?</p>
        <?php
                }
            }

            if ($display_add_game_form)
            {
        ?>
        <form class="needs-validation"
              novalidate method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
          <div class="form-group row">
            <label for="title"
                   class="col-sm-3 col-form-label-lg">Title</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="title" 
                     name="title" value="<?= htmlspecialchars($title) ?>"
                     placeholder="Game Title" maxlength="255" required>
              <div class="invalid-feedback">
                Please provide a valid game title.
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="purchase_date" 
                   class="col-sm-3 col-form-label-lg">Purchase Date</label>
            <div class="col-sm-8">
              <input type="date" class="form-control" id="purchase_date" 
                     name="purchase_date" value="<?= htmlspecialchars($purchase_date) ?>"
                     required>
              <div class="invalid-feedback">
                Please provide a valid purchase date.
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="status" 
                   class="col-sm-3 col-form-label-lg">Status</label>
            <div class="col-sm-8">
              <select class="form-control" id="status" name="status" required>
                <option value="">Select Status</option>
                <option value="Owned" <?= $status == 'Owned' ? 'selected' : '' ?>>Owned</option>
                <option value="Wishlist" <?= $status == 'Wishlist' ? 'selected' : '' ?>>Wishlist</option>
                <option value="Playing" <?= $status == 'Playing' ? 'selected' : '' ?>>Playing</option>
                <option value="Completed" <?= $status == 'Completed' ? 'selected' : '' ?>>Completed</option>
              </select>
              <div class="invalid-feedback">
                Please select a status.
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="rating" 
                   class="col-sm-3 col-form-label-lg">Rating (1-10)</label>
            <div class="col-sm-8">
              <input type="number" class="form-control" id="rating" 
                     name="rating" value="<?= htmlspecialchars($rating) ?>"
                     placeholder="Rating" min="1" max="10" required>
              <div class="invalid-feedback">
                Please provide a rating between 1 and 10.
              </div>
            </div>
          </div>
          <button class="btn btn-primary" type="submit" 
                  name="add_game_submission">Add Game</button>
        </form>
        <script>
        // JavaScript for disabling form submissions if there are invalid fields
        (function() {
          'use strict';
          window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
              form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                  event.preventDefault();
                  event.stopPropagation();
                }
                form.classList.add('was-validated');
              }, false);
            });
          }, false);
        })();
        </script>
        <?php
            } // Display add game form
        ?>
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
  </body>
</html>
