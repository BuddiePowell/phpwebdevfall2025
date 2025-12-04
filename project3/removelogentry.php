<?php
session_start();

// Access restriction: Redirect if not logged in
if (empty($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once('activitylogdbconnection.php');
require_once('queryutils.php');

$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
    or trigger_error('Error connecting to MySQL server for ' . DB_NAME, E_USER_ERROR);

// Check if ID is provided and belongs to the user
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $entry_id = $_GET['id'];
    
    // Delete only if it belongs to the logged-in user
    $delete_query = "DELETE FROM exercise_log WHERE id = ? AND user_id = ?";
    parameterizedQuery($dbc, $delete_query, 'ii', $entry_id, $_SESSION['user_id']);
    
    // Redirect back to profile with success message
    header("Location: viewprofile.php");
    exit;
} else {
    // Invalid request
    header("Location: viewprofile.php");
    exit;
}

mysqli_close($dbc);
?>