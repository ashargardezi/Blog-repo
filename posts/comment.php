<?php 
require('../common/db.php'); 
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $postId = $_GET['id'];
  $user_id = $_SESSION['user_id'];

  // $content = $_POST['comments'];
  $content = trim($_POST['comments']);
  // if (empty($content)) {
  //   echo "<script>alert('Comment cannot be empty.');</script>";
  // }
  
  if (strlen($content) == 0 || strlen($content) > 100) {
    echo "<script>alert('Comment cannot be empty or exceed 100 characters.');</script>";
}



  $status = 1; 

  $insertQuery = "INSERT INTO comment (post_id, user_id, comment, status) 
                  VALUES (:post_id, :user_id, :content, :status)";
  $stmt = $pdo->prepare($insertQuery);

  $stmt->bindParam(':post_id', $postId, PDO::PARAM_INT);
  $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
  $stmt->bindParam(':content', $content, PDO::PARAM_STR);
  $stmt->bindParam(':status', $status, PDO::PARAM_INT);

  $success = $stmt->execute();

  if ($success) {
    $sql = "SELECT comment.*, _user.first_name, _user.last_name FROM comment JOIN _user ON comment.user_id = _user.id WHERE comment.id = LAST_INSERT_ID()";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $commentHtml = '<div class="card mt-3 comment-wrap">' .
                    '<div class="card-body">' .
                    '<p class="card-text">' . $row["comment"] .'</p>' .
                    '<p class="card-text">By <b>' . $row["first_name"] . ' ' . $row["last_name"] . '</b></p>' .
                    '<form method="post" action="delete_comment.php">' .
                    '<input type="hidden" name="delete_comment_id" value="' . $row['id'] . '">' .
                    '<button type="button" onclick="callDeleteComment(this,' . $row['id'] . ');" class="btn btn-danger">Delete</button>' .
                    '</form>' .
                    '</div>' .
                    '</div>';
    echo $commentHtml;
  } else {
    echo "Failed to insert comment";
  }
}


?>




