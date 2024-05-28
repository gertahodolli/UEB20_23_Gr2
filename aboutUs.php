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
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['emri'])) {
    // Retrieve form data
    $emriDheMbiemri = $_POST['emri'];
    $pozita = $_POST['puna'];
    $email = $_POST['email'];
    $tel = $_POST['telefoni'];
    $mosha = $_POST['mosha'];
    $koment = $_POST['komente'];

    // Create a new connection to the database
    include 'database/db_connect.php'; // Ensure the connection details are correct

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO apliko (emriDheMbiemri, pozita, email, tel, mosha, koment) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die('prepare() failed: ' . htmlspecialchars($conn->error));
    }

    $bind = $stmt->bind_param("ssssis", $emriDheMbiemri, $pozita, $email, $tel, $mosha, $koment);
    if ($bind === false) {
        die('bind_param() failed: ' . htmlspecialchars($stmt->error));
    }

    // Execute the statement
    $exec = $stmt->execute();
    if ($exec) {
        echo "New record created successfully";
    } else {
        echo "Error: " . htmlspecialchars($stmt->error);
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();

    // Redirect to avoid resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="resources/css/aboutUs.css">
    <link rel="stylesheet" href="resources/css/home.css">
    <link rel="stylesheet" href="resources/css/modal.css">
    <link href="./libraries/bootstrap-5.3.2-dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="./libraries/bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="...">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-egFbsXOp+g8gP2Vj8DR5FPa/Wh0TSO+zreQ0ZwPvvlS7CdltqAcMQn3O4d2Zx15bwQPGssS1NN5cx+s/ISv6Bw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>About Us</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <link rel="icon" type="image/png" href="resources/images/logo1.png"/>

    <style>
        #puzzle-container {
            width: 300px;
            height: 100px;
            border: 2px solid #ccc;
            position: relative;
        }

        #puzzle-drop-zone {
            width: 100%;
            height: 2px;
            background-color: #ccc;
            position: absolute;
            bottom: 0;
        }

        #green-zone {
            width: 40px;
            height: 100%;
            background-color: #4CAF50;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0.3s;
        }

        #puzzle-piece {
            width: 80px;
            height: 80px;
            background-color: #4CAF50;
            color: #fff;
            text-align: center;
            line-height: 80px;
            position: absolute;
            cursor: move;
            clip-path: polygon(50% 0%, 61% 35%, 98% 35%, 68% 57%, 79% 91%, 50% 70%, 21% 91%, 32% 57%, 2% 35%, 39% 35%);
        }
    </style>

</head>

<body>

