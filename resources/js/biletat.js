$(document).ready(function() {
    // Change text color for buttons
    $('.btn-style').css('background-color', 'red');

    // Attach event handlers
    window.addEventListener('resize', equalizeCardHeights);
    window.addEventListener('load', equalizeCardHeights);

    // Close modal on button click
    $('#closeModalButton').click(function() {
        $('#purchaseModal').modal('hide');
    });

    // Initialize buy ticket buttons
    $('.buy-tickets-btn').click(function() {
        var showId = $(this).data('show-id');
        var showName = $(this).data('show-name');
        var showDates = $(this).data('show-dates');
        var showDuration = $(this).data('show-duration');
        var dateOptionsHtml = '';

        $('#showSelection').val(showName);
        $('#showId').val(showId); // Set the showId in the hidden field

        showDates.forEach(function(date) {
            dateOptionsHtml += '<div class="form-check">';
            dateOptionsHtml += '<input class="form-check-input" type="radio" name="showDate" value="' + date + '" required>';
            dateOptionsHtml += '<label class="form-check-label">' + date + '</label>';
            dateOptionsHtml += '</div>';
        });

        $('#dateOptions').html(dateOptionsHtml);

        // Pass the show duration to the fetchFilteredTickets function
        fetchFilteredTickets(showDuration);
    });

    $('#submitButton').click(function() {
        if (!isLoggedIn()) {
            alert('You must be logged in to purchase tickets.');
            return false;
        }
        $('#totalPrice').val($('.finalPrice').text().replace('Total: € ', '')); // Set the total price in the hidden field
        $('#purchaseForm').submit(); // Submit the form without validation
    });
});

function equalizeCardHeights() {
    var cards = document.querySelectorAll('.card');
    var maxCardHeight = 0;

    cards.forEach(function(card) {
        card.style.height = 'auto';
        maxCardHeight = Math.max(maxCardHeight, card.offsetHeight);
    });

    cards.forEach(function(card) {
        card.style.height = maxCardHeight + 'px';
    });
}

function fetchFilteredTickets(showDuration) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'fetch_filtered_tickets.php?showDuration=' + showDuration, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);
            populateTicketTypes(response);
        }
    };
    xhr.send();
}

function populateTicketTypes(ticketTypes) {
    var ticketTypeContainer = document.getElementById('ticketTypeContainer');
    ticketTypeContainer.innerHTML = ''; // Clear existing options
    ticketTypes.forEach(function(ticket) {
        var formCheck = document.createElement('div');
        formCheck.classList.add('form-check');
        
        var label = document.createElement('label');
        label.classList.add('form-check-label');
        label.innerText = ticket.tipi + ' - €' + ticket.cmimi;

        var quantityControl = document.createElement('div');
        quantityControl.classList.add('quantity-control');

        var quantityLabel = document.createElement('label');
        quantityLabel.setAttribute('for', ticket.id + 'Quantity');
        quantityLabel.innerText = 'Quantity:';

        var rowDiv = document.createElement('div');
        rowDiv.classList.add('row');

        var colDiv = document.createElement('div');
        colDiv.classList.add('col', 'quantity-buttons');

        var decrementButton = document.createElement('button');
        decrementButton.type = 'button';
        decrementButton.classList.add('btn', 'btn-secondary', 'quantity');
        decrementButton.innerText = '-';
        decrementButton.setAttribute('onclick', 'decrementQuantity("#' + ticket.id + 'Quantity")');

        var quantityInput = document.createElement('input');
        quantityInput.type = 'text';
        quantityInput.classList.add('form-control', 'value');
        quantityInput.id = ticket.id + 'Quantity';
        quantityInput.name = 'quantity[]'; // Change the name attribute to 'quantity[]'
        quantityInput.value = '0';
        quantityInput.setAttribute('data-price', ticket.cmimi); // Store price in data attribute
        quantityInput.readOnly = true;

        var incrementButton = document.createElement('button');
        incrementButton.type = 'button';
        incrementButton.classList.add('btn', 'btn-secondary', 'quantity');
        incrementButton.innerText = '+';
        incrementButton.setAttribute('onclick', 'incrementQuantity("#' + ticket.id + 'Quantity")');

        colDiv.appendChild(decrementButton);
        colDiv.appendChild(quantityInput);
        colDiv.appendChild(incrementButton);
        rowDiv.appendChild(colDiv);
        quantityControl.appendChild(quantityLabel);
        quantityControl.appendChild(rowDiv);

        formCheck.appendChild(label);
        formCheck.appendChild(quantityControl);
        ticketTypeContainer.appendChild(formCheck);
    });

    // Initialize quantity buttons
    document.querySelectorAll('.quantity').forEach(function(button) {
        button.addEventListener('click', function() {
            calculateTotal(); // Recalculate total when quantity changes
        });
    });

    calculateTotal(); // Calculate total initially
}

function decrementQuantity(quantityInputSelector) {
    var quantityInput = document.querySelector(quantityInputSelector);
    if (quantityInput.value > 0) {
        quantityInput.value = parseInt(quantityInput.value) - 1;
    }
    calculateTotal();
}

function incrementQuantity(quantityInputSelector) {
    var quantityInput = document.querySelector(quantityInputSelector);
    quantityInput.value = parseInt(quantityInput.value) + 1;
    calculateTotal();
}

function calculateTotal() {
    var total = 0;
    document.querySelectorAll('.value').forEach(function(quantityInput) {
        var price = parseFloat(quantityInput.getAttribute('data-price'));
        var quantity = parseInt(quantityInput.value);
        if (!isNaN(price) && !isNaN(quantity)) {
            total += price * quantity;
        }
    });
    document.querySelector('.finalPrice').innerText = 'Total: € ' + total.toFixed(2);
}
