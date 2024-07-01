<?php require('../common/config.php'); ?>
<?php require('../common/db.php'); ?>

<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "../auth/login.php");
}
?>
<?php


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Feed</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> <!-- <link href="assets/style.css" rel="stylesheet"> -->
</head>

<body>
    <?php require('../common/header.php'); ?>
    <div class="container text-center ">
        <h2>Posts List</h2>
     
<?php

        $limit = 5;
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }

        $offset = ($page - 1) * $limit;

        $user_id = $_SESSION['user_id'];
        $sql = "SELECT * FROM `post` WHERE user_id = :user_id ORDER BY `created_date` DESC"; 
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();


        if ($stmt->rowCount() > 0) {
            




            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        ?>
                <div class="post" style="padding-left: 20px;">
                    <p><?php echo $row['title']; ?></p>
                    <p>
                        <!-- <a class="btn btn-primary" href="<?php echo BASE_URL; ?>/posts/create.php?id=<?php $row['id']; ?>">Create Blog</a> -->
                        <a class="btn btn-secondary" href="<?php echo BASE_URL; ?>/posts/view.php?id=<?php echo $row['id']; ?>">View Post</a>
                        <a class="btn btn-success" href="<?php echo BASE_URL; ?>/posts/edit.php?id=<?php echo $row['id']; ?>">Edit Post</a>
                        <a class="btn btn-outline-danger" href="<?php echo BASE_URL; ?>/posts/delete.php?id=<?php echo $row['id']; ?>">Delete Post</a>
                    </p>
                </div>
        <?php
            }
        } else {
            echo "No records found.";
        }

        // Close connection
        // mysqli_close($connection);
        $sql_total_records = "SELECT COUNT(*) AS total FROM `post`";
        $stmt_total_records = $pdo->query($sql_total_records);
        $total_records = $stmt_total_records->fetchColumn();

        // Calculate total pages
        $total_pages = ceil($total_records / $limit);
        ?>

        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php if ($page > 1) : ?>
                    <li class="page-item"><a class="page-link" href="?page=<?php echo ($page - 1); ?>">Previous</a></li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>"><a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                <?php endfor; ?>

                <?php if ($page < $total_pages) : ?>
                    <li class="page-item"><a class="page-link" href="?page=<?php echo ($page + 1); ?>">Next</a></li>
                <?php endif; ?>
            </ul>
        </nav>

    </div>

    <?php require('../common/footer.php') ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>


</html>