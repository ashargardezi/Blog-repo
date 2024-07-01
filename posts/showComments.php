<?php
require('../common/config.php');
require('../common/db.php');

// Retrieve post ID from GET parameter
$post_id = $_GET['id'];

// Prepare SQL statement to fetch comments for the specified post ID
$sql = "SELECT comment.*, _user.first_name, _user.last_name 
        FROM comment 
        JOIN _user ON comment.user_id = _user.id 
        WHERE comment.post_id = :post_id 
        AND comment.status = 1 
        ORDER BY comment.id DESC";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':post_id', $post_id);
$stmt->execute();

// Initialize variable to store HTML markup for comments
$comments_html = '';

// Check if comments are found
if ($stmt->rowCount() > 0) {
    // Loop through each comment and generate HTML markup
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $comments_html .= '<div class="card mt-3 comment-wrap">';
        $comments_html .= '<div class="card-body">';
        $comments_html .= '<p class="card-text">' . $row["comment"] . '</p>';
        $comments_html .= '<p class="card-text">By <b>' . $row["first_name"] . " " . $row['last_name'] . '</b></p>';
        $comments_html .= '<form method="post" action="delete_comment.php">';
        $comments_html .= '<input type="hidden" name="delete_comment_id" value="' . $row['id'] . '">';
        $comments_html .= '<button type="button" onclick="callDeleteComment(this,' . $row['id'] . ');" class="btn btn-danger">Delete</button>';
        $comments_html .= '</form>';
        $comments_html .= '</div>';
        $comments_html .= '</div>';
    }
}

// Return HTML markup for comments
echo $comments_html;
?>
