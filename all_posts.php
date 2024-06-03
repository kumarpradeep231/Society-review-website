<?php
    include 'components/connection.php';
?>
<style type="text/css">
    <?php include 'style.css'; ?>
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Posts</title>
    <!-- <link rel="stylesheet" type="text/css" href="style.css"> -->
    <style>

        body {
            background: url('building-7077718_1280.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        
        .locality-tag {
            display: inline-block;
            background-color: #f4d03f;
            color: #fff;
            padding: 8px 12px;
            border-radius: 20px;
            font-size: 16px;
            font-weight: bold;
            margin: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }
        .tag {
            display: inline-block;
            background-color: #3498db;
            color: #fff;
            padding: 8px 12px;
            border-radius: 20px;
            font-size: 16px;
            font-weight: bold;
            margin: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        .facilities-tags,
        .connectivity-tags {
        margin-top: 10px;
        }

        .facility-tag,
        .connectivity-tag {
        display: inline-block;
        background-color: #3498db;
        color: #fff;
        padding: 8px 12px;
        border-radius: 20px;
        font-size: 16px;
        font-weight: bold;
        margin-right: 5px;
        margin-bottom: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }


       
    </style>
    </style>

    </style>
    
</head>
<body>
    <?php include 'components/header.php'; ?>
    <section class="all_posts">
        <h1 class="heading"><span style="color: white; font-weight: bold;">All Posts</span></h1>

        <!-- <h1 class="heading"><span style="color: white; font-weight: bold;">All Posts</span></h1> -->
        <div class="box-container">
            <?php
                $select_posts = $conn->prepare("SELECT * FROM houses");
                $select_posts->execute();
                if ($select_posts->rowCount() > 0) {
                    while ($fetch_post = $select_posts->fetch(PDO::FETCH_ASSOC)) {
                        $post_id = $fetch_post['id'];
                        $count_reviews = $conn->prepare("SELECT * FROM reviews WHERE post_id = ?");
                        $count_reviews->execute([$post_id]);
                        $total_reviews = $count_reviews->rowCount();
                        $total_reviews = $count_reviews->rowCount();
                        $facilities = explode(",", $fetch_post['facilities']);
                        $connectivity = explode(",", $fetch_post['connectivity']);
            ?>
            <div class="box">
                <img src="uploaded_file/<?= $fetch_post['image']; ?>" class="image">
                <h3 class="title"><?= $fetch_post['name']; ?></h3>
                <p class="locality-tag"><?= $fetch_post['locality']; ?></p>
                <div class="facilities-tags">
                    <?php foreach ($facilities as $facility) { ?>
                        <span class="facility-tag"><?= $facility; ?></span>
                    <?php } ?>
                </div>
                <div class="connectivity-tags">
                    <?php foreach ($connectivity as $connect) { ?>
                        <span class="connectivity-tag"><?= $connect; ?></span>
                    <?php } ?>
                </div>


                <p class="total-reviews"><i class="fas fa-star"></i><span><?= $total_reviews; ?></span></p>
                <a href="view_post.php?get_id=<?= $post_id; ?>" class="btn">View Post</a>
            </div>
            <?php
                    }
                } else {
                    echo '<p class="empty">No posts added yet!</p>';
                }
            ?>
        </div>
    </section>
    <script type="text/javascript" src="js/script.js"></script>
</body>
</html>
