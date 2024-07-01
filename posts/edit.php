<?php
require('../common/config.php');
require('../common/db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM `post` WHERE `id` = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = $_POST["title"];
            $content = $_POST["content"];

            if (strlen($title) < 40 || strlen($title) > 100) {
                echo "Title must be between 40 and 100 characters long.";
                exit();
            }
            if (strlen($content) < 500 || strlen($content) > 1500) {
                echo "Content must be between 500 and 1500 characters long.";
                exit();
            }

            $fileName = '';
            if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $allowedTypes = ['image/jpeg', 'image/png'];
                if (!in_array($_FILES['image']['type'], $allowedTypes)) {
                    echo "Only JPG and PNG images are allowed.";
                    exit();
                }
                list($width, $height) = getimagesize($_FILES["image"]["tmp_name"]);
                if ($width < 1200) {
                    echo "Image width must be below 1200px.";
                    exit();
                }

                $fileName = $_FILES['image']['name'];
                $tempName = $_FILES['image']['tmp_name'];

                if (move_uploaded_file($tempName, "images/" . $fileName)) {
                    // Delete previous image file if new image is uploaded
                    if (!empty($row['image'])) {
                        unlink("images/" . $row['image']);
                    }
                }
            }

            $sql = "UPDATE `post` SET `title` = :title, `content` = :content";
            if (!empty($fileName)) {
                $sql .= ", `image` = :image";
            }
            $sql .= " WHERE `id` = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':content', $content, PDO::PARAM_STR);
            if (!empty($fileName)) {
                $stmt->bindParam(':image', $fileName, PDO::PARAM_STR);
            }
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                echo "Post updated successfully.";
                header("Location: view.php?id=" . $id);
                exit();
            } else {
                echo "Error updating post.";
            }
        }
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Edit Post</title>
            <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
           <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">            <link rel="stylesheet" href="assets/edit.css"> -->
            <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
            <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
            <style>
                .ck-editor__editable[role="textbox"] {
                    /* Editing area */
                    min-height: 300px;
                    /* min-width:  100px; */
                }

                /* .hidden {
                    display: none;
                } */
            </style>
        </head>


        <body>
            <?php include('../common/header.php'); ?>

            <div class="container">
                <h2 class="mt-4">Edit Post</h2>
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title:</label>
                        <input type="text" id="title" name="title" class="form-control" value="<?php echo $row['title']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="prev_image" class="form-label">Previous Image:</label><br>
                        <img src="../images/?php echo $row['image']; ?>" alt="Previous Image" style="max-width: 200px; height: auto;">
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">New Image:</label><br>
                        <input type="file" id="image" name="image" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Content:</label><br>
                        <textarea id="content" name="content" class="form-control" rows="10"><?php echo $row['content']; ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>




            <script>
                ClassicEditor.create(document.querySelector('#content'))
                    .then(editor => {
                        console.log('Editor was initialized', editor);
                    })
                    .catch(error => {
                        console.error('Error during editor initialization:', error);
                    });
            </script>
        </body>
        <?php require('../common/footer.php') ?>

        </html>
<?php
    } else {
        echo "Post not found.";
    }
} else {
    echo "No post ID provided for editing.";
}
?>