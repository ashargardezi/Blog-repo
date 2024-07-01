<?php require('../common/config.php'); ?>
<?php require('../common/header.php'); ?>
<?php require('../common/db.php'); ?>

<?php
// session_start(); // Start the session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = trim($_POST['password']);
    $pass_hash = md5($password);

    $sql = "SELECT * FROM _user WHERE email = :email and password_hash = :pass_hash";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':pass_hash', $pass_hash);

    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['first_name'] = $user['first_name'];
         
        // Redirect to posts page after successful login
        header("Location: " . BASE_URL . "/posts/index.php");
        exit();
    } else {
        $error = "Invalid email or password";
    }
}

// Check if user is logged in


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Login</h5>
                        <form action="login.php" method="post">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                        <?php if (isset($error)) : ?>
                            <div class="alert alert-danger mt-3" role="alert"><?php echo $error; ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="mt-3 text-center">
                    <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
                </div>
            </div>
        </div>
    </div>

    <?php if(isset($posts) && !empty($posts)) : ?>
    <div class="container mt-5">
        <h3>Your Posts</h3>
        <div class="row">
            <?php foreach($posts as $post) : ?>
            <div class="col-md-4">
                <div class="card">
                    <img src="<?php echo $post['image']; ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $post['title']; ?></h5>
                        <p class="card-text"><?php echo $post['content']; ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
