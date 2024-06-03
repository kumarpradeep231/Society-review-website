<?php
include 'components/connection.php';

if (isset($_GET['get_id'])) {
    $get_id = $_GET['get_id'];
} else {
    $get_id = '';
    header('location: all_posts.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>View Post</title>
    <style>


    </style>
</head>

<body
    style="background-image: url('home-1622401_1280.jpg'); background-repeat: no-repeat; background-attachment: fixed; background-size: cover;  ">
    <?php include 'components/header.php'; ?>


    <!-- -----------------------------------------------section--------------------------------- -->
    <section class="view-post" style="font-family: Arial, sans-serif; padding: 20px;">
        <h1 style="color: #333; margin-bottom: 20px; text-align: center; font-size: 20px;">Post Details</h1>
        <div style="display: flex; justify-content: center; margin-bottom: 20px;">
            <a href="all_posts.php"
                style="font-size: 20px; text-decoration: none; padding: 10px 20px; background-color: #f2f2f2; color: #333; border-radius: 4px; font-weight: bold; text-align: center;">All
                Posts</a>
        </div>>
        <?php
        $select_post = $conn->prepare("SELECT * FROM houses WHERE id = ? LIMIT 1");
        $select_post->execute([$get_id]);
        if ($select_post->rowCount() > 0) {
            while ($fetch_post = $select_post->fetch(PDO::FETCH_ASSOC)) {
                $total_ratings = 0;
                $rating_1 = 0;
                $rating_2 = 0;
                $rating_3 = 0;
                $rating_4 = 0;
                $rating_5 = 0;
                $select_ratings = $conn->prepare("SELECT * FROM reviews WHERE post_id = ?");
                $select_ratings->execute([$fetch_post['id']]);
                $total_reviews = $select_ratings->rowCount();
                while ($fetch_rating = $select_ratings->fetch(PDO::FETCH_ASSOC)) {
                    $total_ratings += $fetch_rating['rating'];

                    if ($fetch_rating['rating'] == 1) {
                        $rating_1 += 1;
                    }
                    if ($fetch_rating['rating'] == 2) {
                        $rating_2 += 1;
                    }
                    if ($fetch_rating['rating'] == 3) {
                        $rating_3 += 1;
                    }
                    if ($fetch_rating['rating'] == 4) {
                        $rating_4 += 1;
                    }
                    if ($fetch_rating['rating'] == 5) {
                        $rating_5 += 1;
                    }
                }
                if ($total_reviews != 0) {
                    $average = round($total_ratings / $total_reviews, 1);
                } else {
                    $average = 0;
                }
                ?>
                <div class="row" style="display: flex; flex-wrap: wrap;">

                    <div class="col" style="flex: 1; margin-right: 20px;">
                        <img src="uploaded_file/<?= $fetch_post['image']; ?>" class="image"
                            style="max-width: 100%; height: auto;">
                        <div style="padding-left: 10px;"> <!-- Add this div to align details with the name -->
                            <h3 class="title" style="margin-top: 20px; font-size: 24px; color: #333;">
                                <?= $fetch_post['name']; ?>
                            </h3>
                            <p class="highlighted-section" style="margin-top: 10px; font-size: 16px; color: #333;">
                                <span class="highlighted-title"
                                    style="font-weight: bold; margin-right: 5px; background-color: yellow;">Rent:</span>
                                <?= $fetch_post['rent']; ?>
                            </p>
                            <p class="highlighted-section" style="margin-top: 10px; font-size: 16px; color: #333;">
                                <span class="highlighted-title"
                                    style="font-weight: bold; margin-right: 5px; background-color: yellow;">Locality:</span>
                                <?= $fetch_post['locality']; ?>
                            </p>
                            <p style="font-size: 16px; color: #333; margin-top: 10px;">Location:
                                <?= $fetch_post['location']; ?>
                            </p>
                            <p class="highlighted-section" style="margin-top: 20px; font-size: 18px; color: #333;">
                                <span class="highlighted-title"
                                    style="font-weight: bold; margin-right: 5px; background-color: lightblue; padding: 5px; border-radius: 10px;">Facilities:</span>
                                <?= $fetch_post['facilities']; ?>
                            </p>
                            <p class="highlighted-section" style="margin-top: 20px; font-size: 18px; color: #333;">
                                <span class="highlighted-title"
                                    style="font-weight: bold; margin-right: 5px; background-color: lightgreen; padding: 5px; border-radius: 10px;">Connectivity:</span>
                                <?= $fetch_post['connectivity']; ?>
                            </p>
                            <!--<a href="<?= $fetch_post['video']; ?>" target="_blank"-->
                            <!--    style="display: inline-block; margin-top: 10px; padding: 10px 20px; background-color: #f2f2f2; color: #333; text-decoration: none; border-radius: 4px;">Watch-->
                            <!--    Video</a>-->

                            <!-- <a href="uploaded_file/<?= $fetch_post['video']; ?>" target="_blank" style="display: inline-block; margin-top: 10px; padding: 10px 20px; background-color: #f2f2f2; color: #333; text-decoration: none; border-radius: 4px;">Watch Video</a> -->

                        </div>
                    </div>
                    <div class="col" style="flex: 1;">
                        <div class="flex"
                            style="display: flex; justify-content: center; flex-direction: column; align-items: center;">
                            <div class="total-reviews" style="text-align: center;">
                                <h3 style="font-size: 36px; color: #333; margin: 0;">
                                    <?= $average; ?><i class="fas fa-star" style="color: gold;"></i>
                                </h3>
                                <p style="font-size: 16px; color: #666; margin: 0;">
                                    <?= $total_reviews ?>
                                </p>
                            </div>
                            <div class="total-ratings" style="margin: 20px 0;">
                                <p>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <span>
                                        <?= $rating_5; ?>
                                    </span>
                                </p>
                                <p>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <span>
                                        <?= $rating_4; ?>
                                    </span>
                                </p>
                                <p>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <span>
                                        <?= $rating_3; ?>
                                    </span>
                                </p>
                                <p>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <span>
                                        <?= $rating_2; ?>
                                    </span>
                                </p>
                                <p>
                                    <i class="fas fa-star"></i>
                                    <span>
                                        <?= $rating_1; ?>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo '<p class="empty" style="font-size: 18px; color: #666;">No posts added yet!</p>';
        }
        ?>
    </section>





    <!-- ----------------------------------------Review--------------- -->




    <section class="reviews-container">
        <div class="heading">
            <h1 style="color: white">User's Reviews</h1>
            <a href="add_review.php?get_id=<?= $get_id; ?>" style="margin-top: .5rem;" class="btn">Add Review</a>
        </div>
        <div class="box-container">
            <?php
            $select_reviews = $conn->prepare("SELECT * FROM reviews WHERE post_id = ?");
            $select_reviews->execute([$get_id]);
            if ($select_reviews->rowCount() > 0) {
                while ($fetch_review = $select_reviews->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <div class="box" <?php if ($fetch_review['user_id'] == $user_id) {
                        echo 'style="order:-1"';
                    } ?>>
                        <?php
                        $select_user = $conn->prepare("SELECT * FROM users WHERE id=?");
                        $select_user->execute([$fetch_review['user_id']]);
                        while ($fetch_user = $select_user->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <div class="user">
                                <?php if ($fetch_user['image'] != "") { ?>
                                    <img src="uploaded_file/<?= $fetch_user['image']; ?>">
                                <?php } else { ?>
                                    <h3>
                                        <?= substr($fetch_user['name'], 0, 1); ?>
                                    </h3>
                                <?php } ?>
                                <div>
                                    <p>
                                        <?= $fetch_user['name']; ?>
                                    </p>
                                   <span><?= $fetch_review['created_at']; ?></span>



                                </div>
                            </div>
                        <?php } ?>

                        <h3 class="title">
                            <?= $fetch_review['title']; ?>
                        </h3>
                        <?php if ($fetch_review['description'] != '') { ?>
                            <p class="description">
                                <?= $fetch_review['description']; ?>
                            </p>
                        <?php } ?>

                        <?php if ($fetch_review['user_id'] == $user_id) { ?>
                            <form action="" method="post" class="flex-btn">
                                <input type="hidden" name="delete_id" value="<?= $fetch_review['id']; ?>">
                                <a href="update_review.php?get_id=<?= $fetch_review['id']; ?>" class="btn">Edit Review</a>
                                <input type="submit" name="delete_review" value="Delete Review" class="delete-btn"
                                    onclick="return confirm('Delete this review?');">
                            </form>
                        <?php } ?>

                        <h2>Facilities Rating: </h2>
                        <div class="ratings" style="text-align:right;">
                            <?php generateStarRatings($fetch_review['facilities_review']); ?>
                        </div>
                        <p class="description">
                            <?= $fetch_review['facilities_review']; ?><i class="fas fa-star"></i>
                        </p>
                        <h2>Connectivity Rating: </h2>
                        <div class="ratings" style="text-align:right;">
                            <?php generateStarRatings($fetch_review['connectivity_review']); ?>
                        </div>
                        <p class="description">
                            <?= $fetch_review['connectivity_review']; ?><i class="fas fa-star"></i>
                        </p>
                    </div>


                    <div class="facilities-review">
                        <span class="highlighted-title" style="font-size: 16px;">Facilities:</span>

                        <?php
                        $facilitiesTags = array(
                            'air_conditioning_review' => array('Air Conditioning', 'blue'),
                            'balcony_review' => array('Balcony', 'blue'),
                            'garden_review' => array('Garden', 'blue'),
                            'parking_review' => array('Parking', 'blue'),
                            'swimming_pool_review' => array('Swimming Pool', 'blue'),
                            'hospital_nearby_review' => array('Hospital Nearby', 'blue'),
                            'power_backup_review' => array('Power Backup', 'blue'),
                            'lift_review' => array('Lift', 'blue'),
                            'water_review' => array('Water', 'blue')
                        );

                        foreach ($facilitiesTags as $column => $tagData) {
                            if ($fetch_review[$column] == 1) {
                                echo '<span class="tag tag-facilities" style="background-color: ' . $tagData[1] . '; color: white; font-size: 14px; margin-right: 5px; padding: 5px 10px; border-radius: 10px; font-weight: bold;">' . $tagData[0] . '</span>';
                            }
                        }
                        ?>
                        <!-- <i class="fas fa-star" style="color: gold; font-size: 16px;"></i> -->
                    </div>

                    <div class="connectivity-review">
                        <span class="highlighted-title" style="font-size: 16px;">Connectivity:</span>

                        <?php
                        $connectivityTags = array(
                            'airport_review' => array('Airport', 'yellow'),
                            'railways_review' => array('Railways', 'yellow'),
                            'bus_stand_review' => array('Bus Stand', 'yellow'),
                            'metro_station_review' => array('Metro Station', 'yellow'),
                            'highway_review' => array('Highway', 'yellow')
                        );

                        foreach ($connectivityTags as $column => $tagData) {
                            if ($fetch_review[$column] == 1) {
                                echo '<span class="tag tag-connectivity" style="background-color: ' . $tagData[1] . '; color: #333; font-size: 14px; margin-right: 5px; padding: 5px 10px; border-radius: 10px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);">' . $tagData[0] . '</span>';
                            }
                        }
                        ?>
                        <!-- <i class="fas fa-star" style="color: gold; font-size: 16px;"></i> -->
                    </div>




                    <?php
                }
            } else {
                echo '<p class="empty">No reviews added yet!</p>';
            }
            ?>
        </div>
    </section>
    <?php
    function generateStarRatings($rating)
    {
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $rating) {
                echo '<i class="fas fa-star"></i>';
            } else {
                echo '<i class="far fa-star"></i>';
            }
        }
    }

    ?>




    <!-- sweetalert cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- custom js link -->
    <script type="text/javascript" src="js/script.js"></script>

    <?php include "components/alert.php"; ?>
</body>

</html>