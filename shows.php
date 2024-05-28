<?php

include 'database/db_connect.php';
// Function to set a cookie
function set_cookie($name, $value, $expiry) {
    setcookie($name, $value, time() + $expiry, "/");
}

// Function to delete a cookie
function delete_cookie($name) {
    setcookie($name, "", time() - 3600, "/");
    unset($_COOKIE[$name]);
}

// Check if a cookie is set
$cookie_name = "bg_color";
if(isset($_COOKIE[$cookie_name])) {
    // Cookie exists, get its value
    $bg_color = $_COOKIE[$cookie_name];
} else {
    // Cookie does not exist, set a default value
    $bg_color = "black";
    set_cookie($cookie_name, $bg_color, 86400); // Cookie expires in 1 day
}

// Process form submission
if(isset($_POST['color'])) {
    $selected_color = $_POST['color'];
    set_cookie($cookie_name, $selected_color, 86400); // Update cookie with selected color
    // Redirect to avoid header modification after output
    header("Location: {$_SERVER['PHP_SELF']}");
    exit; // Ensure script stops execution after redirection
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shows</title>
    <link rel="stylesheet" href="./resources/css/home.css">
    <link rel="stylesheet" href="resources/css/shows.css">
    <link href="./libraries/bootstrap-5.3.2-dist/css/bootstrap.min.css" rel="stylesheet" >
    <script src="./libraries/bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="icon" type="image/png" href="resources/images/logo1.png"/>

    <style>
        /* Your provided CSS styles */
        body {
          background-color: <?php echo $bg_color; ?>;
          color: <?php echo $bg_color === 'white' ? 'black' : 'white'; ?>;
        }
        .show-changes {
          background-color: <?php echo $bg_color; ?>;
        }
        .search-bar {
            color: <?php echo $bg_color === 'white' ? 'black' : 'white'; ?>; /* Change text color based on background color */
        }
        
        .search-input, .search-icon {
        color: <?php echo $bg_color === 'white' ? 'black' : 'white'; ?>;
        background-color: <?php echo $bg_color === 'white' ? 'white' : 'black'; ?>;
        border-color: <?php echo $bg_color === 'white' ? 'black' : 'white'; ?>;
        }
        .search-input::placeholder {
            
        }

        .bg-color {
            background-color: <?php echo $bg_color; ?>; /* Set footer background color to match the theme */
            color: <?php echo $bg_color === 'white' ? 'black' : 'white'; ?>;
        }

        .show-card {
            perspective: 1000px;
            position: relative;
            width: 100%;
            height: 100%;
        }

        .show-image {
            position: relative;
            width: auto;
            height: 100%;
            transition: transform 0.5s ease;
            transform-style: preserve-3d;
        }

        .show-card:hover .show-image {
            transform: rotateY(180deg);
        }

        .show-image img {
            width: 100%;
            height: auto;
            display: block;
        }

        .show-title {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            text-shadow: 2px 2px #614949;
            text-wrap: nowrap;
            font-size: 22px;
            font-weight: bold;
            color: white;
            background-color: rgba(0, 0, 0, 0);
            padding: 10px;
            visibility: visible;
            opacity: 1;
            transition: visibility 0s, opacity 0.5s ease;
        }

        .show-card:hover .show-title {
            visibility: hidden;
            opacity: 0;
        }

        .show-info {
            background-color: black;
            color: white;
            padding: 20px;
            backface-visibility: hidden;
            transform: rotateY(180deg);
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
        }

        .shows-img {
            width: auto; /* Ensures images take up full width */
            height: auto; /* Maintains aspect ratio */
            max-height: 450px; /* Example height; adjust as needed */
        }

        .search-bar {
            position: relative;
            width: 100%;
            margin-bottom: 20px;
        }

        .search-input {
            width: 100%;
            padding: 10px;
            border: none;
            border-bottom: 1px solid; /* Line for searching */
            color: <?php echo $bg_color === 'white' ? 'black' : 'white'; ?>;
          background-color: <?php echo $bg_color === 'white' ? 'white' : 'black'; ?>;
          border-color: <?php echo $bg_color === 'white' ? 'black' : 'white'; ?>; 
            outline: none;
        }

        .search-input::placeholder {
            color: <?php echo $bg_color === 'white' ? 'black' : 'white'; ?>; /* Placeholder text color */
        }

        .search-icon {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            color: <?php echo $bg_color === 'white' ? 'black' : 'white'; ?>;
            background-color: <?php echo $bg_color === 'white' ? 'white' : 'black'; ?>;
            border-color: <?php echo $bg_color === 'white' ? 'black' : 'white'; ?>; /* Icon color */
        }
    </style>

</head>
<body>
  <header>
  <?php include 'navbar.php'; ?>
</header>

<section class="show-changes">
    <div class="container pt-5">
        <h2 style="text-align: center; margin-bottom: 30px;">Shows</h2>
        <div class="search-bar ml-5">
            <input type="text" class="search-input mb-2" placeholder="Search shows...">
            <i class="fas fa-search search-icon"></i>
        </div>
        <div class="row">
        <?php 

        // Query to fetch show data from the database
        $stmt = $conn->prepare("SELECT emrin, regjisorin, duration, aktoret, pershkrimi, foto FROM shfaqje");
        $stmt->execute();
        $result = $stmt->get_result();

        // Store the fetched data in an array
        $shows = array();
        while ($row = $result->fetch_assoc()) {
            $shows[] = $row;
        }

        $stmt->close();
        $conn->close();

        // Function to compare titles for sorting
        function compare_titles($show1, $show2) {
            return strcmp($show1['emrin'], $show2['emrin']);
        }

        // Sort the shows array alphabetically based on titles
        usort($shows, 'compare_titles');

        // Loop through the sorted shows array and generate HTML for each show dynamically
        foreach ($shows as $show) {
            ?>
            <div class="col-md-4 mb-4">
                <div class="show-card">
                    <div class="show-image">
                        <!-- Display the image for the show -->
                        <img src="<?php echo htmlspecialchars($show['foto']); ?>" alt="<?php echo htmlspecialchars($show['emrin']); ?>" class="shows-img">
                        <div class="show-title"><?php echo htmlspecialchars($show['emrin']); ?></div>
                        <div class="show-info">
                            <h3><?php echo htmlspecialchars($show['emrin']); ?></h3>
                            <p><b>Director:</b> <u><?php echo htmlspecialchars($show['regjisorin']); ?></u></p>
                            <p><i><b>Actors:</b></i> <?php echo htmlspecialchars($show['aktoret']); ?></p>
                            <p><?php echo htmlspecialchars($show['pershkrimi']); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        </div>

        <div class="row mt-4 mb-5 pb-5 text-center">
            <div class="col-md-6">
                <a href="calendar.php" class="btn btn-primary butonat">Go to Calendar</a>
            </div>
            <div class="col-md-6">
                <a href="biletat.php" class="btn btn-primary butonat">Go to Tickets</a>
            </div>
        </div>
    </div>
</section>

<footer class="text-center pb-3 bg-color">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="footer-icons social-links">
                    <a href="https://www.facebook.com/teatrikombetarikosoves" target="_blank" class="social-icon p-2"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.instagram.com/teatrikombetarks/" target="_blank" class="social-icon p-2"><i class="fab fa-instagram"></i></a>
                    <a href="mailto:teatri.kombetar@rks-gov.net" class="social-icon p-2"><i class="fas fa-envelope"></i></a>
                </div>
                <p>Phone: +383 (44) 753 330</p>
            </div>
            <div class="col pt-4">
                <address>Address: Street Luan Haradinaj, Prishtina</address>
            </div>
            <div class="col pt-4">
                <form method="post" id="color-form" style="position: fi; bottom: 20px; right: 20px;">
                    <label for="color-select" sty>Select Background Color:</label>
                    <select name="color" id="color-select">
                        <option value="white" <?php if($bg_color === 'white') echo 'selected'; ?>>Light</option>
                        <option value="black" <?php if($bg_color === 'black') echo 'selected'; ?>>Dark</option>
                        <!-- Add more color options as needed -->
                    </select>
                    <button type="submit">Save</button>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <p>&copy; <span id="remove">2023</span> National Theater of Kosovo</p></p>
            </div>
        </div>
    </div>
</footer>

<script>
    $(document).ready(function() {
        $('#remove').remove();
    });

    document.addEventListener('DOMContentLoaded', function () {
        const showElements = document.querySelectorAll('.show-card');
        const showsArray = Array.from(showElements);

        document.querySelector('.search-input').addEventListener('input', function (event) {
            const searchValue = event.target.value.toLowerCase();

            const filteredShows = showsArray.filter(show => {
                const title = show.querySelector('.show-title').textContent.toLowerCase();
                const info = show.querySelector('.show-info').textContent.toLowerCase();

                return title.includes(searchValue) || info.includes(searchValue);
            });

            // Display matching shows and hide non-matching shows
            showsArray.forEach(show => {
                show.style.display = filteredShows.includes(show) ? 'block' : 'none';
            });

            // Calculate and display total matching shows
            const totalMatchingShows = filteredShows.reduce((accumulator, currentShow) => {
                return accumulator + 1;
            }, 0);

            console.log('Total matching shows:', totalMatchingShows);
        });
    });
</script>
</body>
</html>
