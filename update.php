<?php
include 'components/connection.php';

if (isset($_POST['submit'])) {
    $select_user = $conn->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
    $select_user->execute([$user_id]);

    $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);

    if (!empty($name)) {
        $update_name = $conn->prepare("UPDATE users SET name = ? WHERE id = ?");
        $update_name->execute([$name, $user_id]);
        $success_msg[] = 'User name updated';
    }

    if (!empty($email)) {
        $verify_email = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $verify_email->execute([$email]);

        if ($verify_email->rowCount() > 0) {
            $warning_msg[] = 'Email already taken';
        } else {
            $update_email = $conn->prepare("UPDATE users SET email = ? WHERE id = ?");
            $update_email->execute([$email, $user_id]);
            $success_msg[] = 'User email updated';
        }
    }

    // Update image
    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $ext = pathinfo($image, PATHINFO_EXTENSION);
    $rename = create_unique_id() . '.' . $ext;
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded file/' . $rename;

    if (!empty($image)) {
        if ($image_size > 2000000) {
            $warning_msg[] = 'Image size is too large';
        } else {
            $update_image = $conn->prepare("UPDATE users SET image = ? WHERE id = ?");
            $update_image->execute([$rename, $user_id]);
            move_uploaded_file($image_tmp_name, $image_folder);
            if ($fetch_user['image'] != '') {
                unlink('uploaded_file/' . $fetch_user['image']);
            }
            $success_msg[] = 'Profile image updated successfully';
        }
    }

    $prev_pass = $fetch_user['password'];

    $old_pass = password_hash($_POST['old_pass'], PASSWORD_DEFAULT);
    $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);

    $empty_old = password_verify('', $old_pass);

    $new_pass = password_hash($_POST['new_pass'], PASSWORD_DEFAULT);
    $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);

    $empty_new = password_verify('', $new_pass);

    $c_pass = password_verify($_POST['cpass'], $new_pass);
    $c_pass = filter_var($c_pass, FILTER_SANITIZE_STRING);

    if ($empty_old != 1) {
        $verify_old_pass = password_verify($_POST['old_pass'], $prev_pass);
        if ($verify_old_pass == 1) {
            if ($c_pass == 1) {
                if ($empty_new != 1) {
                    $update_pass = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
                    $update_pass->execute([$new_pass, $user_id]);
                    $success_msg[] = 'Password updated successfully';
                } else {
                    $warning_msg[] = 'Please enter a new password';
                }
            } else {
                $warning_msg[] = 'Confirm password does not match';
            }
        } else {
            $warning_msg[] = 'Old password does not match';
        }
    }

}

// Delete profile picture
if (isset($_POST['delete_image'])) {
    $select_old_pic = $conn->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
    $select_old_pic->execute([$user_id]);
    $fetch_old_pic = $select_old_pic->fetch(PDO::FETCH_ASSOC);

    if ($fetch_old_pic['image'] == '') {
        $warning_msg[] = 'Image already deleted';
    } else {
        $update_old_pic = $conn->prepare("UPDATE users SET image = ? WHERE id = ?");
        $update_old_pic->execute(['', $user_id]);
        if ($fetch_old_pic['image'] != '') {
            unlink('uploaded_file/' . $fetch_old_pic['image']);
        }
        $success_msg[] = 'Image deleted successfully!';
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

    <title>Update Your Profile</title>
</head>

<body>
    <?php include 'components/header.php'; ?>

    <section class="account-form">
        <img src="image/9.png" class="img" alt="">
        <img src="image/8.png" class="img1" alt="">
        <h3 class="heading">Modify Your Account Details</h3>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="input-field">
                <p class="placeholder">Your Name <span>*</span></p>
                <input type="text" name="name" id="" placeholder="<?= $fetch_profile['name']; ?>" class="box" maxlength="50">
            </div>
            <div class="input-field">
                <p class="placeholder">Your Email <span>*</span></p>
                <input type="email" name="email" id="" placeholder="<?= $fetch_profile['email']; ?>" class="box" maxlength="50">
            </div>
            <div class="input-field">
                <p class="placeholder">Old Password <span>*</span></p>
                <input type="password" name="old_pass" id="" placeholder="Enter your old password" class="box" maxlength="50">
            </div>
            <div class="input-field">
                <p class="placeholder">New Password <span>*</span></p>
                <input type="password" name="new_pass" id="" placeholder="Enter your new password" class="box" maxlength="50">
            </div>
            <div class="input-field">
                <p class="placeholder">Confirm Password <span>*</span></p>
                <input type="password" name="cpass" id="" placeholder="Confirm your password" class="box" maxlength="50">
            </div>
            <?php if ($fetch_profile['image'] != '') { ?>
                <img src="uploaded_file/<?= $fetch_profile['image']; ?>" class="image">
                <input type="submit" name="delete_image" class="delete-btn" onclick="return confirm('Delete this image?');" value="Delete Profile">
            <?php } ?>

            <div class="input-field">
                <p class="placeholder">Choose Your Profile Pic<span>*</span></p>
                <input type="file" name="image" accept="image/*" class="box" required maxlength="50">
            </div>

            <input type="submit" name="submit" value="Update Profile" class="btn">
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


