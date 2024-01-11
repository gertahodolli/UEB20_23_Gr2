/*this is a jquery method that waits for the html file to be fully loaded before using the jquery
selector ($('.btn-style)) before changing the color of every element that has that class to red */ 
$(document).ready(function() {
    $('.btn-style').css('background-color', 'red'); // Change text color for buttons
  });

/*Adding an event listener for when the window has finished resizing and 
loading so the equalizeCardHeights function can be called*/
window.addEventListener('resize', equalizeCardHeights);
window.addEventListener('load', equalizeCardHeights);

//Creating the function
function equalizeCardHeights(){
    //Assinging all elements with this class to this variable
    var cards=document.querySelectorAll('.card');
    
    //Initializing this variable to 0
    var maxCardHeight=0;
    
    //Iterating through all the cards in the NodeList cards to find the one with max height
    cards.forEach(function (card){
        card.style.height='auto';
        maxCardHeight=Math.max(maxCardHeight, card.offsetHeight);
    });

    //Setting the height of each of the card to max heaight
    cards.forEach(function (card){
        card.style.height=maxCardHeight+'px';
    });
}
        // Wait for the document to be ready
        $(document).ready(function () {
            // Attach a click event handler to the close button
            $('#closeModalButton').click(function () {
                // Close the modal using jQuery
                $('#purchaseModal').modal('hide');
            });
        });

        //function to show or hide the quantity controls in the forms
        //Wait for the document to be ready
        $(document).ready(function () {
            /* Attach a change event handler to each element targeted
            by the jQuery selector(all the checkboxes)*/
            $('.form-check-input').change(function () {
                //gets the id of the checkbox that triggered the change event
                var checkboxId = $(this).attr('id');
                /*jQuery object that finds siblings of the checkbox with the
                class 'quantity-control'*/
                var quantityControl = $('#' + checkboxId).siblings('.quantity-control');

                // Toggle the visibility of the quantity control based on checkbox state
                quantityControl.toggle(this.checked);
            });
        });

         // Function to calculate and update the final price
        function updateFinalPrice() {
        //Constant Prices for each type of ticket
        const regularTicketPrice = 2;
        const hours2TicketPrice = 3;
        const studentTicketPrice = 1;
        const students2hoursTicketPrice = 2;

        //Get the quantities selected by the user and turn them to int
        const regularTicketQuantity = parseInt(document.getElementById('regularTicketQuantity').value);
        const hours2TicketQuantity = parseInt(document.getElementById('2hoursTicketQuantity').value);
        const studentTicketQuantity = parseInt(document.getElementById('studentTicketQuantity').value);
        const students2hoursTicketQuantity = parseInt(document.getElementById('students2hoursTicketQuantity').value);

        // Calculate the subtotal for each type of ticket
        const regularTicketSubtotal = regularTicketQuantity * regularTicketPrice;
        const hours2TicketSubtotal = hours2TicketQuantity * hours2TicketPrice;
        const studentTicketSubtotal = studentTicketQuantity * studentTicketPrice;
        const students2hoursTicketSubtotal = students2hoursTicketQuantity * students2hoursTicketPrice;

        // Calculate the total price
        const totalPrice = regularTicketSubtotal + hours2TicketSubtotal + studentTicketSubtotal + students2hoursTicketSubtotal;

        // Update the final price in the output element
        document.querySelector('.finalPrice').textContent = 'Total Price: €' + totalPrice.toFixed(2);
    }

    // Function to increment quantity
    function incrementQuantity(quantityId, displayId) {
            //Using jQuery to select the element with the specified ID 
            var quantityInput = $(quantityId);
            /*Parsing the value as an integer, if the value isnt valid 
            and the parsing fails, it defaults to 0*/
            var currentQuantity = parseInt(quantityInput.val()) || 0;
            //Increments the quantity by 1
            quantityInput.val(currentQuantity + 1);
            //Calling this function to update the display
            updateDisplay(quantityInput, displayId);
            //Calling this function to recalculate the price
            updateFinalPrice();
        }

    // Function to decrement quantity
    function decrementQuantity(quantityId, displayId) {
            //Using jQuery to select the element with the specified ID 
            var quantityInput = $(quantityId);
            /*Parsing the value as an integer, if the value isnt valid 
            and the parsing fails, it defaults to 0*/
            var currentQuantity = parseInt(quantityInput.val()) || 0;
            //Checking if the current quantit is higher than zero
            if (currentQuantity > 0) {
                //Decrement the wuantity and display this change
                quantityInput.val(currentQuantity - 1);
                updateDisplay(quantityInput, displayId);
            }
            //Updating final price
            updateFinalPrice();
        }

        //Function to update the display
        function updateDisplay(quantityInput, displayId) {
            //Using jQuery to select the element with the specified ID 
            var quantityDisplay = $(displayId);
            //Inserting the selected quantity to the element
            quantityDisplay.text(quantityInput.val());
        }

        // Define a ShowCard class
        class ShowCard {
            //Takes as a parameter a card on the html file
            constructor(cardElement) {
                this.cardElement = cardElement;
                this.dates = this.extractDates();
                this.setupBuyTicketButton();
            }

            // Extract dates from the card
            extractDates() {
                /*Extracting the elements with the class show-date, splitting the html 
                content then trimming it*/
                const dateText = this.cardElement.find('.show-date').html().trim();
                //splits a string into an array of substrings, trims the substrings
                return dateText.split('<br>').map(date => date.trim());
            }

            // Setup "Buy ticket" button click event
            setupBuyTicketButton() {
                //a click event handler that invokes the openTicketForm function
                const buyButton = this.cardElement.find('.buy-tickets-btn');
                buyButton.on('click', () => this.openTicketForm());
            }

            // Open the ticket form
            openTicketForm(button) {
                //Opens the modal/form with ID purchaseModal
                $('#purchaseModal').modal('show');
                //empties the existing radioGroup
                const radioGroup = $('#radioGroup');
                radioGroup.empty();

                // Create radio buttons for each date
                this.dates.forEach(date => {
                    //Iterate through dates and create radio buttons for each one
                    const formattedDate = date.trim();
                    const radioBtn = $(`
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="showDateRadio" value="${formattedDate}">
                            <label class="form-check-label">${formattedDate}</label>
                        </div>`
                    );
                    //inserting the dates on radioBtn to radioGroup container
                    radioGroup.append(radioBtn);
                });
                // Open the ticket modal
                $('#ticketModal').modal('show');
            }
        }

        // Initialize ShowCard instances for each card
        $(document).ready(() => {
            /*converts the jQuery object of selected elements by $('.card') toa regylar js array and
            then creating a new showCard object for every element with the class 'card'*/
            const showCards = $('.card').toArray().map(cardElement => new ShowCard($(cardElement)));
        });

        //validating the form for purchasing tickets
          $("#submitButton").on("click", function() {
            validateForm();
          });
          
          document.addEventListener('DOMContentLoaded', function () {
            $('#submitButton').click(function () {
                // Validate the form
                if (validateForm()) {
                    console.log('Form submitted successfully!');
                    //Play sound effect
                    playSound('./resources/images/ding.mp3');
                    
                    // Hide the form
                    $('#purchaseModal').addClass('hidden');
        
                    // Show a success notification using SweetAlert2
                    Swal.fire({
                        title: 'Success!',
                        text: 'Ticket has been purchased successfully!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(function () {
                        // Reload the page
                        location.reload();
                    });
                }
            });
        });
        
        // Function to validate the form
        function validateForm() {
            // Reset all error messages
            resetErrorMessages();
    
            // Flag to check if there are any validation errors
            let hasErrors = false;
    
            // Validate Ticket Name
            const fullName = document.getElementById('fullName').value.trim();
            if (fullName === '') {
                displayErrorMessage('fullName', 'Please enter your full name.');
                hasErrors = true;
            }
    
            // Validate Email
            const email = document.getElementById('email').value.trim();
            if (email === '' || !isValidEmail(email)) {
                displayErrorMessage('email', 'Please enter a valid email address.');
                hasErrors = true;
            }
            // Validate Ticket Selection
            const selectedTickets = document.querySelectorAll('input[type="checkbox"]:checked');
            if (selectedTickets.length === 0) {
                displayErrorMessage('ticketSelection', 'Please select at least one ticket option.');
                hasErrors = true;
            }
    
            // If there are any errors, prevent form submission
            return !hasErrors;
        }
    
        // Function to reset all error messages
        function resetErrorMessages() {
            const errorMessages = document.querySelectorAll('.error-message');
            errorMessages.forEach(message => message.textContent = '');
        }
    
        // Function to display error message for a specific input field
        function displayErrorMessage(fieldId, message) {
            const errorField = document.getElementById(`${fieldId}-error`);
            errorField.textContent = message;
        }
    
        // Function to check if the email is valid
        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        //Play sound effect
        function playSound(soundPath) {
            var audio = new Audio(soundPath);
            audio.play();
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Get all video elements on the page
            var videos = document.querySelectorAll('.video-container video');
        
            // Iterate through the video elements and set the variables
            videos.forEach(function (video) {
              var overlayText = video.closest('.video-container').querySelector('.overlay-text');
              var customControls = video.closest('.video-container').querySelector('.custom-controls');
        
              // Add event listener to hide overlay text and show controls when the video starts playing
              video.addEventListener('loadedmetadata', function(){
                overlayText.style.opacity=1;
                customControls.style.opacity=0;
                video.closest('.video-container').style.opacity=1;
              })
              // Add 'mouseenter' event listener to show controls on hover
              video.addEventListener('mouseenter', function () {
                customControls.style.opacity = 1;
              });
              video.addEventListener('mouseleave', function(){
                overlayText.style.opacity=0;
              })
              // Add event listener to show overlay text and hide controls when the video is paused
              video.addEventListener('pause', function () {
                overlayText.style.opacity = 1;
                customControls.style.opacity = 1;
              });
            });
          });
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
