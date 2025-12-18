<?php
    session_start(); // Start the session to access $_SESSION
    require_once('pagetitles.php');
    $page_title = VIEW_PROFILE;
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
            require_once('videogamedbconnection.php');
            require_once('queryutils.php');

            // Check if user is logged in 
            if (!isset($_SESSION['user_id'])) {
                // Redirect to login page
                header('Location: login.php'); 
                exit();
            }
            $user_id = $_SESSION['user_id'];

            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                    or trigger_error(
                            'Error connecting to MySQL server for' . DB_NAME, 
                            E_USER_ERROR);

            $user_query = "SELECT name, user_name FROM users WHERE id = ?";
            $user_results = parameterizedQuery($dbc, $user_query, 'i', $user_id);
            if (mysqli_num_rows($user_results) == 1) {
                $user_row = mysqli_fetch_assoc($user_results);
                $user_name = $user_row['name'];
                $user_username = $user_row['user_name'];

                // Query to get user's game collection from games table
                $query = "SELECT id, user_id, title, purchase_date, status, rating FROM games WHERE user_id = ? ORDER BY purchase_date DESC";

                $results = parameterizedQuery($dbc, $query, 'i', $user_id)
                        or trigger_error(mysqli_error($dbc), E_USER_ERROR);

                ?>
                <h3 class="text-info">User Information</h3>
                <p><strong>Name:</strong> <?= $user_name ?></p>
                <p><strong>Username:</strong> <?= $user_username ?></p>
                <?php
                if (mysqli_num_rows($results) > 0) {
                ?>
                <h3 class="text-info">Video Game Collection</h3>
                <div class="row">
                  <div class="col">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th scope="col">Title</th>
                          <th scope="col">Purchase Date</th>
                          <th scope="col">Status</th>
                          <th scope="col">Rating</th>
                          <th scope="col">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                            while ($row = mysqli_fetch_assoc($results)) {
                        ?>
                        <tr>
                          <td><?= $row['title'] ?></td>
                          <td><?= $row['purchase_date'] ?></td>
                          <td><?= $row['status'] ?></td>
                          <td><?= $row['rating'] ?>/10</td>
                          <td><a href="deletegame.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this game?')">Remove</a></td>
                        </tr>
                        <?php
                            }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <?php
                } else {
                    echo "<p>No games found for this user.</p>";
                    echo "<a href='addvideogame.php' class='btn btn-primary'>Add a Video Game</a>";
                }
                mysqli_free_result($results);
            } else {
                echo "<p>User details not found.</p>";
            }
            mysqli_free_result($user_results);
            mysqli_close($dbc);
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
