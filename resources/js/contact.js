
function startLiveChat() {
        document.getElementById("liveChatSection").style.display = "block";
    }

    // Function to open the popup
function openPopup() {
    document.getElementById("liveChatPopup").style.display = "block";

}



// Function to close the popup
function closePopup() {
    document.getElementById("liveChatPopup").style.display = "none";
}

// Function to submit the live chat 
function submitLiveChat() {
    const name = document.getElementById("liveChatName").value.trim();
    const email = document.getElementById("liveChatEmail").value.trim();
    const message = document.getElementById("liveChatMessage").value.trim();

    // Validimi i emrit, email-it dhe mesazhit
    const isNameValid = validateName();
    const isEmailValid = validateEmail();
    const isMessageValid = message !== "";

   
    // Kontrolloni nëse të gjitha fushat janë valide
    if (isNameValid && isEmailValid && isMessageValid) {
        alert("Your message has been successfully submitted!");
        document.getElementById("liveChatSection").style.display = "none";
        closePopup();
    } 
    else {
        alert("Please fill out all required fields correctly.");
    }
}



function validateName() {
    var name = document.getElementById('liveChatName').value;
    var nameFormatHint = document.getElementById('nameFormatHint');

    // Kontrolloni nëse emri është i zbrazët
    if (name.trim() === '') {
        nameFormatHint.style.display = 'none';
        return false;
    }

    // Kontrolloni për praninë e numrave në emër
    var containsNumbers = /\d/.test(name);

    // Shfaqni ose fshehni udhëzimin për formatin e duhur të emrit
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

    // Kontrolloni nëse email është i zbrazët
    if (email.trim() === '') {
        emailFormatHint.style.display = 'none';
        return false;
    }

    // Kontrolloni për një format të vlefshëm të email-it
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    var isValidEmail = emailRegex.test(email);

    // Shfaqni ose fshehni udhëzimin për formatin e duhur të email-it
    if (!isValidEmail) {
        emailFormatHint.style.display = 'block';
    } else {
        emailFormatHint.style.display = 'none';
    }

    return isValidEmail;
}

function validateMessage() {
    var message = document.getElementById('liveChatMessage').value;
    var messageFormatHint = document.getElementById('messageFormatHint');

    // Kontrolloni nëse mesazhi është i zbrazët
    if (message.trim() === '') {
        messageFormatHint.style.display = 'block';
        return false;
    } else {
        messageFormatHint.style.display = 'none';
        return true;
    }
}



// Përditësojeni funksionin për animacionin e emrit
function animateNameHint() {
    $("#nameFormatHint").show("slide", { direction: "right" }, 1000);
}

// Përditësojeni funksionin për animacionin e email-it
function animateEmailHint() {
    $("#emailFormatHint").show("slide", { direction: "right" }, 1000);
}

// Përditësojeni funksionin për animacionin e mesazhit
function animateMessageHint() {
    $("#messageFormatHint").show("slide", { direction: "right" }, 1000);
}

// Përditësojeni funksionin për fshehjen e animacionit të emrit
function hideNameHint() {
    $("#nameFormatHint").hide("slide", { direction: "left" }, 1000);
}

// Përditësojeni funksionin për fshehjen e animacionit të email-it
function hideEmailHint() {
    $("#emailFormatHint").hide("slide", { direction: "left" }, 1000);
}

// Përditësojeni funksionin për fshehjen e animacionit të mesazhit
function hideMessageHint() {
    $("#messageFormatHint").hide("slide", { direction: "left" }, 1000);
}



