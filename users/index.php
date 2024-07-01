

<?php
require('../common/config.php');
require('../common/db.php');
if(!isset ($_SESSION['user_id'])){
    header("Location: " . BASE_URL . "../auth/login.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle form submission here
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Feed</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

    <?php include('../common/header.php'); ?>

    <div class="container justify-content-center">
        <?php
        $user_id = $_SESSION['user_id'];




        // Full texts
        // id	
        // post_id	
        // user_id	
        // comment	
        // status	
        // created_at

        // $sql = "SELECT * FROM comment  join _user on comment.user_id = _user.user_id";

        // $stmt = $pdo->prepare($sql);
        // $stmt->bindParam('user_id', $user_id);

        // print_r($stmt); die;

        // $stmt->execute();
        // $user_id = $_SESSION['user_id'];
        $sql = "SELECT * FROM comment  JOIN _user ON comment.user_id = _user.id WHERE comment.user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();


        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
                <div class="post card mb-3">
                    <div class="post-content card-body">
                        <p class="card-text">User  <b><?php echo $row["first_name"] . " " . $row['last_name']; ?></b></p>
                        <p class="post-text card-text"><?php echo substr($row["comment"], 0, 200); ?></p>
                        <p class="post-date card-text">Created Date: <?php echo $row["create_at"]; ?></p>
                    </div>
                </div>

        <?php
            }
        } else {
            echo "No records found.";
        }
        ?>
    </div>

    

    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        function toggleContent(element) {
            element.parentNode.querySelector('.full-content').style.display = 'block';
            element.style.display = 'none';
        }
    </script>

</body>

</html>