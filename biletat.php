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
        <link href="./libraries/bootstrap-5.3.2-dist/css/bootstrap.min.css" rel="stylesheet" >
        <script src="./libraries/bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="...">
        <link rel="stylesheet" href="./resources/css/home.css">
        <link rel="stylesheet" href="./resources/css/biletat.css">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="./resources/js/biletat.js" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="icon" type="image/png" href="resources/images/logo1.png"/>
        <title>Tickets</title>
    </head>    
    <style>
        body{
            background-color: rgb(11, 11, 11);
        }
        .navbar{
            height: 75px;
        }
        footer{
            background: #333333;
        }

    </style>
    <body>
        <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="go-to-nav">
                <a class="navbar-brand" href="index.php"> <!--specifies the link to the homepage-->
                    <img src="resources/images/logo1.png" alt="National Theater of Kosovo" class="navbar-logo">
                </a><!--this button is styled for toggling on smaller screens, utilizes bootstraps collapse plugin to handle the collapse behavior-->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button><!--the elements below are the collapsible elements-->
                <div class="collapse navbar-collapse mr-5" id="navbarNav">
                    <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item pr-3">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item dropdown pr-3" id="showsDropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownShows" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                      <a class="nav-link btn btn-primary butoni" style=" margin-right: 15px;" href="index.html">Log In</a>
                    </li>
                    </ul>
                </div>
            </nav>
        </header>
        <main>
        <?php
            // Definimi i konstantave për çmimet e biletave
            define("REGULAR_TICKET_PRICE", "€ 2");
            define("SHOW_OVER_2_HOURS_PRICE", "€ 3");
            define("KIDS_AND_SENIORS_PRICE", "Free");
            define("STUDENT_TICKET_PRICE", "€ 1");
            define("STUDENT_OVER_2_HOURS_PRICE", "€ 2");
            ?>

            <section id="price-list" class="my-5">
                <div class="container text-center">
                    <h2 class="mb-4" style="color: lightgray;">Ticket information</h2>
                    <div class="row justify-content-center">
                        <table>
                            <thead>
                                <tr>
                                    <th>Ticket Type</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Regular Tickets</td>
                                    <td><?php echo REGULAR_TICKET_PRICE; ?></td>
                                </tr>
                                <tr>
                                    <td>Show over 2 hours</td>
                                    <td><?php echo SHOW_OVER_2_HOURS_PRICE; ?></td>
                                </tr>
                                <tr>
                                    <td>Kids and Seniors</td>
                                    <td><?php echo KIDS_AND_SENIORS_PRICE; ?></td>
                                </tr>
                                <tr>
                                    <td>Student Tickets</td>
                                    <td><?php echo STUDENT_TICKET_PRICE; ?></td>
                                </tr>
                                <tr>
                                    <td>Student for shows over 2 hours</td>
                                    <td><?php echo STUDENT_OVER_2_HOURS_PRICE; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
            <section id="ticket-showcase" class="my-5">
                <div class="container">
                    <h3 class="mb-4 text-center" style="color: lightgray;">Shows that are currently playing:</h3>
                    <div class="row">
                    <?php
                // Define the shows array
                $shows = [
                    [
                        'title' => 'CLUB ALBANIA',
                        'image' => './resources/shows/InkedclubAlbania2_.jpg',
                        'dates' => ['2023-12-14', '2023-12-26'],
                        'time' => '20:00'
                    ],
                    [
                        'title' => 'Grate',
                        'image' => './resources/shows/Inkedgrate2.jpg',
                        'dates' => ['2023-12-17', '2023-12-23'],
                        'time' => '20:00'
                    ],
                    [
                        'title' => 'Udhetim i gjate drejt nates',
                        'image' => './resources/shows/udhetimGjateDrejtNates.jpg',
                        'dates' => ['2023-12-05'],
                        'time' => '20:00'
                    ],
                    [
                        'title' => '1984',
                        'image' => './resources/shows/1984.jpg',
                        'dates' => ['2023-12-11', '2023-12-21'],
                        'time' => '20:00'
                    ],
                    [
                        'title' => 'Gjithcka rreth IV',
                        'image' => './resources/shows/gjithckaRrethIV.jpg',
                        'dates' => ['2023-12-09', '2023-12-30'],
                        'time' => '20:00'
                    ],
                    [
                        'title' => 'Dite Vere',
                        'image' => './resources/shows/diteVere2.jpg',
                        'dates' => ['2023-12-03', '2023-12-10'],
                        'time' => '20:00'
                    ]
                ];

                // Sort the shows by the earliest date using usort()
                usort($shows, function($a, $b) {
                    return strtotime($a['dates'][0]) - strtotime($b['dates'][0]);
                });

                // Generate HTML from the sorted array
                foreach ($shows as $show) {
                    echo '<div class="col-md-4 mb-4">';
                    echo '<div class="card text-center">';
                    echo '<img src="' . htmlspecialchars($show['image']) . '" alt="' . htmlspecialchars($show['title']) . '" class="card-img-top">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . htmlspecialchars($show['title']) . '</h5>';
                    echo '<p class="card-text">Date: <span class="show-date">' . implode(' <br>', $show['dates']) . '</span></p>';
                    echo '<p class="card-text">Time: ' . htmlspecialchars($show['time']) . '</p>';
                    echo '</div>';
                    echo '<div class="card-footer">';
                    echo '<button class="btn btn-primary buy-tickets-btn" data-toggle="modal" data-target="#ticketModal">Buy ticket</button>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </section>
            <!-- Modal for ticket information -->
            <div class="modal" tabindex="-1" role="dialog" id="purchaseModal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Buy Tickets</h5>
                        </div>
                        <div class="modal-body">
                            <form id="purchaseForm" onsubmit="return validateForm()">
                                <!--Full name-->
                                <div class="form-group">
                                    <label for="fullName">Ticket Name</label>
                                    <input type="text" class="form-control" id="fullName" placeholder="Enter your full name" required autocomplete="on">
                                    <div id="fullName-error" class="error-message"></div>
                                </div>
                                <!-- Email -->
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" placeholder="Enter your email" required autocomplete="on">
                                    <div id="email-error" class="error-message"></div>
                                </div>
                                <!-- Date selection using radio buttons -->
                                <div class="form-group">
                                    <label for="showDate" style="margin: 10px; margin-top: 20px;">Date Selection</label>
                                    <div class="form-group" id="radioGroup">
                                        <datalist id="show-dates"></datalist>
                                        <label>Show Dates:</label>
                                    </div>
                                    <div id="showDate-error" class="error-message"></div>
                                </div>
                                <label style="margin: 10px; margin-top: 20px;">Ticket Selection</label><br>
                                <!-- Quantity selection using buttons -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="regularTicketCheckbox" required>
                                            <label class="form-check-label" for="regularTicketCheckbox">Regular Ticket</label>
                                            <div class="quantity-control" style="display: none;">
                                                <label for="regularTicketQuantity">Quantity:</label>
                                                <div class="row">
                                                    <div class="col quantity-buttons">
                                                        <button type="button" class="btn btn-secondary quantity" onclick="decrementQuantity('#regularTicketQuantity', '#regularTicketQuantity-display')">-</button>
                                                        <input type="text" class="form-control value" id="regularTicketQuantity" value="0" readonly>
                                                        <button type="button" class="btn btn-secondary quantity" onclick="incrementQuantity('#regularTicketQuantity', '#regularTicketQuantity-display')">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>    
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="2hoursTicketCheckbox" required>
                                            <label class="form-check-label" for="2hoursTicketCheckbox">Show over 2 hours Ticket</label>
                                            <div class="quantity-control" style="display: none;">
                                                <label for="2hoursTicketQuantity">Quantity:</label>
                                                <div class="row">
                                                    <div class="col-md-6 quantity-buttons">
                                                        <button type="button" class="btn btn-secondary " onclick="decrementQuantity('#2hoursTicketQuantity', '#2hoursTicketQuantity-display')">-</button>
                                                        <input type="text" class="form-control" id="2hoursTicketQuantity" value="0" readonly>
                                                        <button type="button" class="btn btn-secondary" onclick="incrementQuantity('#2hoursTicketQuantity', '#2hoursTicketQuantity-display')">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="studentTicketCheckbox" required>
                                            <label class="form-check-label" for="studentTicketCheckbox">Student Ticket</label>
                                            <div class="quantity-control" style="display: none;">
                                                <label for="studentsTicketQuantity">Quantity:</label>
                                                <div class="row">
                                                    <div class="col quantity-buttons">
                                                        <button type="button" class="btn btn-secondary" onclick="decrementQuantity('#studentTicketQuantity', '#studentTicketQuantity-display')">-</button>
                                                        <input type="text" class="form-control" id="studentTicketQuantity" value="0" readonly>
                                                        <button type="button" class="btn btn-secondary" onclick="incrementQuantity('#studentTicketQuantity', '#studentTicketQuantity-display')">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="students2hoursTicketCheckbox" required>
                                            <label class="form-check-label" for="students2hoursTicketCheckbox">Student for shows over 2 hours Ticket</label>
                                            <div class="quantity-control" style="display: none;">
                                                <label for="students2hoursTicketQuantity">Quantity:</label>
                                                <div class="row">
                                                    <div class="col quantity-buttons">
                                                        <button type="button" class="btn btn-secondary" onclick="decrementQuantity('#students2hoursTicketQuantity', '#students2hoursTicketQuantity-display')">-</button>
                                                        <input type="text" class="form-control" id="students2hoursTicketQuantity" value="0" readonly>
                                                        <button type="button" class="btn btn-secondary" onclick="incrementQuantity('#students2hoursTicketQuantity', '#students2hoursTicketQuantity-display')">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="ticketSelection-error" class="error-message"></div>
                                <output class="finalPrice"></output>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeModalButton">Close</button>
                            <button type="button" class="btn btn-primary" id="submitButton">Buy Tickets</button>
                        </div>
                    </div>
                </div>
            </div>
            <section>
                <div class="container">
                    <h3 class="mb-4 text-center" style="color: lightgray;">Trailers of shows currently playing:</h3>
                    <div class="row video-section">
                    <div class="col-md-6 position-relative">
                        <div class="video-container">
                            <video class="custom-controls" controls>
                            <source src="./resources/video/clubAlbania.mp4" type="video/mp4">
                            Your browser does not support the video tag.
                            </video>
                            <h5 class="overlay-text">"Club Albania"</h5>
                        </div>
                    </div>
                
                    <div class="col-md-6 position-relative">
                        <div class="video-container">
                            <video class="custom-controls" controls>
                            <source src="./resources/video/udhetimIGjateDrejtNates.mp4" type="video/mp4">
                            Your browser does not support the video tag.
                            </video>
                            <h5 class="overlay-text">"Udhetim i gjate drejt nates"</h5>
                        </div>
                    </div>
                    </div>
                </div>     
            </section>
            <footer class=" text-white text-center py-3 bg-color" id="animate-trans">
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
                      <p>&copy; <span id="remove">2023</span> <a href="#go-to-nav" id="top" style="text-decoration: none;  color: aliceblue;">National Theater of Kosovo</a></p>
                    </div>
                  </div>
                </div>
            </footer>
            <script>
                $(document).ready(function() {
                // Select the element with the ID 'remove'
                $('#remove').remove();
              });
              
            </script>
        </main>
    </body>
</html>