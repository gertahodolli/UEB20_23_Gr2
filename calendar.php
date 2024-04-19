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


  <section class="calendar-show">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center ">
                <h1>Calendar</h1>
            </div>
        </div>
        <div class="row mt-4">
        <!-- Calendar -->
            <div class="col-md-4">
                <p class="muaji">December</p>
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
                    <tr>
                        <td class="notAvailable">27</td>
                        <td class="notAvailable">28</td>
                        <td class="notAvailable">29</td>
                        <td class="notAvailable">30</td>
                        <td>1</td>
                        <td>2</td>
                        <td><a href="#" class="date-link active">3</a></td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td><a href="#" class="date-link">5</a></td>
                        <td>6</td>
                        <td>7</td>
                        <td>8</td>
                        <td><a href="#" class="date-link">9</a></td>
                        <td><a href="#" class="date-link">10</a></td>
                    </tr>
                    <tr>
                        <td><a href="#" class="date-link">11</a></td>
                        <td>12</td>
                        <td>13</td>
                        <td><a href="#" class="date-link">14</a></td>
                        <td>15</td>
                        <td>16</td>
                        <td><a href="#" class="date-link">17</a></td>
                    </tr>
                    <tr>
                        <td>18</td>
                        <td>19</td>
                        <td>20</td>
                        <td><a href="#" class="date-link">21</a></td>
                        <td>22</td>
                        <td><a href="#" class="date-link">23</a></td>
                        <td>24</td>
                    </tr>
                    <tr>
                        <td>25</td>
                        <td><a href="#" class="date-link">26</a></td>
                        <td>27</td>
                        <td>28</td>
                        <td>29</td>
                        <td><a href="#" class="date-link">30</a></td>
                        <td>31</td>
                    </tr>
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
                              <h6 class="card-subtitle mb-2 text-muted" id="selectedDate">Date: </h6>
                              <p class="card-text" id="director">Director: </p>
                              <p class="card-text" id="runningTime">Running Time: </p>
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
              <a href="contact.html" class="btn btn-primary butonat">Go to Contact</a>
            </div>
            <div class="col-md-6">
              <a href="biletat.html" class="btn btn-primary butonat">Go to Tickets</a>
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
          <p id="currentDateTime"></p>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <p>&copy; <span id="remove">2023</span> <a href="#go-to-nav" id="top" style="text-decoration: none;  color: aliceblue;">National Theater of Kosovo</a></p>
        </div>
      </div>
    </div>
    </footer>




    <script src ="resources/js/contact.js"></script>

  <script src="resources/js/calendar.js"></script>
  <script>
    // Example of using jQuery selectors for changing color
    $(document).ready(function() {
      $('.btn-style').css('background-color', 'red'); // Change text color for buttons
    });
  </script>

  <!-- Used match() and replace() -->

  <script>
    var pElement = document.getElementById('myP');

    var pText = pElement.textContent;

    // Use match to check if the word 'watched' exists in the paragraph
    var matchResult = pText.match("info");

    if (matchResult !== null) {
      // If 'watched' is found, replace it with 'seen' using replace
      var updatedText = pText.replace("info", "information");

      // Update the paragraph content with the replaced text
      pElement.textContent = updatedText;

      // Log the updated text
      console.log(updatedText);
    } else {
      // Log a message if the word 'watched' is not found
      console.log("The word 'watched' is not present in the paragraph.");
    }
  </script>

  <!--Used remove to delete the span element containing the year-->

  <script>
      $(document).ready(function() {
      // Select the element with the ID 'remove'
      $('#remove').remove();
    });

  </script>



</body>
</html>