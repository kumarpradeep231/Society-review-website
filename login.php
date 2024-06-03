<?php
    include 'components/connection.php';

    if (isset($_POST['submit'])) {
        session_start();
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);

        

        $pass = $_POST['pass'];
        $pass = filter_var($pass, FILTER_SANITIZE_STRING);

        $verify_email = $conn->prepare("SELECT * FROM `users` WHERE email = ? LIMIT 1");
        $verify_email->execute([$email]);

        if ($verify_email->rowCount() > 0) {
            $fetch = $verify_email->fetch(PDO::FETCH_ASSOC);
            $verify_pass = password_verify($pass, $fetch['password']);
            if($verify_pass == 1){
                setcookie('user_id', $fetch['id'], time() + 60*60*24*30, '/');
                header('location:all_posts.php');
            } else {
                $warning_msg[] = 'Incorrect Password';
            }
        } else {
            $warning_msg[] = 'Incorrect email!';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
    
    <title>Login</title>
</head>
<body>
    <?php include 'components/header.php'; ?>

    <section class="account-form">
        <h3 class="heading">Login to Your Account</h3>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="input-field">
                <p class="placeholder">Your Email <span>*</span></p>
                <input type="email" name="email" placeholder="Enter your Email" class="box" required maxlength="50">
            </div>
            <div class="input-field">
                <p class="placeholder">Your Password <span>*</span></p>
                <input type="password" name="pass" placeholder="Enter your password" class="box" required maxlength="50">
            </div>
            <input type="submit" name="submit" value="Login Now" class="btn">
            <p class="link">Don't have an account? <a href="register.php">Register Now</a></p>
        </form>
    </section>

    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
    <script type="text/javascript" src="js/script.js"></script>

    <?php
    if (isset($success_msg)) {
        echo '<script>Swal.fire("' . $success_msg[0] . '", "", "success");</script>';
    }

    if (isset($warning_msg)) {
        echo '<script>Swal.fire("' . $warning_msg[0] . '", "", "warning");</script>';
    }

    if (isset($error_msg)) {
        echo '<script>Swal.fire("' . $error_msg[0] . '", "", "error");</script>';
    }
?>
</body>
</html>

