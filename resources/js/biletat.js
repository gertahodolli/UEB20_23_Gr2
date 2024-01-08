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
         // Function to populate the date options with radio buttons
         function populateDateOptions(card) {
            var dateOptions = [];
            var dateElement = card.find(".show-date");

            // Extract the date from the current card
            var date = dateElement.text();
            dateOptions.push(date);

            // Populate the date options with radio buttons
            var dateOptionsContainer = card.find(".date-options");
            dateOptionsContainer.empty();
            dateOptions.forEach(function(date, index) {
                dateOptionsContainer.append(`
                    <label>
                        <input type="radio" name="showDate" value="${date}" ${index === 0 ? 'checked' : ''}>
                        ${date}
                    </label>
                `);
            });
        }

        // Function to handle the "Buy Tickets" button click and open the modal
        function handleBuyTicketsClick() {
            var card = $(this).closest(".card");
            var modal = card.find(".ticket-modal");

            // Populate the date options with radio buttons specific to the clicked card
            populateDateOptions(card);

            // Open the modal for the specific card
            modal.show();

            // You can add additional logic to handle form submission, etc.
        }

        // Document ready function
        $(document).ready(function() {
            // Attach the click event to the "Buy Tickets" button for each card
            $(".buy-tickets-btn").click(handleBuyTicketsClick);

            // Add additional logic as needed
        });
        // Function to handle "Buy ticket" button click and open the purchase modal
        function openTicketForm(button) {
            $('#purchaseModal').modal('show');
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
        class TicketManager {
        constructor() {
            this.ticketPrices = {
                regular: 2,
                over2Hours: 3,
                students: 1,
                studentsOver2Hours: 2
            };
            this.quantities = {
                regular: 0,
                over2Hours: 0,
                students: 0,
                studentsOver2Hours: 0
            };
        }

        // Get total price for a specific ticket type
        getTotalPrice(ticketType) {
            return this.quantities[ticketType] * this.ticketPrices[ticketType];
        }

        // Update quantity for a specific ticket type
        setQuantity(ticketType, quantity) {
            this.quantities[ticketType] = quantity;
        }

        // Get ticket price for a specific ticket type
        getTicketPrice(ticketType) {
            return this.ticketPrices[ticketType];
        }

        // Calculate and update the final price
        updateFinalPrice() {
            var finalPrice = this.getTotalPrice('regular') +
                this.getTotalPrice('over2Hours') +
                this.getTotalPrice('students') +
                this.getTotalPrice('studentsOver2Hours');

            $('#finalPrice').text(finalPrice);
        }
        }

        // Create an instance of TicketManager
        var ticketManager = new TicketManager();

        // Function to automatically display ticket prices and update the form
        function displayTicketPrices() {
        // Display ticket prices on the form
        $('#regularPrice').text(ticketManager.getTicketPrice('regular'));
        $('#over2HoursPrice').text(ticketManager.getTicketPrice('over2Hours'));
        $('#kidsAndSeniorsPrice').text(ticketManager.getTicketPrice('kidsAndSeniors'));
        $('#studentsPrice').text(ticketManager.getTicketPrice('students'));
        $('#studentsOver2HoursPrice').text(ticketManager.getTicketPrice('studentsOver2Hours'));
        }

        // Function to handle input events and update the final price
        function handleInputEvent() {
        var id = $(this).attr('id');
        var ticketType = id.replace('Quantity', '');

        // Update quantity in the TicketManager
        ticketManager.setQuantity(ticketType, parseInt($(this).val()));

        // Update the final price
        ticketManager.updateFinalPrice();
        }

        // Attach input event handlers to quantity input fields
        $('input[id$="Quantity"]').on('input', handleInputEvent);

        // Call the function to display ticket prices when the page loads
        $(document).ready(function () {
        displayTicketPrices();
        ticketManager.updateFinalPrice(); // Initialize the final price
        });
