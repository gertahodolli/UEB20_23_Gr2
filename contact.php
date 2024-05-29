<?php
session_start();  // Start the session at the top of the script
require 'database/db_connect.php';  // Include the database connection file
require 'vendors/phpmailer/src/PHPMailer.php';
require 'vendors/phpmailer/src/SMTP.php';
require 'vendors/phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if a feedback form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['emri'], $_POST['email'], $_POST['feedback'], $_POST['rating'])) {
    
    $name = filter_var($_POST['emri'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $feedback = filter_var($_POST['feedback'], FILTER_SANITIZE_STRING);
    $rating = filter_var($_POST['rating'], FILTER_VALIDATE_INT);
    
    // Prepare the SQL query
    $sql = "INSERT INTO feedback (name, email, rating, feedback) VALUES ('$name', '$email', '$rating', '$feedback')";
    
    // Attempt to execute the query
    if (mysqli_query($conn, $sql)) {
        // Store feedback in session for display
        $_SESSION['feedbacks'][] = ['name' => $name, 'rating' => $rating, 'feedback' => $feedback];
        
        // Send email using PHPMailer
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'teatrikombetarikosoves02@gmail.com';   // SMTP username
            $mail->Password   = 'gqzzhbjlcyugifwc';                     // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption
            $mail->Port       = 587;                                    // TCP port to connect to

            // Recipients
            $mail->setFrom('teatrikombetarikosoves02@gmail.com', 'Theater Feedback');
            $mail->addAddress('boxoffice@gmail.com', 'Theater Box Office');     // Add a recipient
            
            // Content
            $mail->isHTML(true);                                        // Set email format to HTML
            $mail->Subject = 'New Feedback Received';
            $mail->Body    = "You have received new feedback from <b>$name</b>.<br><br>" .
                             "Email: $email<br>" .
                             "Rating: $rating<br>" .
                             "Feedback: $feedback";
            
            $mail->send();
            echo 'Feedback has been sent successfully';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "ERROR: Could not execute $sql. " . mysqli_error($conn);
    }
    
    // Close the connection
    mysqli_close($conn);
}
?>

<!-- Continue with your HTML and embedded PHP for display -->
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
if (isset($_COOKIE[$cookie_name])) {
    // Cookie exists, get its value
    $bg_color = $_COOKIE[$cookie_name];
} else {
    // Cookie does not exist, set a default value
    $bg_color = "black";
    set_cookie($cookie_name, $bg_color, 86400); // Cookie expires in 1 day
}

// Process form submission for color selection
if (isset($_POST['color'])) {
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
    <title>Contact Us</title>
    <link rel="stylesheet" type="text/css" href="resources/css/contact.css">
    <link rel="stylesheet" href="./resources/css/home.css">
    <link href="./libraries/bootstrap-5.3.2-dist/css/bootstrap.min.css" rel="stylesheet" >
    <script src="./libraries/bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="...">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="icon" type="image/png" href="resources/images/logo1.png"/>
    <style>
        .ratings-comments { /* Light grey background */
        color: white;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1); /* Optional: adds shadow for better visibility */
        }

        .comment {
        /* White background for each comment */
        padding: 10px;
        margin-bottom: 10px;
        border-left: 5px solid; /* Blue left border for visual effect */
        font-style: italic;
        color: white;
        }
    </style>
</head>
<body>
    <div class="color">
        <!-- Navbar -->
        <header id='go-to-nav'>
        <?php include 'navbar.php'; ?>
        </header>

        <!--Scroll to top button-->
        <div id="arrow-button">&#8593;</div>

        <section class="contact">
            <div class="container">
                <div class="row text-center mt-4" style="color: aliceblue;">
                    <h1>Contact Us & Hours</h1>
                </div>
                <div class="row mt-5">
                    <div class="col-sm-4 ">
                        <h2>Box Office</h2>
                    </div>
                    <div class="col-sm-4 ">
                        <div class="">
                            <h2>Contact</h2>
                            <address>
                                <p>CALL: <a href="tel:+38344753330">+383(44) 753330</a></p>
                                <p>EMAIL: <a href="mailto:boxoffice@example.com">boxoffice@gmail.com</a></p>
                                <p>IN PERSON: Street Luan Haradinaj, Prishtina</p>
                            </address>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="">
                            <h2>Hours</h2>
                            <h4>Days with Performance</h4>
                            <p>Our box office remains open until 30 minutes after the start of each performance.</p>
                            <h4>Standard Ticket Hours</h4>
                            <section class="standard-ticket-hours">
                                <ol>
                                    <li>Monday to Friday: 9:30 am - 5:00 pm</li>
                                    <li>Saturday: 10:30 am - 5:00 pm</li>
                                    <li>Sunday: Opens 1 hour prior to each performance</li>
                                </ol>
                            </section>
                        </div>
                    </div>
                </div>
                
                <div class="container mt-5">
                    <svg width="100%" height="30">
                        <line x1="0%" y1="15" x2="100%" y2="15" style="stroke:white; stroke-width:2" />
                    </svg>
                    <div class="row mt-5 mb-5">
                        <div class="col-sm-4">
                            <h2>Enquiries</h2>
                        </div>
                        <div class="col-sm-4">
                            <div class="inquiry-item1">
                                <h5>EDUCATION ENQUIRIES</h5>
                                <p>ERTA BEKA / 383(44)733443</p>
                                <p><a href="mailto:erta@gmail.com">erta@gmail.com</a></p>
                            </div> 
                            <div class="inquiry-item1">
                                <h5>VENUE ENQUIRIES</h5>
                                <p>MAJA BERISHA / 383(44)464647</p>
                                <p><a href="mailto:majab@gmail.com">majab@gmail.com</a></p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="inquiry-item">
                                <h5>STAFFING ENQUIRIES</h5>
                                <p>SAMI BISLIMI / 383(44)473503</p>
                                <p><a href="mailto:samib@egmail.com">samib@egmail.com</a></p>
                            </div>
                            <div class="inquiry-item">
                                <h5>SPONSORSHIP & DONATION</h5>
                                <p>SARA GASHI / 383(44)464647</p>
                                <p><a href="mailto:sara@gmail.com">sara@gmail.com</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Live Chat --> 
        <div id="liveChatPopup" class="popup">
            <div id="liveChatSection">
                <h2>Contact Me</h2>
                <p id="requiredFields">Fields marked with an * are required</p>
                <label for="liveChatName">Name*:</label>
                <input type="text" id="liveChatName" name="liveChatName" required onblur="validateName()"  placeholder="Your Name">
                <p id="nameFormatHint" class="hint" style="color: #8d1a1a; display: none;">Make sure to enter a valid name without numbers.</p>
                
                <label for="liveChatEmail">Email*:</label>
                <input type="email" id="liveChatEmail" name="liveChatEmail" required onblur="validateEmail()" placeholder="YourEmail@gmail.com">
                <p id="emailFormatHint" class="hint" style="color: #8d1a1a; display: none;">Make sure to enter a valid email address.</p>
                
                <div class="form-section">
                    <label for="liveChatInput">Choose Department:</label>
                    <select id="liveChatInput" name="liveChatInput" required>
                        <option value="Ticketing">Ticketing</option>
                        <option value="Technical Support">Technical Support</option>
                        <option value="General Inquiry" selected>General Inquiry</option>
                    </select>
                </div>
                
                <label for="liveChatMessage">Message*:</label>
                <textarea id="liveChatMessage" name="liveChatMessage" rows="4" required onblur="validateMessage()" placeholder="Your Message"></textarea>
                <p id="messageFormatHint" class="hint" style="color: #8d1a1a; display: none;">Please enter a message before submitting.</p>

                <button class="btn btn-primary butonat" onclick="submitLiveChat()">Submit</button>
                <button class="btn btn-primary butonat" onclick="closePopup()">Close</button>
            </div>
        </div>

        <!-- Harta -->
        <section>
            <div class="container-fluid bg-dark py-5">
                <div>
                    <div class="center-text">
                        <h2>Getting Here</h2>
                        <iframe
                            width="100%"
                            height="300"
                            frameborder="0" style="border:0"
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14866.283348271413!2d21.1567011!3d42.6610999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x189f57f3727e8636!2sYouth%20and%20Sports%20Center!5e0!3m2!1sen!2sus!4v1651405369999!5m2!1sen!2sus" allowfullscreen>
                        </iframe>
                        <p>M564+CMP, Luan Haradinaj, Prishtina</p>
                    </div>
                    <section class="additional-section">
                        <h5>PARKING SPOTS</h5>
                        <p>
                            Adjacent to the theater, our spacious and well-lit parking facility offers stress-free access. 
                            Enjoy secure and convenient on-site parking, ensuring a hassle-free experience before you even enter 
                            the venue. Your theater visit starts with easy and welcoming parking.
                        </p>
                        <h5>ON A BUS</h5>
                        <p>The following transit lines have routes that pass near the theatre: 1 & 4</p>
                    </section>
                </div>
            </div>
        </section>

        <!-- FAQs -->
        <section class="container mt-5">
            <div class="row text-center faqs-heading">
                <h2>Frequently Asked Questions</h2>
            </div>
            <div class="row mt-5">
                <div class="col-6">
                    <h3 class="faqs-title">TICKET INFORMATION</h3>
                    <ul class="faqs-list">
                        <li>
                            <details>
                                <summary>How can I purchase tickets?</summary>
                                <p>You can conveniently purchase <strong><a href="biletat.html" class="buy-tickets">tickets</a></strong> through our website or at the box office in person. Our online platform allows for easy browsing, seat selection, and secure payment.</p>
                            </details>
                        </li>
                        <li>
                            <details>
                                <summary>Are there discounts for seniors, students, or group bookings?</summary>
                                <p>Yes, we offer discounts for seniors and students. Additionally, we have special rates for group bookings, providing a cost-effective option for larger audiences. Check our website or contact the box office for more details.</p>
                            </details>
                        </li>
                        <li>
                            <details>
                                <summary>What is your refund policy?</summary>
                                <p>Our refund policy allows for ticket refunds or exchanges under certain circumstances. Please refer to our website or contact the box office for specific details and assistance with any refund inquiries.</p>
                            </details>
                        </li>
                    </ul>

                </div>
                <div class="col-6">
                    <h3 class="faqs-title">VENUE AND SEATING</h3>
                    <ul class="faqs-list">
                        <li>
                            <details>
                                <summary>How can I view the seating chart?</summary>
                                <p>You can easily view our seating chart on our website when purchasing tickets. The interactive chart provides a visual representation of available seats, allowing you to choose the best spot for your preference.</p>
                            </details>
                        </li>
                        <li>
                            <details>
                                <summary>Is there reserved seating?</summary>
                                <p>Yes, we offer reserved seating for all our performances. When purchasing tickets, you can select your preferred seats from the available options, ensuring a designated spot for your convenience.</p>
                            </details>
                        </li>
                        <li>
                            <details>
                                <summary>Do you have accessible seating for individuals with mobility challenges?</summary>
                                <p>Absolutely. We provide accessible seating to accommodate individuals with mobility challenges. Please inform our box office staff of your specific needs, and they will assist you in selecting suitable and comfortable seating options.</p>
                            </details>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-6">
                    <h3 class="faqs-title">EVENT POLICIES</h3>
                    <ul class="faqs-list">
                        <li>
                            <details>
                                <summary>What is your policy on late arrivals?</summary>
                                <p>We recommend arriving at least 30 minutes before the start of the performance. Late arrivals may not be permitted to enter the theater until a suitable break in the performance.</p>
                            </details>
                        </li>
                        <li>
                            <details>
                                <summary>What is your policy on photography and recording?</summary>
                                <p>Photography and recording are strictly prohibited during performances. We ask that you please turn off your mobile devices and refrain from using them during the performance.</p>
                            </details>
                        </li>
                        <li>
                            <details>
                                <summary>What is your policy on food and drinks?</summary>
                                <p>Outside food and drinks are not permitted in the theater. We have a concession stand that offers a variety of snacks and beverages for your enjoyment.</p>
                            </details>
                        </li>
                    </ul>
                </div>
                <div class="col-6">
                    <h3 class="faqs-title">LOST AND FOUND</h3>
                    <ul class="faqs-list">
                        <li>
                            <details>
                                <summary>What should I do if I lose something at the theater?</summary>
                                <p>In the event that you misplace an item during your visit, please promptly notify our staff. We will make every effort to assist you in locating your lost belongings.</p>
                            </details>
                        </li>
                        <li>
                            <details>
                                <summary>Is there a lost and found service, and how can I inquire about lost items?</summary>
                                <p>Yes, we have a dedicated lost and found service to help reunite guests with their belongings. If you've lost an item, please contact our box office or visit the information desk, and our team will assist you in checking the lost and found inventory.</p>
                            </details>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Accessibility -->
        <section class="container mt-5">
            <div class="horizontal-line"></div>
            <section class="accessibility-section">
                <div class="accessibility-content">
                    <h2>Accessibility Information</h2>
                    <br>
                    <h4>Wheelchair Access</h4>
                    <p>Our venue is wheelchair accessible. If you require assistance, please contact our staff in advance.</p>
                    <p>Additional information about wheelchair access can be provided upon request. We strive to make our events inclusive for all attendees.</p>
                    
                    <h4>Hearing Aids</h4>
                    <p>We provide assistive listening devices for visitors with hearing impairments. Please inquire at the box office.</p>
                    <p>Our staff is trained to assist individuals with hearing aids and other hearing devices. If you have specific needs, feel free to reach out to us in advance.</p>
                </div>
                <img class="accessibility-image" src="resources/images/Teater.jpeg" alt="Teater" />
            </section>
        </section>

        <section class="container mt-5 mb-5">
            <section class="feedback-section">
                <div class="row">
                    <!-- Paragrafi para butonit -->
                    <p class="p-2" id="feedbackIntro">We value your feedback! Your thoughts and opinions are important to us. Please take a moment to share your feedback by clicking the button below. We appreciate your input and use it to enhance our services. Thank you for helping us improve!</p>
                    <!-- Feedback Button -->
                    <div class="text-center mt-1 mb-">
                        <button class="btn btn-primary" id="openFeedbackFormBtn" style="background-color: rgba(145, 15, 18, 0.7); border: none;">Feedback</button>
                    </div>

                    <!-- Feedback Popup Form -->
                    <div id="feedbackPopup" class="popup1" style="display: none;">
                        <h2>Feedback Form</h2>
                        <form id="feedbackForm" method="post" action="">
                            <!-- Name Field -->
                            <div class="form-section">
                                <label for="emri">Name:</label>
                                <input type="text" id="emri" name="emri" required placeholder="Your name" autocomplete="on" pattern="[A-Za-z\s]+">
                            </div>

                            <!-- Email Field -->
                            <div class="form-section">
                                <label for="email">Email:</label>
                                <input type="email" id="email" name="email" required placeholder="Your email" autocomplete="on" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}">
                            </div>

                            <!-- Rating Field -->
                            <div class="form-section">
                                <label for="rating">Overall Satisfaction:</label>
                                <input list="ratings" name="rating" id="rating" placeholder="Select your satisfaction level" required min="1" max="5">
                                <datalist id="ratings">
                                    <option value="1"></option>
                                    <option value="2"></option>
                                    <option value="3"></option>
                                    <option value="4"></option>
                                    <option value="5"></option>
                                </datalist>
                            </div>

                            <!-- Feedback Field -->
                            <div class="form-section">
                                <label for="feedback">Feedback:</label>
                                <textarea id="feedback" name="feedback" rows="4" required placeholder="Your feedback" autocomplete="on" pattern="[A-Za-z0-9\s]+"></textarea>
                            </div>

                            <!-- Form Submission Buttons -->
                            <div class="button-container">
                                <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
                                <button type="button" class="btn btn-primary" onclick="closePopup()">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </section>

        <!-- Displaying Feedback -->
        <section class="ratings-comments container mt-5">
            <div class="row">
                <div class="col-md-6">
                    <h2>Latest Ratings</h2>
                    <ul>
                        <?php
                        // Check if session variable exists and is not empty
                        if (!empty($_SESSION['feedbacks'])) {
                            // Get the last three feedback entries
                            $lastThreeFeedbacks = array_slice($_SESSION['feedbacks'], -3, 3, true);
                            foreach ($lastThreeFeedbacks as $feedback) {
                                echo "<li>" . htmlspecialchars($feedback['rating']) . " stars - " . htmlspecialchars($feedback['name']) . "</li>";
                            }
                        }
                        ?>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h2>Comments</h2>
                    <?php
                    if (!empty($_SESSION['feedbacks'])) {
                        foreach ($lastThreeFeedbacks as $feedback) {
                            echo "<p>\"" . htmlspecialchars($feedback['feedback']) . "\" - <em>" . htmlspecialchars($feedback['name']) . "</em></p>";
                        }
                    }
                    ?>
                </div>
            </div>
        </section>

        <!-- Footer -->
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
                            <label for="color-select">Select Background Color:</label>
                            <select name="color" id="color-select">
                                <option value="white" <?php if($bg_color === 'white') echo 'selected'; ?>>Light</option>
                                <option value="black" <?php if($bg_color === 'black') echo 'selected'; ?>>Dark</option>
                                <!-- Add more color options as needed -->
                            </select>
                            <button type="submit" style="display: inline-block; background-color: white; color: black; padding: 8px 12px; border: 1px solid #007bff; border-radius: 4px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 1rem; line-height: 1.5; text-align: center; cursor: pointer; box-shadow: none; transition: background-color 0.3s ease-in-out;width: 60px;">Save</button>
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
            document.getElementById('openFeedbackFormBtn').addEventListener('click', function() {
                document.getElementById('feedbackPopup').style.display = 'block';
            });

            function closePopup() {
                document.getElementById('feedbackPopup').style.display = 'none';
            }

            $(document).ready(function(){
                $('.btn-style').css('background-color', 'red'); 
            });

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

                // Remove element with ID 'remove'
                $('#remove').remove();
            });

            // Close the feedback form when clicking outside the form
            window.addEventListener('click', function(event) {
                var feedbackPopup = document.getElementById('feedbackPopup');
                if (event.target == feedbackPopup) {
                    feedbackPopup.style.display = 'none';
                }
            });

            // Function to close the popup (in case it's used elsewhere)
            function closePopup() {
                document.getElementById('feedbackPopup').style.display = 'none';
            }
        </script>

        <script src ="resources/js/contact.js"></script>
    </div>
</body>
</html>
