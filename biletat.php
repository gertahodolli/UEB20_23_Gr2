<?php
session_start();
include 'database/db_connect.php'; // Include the connection script

// Check if the user is logged in and the user_id is set in the session
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Session expiry logic
if (!isset($_SESSION['form_access_time'])) {
    $_SESSION['form_access_time'] = time();
} else {
    if (time() - $_SESSION['form_access_time'] > 120) { // 120 seconds = 2 minutes
        session_unset();
        session_destroy();
        header("Location: biletat.php?session_expired=true");
        exit;
    }
}
$_SESSION['form_access_time'] = time();

// Handle form submission for ticket purchases
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['buyTickets'])) {
    $ticketType = $_POST['ticketType'];
    $quantity = $_POST['quantity'];
    $totalPrice = $_POST['totalPrice'];
    $showId = $_POST['showId'];
    $showDate = $_POST['showDate'];
    $userId = $user_id; // Using the user ID from session

    // Get the show date and time
    $stmt = $conn->prepare("SELECT time FROM performances WHERE id = ?");
    $stmt->bind_param("i", $showId);
    $stmt->execute();
    $result = $stmt->get_result();
    $showTime = $result->fetch_assoc()['time'];
    $stmt->close();

    // Insert the purchase into the shitjet table
    $stmt = $conn->prepare("INSERT INTO shitjet (time, date, userId, performancaId, biletaId, sasia, totali, kaPerfunduar) VALUES (?, ?, ?, ?, ?, ?, ?, false)");
    $stmt->bind_param("ssiiiiid", $showTime, $showDate, $userId, $showId, $ticketType, $quantity, $totalPrice);
    if ($stmt->execute()) {
        echo '<script>alert("Bileta u blerë me sukses!");</script>';
    } else {
        echo '<script>alert("Gabim: ' . $stmt->error . '");</script>';
    }
    $stmt->close();
}

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

// Process form submission for color change
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
    <link href="./libraries/bootstrap-5.3.2-dist/css/bootstrap.min.css" rel="stylesheet">
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
    body {
        background-color: rgb(11, 11, 11);
    }
    .navbar {
        height: 75px;
    }
    footer {
        background: #333333;
    }
</style>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="go-to-nav">
        <a class="navbar-brand" href="index.php">
            <img src="resources/images/logo1.png" alt="National Theater of Kosovo" class="navbar-logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
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
                    <a class="nav-link btn btn-primary butoni" style="margin-right: 15px;" href="index.html">Log In</a>
                </li>
            </ul>
        </div>
    </nav>
