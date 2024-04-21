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
<?php
// Start the session
session_start();

// Check if the visit count session variable exists
if (!isset($_SESSION['visit_count'])) {
    // If not, initialize it to 1
    $_SESSION['visit_count'] = 1;
} else {
    // If it exists, increment it by 1
    $_SESSION['visit_count']++;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="resources/css/home.css">
    <link href="./libraries/bootstrap-5.3.2-dist/css/bootstrap.min.css" rel="stylesheet" >
    <script src="./libraries/bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="...">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>National Theater of Kosovo</title>

    <link rel="icon" type="image/png" href="resources/images/logo1.png"/>

    <style>
          body, html {
              background-color: <?php echo $bg_color; ?>;
              color: <?php echo $bg_color === 'white' ? 'black' : 'white'; ?>;
          }
        .full-page {
            height: 100vh; /* Set section to full viewport height */
            background-image: url('resources/images/aboutUs(3).png'),url('second_image.jpg'); /* Default background images */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: scroll;
            background-origin: padding-box;
            position: relative;
            }
            .overlay-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: <?php echo $bg_color === 'white' ? 'black' : 'white'; ?>;
            text-shadow: <?php echo $bg_color === 'white' ? '2px 2px 2px grey' : '2px 2px 2px black'; ?>;
            text-align: center;
            }

            /* Style for the hover buttons */
            .hover-button {
            display: none;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 50px;
            height: 50px;
            background-color: <?php echo $bg_color === 'white' ? 'rgba(0, 0, 0, 0.5)' : 'rgba(255, 255, 255, 0.5)'; ?>;
            text-align: center;
            line-height: 50px;
            cursor: pointer;
            }
            .hover-button.left {
            left: 0;
            }
            .hover-button.right {
            right: 0;
            }

            .full-page:hover .hover-button {
            display: block;
            }

            #arrow-button {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 20px;
            cursor: pointer;
            background-color: #555; /* Grey background color */
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            }

            .full-page {
            background-color: <?php echo $bg_color; ?>; /* Adjust the background color for the full page */
            }

            .bg-color {
                background-color: <?php echo $bg_color; ?>;
                color: <?php echo $bg_color === 'white' ? 'black' : 'white'; ?>;
            }

            .sponsor-changes{
                background-color: <?php echo $bg_color; ?>;
                color: <?php echo $bg_color === 'white' ? 'black' : 'white'; ?>;
            }

            section{
                background-color: <?php echo $bg_color; ?>;
                color: <?php echo $bg_color === 'white' ? 'black' : 'white'; ?>;
            }

            .about-changes{
                background-color: <?php echo $bg_color; ?>;
                color: <?php echo $bg_color === 'white' ? 'black' : 'white'; ?>;
            }



        
    </style>




</head>


