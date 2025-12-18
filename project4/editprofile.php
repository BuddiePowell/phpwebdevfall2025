<?php
session_start();
require_once('pagetitles.php');
$page_title = EDIT_PROFILE;  
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= $page_title ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
</head>
<body>
<?php require_once('navmenu.php'); ?>
<div class="card">
    <div class="card-body">
        <h1><?= $page_title ?></h1>
        <hr/>
        <?php
        require_once('videogamedbconnection.php');
        require_once('queryutils.php');

        $user_id = $_SESSION['user_id'];

        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or trigger_error('Error connecting to MySQL server for ' . DB_NAME, E_USER_ERROR);

        $update_success = true; 

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Handle games update
            if (isset($_POST['id'])) {
                foreach ($_POST['id'] as $index => $game_id) {
                    $title = trim($_POST['title'][$index]);
                    $purchase_date = trim($_POST['purchase_date'][$index]);
                    $status = trim($_POST['status'][$index]);
                    $rating = trim($_POST['rating'][$index]);
                    if ($rating < 0 || $rating > 10) {
                        $rating = 0;
                        echo "<div class='alert alert-warning'>Invalid rating for game ID $game_id; set to 0.</div>";
                    }
                    // Basic date validation
                    if (!empty($purchase_date) && !strtotime($purchase_date)) {
                        echo "<div class='alert alert-warning'>Invalid purchase date for game ID $game_id.</div>";
                    }
                    $update_game_query = "UPDATE games SET title = ?, purchase_date = ?, status = ?, rating = ? WHERE id = ? AND user_id = ?";
                    $game_result = parameterizedQuery($dbc, $update_game_query, 'sssiii', $title, $purchase_date, $status, $rating, $game_id, $user_id);
                    if (!$game_result) {
                        echo "<div class='alert alert-danger'>Error updating game ID $game_id: " . mysqli_error($dbc) . "</div>";
                        $update_success = false;
                    }
                }
            }

            if ($update_success) {
                echo "<div class='alert alert-success'>Games updated successfully.</div>";
            }
        }

        // Fetch games data
        $games_query = "SELECT id, title, purchase_date, status, rating FROM games WHERE user_id = ? ORDER BY purchase_date DESC";
        $games_results = parameterizedQuery($dbc, $games_query, 'i', $user_id);
        $games = [];
        if (mysqli_num_rows($games_results) > 0) {
            while ($row = mysqli_fetch_assoc($games_results)) {
                $games[] = $row;
            }
        }
        mysqli_free_result($games_results);
        mysqli_close($dbc);
        ?>
        <form method="post" action="editprofile.php">
            <h3 class="text-info">Edit Video Game Collection</h3>
            <?php if (!empty($games)): ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Purchase Date</th>
                            <th>Status</th>
                            <th>Rating (0-10)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($games as $game): ?>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" name="title[]" value="<?= htmlspecialchars($game['title']) ?>" required>
                                </td>
                                <td>
                                    <input type="date" class="form-control" name="purchase_date[]" value="<?= htmlspecialchars($game['purchase_date']) ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="status[]" value="<?= htmlspecialchars($game['status']) ?>">
                                </td>
                                <td>
                                    <input type="number" class="form-control" name="rating[]" min="0" max="10" value="<?= htmlspecialchars($game['rating']) ?>">
                                </td>
                                <input type="hidden" name="id[]" value="<?= $game['id'] ?>">
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No games   .</p>
            <?php endif; ?>

            <button type="submit" class="btn btn-primary">Update Games</button>
        </form>

        <hr/>
        <a href="viewprofile.php" class="btn btn-secondary">Back to Profile</a>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>
</html>
