
<?php
    include 'components/connection.php';

    error_reporting(E_ALL);
    ini_set('display_errors', 1);



        // -------------------------------------------------------

    if (isset($_POST['submit'])) {
        $id = create_unique_id();
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);

        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);

        $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
        $pass = filter_var($pass, FILTER_SANITIZE_STRING);

        $cpass = password_verify($_POST['cpass'], $pass);
        $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

        $image = $_FILES['image']['name'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);
        $ext = pathinfo($image, PATHINFO_EXTENSION);
        $rename = create_unique_id() . '.' . $ext;
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = 'uploaded_file/' . $image;

        if (!empty($image)) {
            if ($image_size > 2000000) {
                $warning_msg[] = 'Please reduce your image size';
            } else {
                move_uploaded_file($image_tmp_name, $image_folder);
            }
        } else {
            $rename = '';
        }

        $verify_email = $conn->prepare("SELECT COUNT(*) FROM `users` WHERE email = ?");
        $verify_email->execute([$email]);

        if ($verify_email->fetchColumn()) {
            $warning_msg[] = 'Email Already Exists';
        } else {
            if ($cpass == 1) {
                $insert_user = $conn->prepare("INSERT INTO `users` (id, name, email, password, image) VALUES (?, ?, ?, ?, ?)");
                $insert_user->execute([$id, $name, $email, $pass, $image]);
                $success_msg[] = 'Registered Successfully';
            } else {
                $warning_msg[] = 'Confirm password does not match';
            }
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
    
    <title>Register Your Profile</title>
    
     <style>
        
    </style>
</head>
<body>


    <?php include 'components/header.php'; ?>

    <section class="account-form">
        <!-- <img src="image/9.png" class="img"  alt="">
        <img src="image/8.png" class="img1"  alt=""> -->
        <h3 class="heading">Make Your Account Here</h3>
        <form action="" method = "post" enctype="multipart/form-data">
            <div class="input-field">
                <p class="placeholder">Your Name <span>*<span></p>
                <input type="text" name="name" id="" placeholder="Enter your name" class="box" required maxlength = "50">
            </div>
            <div class="input-field">
                <p class="placeholder">Your Email <span>*<span></p>
                <input type="email" name="email" id="" placeholder="Enter your Email" class="box" required maxlength = "50">
            </div>
            <div class="input-field">
                <p class="placeholder">Your Password <span>*<span></p>
                <input type="password" name="pass" id="" placeholder="Enter your password" class="box" required maxlength = "50">
            </div>
            <div class="input-field">
                <p class="placeholder">Confirm Your Password <span>*<span></p>
                <input type="password" name="cpass" id="" placeholder="Confirm your password" class="box" required maxlength = "50">
            </div>
            <div class="input-field">
                <p class="placeholder">Choose Your Profile Pic<span>*<span></p>
                <input type="file" name="image" accept="image/*" class="box" required maxlength = "50">
            </div>

            <input type="submit" name="submit" value="Register Now" class="btn">
            <pc class="link">Alredy have account ? <a href="login.php">Login Now</a> </p>
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

      <!-- SweetAlert JS -->
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
    <script type="text/javascript" src="js/script.js"></script>

   



    


</body>
</html>