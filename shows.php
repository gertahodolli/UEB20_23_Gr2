<?php
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
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">
            <img src="resources/images/logo1.png" alt="National Theater of Kosovo" class="navbar-logo">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse mr-5" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item pr-3">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item dropdown pr-3" id="showsDropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownShows" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Shows
                    </a>
                    <div class="dropdown-menu bg-dark" aria-labelledby="navbarDropdownShows">
                        <a class="dropdown-item dropdown-text" style="color: aliceblue;" href="shows.php">Shows</a>
                        <a class="dropdown-item dropdown-text" style="color: aliceblue;" href="calendar.php">Calendar</a>
                    </div>
                </li>
                <li class="nav-item pr-3">
                    <a class="nav-link" href="biletat.php">Tickets</a>
                </li>
                <li class="nav-item pr-3">
                    <a class="nav-link" href="aboutUs.php">About Us</a>
                </li>
                <li class="nav-item pr-3" style="margin-right: 5px;">
                  <a class="nav-link" href="contact.php">Contact Us</a>
                </li>
                <li class="nav-item pr-3">
                  <a class="nav-link btn btn-primary butoni" style=" margin-right: 15px;" href="logIn.php">Log In</a>
                </li>
            </ul>
        </div>
    </nav>
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
            // Define an array of shows with their titles and other details
            $shows = array(
                array(
                    "title" => "Club Albania",
                    "director" => "Fatos Berisha",
                    "actors" => "Armond Morina, Ard Islami, Armend Smajli, Maylinda Kosumovic, Naim Berisha, Teuta Krasniqi and Ylber Bardhi",
                    "description" => "The play is based on the comedy, 'After Death' by A.Z. Çajupi."
                ),
                array(
                    "title" => "1984",
                    "director" => "Igor Mendjisky",
                    "actors" => "Adrian Morina, Arta Selimi, Basri Lushtaku, Edona Reshitaj, Flaka Latifi, Shpejtim Kastrati, Xhejlane Godanci dhe Ylber Bardhi",
                    "description" => "Dramatized from author George Orwell's dystopian novel."
                ),
                array(
                    "title" => "Udhëtim i gjatë drejt natës",
                    "director" => "Iliriana Arifi",
                    "actors" => "Ernest Malazogu, Arta Selimi, Allmir Suhodolli, Don Shala, Florie Bajoku",
                    "description" => "“Udhëtimi i gjate drejt nates” for the last time this year on December 13, 2023."
                ),
                array(
                    "title" => "GJITHÇKA RRETH IV",
                    "director" => "Hervin Çuli",
                    "actors" => "Ermira Hysaj Çerkozi, Albulena Kryeziu Bokshi, Hervin Çuli, Adrian Morina, Kushtrim Sheremeti, Rovena Lule Kuka, Natasha Sela, Endriu Hysi",
                    "description" => "The dramas and intrigues that a person weaves with a sick ego to achieve their goals, regardless of the destruction or harm inflicted on those around them."
                ),
                array(
                    "title" => "GRATË",
                    "director" => "Nastazja Domaradzka",
                    "actors" => "Edona Reshitaj, Gresa Pallaska, Lumnije Sopi, Sheqerie Buqaj, Shengyl Ismaili, Xhejlane Godanci",
                    "description" => "The play 'WOMEN - or their sins in patriarchy!', is an authorial show in collaboration with the ensemble."
                ),
                array(
                    "title" => "Ditë Vere",
                    "director" => "Kaltrim Balaj",
                    "actors" => "Andi Bajgora, Art Pasha, Era Balaj, Lumnije Sopi, Veton Osmani, Adhurim Demi, Naim Berisha",
                    "description" => "The show will be played in the open air at the Palace of Youth and Sports in Pristina, so after getting the tickets at the ticket office of the National Theatre, the theater attendants will accompany you to the location of the show."
                )
                // Add more shows here
            );

            // Function to compare titles for sorting
            function compare_titles($show1, $show2) {
                return strcmp($show1['title'], $show2['title']);
            }

            // Sort the shows array alphabetically based on titles
            usort($shows, 'compare_titles');

            // Loop through the sorted shows array and generate HTML for each show dynamically
            foreach ($shows as $show) {
                ?>
                <div class="col-md-4 mb-4">
                    <div class="show-card">
                        <div class="show-image">
                            <!-- Your show image HTML -->
                            <img src="resources/shows/<?php echo strtolower(str_replace(' ', '', $show['title'])); ?>.png" alt="<?php echo $show['title']; ?>" class="shows-img">
                            <div class="show-title"><?php echo $show['title']; ?></div>
                            <div class="show-info">
                                <h3><?php echo $show['title']; ?></h3>
                                <p><b>Director:</b> <u><?php echo $show['director']; ?></u></p>
                                <p><i><b>Actors:</b></i> <?php echo $show['actors']; ?></p>
                                <p><?php echo $show['description']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>

            <div class="row mt-4 mb-5 pb-5 text-center">
                <div class="col-md-6">
                  <a href="calendar.html" class="btn btn-primary butonat">Go to Calendar</a>
                </div>
                <div class="col-md-6">
                  <a href="biletat.html" class="btn btn-primary butonat">Go to Tickets</a>
                </div>
              </div>
        </div>
    </section>

    <footer class=" text-center pb-3 bg-color">
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

      


    <!--Used remove to delete the span element containing the year-->

    <script>
      $(document).ready(function() {
      // Select the element with the ID 'remove'
      $('#remove').remove();
    });

    </script>

    <!--Through filter, map and reduce funtions, sorted the shows in which Ylber Bardhi plays, shows which are directed by Kaltrim Balaj, and the total number of shows-->


    <script>
      // Get all the show elements
      const showElements = document.querySelectorAll('.show-card');

      // Convert NodeList to Array
      const showsArray = Array.from(showElements);

      // Filter shows where Actor Ylber Bardhi plays
      const showsWithYlberBardhi = showsArray.filter(show => {
        const actors = show.querySelector('.show-info').innerHTML;
        return actors.includes('Ylber Bardhi');
      }).map(show => {
        return show.querySelector('.show-title').textContent;
      });

      // Extract shows directed by Kaltrim Balaj
      const showsDirectedByKaltrimBalaj = showsArray.filter(show => {
        const director = show.querySelector('.show-info').innerHTML;
        return director.includes('Kaltrim Balaj');
      }).map(show => {
        return show.querySelector('.show-title').textContent;
      });

      // Use reduce for counting or summing up
      const totalShows = showsArray.reduce((accumulator, currentShow) => {
        // Perform any operation here (e.g., counting)
        return accumulator + 1;
      }, 0);

      console.log('Shows with Ylber Bardhi:', showsWithYlberBardhi);
      console.log('Shows directed by Kaltrim Balaj:', showsDirectedByKaltrimBalaj);
      console.log('Total number of shows:', totalShows);

      
    </script>
    <script>
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

<script>
  $(document).ready(function() {
  // Select the element with the ID 'remove'
  $('#remove').remove();
});

</script>

</body>
</html>