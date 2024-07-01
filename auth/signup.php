<?php require('../common/config.php'); ?>
<?php require('../common/header.php'); ?>
<?php require('../common/db.php'); ?>
<?php session_start();
// if(!isset($_SESSION['email'])){
//     header("Location:../auth/login.php");
//     exit;
// }?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $user_name = $_POST['user_name'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password_hash = trim($_POST['password']);
    $confirm_password = $_POST['confirmPassword'];
    $errors = [];

    if (empty($user_name)) {
        $errors[] = "User name is required.";
    }

    if (empty($first_name)) {
        $errors[] = "First name is required.";
    }

    if (empty($last_name)) {
        $errors[] = "Last name is required.";
    }

    if (empty($email)) {
        $errors[] = "Email is required.";
    } 

    $sql  = "SELECT * FROM `_user` WHERE `email` = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $errors[] = "User with this email already exists.";
    } else {
        if (empty($password_hash)) {
            $errors[] = "Password is required.";
        }
    }
   



    // if (empty($password_hash)) {
    //     $errors[] = "Password is required.";
    // }

    if ($password_hash !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    // If there are validation errors, display them
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo '<div class="alert alert-danger" role="alert">' . $error . '</div>';
        }
    } else {
        // Encrypt password using MD5
        $password_hash = md5($password_hash);

        $sql = "INSERT INTO _user (username, first_name, last_name, email, password_hash, create_at) 
        VALUES (:user_name, :first_name, :last_name, :email, :password_hash, NOW())";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_name', $user_name);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password_hash', $password_hash);
        $stmt->execute();
        echo "Data inserted successfully.";
        header("Location: " . BASE_URL . "/login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Sign Up</h5>
                        <form action="signup.php" method="post">
                            <div class="mb-3">
                                <label for="user_name" class="form-label">User Name</label>
                                <input type="text" class="form-control" id="user_name" name="user_name" placeholder="user_name" >
                            </div>
                            <div class="mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" required>
                            </div>
                            <div class="mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirmPassword" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
                <div class="mt-3 text-center">
                    <p>Already have an account? <a href="login.php">Login</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>