<?php
require('../common/config.php');
require('../common/db.php');

// Start the session if you're using sessions
// session_start();
//Check if user is not loged in, then shoudl not be able to create post. 
if(!isset ($_SESSION['user_id'])){
    header("Location: " . BASE_URL . "../auth/login.php");
}

?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection
    // $pdo = require('../common/db.php');

    $title = $_POST["title"];
    $content = $_POST["content"];

    if (strlen($title) < 40 || strlen($title) > 100) {
        echo "Title must be between 40 and 100 characters long.";
        exit();
    }

    // Validate content length
    if (strlen($content) < 500 || strlen($content) > 1500) {
        echo "Content must be between 500 and 1500 characters long.";
        exit();
    }

    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        echo "Please upload an image.";
        exit();
    } else {
        $allowedTypes = ['image/jpeg', 'image/png'];
        if (!in_array($_FILES['image']['type'], $allowedTypes)) {
            echo "Only JPG and PNG images are allowed.";
            exit();
        }

        $imagesize = getimagesize($_FILES['image']['tmp_name']);
        $width = $imagesize[0];
        $height = $imagesize[1];
        if ($width < 1200) {
            echo "Image width must be at least 1200px.";
            exit();
        }
    }

    $fileName = $_FILES['image']['name'];
    $tempName = $_FILES['image']['tmp_name'];

    if (move_uploaded_file($tempName, "../images/" . $fileName)) {
        $sql = "INSERT INTO `post` (`user_id`,`title`, `image`, `content`, `created_date`) 
                VALUES (:user_id , :title, :image, :content, current_timestamp())";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $_SESSION['user_id']);        
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':image', $fileName);
        $stmt->bindParam(':content', $content);
        

        // Execute the statement
        if ($stmt->execute()) {
            echo "Record inserted successfully.";
            header("Location: view.php?id=" . $pdo->lastInsertId());
            exit();
        } else {
            echo "Error: " . implode(" ", $stmt->errorInfo());
        }
    } else {
        echo "Failed to upload file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Blog Post</title>

    <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
    .ck-editor__editable[role="textbox"] {
                /* Editing area */
                min-height: 300px;
            }
            .hidden {
        display: none;
    }
</style>
</head>

<body>
    <?php include "../common/header.php"; ?>
    <h2 class="text-center mt-4">Create a New Blog</h2>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="create.php" method="post" enctype="multipart/form-data" novalidate >
                    <div class="mb-3">
                        <label for="title" class="form-label">Title:</label>
                        <input type="text" id="title" name="title" class="form-control" placeholder="Min 40 - Max 100 Characters" required>
                    </div>
                <!-- <input type="hidden"> -->
                    <div class="mb-3">
                        <label for="image" class="form-label">Image:</label>
                        <input type="file" id="image" name="image" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Content:</label>
                        <textarea id="content" name="content" class="form-control" rows="10" placeholder="Minimum 500 Characters" required style="display: none;"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <script>
    ClassicEditor
        .create( document.querySelector( '#content' ) )
        .catch( error => {
            console.error( error );
        } );
</script>

</body>

</html>