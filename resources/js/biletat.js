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
        function incrementQuantity(quantityId, displayId) {
            var quantityInput = $(quantityId);
            var currentQuantity = parseInt(quantityInput.val()) || 0;
            quantityInput.val(currentQuantity + 1);
            updateDisplay(quantityInput, displayId);
        }

        function decrementQuantity(quantityId, displayId) {
            var quantityInput = $(quantityId);
            var currentQuantity = parseInt(quantityInput.val()) || 0;
            if (currentQuantity > 0) {
                quantityInput.val(currentQuantity - 1);
                updateDisplay(quantityInput, displayId);
            }
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


        //Form Validation
        $(document).ready(function() {

            // Initialize the form validation
            var validator = $("#purchaseForm").validate({
                // Define validation rules for each input field
                rules: {
                    fullName: "required",
                    email: {
                        required: true,
                        email: true
                    },
                    // Add rules for other fields as needed
                },
                // Define error messages for each rule
                messages: {
                    fullName: "Please enter your full name",
                    email: {
                        required: "Please enter your email address",
                        email: "Please enter a valid email address"
                    },
                    // Add messages for other fields as needed
                },
                // Display error messages in the error-container div
                errorPlacement: function(error, element) {
                    error.appendTo("#error-container");
                }
            });
        
            // Add custom validation for the date selection
            validator.rules("add", {
                showDate: {
                    required: true
                }
            });
        
            // Add custom validation for at least one ticket selection
            $.validator.addMethod("atLeastOneTicket", function(value, element) {
                return $('#regularTicketCheckbox').is(':checked') || $('#2hoursTicketCheckbox').is(':checked') || $('#studentTicketCheckbox').is(':checked') || $('#students2hoursTicketCheckbox').is(':checked');
            }, "Please select at least one ticket");
        
            // Apply the custom validation to the checkboxes
            validator.rules("add", {
                regularTicketCheckbox: {
                    atLeastOneTicket: true
                },
                // Add rules for other checkboxes as needed
            });
        
            // Event listener for the form submission
            $("#purchaseForm").submit(function(event) {
                // Validate the form using the 'valid' method
                if (!validator.valid()) {
                    // If the form is not valid, prevent submission
                    event.preventDefault();
                }
            });
        });