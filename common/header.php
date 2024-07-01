<header>
        <nav class="navbar navbar-expand-lg bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand" href="<?php echo BASE_URL; ?>/">My Blog</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="<?php echo BASE_URL; ?>/auth/login.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="<?php echo BASE_URL; ?>/posts/index.php">User data</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link">Posts</a>
                        </li> -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Posts
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>./index.php">All posts</a></li>
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>./posts/create.php">Create Posts</a></li>
                            </ul>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>../users/index.php">Users</a>
                        </li> -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>./posts/bulkpost.php">Bulk Posts</a>
                        </li>
        
                    </ul>
                </div>
                <?php if(isset($_SESSION['user_id'])){ ?>
                <a style="float:right;"><?php echo $_SESSION['first_name']; ?></a>
                <br>
                <a href="<?php echo BASE_URL; ?>/auth/logout.php" style="float:right; color:red; margin-left:10px;"> Logout </a>
                <?php } ?> 
            </div>
        </nav>
    </header>
