<?php
session_start();

// Access restriction: Redirect if not logged in
if (empty($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once('videogamedbconnection.php');
require_once('queryutils.php');

$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
    or trigger_error('Error connecting to MySQL server for ' . DB_NAME, E_USER_ERROR);

// Check if ID is provided and belongs to the user
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $game_id = $_GET['id'];
    
    // Delete only if it belongs to the logged-in user
    $delete_query = "DELETE FROM games WHERE id = ? AND user_id = ?";
    $result = parameterizedQuery($dbc, $delete_query, 'ii', $game_id, $_SESSION['user_id']);
    
    // Assume deletion was attempted; set success message
    $_SESSION['message'] = "Game deleted successfully.";
    
    // Redirect back to profile
    header("Location: viewprofile.php");
    exit;
} else {
    // Invalid request
    $_SESSION['message'] = "Invalid request.";
    header("Location: viewprofile.php");
    exit;
}

mysqli_close($dbc);
?>
