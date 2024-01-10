$(document).ready(function() {
    $('.btn-style').css('background-color', 'red'); // Change text color for buttons
  });

window.addEventListener('resize', equalizeCardHeights);
window.addEventListener('load', equalizeCardHeights);

function equalizeCardHeights(){
    var cardContainer=document.querySelector('.card-container');
    var cards=document.querySelectorAll('.card');

    var maxCardHeight=0;

    cards.forEach(function (card){
        card.style.height='auto';
        maxCardHeight=Math.max(maxCardHeight, card.offsetHeight);
    });

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

        $(document).ready(function () {
            // Attach a change event handler to each checkbox
            $('.form-check-input').change(function () {
                var checkboxId = $(this).attr('id');
                var quantityControl = $('#' + checkboxId).siblings('.quantity-control');

                // Toggle the visibility of the quantity control based on checkbox state
                quantityControl.toggle(this.checked);
            });
        });
         // Function to calculate and update the final price
    function updateFinalPrice() {
        // Prices for each type of ticket
        const regularTicketPrice = 2;
        const hours2TicketPrice = 3;
        const studentTicketPrice = 1;
        const students2hoursTicketPrice = 2;

        // Get the quantities selected by the user
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
            var quantityInput = $(quantityId);
            var currentQuantity = parseInt(quantityInput.val()) || 0;
            quantityInput.val(currentQuantity + 1);
            updateDisplay(quantityInput, displayId);
            updateFinalPrice();
        }

    // Function to decrement quantity
    function decrementQuantity(quantityId, displayId) {
            var quantityInput = $(quantityId);
            var currentQuantity = parseInt(quantityInput.val()) || 0;
            if (currentQuantity > 0) {
                quantityInput.val(currentQuantity - 1);
                updateDisplay(quantityInput, displayId);
            }
            updateFinalPrice();
        }

        function updateDisplay(quantityInput, displayId) {
            var quantityDisplay = $(displayId);
            quantityDisplay.text(quantityInput.val());
        }
        // Define a ShowCard class
        class ShowCard {
            constructor(cardElement) {
                this.cardElement = cardElement;
                this.dates = this.extractDates();
                this.setupBuyTicketButton();
            }

            // Extract dates from the card
            extractDates() {
                const dateText = this.cardElement.find('.show-date').html().trim();
                return dateText.split('<br>').map(date => date.trim());
            }

            // Setup "Buy ticket" button click event
            setupBuyTicketButton() {
                const buyButton = this.cardElement.find('.buy-tickets-btn');
                buyButton.on('click', () => this.openTicketForm());
            }

            // Open the ticket form
            openTicketForm(button) {
                $('#purchaseModal').modal('show');
                const radioGroup = $('#radioGroup');
                radioGroup.empty();

                // Create radio buttons for each date
                this.dates.forEach(date => {
                    const formattedDate = date.trim();
                    const radioBtn = $(`
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="showDateRadio" value="${formattedDate}">
                            <label class="form-check-label">${formattedDate}</label>
                        </div>`
                    );

                    radioGroup.append(radioBtn);
                });

                // Open the ticket modal
                $('#ticketModal').modal('show');
            }
        }

// Initialize ShowCard instances for each card
$(document).ready(() => {
    const showCards = $('.card').toArray().map(cardElement => new ShowCard($(cardElement)));
});

        function updateDateTime() {
            const currentDate = new Date();
            const formattedDate = currentDate.toLocaleDateString();
            const formattedTime = currentDate.toLocaleTimeString();
            const dateTimeString = `Current Date and Time: ${formattedDate} ${formattedTime}`;
            
            // Update the content of the element with id "currentDateTime"
            document.getElementById("currentDateTime").textContent = dateTimeString;
        }

          $("#submitButton").on("click", function() {
            validateForm();
            // Additional logic or form submission code can go here if needed.
          });
          
          document.addEventListener('DOMContentLoaded', function () {
            $('#submitButton').click(function () {
                // Validate the form
                if (validateForm()) {
                    console.log('Form submitted successfully!');
        
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