</header>
<main>
    <!-- PHP constants and content display for ticket prices -->
    <?php
    define("REGULAR_TICKET_PRICE", 2);
    define("SHOW_OVER_2_HOURS_PRICE", 3);
    define("KIDS_AND_SENIORS_PRICE", 0);
    define("STUDENT_TICKET_PRICE", 1);
    define("STUDENT_OVER_2_HOURS_PRICE", 2);
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
                            <td>€ <?php echo REGULAR_TICKET_PRICE; ?></td>
                        </tr>
                        <tr>
                            <td>Show over 2 hours</td>
                            <td>€ <?php echo SHOW_OVER_2_HOURS_PRICE; ?></td>
                        </tr>
                        <tr>
                            <td>Kids and Seniors</td>
                            <td><?php echo KIDS_AND_SENIORS_PRICE == 0 ? 'Free' : '€ ' . KIDS_AND_SENIORS_PRICE; ?></td>
                        </tr>
                        <tr>
                            <td>Student Tickets</td>
                            <td>€ <?php echo STUDENT_TICKET_PRICE; ?></td>
                        </tr>
                        <tr>
                            <td>Student for shows over 2 hours</td>
                            <td>€ <?php echo STUDENT_OVER_2_HOURS_PRICE; ?></td>
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
            // Query to fetch performance data from the database
            $stmt = $conn->prepare("
                SELECT p.id, p.emri, p.date, p.time, s.foto, s.emrin, s.duration 
                FROM performances p 
                JOIN shfaqje s ON p.shfaqje_id = s.id
            ");
            $stmt->execute();
            $result = $stmt->get_result();

            $shows = [];
            while ($row = $result->fetch_assoc()) {
                if (!isset($shows[$row['emri']])) {
                    $shows[$row['emri']] = [
                        'id' => $row['id'],
                        'dates' => [],
                        'time' => $row['time'],
                        'foto' => $row['foto'],
                        'emrin' => $row['emrin'],
                        'duration' => $row['duration']
                    ];
                }
                $shows[$row['emri']]['dates'][] = $row['date'];
            }
            $stmt->close();

            // Sort the shows by the earliest date using usort()
            usort($shows, function($a, $b) {
                return strtotime($a['dates'][0]) - strtotime($b['dates'][0]);
            });

            // Generate HTML from the sorted array
            foreach ($shows as $show) {
                echo '<div class="col-md-4 mb-4">';
                echo '<div class="card text-center">';
                echo '<img src="' . htmlspecialchars($show['foto']) . '" alt="' . htmlspecialchars($show['emrin']) . '" class="card-img-top">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . htmlspecialchars($show['emrin']) . '</h5>';
                echo '<p class="card-text">Date: <span class="show-date">' . implode('<br>', $show['dates']) . '</span></p>';
                echo '<p class="card-text">Time: ' . htmlspecialchars($show['time']) . '</p>';
                echo '</div>';
                echo '<div class="card-footer">';
                echo '<button class="btn btn-primary buy-tickets-btn" data-toggle="modal" data-target="#purchaseModal" data-show-id="' . htmlspecialchars($show['id']) . '" data-show-name="' . htmlspecialchars($show['emrin']) . '" data-show-dates=\'' . json_encode($show['dates']) . '\' data-show-duration="' . htmlspecialchars($show['duration']) . '">Buy ticket</button>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            ?>
            </div>
        </div>
    </section>

    <!-- Modal for ticket information -->
    <div class="modal" tabindex="-1" role="dialog" id="purchaseModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buy Tickets</h5>
                </div>
                <div class="modal-body">
                    <form id="purchaseForm" method="POST" action="biletat.php" onsubmit="return validateForm()">
                        <!-- Full name -->
                        <div class="form-group">
                            <label for="fullName">Full Name</label>
                            <input type="text" class="form-control" id="fullName" name="fullName" placeholder="Enter your full name" required autocomplete="on">
                            <div id="fullName-error" class="error-message"></div>
                        </div>
                        <!-- Email -->
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required autocomplete="on">
                            <div id="email-error" class="error-message"></div>
                        </div>
                        <!-- Date Selection -->
                        <div class="form-group">
                            <label for="showDate">Select Date</label>
                            <div id="dateOptions"></div>
                            <div id="showDate-error" class="error-message"></div>
                        </div>
                        <!-- Ticket Type -->
                        <label style="margin: 10px; margin-top: 20px;">Ticket Selection</label><br>
                        <div id="ticketTypeContainer" class="row">
                            <!-- Ticket types will be populated dynamically -->
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
    // Change text color for buttons
    $('.btn-style').css('background-color', 'red');

    // Attach event handlers
    window.addEventListener('resize', equalizeCardHeights);
    window.addEventListener('load', equalizeCardHeights);

    // Close modal on button click
    $('#closeModalButton').click(function() {
        $('#purchaseModal').modal('hide');
    });

    // Initialize buy ticket buttons
    $('.buy-tickets-btn').click(function() {
        var showId = $(this).data('show-id');
        var showName = $(this).data('show-name');
        var showDates = $(this).data('show-dates');
        var showDuration = $(this).data('show-duration');
        var dateOptionsHtml = '';

        $('#showSelection').val(showName);
        $('#showId').val(showId); // Set the showId in the hidden field

        showDates.forEach(function(date) {
            dateOptionsHtml += '<div class="form-check">';
            dateOptionsHtml += '<input class="form-check-input" type="radio" name="showDate" value="' + date + '" required>';
            dateOptionsHtml += '<label class="form-check-label">' + date + '</label>';
            dateOptionsHtml += '</div>';
        });

        $('#dateOptions').html(dateOptionsHtml);

        // Pass the show duration to the fetchFilteredTickets function
        fetchFilteredTickets(showDuration);
    });

    $('#submitButton').click(function() {
        if (!isLoggedIn()) {
            alert('You must be logged in to purchase tickets.');
            return false;
        }
        $('#totalPrice').val($('.finalPrice').text().replace('Total: € ', '')); // Set the total price in the hidden field
        $('#purchaseForm').submit(); // Submit the form without validation
    });
});

function equalizeCardHeights() {
    var cards = document.querySelectorAll('.card');
    var maxCardHeight = 0;

    cards.forEach(function(card) {
        card.style.height = 'auto';
        maxCardHeight = Math.max(maxCardHeight, card.offsetHeight);
    });

    cards.forEach(function(card) {
        card.style.height = maxCardHeight + 'px';
    });
}

function isLoggedIn() {
    return <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;
}

function fetchFilteredTickets(showDuration) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'fetch_filtered_tickets.php?showDuration=' + showDuration, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);
            populateTicketTypes(response);
        }
    };
    xhr.send();
}

