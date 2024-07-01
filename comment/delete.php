<?php

require('../common/config.php');
require('../common/db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "../auth/login.php");
}


$output = [
    'status' => 'error',
    'message' => ''
];

//php 8 syntax, latest. 
//$output = array();//old way

// Check if ID is set in the URL
if (isset($_POST['comment_id']) && !empty($_POST['comment_id'])) {

    $comment_id = $_POST['comment_id'];

    try {
        // Construct SQL query
        $sql = "DELETE FROM `comment` WHERE `id` = :id";

        // Prepare the statement
        $stmt = $pdo->prepare($sql);
        
        // Bind parameters
        $stmt->bindParam(':id', $comment_id, PDO::PARAM_INT);

        // Execute the statement
        if ($stmt->execute()) {
            $output['status'] = 'success';
            $output['message'] = 'Comment Deleted';
        } else{
            $output['status'] = 'error';
            $output['message'] = 'Comment Not Deleted';
        }

    } catch (PDOException $e) {
        $output['status'] = 'error';
        $output['message'] = 'Comment Not deleted, Error : '.$e->getMessage();
    }
} 

$output = json_encode($output);
echo $output;
exit;

