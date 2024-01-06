
function submitLiveChat() {
    
    var name = document.getElementById("liveChatName").value;
    var email = document.getElementById("liveChatEmail").value;
    var message = document.getElementById("liveChatMessage").value;

    if (!name || !email || !message) {
        alert("Please fill in all required fields.");
    } else {
        alert("Live chat message submitted!");
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

// Function to submit the live chat 
function submitLiveChat() {
    const name = document.getElementById("liveChatName").value.trim();
    const email = document.getElementById("liveChatEmail").value.trim();
    const message = document.getElementById("liveChatMessage").value.trim();

    if (name !== "" && email !== "" && message !== "") {
        alert("Live chat message submitted!");
        document.getElementById("liveChatSection").style.display = "none";
    closePopup();
} 
else {
    alert("Please fill out all required fields.");
}
}





 