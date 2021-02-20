// This javascript file is form validation. 
function Validator(username,email, password1, password2) {
    var nameExp = /^[0-9A-Za-z]+$/;
    var emailExp=/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/;
    // Checks to see if the username, password, and password2 match the expression above. If it does it match it means that the information is formatted correctly. 
    if (!username.value.match(nameExp) || !password1.value.match(nameExp) || !password2.value.match(nameExp)){
        alert("Invalid format!");
        return false;
    }
  
    else if (username.value.length < 5 || password1.value.length < 5 || password2.value.length < 5 || username.value.length > 15 || password1.value.length > 15 || password2.value.length > 15){
        alert("Wrong input length. Length should be between 5 to 15 characters!");
        return false;
    }

    else if (password1.value != password2.value){
        alert("Password and Password-repeat is different!");
        return false;
    }
    else if(!email.value.match(emailExp)){
        return false;
    }
    
    return true;
}