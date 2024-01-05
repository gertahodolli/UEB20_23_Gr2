
// Function to open the popup
function submitLiveChat() {
    
    // Check if the required fields are filled before submission
    var name = document.getElementById("liveChatName").value;
    var email = document.getElementById("liveChatEmail").value;
    var message = document.getElementById("liveChatMessage").value;

    if (!name || !email || !message) {
        alert("Please fill in all required fields.");
    } else {
        // Your live chat submission logic here
        alert("Live chat message submitted!");
        // You may want to handle the live chat form submission differently
    }
}
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

// Function to submit the live chat (replace this with your actual submission logic)
function submitLiveChat() {
    const name = document.getElementById("liveChatName").value.trim();
    const email = document.getElementById("liveChatEmail").value.trim();
    const message = document.getElementById("liveChatMessage").value.trim();

    if (name !== "" && email !== "" && message !== "") {
        // Add your live chat submission logic here
        alert("Live chat message submitted!");
        document.getElementById("liveChatSection").style.display = "none";
    closePopup();
} 
else {
    alert("Please fill out all required fields.");
}
}





 