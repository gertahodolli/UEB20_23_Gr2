// Funksioni për të filluar bisedën e drejtpërdrejtë
function startLiveChat() {
  $("#liveChatSection").show();
}

// Funksioni për të hapur popup-in
function openPopup() {
  $("#liveChatPopup").show();
}

// Funksioni për të mbyllur popup-in
function closePopup() {
  $("#liveChatPopup").hide();
}

// Funksioni për të dërguar bisedën e drejtpërdrejtë
function submitLiveChat() {
  const name = $("#liveChatName").val().trim();
  const email = $("#liveChatEmail").val().trim();
  const message = $("#liveChatMessage").val().trim();

  // Validimi i emrit, email-it dhe mesazhit
  const isNameValid = validateName();
  const isEmailValid = validateEmail();
  const isMessageValid = message !== "";

  // Kontrolloni nëse të gjitha fushat janë valide
  if (isNameValid && isEmailValid && isMessageValid) {
    alert("Your message has been successfully submitted!");
    $("#liveChatSection").hide();
    closePopup();
  } else {
    alert("Please fill out all required fields correctly.");
  }
}

// validimi i fushave permes funksioneve
//function to validate name
function validateName() {
var name = document.getElementById('liveChatName').value;
var nameFormatHint = document.getElementById('nameFormatHint');

// shikon nëse emri është i zbrazët
if (name.trim() === '') {
    nameFormatHint.style.display = 'none';
    return false;
}

// shikon për praninë e numrave në emër
var containsNumbers = /\d/.test(name);

// shikon se a eshte emri ne formatin e duhur
if (containsNumbers) {
    nameFormatHint.style.display = 'block';
} else {
    nameFormatHint.style.display = 'none';
}

return !containsNumbers;
}

// Function to validate email
function validateEmail() {
var email = document.getElementById('liveChatEmail').value;
var emailFormatHint = document.getElementById('emailFormatHint');

// Kontrollon nëse email është i zbrazët
if (email.trim() === '') {
    emailFormatHint.style.display = 'none';
    return false;
}

// Shikon për një format të vlefshëm të email-it
var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
var isValidEmail = emailRegex.test(email);

if (!isValidEmail) {
    emailFormatHint.style.display = 'block';
} else {
    emailFormatHint.style.display = 'none';
}

return isValidEmail;
}
// function to validate message
function validateMessage() {
var message = document.getElementById('liveChatMessage').value;
var messageFormatHint = document.getElementById('messageFormatHint');

// shikon nëse mesazhi është i zbrazët
if (message.trim() === '') {
    messageFormatHint.style.display = 'block';
    return false;
} else {
    messageFormatHint.style.display = 'none';
    return true;
}
}


document.addEventListener('DOMContentLoaded', function () {
    var openBtn = document.getElementById('openFeedbackFormBtn');
    var popup = document.getElementById('feedbackPopup');
    var cancelBtn = document.getElementById('cancelBtn');
    var form = document.getElementById('feedbackForm');
  
    openBtn.addEventListener('click', function () {
      popup.style.display = 'block';
    });
  
    cancelBtn.addEventListener('click', function () {
      popup.style.display = 'none';
    });
  
    form.addEventListener('submit', function (e) {
      e.preventDefault(); // Parandalon shfletuesin nga dërgimi i formës në mënyrë tradicionale
  
      // Validimi i vlerësimit të përgjithshëm
      var satisfactionField = document.getElementById("rating");
      var satisfactionValue = satisfactionField.value;

      if (satisfactionValue < 1 || satisfactionValue > 5 || isNaN(satisfactionValue)) {
        alert("Please select a valid value for Overall Satisfaction (from 1 to 5).");
        return; // Mos vazhdoni me dërgimin e formës nëse vlera është e pavlefshme
      }
    
  
      // Pas dërgimit, mbyll formën dhe shfaq mesazhin e Thank you
      popup.style.display = 'none';
      alert('Thank you for your feedback!');
    });
  
    // Konstruktori i objektit për informacionin e feedback-ut
    function FeedbackInfo(name, email, number, feedback) {
      this.emri = name;
      this.email = email;
      this.numri = number;
      this.feedback = feedback;
    }
  
    // Ngjarja për dërgimin e formës
    form.addEventListener('submit', function (e) {
      e.preventDefault(); // Parandalon dërgimin e formës për shfaqjen e objektit në konsolë
  
      // Krijimi i një instance të objektit nga konstruktori
      var feedbackInfo = new FeedbackInfo(
        document.getElementById('name').value,
        document.getElementById('email').value,
        document.getElementById('number').value,
        document.getElementById('feedback').value,
      );

        console.log(feedbackInfo);
    });
  });


// FOOTERI

// Function to update current date and time
function updateDateTime() {
    const currentDate = new Date();
    const formattedDate = currentDate.toLocaleDateString();
    const formattedTime = currentDate.toLocaleTimeString();
    const dateTimeString = `Current Date and Time: ${formattedDate} ${formattedTime}`;
    
    // Update the content of the element with id "currentDateTime"
    document.getElementById("currentDateTime").textContent = dateTimeString;
}

// Call the function to update date and time initially
updateDateTime();

// Update date and time every second
setInterval(updateDateTime, 1000);


//Scroll to top

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
      });
    });
  });