<?php include 'navbar.php'; ?>

    <header>
        <div class="container">
            <div class="left-section">
                <h2>About Us</h2>
                <hr class="divider">
                <p>Theater is an incomparable treasure of the soul. It is one of the most powerful tools to reflect, raise questions, and inspire change in society. </p>
                <p class="small-text">
                    Theater is a free voice that seeks justice, humanity and a deep understanding of life.
                    <br><br>
                    <b>Azem Shkreli</b> <br> Albanian poet and literary critic.
                </p>
            </div>

            <div class="right-section">
                <div class="image-container">
                    <div class="frame">
                        <img src="resources/images/AzemShkreli.jpg" alt="Azem Shkreli" class="framed-image">
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="other-part-of-head">
        <div class="blur-background"></div>
        <div class="background-2">
            <div class="wrapper">
                <div class="center-line">
                  <a href="#" class="scroll-icon"><i class="fas fa-caret-up"></i></a>
                </div>
                <div class="row row-1">
                  <section>
                    <i class="icon fa fa-theater-masks"></i>
                    <div class="details">
                      <span class="title">Reshat Arbana</span>
                      <span>September 15, 1940</span>
                    </div>
                    <img src="resources/images/ReshatArbana.jpg">
                    <p>Albanian actor Reshat Arbana has a long and successful career in the theater. He has performed many different roles including popular Albanian and world dramas.</p>
                </section>
                </div>
                <div class="row row-2">
                  <section>
                    <i class="icon fa fa-theater-masks"></i>
                    <div class="details">
                      <span class="title">Adriana Matoshi</span>
                      <span>February 5, 1980</span>
                    </div>
                    <img src="resources/images/AdrianaMatoshi.jpg">
                    <p> Adriana Matoshi is an outstanding actress and director. She has excelled in several shows known as "Dasma Shqiptare" and has won high praise for her talent and theatrical presentation.</p>
                </section>
                </div>
            
            
                <div class="row row-1">
                  <section>
                    <i class="icon fa fa-theater-masks"></i>
                    <div class="details">
                      <span class="title">Blerim Destani</span>
                      <span>April 12, 1981</span>
                    </div>
                    <div>           
                            <img src="resources/images/BlerimiDestani.jpg">
                            <p>The well-known actor Blerim Destani has had a successful career, playing in many theater plays. He has outstanding acting skills and has won critical acclaim.</p>
                    </div>
                  </section>
                </div>
                <div class="row row-2">
                  <section>
                    <i class="icon fa fa-theater-masks"></i>
                    <div class="details">
                      <span class="title">Ermonela Jaho</span>
                      <span>1974</span>
                    </div>
                    <img src="resources/images/ErmonelaJaho.jpg">
                    <p>Although internationally known for her role in the opera, Ermonela Jaho has also excelled in several theater performances in Kosovo. She is known for her outstanding acting ability.</p>
                  </section>
                </div>
            
            
                <div class="row row-1">
                  <section>
                    <i class="icon fa fa-theater-masks"></i>
                    <div class="details">
                      <span class="title">Veton Osmani</span>
                      <span></span>
                    </div>
                    <img src="resources/images/VetonOsmani.jpg">
                    <p>Veton Osmani has contributed to many theater projects, acting and directing. He has a penchant for innovative and experimental projects on the theatrical stage.</p>
                </section>
                </div>
                <div class="row row-2"> 
                    <section>
                      <i class="icon fa fa-theater-masks"></i>
                      <button type="button" data-bs-toggle="modal" data-bs-target="#myModal" style="color:rgba(255, 255, 255, 0.745); background-color:rgba(0, 0, 0, 0.186); border: none;">
                        Apply now, be part of our theater!
                      </button>
                    </section>
                  </div>
        </div>
    </div>

    <div class="parallax-footer">
        <div class="container">
          <h1>National Theater <br>of <br>Kosovo</h1>
          <p id="history">Here the history of the National Theater in Kosovo will be written...</p>
         </div>
    </div>

    <footer class="text-white text-center py-3 bg-color" id="animate-trans">
        <div class="footer-container">
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

    <!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Be part of us</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Forma e re -->
          <form id="application-form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <!-- Input tekst -->
            <div class="mb-3">
              <label for="emri" class="form-label">Name and surname:</label>
              <input type="text" class="form-control" id="emri" name="emri" autocomplete="name" required>
            </div>

            <div class="mb-3">
              <label class="form-check-label">Answer if you have theater experience:</label>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="experienceteater" name="experienceteater">
                <label class="form-check-label" for="experienceteater">I used to work in the theater</label>
              </div>
            </div>

            <div class="mb-3">
              <label for="puna" class="form-label">The job you are applying for:</label>
              <input list="listapunave" name="puna" id="puna" class="form-control" autocomplete="on" required>
              <datalist id="listapunave">
                <option value="Actor">
                <option value="Stage manager">
                <option value="Theater costume designer">
                <option value="Artistic Director">
              </datalist>
            </div>
  
            <!-- Patw (një atribut i ri i propozuar për input) -->
            <div class="mb-3">
              <label for="email" class="form-label">Email:</label>
              <input type="email" class="form-control" id="email" name="email" patw="yes" required>
            </div>
  
            <div class="mb-3">
              <label for="telefoni" class="form-label">Numri i telefonit:</label>
              <input type="tel" class="form-control" id="telefoni" name="telefoni" pattern="[0-9]{3}-[0-9]{3}-[0-9]{3}" placeholder="Formati: xxx-xxx-xxx" required>
            </div>
  
            <!-- Input për moshë me min dhe max -->
            <div class="mb-3">
              <label for="mosha" class="form-label">Age:</label>
              <input type="number" class="form-control" id="mosha" name="mosha" min="18" max="99" required>
            </div>
  
            <!-- Input për koment me placeholder -->
            <div class="mb-3">
              <label for="komente" class="form-label">Comment:</label>
              <input type="text" class="form-control" id="komente" name="komente" placeholder="Shkruani komentin tuaj..." required>
            </div>
            
            <p style="font-size: small;">Are you a human? <b>Drag me in the middle...</b></p>
            <div id="puzzle-container" ondrop="drop(event)" ondragover="allowDrop(event)">
              <div id="puzzle-piece" draggable="true" ondragstart="drag(event)">Drag me!</div>
              <div id="puzzle-drop-zone">
                  <div id="green-zone"></div>
              </div>
          </div>          
            <br>

            <!-- Butoni Submit -->
            <button type="submit" class="btn btn-secondary">Apply now</button>
          
          </form>
        </div>
      </div>
    </div>
  </div>
  
       
  <script>
        function updateCurrentDateTime() {
            var currentDateTimeElement = document.getElementById("currentDateTime");
    
            if (currentDateTimeElement) {
                var currentDate = new Date();
                var options = {
                    year: 'numeric',
                    month: 'numeric',
                    day: 'numeric',
                    hour: 'numeric',
                    minute: 'numeric',
                    second: 'numeric',
                    hour12: true 
                };
                
                var formattedDate = currentDate.toLocaleDateString('en-US', options);
                currentDateTimeElement.textContent = "Current Date and Time: " + formattedDate;
            }
        }
    
        // Call the function to update the current date and time when the page loads
        window.onload = function () {
            updateCurrentDateTime();
    
            // Update the current date and time every second
            setInterval(updateCurrentDateTime, 1000);
        };
    </script>

    <script>
      (function() {
        document.addEventListener('DOMContentLoaded', function () {
          function TheaterHistory(years, developments, contribution, perspective) {
            this.years = years;
            this.developments = developments;
            this.contribution = contribution;
            this.perspective = perspective;
          }

          // Create an instance of the TheaterHistory object
          var nationalTheaterHistory = new TheaterHistory(
            "Founded in 1971, the theater has a rich history that includes its inception and early years.",
            "Undergoing numerous developments and changes throughout the years, it has evolved into a dynamic cultural institution.",
            "Having a profound impact on Kosovo's culture and art, the theater has become a symbol of artistic expression.",
            "Today, the National Theater stands as one of the foremost cultural institutions in Kosovo, contributing significantly to the arts scene."
          );

          // Display the history on the page
          var historyElement = document.getElementById('history');
          historyElement.innerHTML = "<strong>Years:</strong> " + nationalTheaterHistory.years + "<br><br>" +
                                    "<strong>Developments:</strong> " + nationalTheaterHistory.developments + "<br><br>" +
                                    "<strong>Contribution:</strong> " + nationalTheaterHistory.contribution + "<br><br>" +
                                    "<strong>Perspective:</strong> " + nationalTheaterHistory.perspective;
        });
      })();
    </script>

    <script>
      $(document).ready(function() {
      // Select the element with the ID 'remove'
      $('#remove').remove();
    });

    </script>

