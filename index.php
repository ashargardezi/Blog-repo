<?php
require('common/config.php');
require('common/db.php');
?>
<!--  -->

<?php
// Pagination variables
$limit = 8; // Number of records per page
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page number

// Calculate the offset
$offset = ($page - 1) * $limit;

// Query to fetch records with LIMIT and OFFSET
$sql = "SELECT * FROM `post` ORDER BY `created_date` DESC LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();

$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Query to count total records
$countSql = "SELECT COUNT(*) AS total FROM `post`";
$countStmt = $pdo->query($countSql);
$total_records = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];

// Calculate total pages
$total_pages = ceil($total_records / $limit);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

    <?php require('common/header.php') ?>

    <div class="container mt-4">
        <h2>Posts List</h2>
        <?php if ($posts) : ?>
            <div class="row">
                    <?php foreach ($posts as $row) : ?>
                        <div class="col-3">
                        <div class="card mt-3" style="width: 18rem;">
                            <img width="1000px" height="200px" src="images/<?php echo $row['image']; ?>" class="card-img-top" alt="Image">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['title']; ?></h5>
                                <p class="card-text"><?php echo substr($row['content'], 0, 50); ?>...</p>
                                <a href="posts/view.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Read more</a>
                            </div>
                        </div>
                        </div>
                    <?php endforeach; ?>
                
            </div>
        <?php else : ?>
            <p>No records found.</p>
        <?php endif; ?>

        <!-- Pagination -->
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

    <?php require('common/footer.php') ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>


