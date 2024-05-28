<?php
session_start();
include 'database/db_connect.php'; // Include the connection script

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
    <link rel="stylesheet" href="./resources/css/home.css">
    <link rel="stylesheet" href="resources/css/calendar.css">
    <link href="./libraries/bootstrap-5.3.2-dist/css/bootstrap.min.css" rel="stylesheet" >
    <script src="./libraries/bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <link rel="icon" type="image/png" href="resources/images/logo1.png"/>
    <title>Calendar</title>
    <style>
    body, html {
        background-color: <?php echo $bg_color; ?>;
        color: <?php echo $bg_color === 'white' ? 'black' : 'white'; ?>;
    }
    .calendar-show {
        background-color: <?php echo $bg_color; ?>;
        color: <?php echo $bg_color === 'white' ? 'black' : 'white'; ?>;
    }
    .calendar-show h1, .calendar-show .muaji, .show-info {
        background-color: <?php echo $bg_color; ?>;
        color: <?php echo $bg_color === 'white' ? 'black' : 'white'; ?>;
    }
    #calendar {
        border-color: <?php echo $bg_color === 'white' ? 'black' : 'white'; ?>;
    }
    .card-body {
        background-color: <?php echo $bg_color === 'white' ? 'white' : '#333'; ?>;
        color: <?php echo $bg_color === 'white' ? 'black' : 'white'; ?>;
    }
    .btn-primary {
        background-color: <?php echo $bg_color === 'white' ? '#007bff' : '#555'; ?>;
        border-color: <?php echo $bg_color === 'white' ? '#007bff' : '#555'; ?>;
    }
    h6 {
        color: <?php echo $bg_color === 'white' ? 'black' : 'white'; ?>;
    }
    .bg-color {
        background-color: <?php echo $bg_color; ?>;
        color: <?php echo $bg_color === 'white' ? 'black' : 'white'; ?>;
    }
    td span {
        color: gray; /* Default text color for dates */
    }
    .highlight span {
        color: white; /* Highlighted text color for dates with shows */
    }
</style>

</head>
<body>
<header>
  <?php include 'navbar.php'; ?>
</header>

<section class="calendar-show">
  <div class="container">
    <div class="row">
      <div class="col-12 text-center">
        <h1>Calendar</h1>
      </div>
    </div>
    <div class="row mt-4">
      <!-- Calendar -->
      <div class="col-md-4">
        <p class="muaji"><?php $currentMonth = date('F'); echo $currentMonth; ?></p>
        <table id="calendar">
          <thead>
            <tr>
              <th>Sun</th>
              <th>Mon</th>
              <th>Tue</th>
              <th>Wed</th>
              <th>Thu</th>
              <th>Fri</th>
              <th>Sat</th>
            </tr>
          </thead>
          <tbody>
            <?php include 'generate_calendar.php'; ?>
          </tbody>
        </table>
      </div>
      <!-- Show Information for Selected Day -->
      <div class="col-md-8">
        <div class="card">
          <div class="row g-0">
            <!-- Show Image -->
            <div class="col-md-4">
              <img id="showImage" class="card-img show-img img-fluid" alt="Show Image">
            </div>
            <!-- Show Information -->
            <div class="col-md-8 show-info">
              <div class="card-body">
                <h5 class="card-title" id="showTitle">Selected Day's Show</h5>
                <h6 class="card-subtitle mb-2" id="selectedDate">Date: </h6>
                <p class="card-text" id="director">Director: </p>
                <p class="card-text" id="runningTime">Running Time: </p>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-4 mb-5 pb-5 text-center">
        <div class="col-md-6">
          <a href="contact.php" class="btn btn-primary butonat">Go to Contact</a>
        </div>
        <div class="col-md-6">
          <a href="biletat.php" class="btn btn-primary butonat">Go to Tickets</a>
        </div>
      </div>
    </div>
  </div>
</section>

<footer class="text-center py-3 bg-color" id="animate-trans">
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
        <p>&copy; <span id="remove">2023</span> <a href="#go-to-nav" id="top" style="text-decoration: none; color: <?php echo $bg_color === 'white' ? 'black' : 'white'; ?>;">National Theater of Kosovo</a></p>
      </div>
    </div>
  </div>
</footer>

<script src="resources/js/contact.js"></script>
<script>
  $(document).ready(function() {
    $('#remove').remove();

    // Click event for calendar dates
    $('#calendar').on('click', 'td.highlight', function() {
      var selectedDate = $(this).data('date');
      $('#selectedDate').text('Date: ' + selectedDate);
      
      // Fetch show details for the selected date
      $.ajax({
        url: 'get_show_details.php',
        method: 'POST',
        data: { date: selectedDate },
        dataType: 'json',
        success: function(response) {
          if (response) {
            $('#showTitle').text(response.emrin);
            $('#director').text('Director: ' + response.regjisorin);
            $('#runningTime').text('Running Time: ' + response.duration);
            $('#showImage').attr('src', response.foto);
          } else {
            $('#showTitle').text('No show available');
            $('#director').text('Director: N/A');
            $('#runningTime').text('Running Time: N/A');
            $('#showImage').attr('src', '');
          }
        },
        error: function(xhr, status, error) {
          console.error(error);
        }
      });
    });
  });
</script>

</body>
</html>
