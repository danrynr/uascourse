<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NIX Course | Login</title>
    <link rel="stylesheet" href="./style/style.css">
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php       
        if (isset($_POST['login'])) {
                $username = isset($_POST['username']) ? $_POST['username'] : '';
                $password = isset($_POST['password']) ? $_POST['password'] : '';

            if (empty($username) || empty($password)) {
                $msg = "<script>Swal.fire({
                    title: 'Jangan lupa!',
                    text: 'Username dan Password harus diisi!',
                    icon: 'error',
                    timer: 1500,
                    confirmButtonText: 'Oke'
                  });</script>";
            } else {
                include 'config.php';
                $queryCheck = "SELECT pass_hash FROM usercre where username = '$username'";
                $data = mysqli_query($conn, $queryCheck) or die ('Error, query failed ' . mysqli_error($conn));
                $output = mysqli_fetch_array($data);
                
                if (password_verify($password, $output['pass_hash'])) {
                    session_start();
                    $_SESSION['username'] = $username;
                    mysqli_close($conn);
                    header("location:index.php");
                    exit;
                } else {
                    mysqli_close($conn);
                    $msg = "<script>Swal.fire({
                        title: 'Oops...',
                        text: 'Username atau Password salah!',
                        icon: 'error',
                        timer: 1500,
                        confirmButtonText: 'Oke'
                      });</script>";
                }
            }
        }
    ?>

    <header class="shadow"> 
        <div class="container">
            <h1>NIX Course</h1>
        </div>

        <div class="container2">
            <nav>
                <ul>
                    <li><a href="signup.php">Signup</a></li>
                    <li><a href="login.php">Login</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="card shadow">
        <h2>Login</h2>
        <form action="<?php $_SERVER["PHP_SELF"]?>" method="post">
            <p class="warning"><?php if (isset($msg)) { echo $msg; }; ?></p>
            <label for="username">Username</label><br>
            <input type="text" name="username"><br>
            <label for="password">Password</label><br>
            <input type="password" name="password"><br>
            <button name="login" value="Login">Login</button>
            <p>Sudah memiliki akun? Silakan <a class="btn" href="./signup.php">Daftar</a></p>
        </form>
    </div>
</body>
</html>