<body>
    <!-- Navbar -->
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
                  <a class="nav-link btn btn-primary butoni" style=" margin-right: 15px;" href="signUp.php">Log In</a>
                </li>
            </ul>
        </div>
    </nav>
    </header>

    <!--Scroll to top button-->
    <div id="arrow-button">&#8593;</div>

    <!-- Section with switching background picture -->

    <section class="full-page text-center">
        <div class="overlay-text fade-effect">
          <h1 id="showName">GJITHÇKA RRETH IV</h1>
          <p id="director"><b>Director:</b> <u>Hervin Çuli.</u></p>
          <p id="runningTime">Duration: 1:30</p>
        </div>
        <div class="hover-button left" >&lt;</div>
        <div class="hover-button right">&gt;</div>
    </section>
    


    <!-- Section with two recent shows and link to calendar -->
    <section class="container my-5">
    <div class="row">
      <div class="col-md-12">
        <h2 class="text-center mb-5" style="color: <?php echo $bg_color === 'white' ? 'black' : 'white'; ?>;">Recent Shows</h2>
        <!-- Show 1 -->
        <div class="card mb-5">
          <div class="row g-0">
            <div class="col-md-4">
              <img src="resources/shows/1984.png" alt="Show 1 Image" class="img-fluid">
            </div>
            <div class="col-md-8 recent-text-color">
              <div class="card-body">
                <h5 class="card-title show-date1">1984</h5>
                <p class="card-text">Dramatized from author George Orwell's dystopian novel</p>
                <p class="card-text"><b>Director:</b>  <u>Igor Mendjisky</u></p>
                <p class="card-text"><i>Actors:</i> Adrian Morina, Arta Selimi, Basri Lushtaku, Edona Reshitaj, Flaka Latifi, Shpejtim Kastrati, Xhejlane Godanci dhe Ylber Bardhi.</p>
                <p class="card-text date1"><b>Date:</b>  3/12/2023</p>
              </div>
            </div>
          </div>
        </div>
        <!-- Show 2 -->
        <div class="card mb-3">
          <div class="row g-0">
            <div class="col-md-4">
              <img src="resources/shows/club albania.png" alt="Show 2 Image" class="img-fluid">
            </div>
            <div class="col-md-8 recent-text-color">
              <div class="card-body">
                <h5 class="card-title show-date2">CLUB ALBANIA</h5>
                <p class="card-text">The show is based on the comedy, "Pas Vdekjes" by A.Z. Çajupi</p>
                <p class="card-text"><b>Director:</b> <u>Fatos Berisha</u></p>
                <p class="card-text"><i>Actors:</i> Armond Morina, Ard Islami, Armend Smajli, Maylinda Kosumovic, Naim Berisha, Teuta Krasniqi dhe Ylber Bardhi.</p>
                <p class="card-text date2 "><b >Date:</b> 3/12/2023</p>
              </div>
            </div>
          </div>
        </div>
        <a href="calendar.html" class="btn btn-primary butonat" id="goto-calendar">View Calendar</a>
      </div>
    </div>
    </section>

    <!-- Section with theater history-->
    <section class="py-5">
    <div class="container about-changes">
      <div class="row">
        <div class="col-md-6 about-changes" id="slide-ani">
          <h2 id="about-heading">History of</h2>
          <p>The National Theater of Kosovo, abbreviated <abbr title="Teatri Kombetare i Kosoves">TKK</abbr> , is the main performing arts center in Kosovo, founded in 1945 in the city of Prizren in Kosovo. It is ranked as the highest in the country. The National Theater is the only theater in Kosovo and is therefore financed by the <span style="color: rgb(145, 15, 18);" >Ministry of Culture, Youth and Sports</span> . This theater has shown more than <mark style="background-color: #4C4C4C"><a href="#animate-trans" id="myLink" style="text-decoration: none;color: aliceblue;">400 premieres</a></mark> which have been watched by more than <span id="num-calc">3</span>  million viewers. 
          </p>
          <a href="aboutUs.html" class="btn btn-primary butonat goto-about">About Us</a>
        </div>
        <div class="col-md-6">
          <img  name="slide" alt="Founder Image" class="img-fluid">
        </div>
      </div>
    </div>
    </section>

    <audio id="sound1">
      <source  src="resources/images/sound1.mp3" type="audio/wav">
      Your browser does not support the audio element.
    </audio>

    <audio id="sound2">
      <source src="resources/images/swipe_down.mp3" type="audio/mpeg">
      Your browser does not support the audio element.
    </audio>

    <!-- Section with sponsors -->
    <section class="sponsor-changes">
    <div class="container my-2 pb-5">
      <div class="row">
        <div class="col-md-12 text-center mb-5 mt-5">
          <h2>Our Sponsors</h2>
        </div>
        <div class="col-md-6 text-center draggable" draggable="true">
          <img id="draggableImage1" draggable="true" src="resources/images/sponsor1.jpg" alt="Sponsor 1" class="sponsor-img img-fluid mb-3">
        </div>
        <div class="col-md-6 text-center draggable" draggable="true">
          <img id="draggableImage2" draggable="true" src="resources/images/sponsor2.png" alt="Sponsor 2" class="sponsor-img img-fluid mb-3">
        </div>
      </div>
    </div>
    </section>

    <!-- Footer -->
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
          <p>&copy; <span id="remove">2023</span> <a href="#go-to-nav" id="top" style="text-decoration: none;  color: aliceblue;">National Theater of Kosovo</a></p>
        </div>
        <div class="col"><p>Number of Visits: <?php echo $_SESSION['visit_count']; ?></p></div>
      </div>
    </div>
    </footer>



    <!-- Bootstrap JS and other scripts -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <script src ="resources/js/contact.js"></script>
        <script src="resources/js/index.js"></script>


        <script type="text/javascript">
            var i=0;
            var img=[];
            var time=3000
        
            img[0] = '../resources/images/aboutUs.jpg';
            img[1] = '../resources/images/aboutUs(2).jpg';
            img[2] = '../resources/images/aboutUs(3).png';
            
        
          function changeImg() {
            document.slide.src =img[i];
            if (i < img.length -1){
              i++;
            }else{
              i=0;
        
            }
            setTimeout("changeImg()",time);// body...
          }
        
        
          window.onload = changeImg;
        </script>

        <script>
          
          let dragged = null;

          document.addEventListener("dragstart", function(event) {
              // store a reference to the dragged element
              dragged = event.target;
          }, false);

          document.addEventListener("dragend", function(event) {
              // reset the transparency
              if (dragged) {
                  dragged.style.opacity = "";
              }
          }, false);

          document.addEventListener("dragover", function(event) {
              // prevent default to allow drop
              event.preventDefault();
          }, false);

          document.addEventListener("dragenter", function(event) {
              // highlight potential drop target when the draggable element enters it
              if (event.target.classList.contains("draggable")) {
                  event.target.style.background = "purple";
              }
          }, false);

          document.addEventListener("dragleave", function(event) {
              // reset background of potential drop target when the draggable element leaves it
              if (event.target.classList.contains("draggable")) {
                  event.target.style.background = "";
              }
          }, false);

          document.addEventListener("drop", function(event) {
              // prevent default action (open as link for some elements)
              event.preventDefault();

              // move dragged elem to the selected drop target
              if (dragged && event.target.classList.contains("draggable")) {
                  event.target.style.background = "";
                  const temp = document.createElement('div');
                  event.target.parentNode.insertBefore(temp, event.target);
                  dragged.parentNode.insertBefore(event.target, dragged);
                  temp.parentNode.insertBefore(dragged, temp);
                  temp.parentNode.removeChild(temp);
              }
              dragged = null; // reset dragged element after drop
          }, false);
                    
  
        </script>

      <script>
        // Example of using jQuery selectors for changing color
        $(document).ready(function() {
          $('.btn-style').css('background-color', 'red'); // Change text color for buttons
        });
      </script>

      <script>
        $(document).ready(function() {
        // Fade In 
        $('.fade-effect').fadeIn(3000);

        // Slide Out
        $('#slide-ani').slideDown(3000);

        
        });


      </script>

    <script>
      $(document).ready(function(){
        
        $("#animate-trans a").on('click', function(event) {
          var hash = $(this).attr('href');
          if (hash === '#animate-trans') {
            event.preventDefault();


            $('html, body').animate({
              scrollTop: $(hash).offset().top
            }, {
              duration: 800,
              complete: function(){
                window.location.hash = hash;
              }
            });
          }
        });

      });
    </script>





      <script>
        $(document).ready(function(){
          $(".show-date1").click(function(){
            $(".date1").hide(1000);
          });
        });
        $(document).ready(function(){
          $(".show-date1").click(function(){
            $(".date1").show(1000);
          });
        });

        $(document).ready(function(){
          $(".show-date2").click(function(){
            $(".date2").hide(1000);
          });
        });

        $(document).ready(function(){
          $(".show-date2").click(function(){
            $(".date2").show(1000);
          });
        });
      </script>


    <!--Used NaN, toExponential(), toString() -->

      <script>
        var spanElement = document.getElementById('num-calc');

        // Get the text content of the span and convert it to a number
        var numberInSpan = parseInt(spanElement.textContent, 10);

        // Check if the conversion was successful
        if (!isNaN(numberInSpan)) {
          // Use the extracted number
          console.log("Extracted number:", numberInSpan.toExponential(3));

          // Now 'numberInSpan' variable holds the extracted number as a JavaScript number
        } else {
          console.log("No valid number found in the span.");
        }

        //COvert the number back to string

        console.log(numberInSpan.toString());
        
        console.log(Number.MAX_VALUE);





      </script>


      <!--Checking if the word book is mentioned in the paragraph, using try, catch, throw and warn-->

      <script>
        try {
        const paragraph = document.getElementById('try-catch').innerText;
        if (!paragraph.match(/\bbook\b/i)) {
            throw new Error("The word 'book' is not in the paragraph");
        }
        } catch (error) {
            console.warn(error.message);
        }
        
        // Example of using jQuery selectors for changing color
        $(document).ready(function() {
          $('.btn-style').css('background-color', 'red'); // Change text color for buttons
        });

      </script>

      <!--Used jquery add() method-->

      <script>
        $(document).ready(function() {
      // Create a new paragraph element
      var newParagraph = $('<p></p>');

      // Add the new paragraph to the element with class 'card-body'
      $('.card-body').add(newParagraph.appendTo('.card-body'));

      // Set the text for the newly added paragraph
      newParagraph.html('<b>New date:</b> 5/12/2023');
    });
      </script>

      <!--Used remove to delete the span element containing the year-->

      <script>
        $(document).ready(function() {
        // Select the element with the ID 'remove'
        $('#remove').remove();
      });

    </script>


    <!--Added audio files-->

    <script>
      document.getElementById('myLink').addEventListener('click', function() {
      var audio = document.getElementById('sound2');
      audio.play();
      });
    </script>
    

    <script>
      document.getElementById('top').addEventListener('click', function() {
      var audio = document.getElementById('sound1');
      audio.play();
      });
    </script>

    <!--Scroll to Top-->
    <script>
      $(document).ready(function(){
        // Show/Hide arrow button on scroll
        $(window).scroll(function() {
          if ($(this).scrollTop() > 100) {
            $('#arrow-button').fadeIn();
          } else {
            $('#arrow-button').fadeOut();
          }
        });

        // Instant scroll to the navigation bar
        $("#arrow-button").on('click', function() {
          $('html, body').stop().animate({
            scrollTop: $('#go-to-nav').offset().top
          }, {
            duration: 0, // Set duration to 0 for instant scrolling
            complete: function() {
              // Play sound on complete
              var audio = document.getElementById('sound1');
              audio.play();
            }
          });
        });
      });
    </script>
      



    

</body>
</html>
