function ValidateEmail(inputText){
    var mailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    if(inputText.value.match(mailformat))
    {
        alert("Valid email address!");
        return true;
    }
    else
    {
        alert("You have entered an invalid email address!");
        return false;
    }
}

function ValidatePassword(password) {
    var passwordFormat = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
    
    if (password.value.match(passwordFormat)) {
        alert("Valid password!");
        return true;
    } else {
        alert("Password should be at least 8 characters long and include a combination of lowercase, uppercase, and numeric characters.");
        return false;
    }
}

function ValidateUsername(username) {
    var usernameFormat = /^.{4,20}$/;
    
    if (username.value.match(usernameFormat)) {
        alert("Valid username!");
        return true;
    } else {
        alert("Username must be between 4 and 20 characters.");
        return false;
    }
}


