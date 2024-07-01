<?php
if(!isset ($_SESSION['user_id'])){
    header("Location: " . BASE_URL . "../auth/login.php");
}
?>
<?php
require('../common/db.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Post</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4">
        <?php
        // Check if ID is set in the URL
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            try {
                // Construct SQL query
                $sql = "DELETE FROM `post` WHERE `id` = :id";

                // Prepare the statement
                $stmt = $pdo->prepare($sql);

                // Bind parameters
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);

                // Execute the statement
                if ($stmt->execute()) {
                    echo '<div class="alert alert-success" role="alert">Record deleted successfully.</div>';
                    header("Location:../posts/index.php");
                    ; // Redirect to index.php after 3 seconds
                    exit();
                } else {
                    echo '<div class="alert alert-danger" role="alert">Error deleting record.</div>';
                }
            } catch (PDOException $e) {
                echo '<div class="alert alert-danger" role="alert">Error: ' . $e->getMessage() . '</div>';
            }
        } else {
            echo '<div class="alert alert-warning" role="alert">No ID provided for deletion.</div>';
        }
        ?>
    </div>
</body>

</html>
