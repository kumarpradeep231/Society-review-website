<?php
include 'components/connection.php';

if (isset($_POST['add_product'])) {
    $id = create_unique_id();
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $rent = $_POST['rent'];
    $rent = filter_var($rent, FILTER_SANITIZE_STRING);
    $location = $_POST['location'];
    $location = filter_var($location, FILTER_SANITIZE_STRING);
    $locality = $_POST['locality'];
    $locality = filter_var($locality, FILTER_SANITIZE_STRING);
    $city = $_POST['city'];
    $city = filter_var($city, FILTER_SANITIZE_STRING);

    // Process the facilities checkboxes
    $facilities = isset($_POST['facilities']) ? $_POST['facilities'] : array();
    $facilities_string = implode(", ", $facilities);

    // Process the connectivity checkboxes
    $connectivity = isset($_POST['connectivity']) ? $_POST['connectivity'] : array();
    $connectivity_string = implode(", ", $connectivity);

    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $ext = pathinfo($image, PATHINFO_EXTENSION);
    $rename = create_unique_id() . '.' . $ext;
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_file/' . $rename;

    $video = $_FILES['video']['name'];
    $video = filter_var($video, FILTER_SANITIZE_STRING);
    $video_ext = pathinfo($video, PATHINFO_EXTENSION);
    $video_rename = create_unique_id() . '.' . $video_ext;
    $video_size = $_FILES['video']['size'];
    $video_tmp_name = $_FILES['video']['tmp_name'];
    $video_folder = 'uploaded_file/' . $video_rename;

    if ($image_size > 2000000) {
        $warning_msg[] = 'Image size is too large';
    } elseif ($video_size > 10000000) {
        $warning_msg[] = 'Video size is too large. Maximum size allowed is 10MB.';
    } else {
        $insert_product = $conn->prepare("INSERT INTO houses (id, name, rent, location, image, video, locality, city, facilities, connectivity) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insert_product->execute([$id, $name, $rent, $location, $rename, $video_rename, $locality, $city, $facilities_string, $connectivity_string]);
        move_uploaded_file($image_tmp_name, $image_folder);
        move_uploaded_file($video_tmp_name, $video_folder);
        $success_msg[] = 'Property Added Successfully';
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Add Houses</title>

    <style>
        /* AddHouses Form Styles */
        .add-product {
            /* max-width: 600px; */
            margin: 0 auto;
            padding: 20px;
            background-color: #f2f2f2;
            border-radius: 5px;
        }

        .add-product h3 {
            font-size: 20px;
            margin-bottom: 20px;
        }

        .input-field {
            margin-bottom: 20px;
        }

        .input-field p {
            font-size: 16px;
            margin-bottom: 5px;
        }

        .input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .error-msg {
            color: red;
            margin-bottom: 10px;
        }

        .success-msg {
            color: green;
            margin-bottom: 10px;
        }
    </style>

</head>

<body>
    <?php include 'components/header.php'; ?>

    <section class="add-product">

        <h1 style="font-size: 24px; font-weight: bold; text-align: center;">List A Property/Apartments For Review</h1>
        <br>
        <form action="" method="post" enctype="multipart/form-data">

            <h3 style="font-size: 20px;">House Details</h3>
            <div class="input-field">
                <p>House/Property Name <span>*</span></p>
                <input type="text" name="name" required maxlength="50" placeholder="Enter house name" class="input">
            </div>
            <div class="input-field">
                <p>Rent In ₹<span>*</span></p>
                <input type="number" name="rent" required min="0" max="9999999999" class="input">
            </div>
            <div class="input-field">
                <p>Enter Complete address<span>*</span></p>
                <input type="text" name="location" required maxlength="100" placeholder="Enter house location"
                    class="input">
            </div>


            <div class="input-field">
                <p>City <span>*</span></p>
                <select name="city" required class="input">
                    <option value="Mumbai">Mumbai</option>
                </select>
            </div>


            <!-- ---------------------------------------------Locality------------------------ -->
            <div class="input-field">
                <p>Locality <span>*</span></p>
                <select name="locality" required class="input">
                    <option value="">Select Locality</option>
                    <option value="Andheri">Andheri</option>
                    <option value="Bandra">Bandra</option>
                    <option value="Colaba">Colaba</option>
                    <option value="Dadar">Dadar</option>
                    <option value="Goregaon">Goregaon</option>
                    <option value="Juhu">Juhu</option>
                    <option value="Malad">Malad</option>
                    <option value="Powai">Powai</option>
                    <option value="Santacruz">Santacruz</option>
                    <option value="Versova">Versova</option>
                    <option value="Chembur">Chembur</option>
                    <option value="Worli">Worli</option>
                    <option value="Kandivali">Kandivali</option>
                    <option value="Thane">Thane</option>
                    <option value="Navi Mumbai">Navi Mumbai</option>
                    <option value="Vile Parle">Vile Parle</option>
                    <option value="Khar">Khar</option>
                    <option value="Parel">Parel</option>
                    <option value="Mira Road">Mira Road</option>
                    <option value="Borivali">Borivali</option>
                    <option value="Marine Lines">Marine Lines</option>
                    <option value="Wadala">Wadala</option>
                    <option value="Lower Parel">Lower Parel</option>
                    <option value="Sion">Sion</option>
                    <option value="Andheri West">Andheri West</option>
                    <option value="Andheri East">Andheri East</option>
                    <option value="Bandra West">Bandra West</option>
                    <option value="Bandra East">Bandra East</option>
                    <option value="Khar West">Khar West</option>
                    <option value="Khar East">Khar East</option>
                    <option value="Powai">Powai</option>
                    <option value="Goregaon West">Goregaon West</option>
                    <option value="Goregaon East">Goregaon East</option>
                    <option value="Juhu">Juhu</option>
                    <option value="Malad West">Malad West</option>
                    <option value="Malad East">Malad East</option>
                    <option value="Dadar West">Dadar West</option>
                    <option value="Dadar East">Dadar East</option>
                    <option value="Chembur West">Chembur West</option>
                    <option value="Chembur East">Chembur East</option>
                    <option value="Worli">Worli</option>
                    <option value="Thane West">Thane West</option>
                    <option value="Thane East">Thane East</option>
                    <option value="Navi Mumbai">Navi Mumbai</option>
                    <option value="Vashi">Vashi</option>
                    <option value="Airoli">Airoli</option>
                    <option value="Ghansoli">Ghansoli</option>
                </select>
            </div>

            <!-- ------------------------------------------------------------------------------- -->

            <div class="input-field">
                <p>General Facilities <span>*</span></p>
                <div class="checkboxes" style="font-size: 16px;  margin-bottom: 3px; ">
                    <label><input type="checkbox" name="facilities[]" value="Air Conditioning">Air Conditioning</label>
                    <label><input type="checkbox" name="facilities[]" value="Balcony">Balcony</label>
                    <label><input type="checkbox" name="facilities[]" value="Garden">Garden</label>
                    <label><input type="checkbox" name="facilities[]" value="Parking">Parking</label>
                    <label><input type="checkbox" name="facilities[]" value="Swimming Pool">Swimming Pool</label>
                    <label><input type="checkbox" name="facilities[]" value="Hospital">Hospital-Nearby</label>
                    <label><input type="checkbox" name="facilities[]" value="power">Power-Backup</label>
                    <label><input type="checkbox" name="facilities[]" value="water">24*7-Water</label>
                    <!-- Add more facilities checkboxes here -->
                </div>
            </div>


            <div class="input-field">
                <p>Connectivity<span>*</span></p>
                <div class="checkboxes" style="font-size: 16px;  margin-bottom: 3px;>
                    <label><input type=" checkbox" name="connectivity[]" value="Airport">Airport</label>
                    <label><input type="checkbox" name="connectivity[]" value="Railways">Railways</label>
                    <label><input type="checkbox" name="connectivity[]" value="Bus Stand">Bus Stand</label>
                    <label><input type="checkbox" name="connectivity[]" value="Metro Station">Metro Station</label>
                    <label><input type="checkbox" name="connectivity[]" value="Highway">Highway</label>
                    <!-- Add more connectivity checkboxes here -->
                </div>
            </div>





            <div class="input-field">
                <p>House Image <span>*</span></p>
                <input type="file" name="image" required accept="image/*" class="input">
            </div>


            <!--<div class="input-field">-->
            <!--    <p>House Video</p>-->
            <!--    <input type="file" name="video" accept="video/*" class="input">-->
            <!--</div>-->

            <script>
                const fileInputs = document.querySelectorAll('.file-input input');

                fileInputs.forEach(input => {
                    input.addEventListener('change', () => {
                        const fileName = input.files[0] ? input.files[0].name : 'No file chosen';
                        const fileSpan = input.nextElementSibling;
                        fileSpan.textContent = fileName;
                    });
                });
            </script>




            <input type="submit" name="add_product" value="Add House" class="btn">
        </form>
    </section>
    <!-- SweetAlert CDN link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- Custom JS link -->
    <script type="text/javascript" src="js/script.js"></script>

    <?php include "components/alert.php"; ?>
</body>

</html>