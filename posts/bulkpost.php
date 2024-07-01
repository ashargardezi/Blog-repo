<?php
require('../common/config.php');
require('../common/db.php');
require('../common/header.php');
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $user_id = $_SESSION['user_id']; 
    $file = $_FILES['file']['tmp_name'];

    if ($file) {
        $spreadsheet = IOFactory::load($file);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        unset($rows[0]);

        $stmt = $pdo->prepare("INSERT INTO post (user_id, title, image, content) VALUES (:user_id, :title, :image, :content)");

        foreach ($rows as $row) {
           
            $title = $row[0];
            $image = $row[1];
            $content = $row[2];

           
            $image_path = basename($image);

            // Bind parameters and execute
            $stmt->execute([
                ':user_id' => $user_id,
                ':title' => $title,
                ':image' => $image_path,
                ':content' => $content
            ]);
        }

        echo "<script>alert('Posts uploaded successfully!');</script>";

    } else {
        echo "Failed to upload file.";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap File Upload</title>
    <?php require('../common/assets.php'); ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-qKrz2IzU0JZ9JdYFkaV7Scjm9JpN4e9f1B7fK5T3upKdf7U5fweZZqZG2Xas8nZw" crossorigin="anonymous">
</head>
<body>
<div class="container mt-5">
        <h1 class="mb-4">Upload Excel File</h1>
        <form action="bulkpost.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="file" class="form-label">Choose Excel file</label>
                <input class="form-control" type="file" name="file" id="file" accept=".xls,.xlsx" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Upload</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
