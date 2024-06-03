
    

<!-- ----------------------------------------------------------------------------- -->
<?php
include 'components/connection.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the selected criteria from the form
    $locality = $_POST['locality'];
    $facilities = isset($_POST['facilities']) ? $_POST['facilities'] : [];
    $connectivity = isset($_POST['connectivity']) ? $_POST['connectivity'] : [];
    $minRent = $_POST['min_rent'];
    $maxRent = $_POST['max_rent'];

    // Construct the SQL query based on the selected criteria
    $query = "SELECT * FROM houses WHERE 1=1 ";

    // Add conditions based on the selected criteria
    $conditions = [];
    if (!empty($locality)) {
        $conditions[] = "locality = '$locality'";
    }
    if (!empty($facilities)) {
        $facilitiesCondition = implode("', '", $facilities);
        $conditions[] = "facilities IN ('$facilitiesCondition')";
    }
    if (!empty($connectivity)) {
        $connectivityCondition = implode("', '", $connectivity);
        $conditions[] = "connectivity IN ('$connectivityCondition')";
    }
    if (!empty($minRent)) {
        $conditions[] = "rent >= $minRent";
    }
    if (!empty($maxRent)) {
        $conditions[] = "rent <= $maxRent";
    }

    // Append all conditions to the query
    if (!empty($conditions)) {
        $query .= " AND " . implode(" AND ", $conditions);
    }

    // Execute the query
    $result = $conn->query($query);

    // Fetch the matching houses
    $houses = $result->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>House Search</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>

        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap');
        body {
            font-family: 'Roboto', sans-serif;
            font-size: 14px;
            background-image: url('living-room-2155376_1280.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center; /* This will center the image */
        }
        .sidebar {
            float: left;
            width: 25%;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .search-form {
            margin-bottom: 20px;
        }

        .search-form label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .search-form input[type="text"],
        .search-form select,
        .search-form input[type="number"] {
            width: 100%;
            padding: 5px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        .search-form input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        .main-content {
            float: left;
            width: 75%;
            padding: 20px;
        }

        .house-list {
            /* Add your house list styles */
        }

        .house {
            /* Add your house item styles */
        }


        .main-content {
                float: left;
                width: 75%;
                padding: 20px;
            }

            .house-card {
                background-color: #f5f5f5;
                padding: 20px;
                margin-bottom: 20px;
                border-radius: 5px;
            }

            .house-card h3 {
                font-size: 20px;
                margin-bottom: 10px;
            }

            .house-card p {
                margin-bottom: 5px;
            }

            .tag-list {
                margin-top: 5px;
            }

            .tag {
                display: inline-block;
                padding: 5px 10px;
                background-color: #4CAF50;
                color: white;
                font-size: 14px;
                margin-right: 5px;
                margin-bottom: 5px;
                border-radius: 3px;
            }


    </style>
</head>
<body>
    <?php include 'components/header.php'; ?>

    <section class="house-search">
        <h1>Search Houses</h1>
        <div class="sidebar">
            <form class="search-form" action="" method="post">
                <label for="locality">Locality <span>*</span></label>
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

                <label for="facilities">General Facilities <span>*</span></label>
                <div class="checkboxes" style="font-size: 16px; margin-bottom: 3px;">
                    <label><input type="checkbox" name="facilities[]" value="Air Conditioning">Air Conditioning</label>
                    <label><input type="checkbox" name="facilities[]" value="Balcony">Balcony</label>
                    <label><input type="checkbox" name="facilities[]" value="Garden">Garden</label>
                    <label><input type="checkbox" name="facilities[]" value="Parking">Parking</label>
                    <label><input type="checkbox" name="facilities[]" value="Swimming Pool">Swimming Pool</label>
                    <label><input type="checkbox" name="facilities[]" value="Hospital Nearby">Hospital Nearby</label>
                    <label><input type="checkbox" name="facilities[]" value="Power">Power Backup</label>
                    <label><input type="checkbox" name="facilities[]" value="Lift">Lift</label>
                    <label><input type="checkbox" name="facilities[]" value="water">24*7 Water</label>
                    <!-- Add more facilities checkboxes here -->
                </div>

                <label for="connectivity">Connectivity <span>*</span></label>
                <div class="checkboxes" style="font-size: 16px; margin-bottom: 3px;">
                    <label><input type="checkbox" name="connectivity[]" value="Airport">Airport</label>
                    <label><input type="checkbox" name="connectivity[]" value="Railways">Railways</label>
                    <label><input type="checkbox" name="connectivity[]" value="Bus Stand">Bus Stand</label>
                    <label><input type="checkbox" name="connectivity[]" value="Metro Station">Metro Station</label>
                    <label><input type="checkbox" name="connectivity[]" value="Highway">Highway</label>
                    <!-- Add more connectivity checkboxes here -->
                </div>

                <label for="min_rent">Minimum Rent</label>
                <input type="number" name="min_rent" id="min_rent" min="0">

                <label for="max_rent">Maximum Rent</label>
                <input type="number" name="max_rent" id="max_rent" min="0">

                <input type="submit" value="Search">
            </form>
        </div>

        <div class="main-content">
            <div class="search-results">
                <?php if (isset($houses) && count($houses) > 0) { ?>
                    <?php foreach ($houses as $house) { ?>
                        <div class="house-card">
                            <h3><?php echo $house['name']; ?></h3>
                            <p>Rent: ₹<?php echo $house['rent']; ?></p>
                            <p>Location: <?php echo $house['location']; ?></p>
                            <p>Locality: <?php echo $house['locality']; ?></p>
                            <p>City: <?php echo $house['city']; ?></p>
                            <p>Facilities:</p>
                            <div class="tag-list">
                                <?php
                                $facilities = explode(', ', $house['facilities']);
                                foreach ($facilities as $facility) {
                                    echo '<span class="tag">' . $facility . '</span>';
                                }
                                ?>
                            </div>
                            <p>Connectivity:</p>
                            <div class="tag-list">
                                <?php
                                $connectivity = explode(', ', $house['connectivity']);
                                foreach ($connectivity as $connection) {
                                    echo '<span class="tag">' . $connection . '</span>';
                                }
                                ?>
                            </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <p>No houses found.</p>
                <?php } ?>
            </div>
        </div>

    </section>
</body>