<script>
  function allowDrop(event) {
      event.preventDefault();
  }

  function drag(event) {
      event.dataTransfer.setData("text", event.target.id);
  }

  function drop(event) {
      event.preventDefault();
      var data = event.dataTransfer.getData("text");
      var draggedElement = document.getElementById(data);
      var puzzleContainer = document.getElementById("puzzle-container");
      var puzzleDropZone = document.getElementById("puzzle-drop-zone");
      var greenZone = document.getElementById("green-zone");
      var form = document.getElementById("application-form"); // Add an ID to your form

      // Set the new position of the dragged element based on the mouse coordinates
      draggedElement.style.left = (event.clientX - puzzleContainer.getBoundingClientRect().left - draggedElement.clientWidth / 2) + "px";
      draggedElement.style.top = (event.clientY - puzzleContainer.getBoundingClientRect().top - draggedElement.clientHeight / 2) + "px";

      // Check if the puzzle piece is in the middle of the drop zone
      var puzzleMiddleX = puzzleDropZone.offsetWidth / 2;
      var puzzlePieceMiddleX = draggedElement.offsetLeft + draggedElement.offsetWidth / 2;

      if (Math.abs(puzzlePieceMiddleX - puzzleMiddleX) < 10) { // Adjust the threshold as needed
          // Puzzle piece is in the middle of the drop zone
          greenZone.style.opacity = 1; // Show the green zone
          form.removeAttribute("onsubmit"); // Remove the onsubmit attribute to allow form submission
      } else {
          // Puzzle piece is not in the middle of the drop zone
          greenZone.style.opacity = 0; // Hide the green zone
          alert("Try again!"); // Show an alert for trying again
          form.setAttribute("onsubmit", "return false;"); // Disable form submission
      }
  }
</script>

</body>
</html>
