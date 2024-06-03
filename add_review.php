<?php
include 'components/connection.php';

if (isset($_GET['get_id'])) {
    $get_id = $_GET['get_id'];
} else {
    $get_id = '';
    header('location: all_posts.php');
}

if (isset($_POST['submit'])) {
    if ($user_id != '') {
        $id = create_unique_id();
        $title = $_POST['title'];
        $title = filter_var($title, FILTER_SANITIZE_STRING);
        $description = $_POST['description'];
        $description = filter_var($description, FILTER_SANITIZE_STRING);
        $facilities_review = $_POST['facilities_review'] ?? 0;
        $connectivity_review = $_POST['connectivity_review'] ?? 0;
        $rating = $_POST['rating'];
        $rating = filter_var($rating, FILTER_SANITIZE_STRING);
        $air_conditioning_review = $_POST['air_conditioning_review'] ?? 0;
        $balcony_review = $_POST['balcony_review'] ?? 0;
        $garden_review = $_POST['garden_review'] ?? 0;
        $parking_review = $_POST['parking_review'] ?? 0;
        $swimming_pool_review = $_POST['swimming_pool_review'] ?? 0;
        $hospital_nearby_review = $_POST['hospital_nearby_review'] ?? 0;
        $power_backup_review = $_POST['power_backup_review'] ?? 0;
        $lift_review = $_POST['lift_review'] ?? 0;
        $water_review = $_POST['water_review'] ?? 0;
        $airport_review = $_POST['airport_review'] ?? 0;
        $railways_review = $_POST['railways_review'] ?? 0;
        $bus_stand_review = $_POST['bus_stand_review'] ?? 0;
        $metro_station_review = $_POST['metro_station_review'] ?? 0;
        $highway_review = $_POST['highway_review'] ?? 0;

        $verify_rating = $conn->prepare("SELECT * FROM `reviews` WHERE post_id = ? AND user_id = ?");
        $verify_rating->execute([$get_id, $user_id]);

        if ($verify_rating->rowCount() > 0) {
            $warning_msg[] = 'Your review already added!';
        } else {
            $add_review = $conn->prepare("INSERT INTO `reviews` (id, post_id, user_id, rating, title, description, facilities_review, connectivity_review, air_conditioning_review, balcony_review, garden_review, parking_review, swimming_pool_review, hospital_nearby_review, power_backup_review, lift_review, water_review, airport_review, railways_review, bus_stand_review, metro_station_review, highway_review) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $add_review->execute([$id, $get_id, $user_id, $rating, $title, $description, $facilities_review, $connectivity_review, $air_conditioning_review, $balcony_review, $garden_review, $parking_review, $swimming_pool_review, $hospital_nearby_review, $power_backup_review, $lift_review, $water_review, $airport_review, $railways_review, $bus_stand_review, $metro_station_review, $highway_review]);

            $success_msg[] = 'Review added';
        }
    } else {
        $warning_msg[] = "Please login first";
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

    <title>Add your Reviews page</title>
    <Style>
        .rating-stars {
                display: inline-block;
                unicode-bidi: bidi-override;
                direction: rtl;
            }

            .rating-stars input[type="radio"] {
                display: none;
            }

            .rating-stars label {
                display: inline-block;
                position: relative;
                width: 24px;
                height: 24px;
                margin: 0;
                padding: 0;
                cursor: pointer;
            }

            .rating-stars label::before {
                content: '\2605';
                position: absolute;
                font-size: 24px;
                color: #ddd;
            }

            .rating-stars label::after {
                content: '\2605';
                position: absolute;
                font-size: 24px;
                color: #ffdf00;
                opacity: 0;
                transition: opacity 0.2s linear;
            }

            .rating-stars input[type="radio"]:checked ~ label::after,
            .rating-stars input[type="radio"]:hover ~ label::after {
                opacity: 1;
            }

    </Style>
</head>
<body>
    <?php include 'components/header.php'; ?>

    <section class="account-form">
        <h3 class="heading">Post Your Review</h3>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="input-field">
                <p class="placeholder">Review Title <span>*</span></p>
                <input type="text" name="title" required maxlength="50" placeholder="Enter review title" class="box">
            </div>
            <div class="input-field">
                <p class="placeholder">Review Description <span>*</span></p>
                <textarea name="description" class="box" placeholder="Enter review description" maxlength="100" cols="30" rows="10"></textarea>
            </div>

            <!-- Star Ratings for Connectivity and Facilities -->
            <div class="input-field">
                <p class="placeholder">Connectivity Review</p>
                <div class="rating-stars">
                    <input type="radio" id="connectivity_star5" name="connectivity_review" value="5" />
                    <label for="connectivity_star5"></label>
                    <input type="radio" id="connectivity_star4" name="connectivity_review" value="4" />
                    <label for="connectivity_star4"></label>
                    <input type="radio" id="connectivity_star3" name="connectivity_review" value="3" />
                    <label for="connectivity_star3"></label>
                    <input type="radio" id="connectivity_star2" name="connectivity_review" value="2" />
                    <label for="connectivity_star2"></label>
                    <input type="radio" id="connectivity_star1" name="connectivity_review" value="1" />
                    <label for="connectivity_star1"></label>
                </div>
            </div>

            <div class="input-field">
                <p class="placeholder">Facilities Review</p>
                <div class="rating-stars">
                    <input type="radio" id="facilities_star5" name="facilities_review" value="5" />
                    <label for="facilities_star5"></label>
                    <input type="radio" id="facilities_star4" name="facilities_review" value="4" />
                    <label for="facilities_star4"></label>
                    <input type="radio" id="facilities_star3" name="facilities_review" value="3" />
                    <label for="facilities_star3"></label>
                    <input type="radio" id="facilities_star2" name="facilities_review" value="2" />
                    <label for="facilities_star2"></label>
                    <input type="radio" id="facilities_star1" name="facilities_review" value="1" />
                    <label for="facilities_star1"></label>
                </div>
            </div>

            <!-- Additional checkboxes for features -->
            <div class="input-field">
                <p class="placeholder">Air Conditioning</p>
                <input type="checkbox" name="air_conditioning_review" value="1"> Present
            </div>
            <div class="input-field">
                <p class="placeholder">Balcony</p>
                <input type="checkbox" name="balcony_review" value="1"> Present
            </div>
            <div class="input-field">
                <p class="placeholder">Garden</p>
                <input type="checkbox" name="garden_review" value="1"> Present
                </div>
            <div class="input-field">
                <p class="placeholder">Parking</p>
                <input type="checkbox" name="parking_review" value="1"> Present
            </div>
            <div class="input-field">
                <p class="placeholder">Swimming Pool</p>
                <input type="checkbox" name="swimming_pool_review" value="1"> Present
            </div>
            <div class="input-field">
                <p class="placeholder">Hospital Nearby</p>
                <input type="checkbox" name="hospital_nearby_review" value="1"> Present
            </div>
            <div class="input-field">
                <p class="placeholder">Power Backup</p>
                <input type="checkbox" name="power_backup_review" value="1"> Present
            </div>
            <div class="input-field">
                <p class="placeholder">Lift</p>
                <input type="checkbox" name="lift_review" value="1"> Present
            </div>
            <div class="input-field">
                <p class="placeholder">Water (24x7)</p>
                <input type="checkbox" name="water_review" value="1"> Present
            </div>
            <div class="input-field">
                <p class="placeholder">Airport Nearby</p>
                <input type="checkbox" name="airport_review" value="1"> Present
            </div>
            <div class="input-field">
                <p class="placeholder">Railways Nearby</p>
                <input type="checkbox" name="railways_review" value="1"> Present
            </div>
            <div class="input-field">
                <p class="placeholder">Bus Stand Nearby</p>
                <input type="checkbox" name="bus_stand_review" value="1"> Present
            </div>
            <div class="input-field">
                <p class="placeholder">Metro Station</p>
                <input type="checkbox" name="metro_station_review" value="1"> Present
            </div>
            <div class="input-field">
                <p class="placeholder">Highway</p>
                <input type="checkbox" name="highway_review" value="1"> Present
            </div>

            <div class="input-field">
                <p class="placeholder">Overall Rating</p>
                <select name="rating" class="box" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>

            <div class="flex-btn">
                <input type="submit" name="submit" value="Submit Review" class="btn" style="width: 30%;">
                <a href="view_post.php?get_id=<?= $get_id; ?>" class="delete-btn" style="width: 50%;">Go Back</a>
            </div>
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
    ?>
</body>

</html>


