<?php
require('../common/config.php');
require('../common/db.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Feed</title>

    <?php require('../common/assets.php'); ?>

</head>

<body>
    <?php include('../common/header.php'); ?>

    <div class="container justify-content-center">

        <?php

        $post_id = $_GET['id'];

        $sql = "SELECT * FROM `post` WHERE id = :post_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':post_id', $post_id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
                <div class="post">
                    <img class="img-fluid" src="../images/<?php echo $row["image"]; ?>" alt="Post Image">
                    <div class="post-content">
                        <h3 class="post-title"><?php echo $row["title"]; ?></h3>
                        <p class="post-text"><?php echo substr($row["content"], 0, 200); ?></p>
                        <div class="full-content" style="display: none;">
                            <p><?php echo $row["content"]; ?></p>
                        </div>
                        <p class="post-date">Created Date: <?php echo $row["created_date"]; ?></p>
                    </div>
                </div>
        <?php
            }
        } else {
            echo "No records found.";
        }
        ?>

    </div>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="comment.php?id=<?php echo $post_id; ?>" method="post">
                    <div id="form1" class="mb-3">
                        <label for="comments" class="form-label">Leave a Comment</label>
                        <textarea class="form-control" id="comments" name="comments" rows="5" placeholder="Enter your comment"></textarea>
                    </div>
                    <button id="commentsubmit" type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <h3>Comments</h3>
            <div class="col-md-6 comments-section">



                <?php

                //$sql2 = "SELECT * FROM `comment` WHERE post_id = :post_id";
                $sql2 = "SELECT comment.*, _user.first_name, _user.last_name FROM comment JOIN _user ON comment.user_id = _user.id WHERE comment.post_id = :post_id AND comment.status=1 ORDER BY comment.id DESC";
                $stmt = $pdo->prepare($sql2);
                $stmt->bindParam(':post_id', $post_id);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                        <div class="card mt-3 comment-wrap">
                            <div class="card-body">
                                <p class="card-text"><?php echo $row["comment"]; ?></p>
                                <p class="card-text">By <b><?php echo $row["first_name"] . " " . $row['last_name']; ?></b></p>
                                <form method="post" action="delete_comment.php">
                                    <input type="hidden" name="delete_comment_id" value="<?php echo $row['id']; ?>">
                                    <button type="button" onclick="callDeleteComment(this,<?php echo $row['id'] ?>);" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo "No comments found.";
                }
                ?>

            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        function toggleContent(element) {
            element.parentNode.querySelector('.full-content').style.display = 'block';
            element.style.display = 'none';
        }

        function callDeleteComment(buttonObj, comment_id) {

            //var parentDiv = $(buttonObj).closest('.comment-wrap').css({'border':'1px solid blue'});




            //$.ajax();

            //JSON ,XML 

            $.ajax({
                type: "POST",
                url: '<?php echo BASE_URL; ?>/comment/delete.php',
                data: {
                    'comment_id': comment_id,
                    'post_id': 2
                },
                success: function(data) {
                    $(buttonObj).closest('.comment-wrap').animate({
                        left: '1000px',
                    }, function() {
                        $(this).remove();
                    });
                },
                error: function(data) {

                },
                complete: function() {

                },
                dataType: 'json'
            });

        }
    </script>


    <script>
        $(document).ready(function() {
            $('#commentsubmit').click(function(event) {
                event.preventDefault(); // Prevent default form submission behavior
                $.ajax({
                    type: "post",
                    url: '<?php echo BASE_URL; ?>/posts/comment.php?id=<?php echo $post_id; ?>',
                    data: {
                        user_id: <?php echo $_SESSION['user_id']; ?>,
                        comments: $('#comments').val(),
                        status: 1,
                    },
                    success: function(success) {
                        $('.comments-section').prepend(success);
                        $('#comments').val('');
                        //$('#form1').html('$success');
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", error);
                    }
                });
            });
        });
    </script>

    </script>


</body>

</html>