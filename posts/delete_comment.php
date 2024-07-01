<?php
// Include necessary configuration files and establish a database connection
require('../common/config.php');
require('../common/db.php');

// Check if a comment deletion request is made
if(isset($_POST['delete_comment_id'])) {
    $commentIdToDelete = $_POST['delete_comment_id'];
    
    // Update the status of the comment to 0 (deleted)
    $sqlDeleteComment = "UPDATE comment SET status = 0 WHERE id = :comment_id";
    $stmtDeleteComment = $pdo->prepare($sqlDeleteComment);
    $stmtDeleteComment->bindParam(':comment_id', $commentIdToDelete);
    $stmtDeleteComment->execute();
    
    // Redirect back to the page where the comment was deleted from
    header("Location: ".$_SERVER['HTTP_REFERER']);
    exit();
} else {
    // If no comment deletion request is made, redirect to a safe location
    header("Location: index.php"); // You can change this to your desired location
    exit();
}
?>