function populateTicketTypes(ticketTypes) {
    var ticketTypeContainer = document.getElementById('ticketTypeContainer');
    ticketTypeContainer.innerHTML = ''; // Clear existing options
    ticketTypes.forEach(function(ticket) {
        var formCheck = document.createElement('div');
        formCheck.classList.add('form-check');
        
        var label = document.createElement('label');
        label.classList.add('form-check-label');
        label.innerText = ticket.tipi + ' - €' + ticket.cmimi;

        var quantityControl = document.createElement('div');
        quantityControl.classList.add('quantity-control');

        var quantityLabel = document.createElement('label');
        quantityLabel.setAttribute('for', ticket.id + 'Quantity');
        quantityLabel.innerText = 'Quantity:';

        var rowDiv = document.createElement('div');
        rowDiv.classList.add('row');

        var colDiv = document.createElement('div');
        colDiv.classList.add('col', 'quantity-buttons');

        var decrementButton = document.createElement('button');
        decrementButton.type = 'button';
        decrementButton.classList.add('btn', 'btn-secondary', 'quantity');
        decrementButton.innerText = '-';
        decrementButton.setAttribute('onclick', 'decrementQuantity("#' + ticket.id + 'Quantity")');

        var quantityInput = document.createElement('input');
        quantityInput.type = 'text';
        quantityInput.classList.add('form-control', 'value');
        quantityInput.id = ticket.id + 'Quantity';
        quantityInput.name = 'quantity[]'; // Change the name attribute to 'quantity[]'
        quantityInput.value = '0';
        quantityInput.setAttribute('data-price', ticket.cmimi); // Store price in data attribute
        quantityInput.readOnly = true;

        var incrementButton = document.createElement('button');
        incrementButton.type = 'button';
        incrementButton.classList.add('btn', 'btn-secondary', 'quantity');
        incrementButton.innerText = '+';
        incrementButton.setAttribute('onclick', 'incrementQuantity("#' + ticket.id + 'Quantity")');

        colDiv.appendChild(decrementButton);
        colDiv.appendChild(quantityInput);
        colDiv.appendChild(incrementButton);
        rowDiv.appendChild(colDiv);
        quantityControl.appendChild(quantityLabel);
        quantityControl.appendChild(rowDiv);

        formCheck.appendChild(label);
        formCheck.appendChild(quantityControl);
        ticketTypeContainer.appendChild(formCheck);
    });

    // Initialize quantity buttons
    document.querySelectorAll('.quantity').forEach(function(button) {
        button.addEventListener('click', function() {
            calculateTotal(); // Recalculate total when quantity changes
        });
    });

    calculateTotal(); // Calculate total initially
}

function decrementQuantity(quantityInputSelector) {
    var quantityInput = document.querySelector(quantityInputSelector);
    if (quantityInput.value > 0) {
        quantityInput.value = parseInt(quantityInput.value) - 1;
    }
    calculateTotal();
}

function incrementQuantity(quantityInputSelector) {
    var quantityInput = document.querySelector(quantityInputSelector);
    quantityInput.value = parseInt(quantityInput.value) + 1;
    calculateTotal();
}

function calculateTotal() {
    var total = 0;
    document.querySelectorAll('.value').forEach(function(quantityInput) {
        var price = parseFloat(quantityInput.getAttribute('data-price'));
        var quantity = parseInt(quantityInput.value);
        if (!isNaN(price) && !isNaN(quantity)) {
            total += price * quantity;
        }
    });
    document.querySelector('.finalPrice').innerText = 'Total: € ' + total.toFixed(2);
}

    </script>
</main>
</body>
</html>

<?php
if (isset($_GET['action']) && $_GET['action'] === 'fetch_filtered_tickets') {
    // Fetch filtered tickets based on user information
    $userId = $_SESSION['user_id']; // Assuming user ID is stored in session
    $showDuration = isset($_GET['showDuration']) ? $_GET['showDuration'] : '00:00';

    // Fetch user information
    $stmt = $conn->prepare("SELECT mosha, student FROM user WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    $mosha = $user['mosha'];
    $student = $user['student'];

    // Convert duration to minutes for comparison
    $durationParts = explode(':', $showDuration);
    $showDurationMinutes = ($durationParts[0] * 60) + $durationParts[1];

    // Build query based on user information and show duration
    $query = "SELECT id, tipi, cmimi FROM biletat WHERE 1=1";
    if ($student) {
        if ($showDurationMinutes > 120) {
            $query .= " AND tipi IN ('Student for shows over 2 hours')";
        } else {
            $query .= " AND tipi IN ('Student Tickets')";
        }
    } elseif ($mosha <= 10) {
        $query .= " AND tipi IN ('Kids and Seniors')";
    } elseif ($mosha > 65) {
        $query .= " AND tipi IN ('Kids and Seniors')";
    } else {
        if ($showDurationMinutes > 120) {
            $query .= " AND tipi IN ('Show over 2 hours')";
        } else {
            $query .= " AND tipi IN ('Regular Tickets')";
        }
    }

    $result = $conn->query($query);

    $ticketTypes = array();
    while ($row = $result->fetch_assoc()) {
        $ticketTypes[] = $row;
    }

    echo json_encode($ticketTypes);

    $conn->close();
    exit;
}
?>
