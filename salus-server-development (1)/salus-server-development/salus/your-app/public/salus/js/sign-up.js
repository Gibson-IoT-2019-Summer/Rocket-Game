const DISPLAY_BLOCK = "block";
const DISPLAY_NONE = "none";
const CLASS_INVALID = "invalid";
const CLASS_VALID = "valid";

// ********** Password input **********
var password = document.getElementById("password");
var passwordMsgDiv = document.getElementById("password-check");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");

// ********** Password confirm **********
var passwordc = document.getElementById("passwordc");
var passwordcMsgDiv = document.getElementById("passwordc-check");
var match = document.getElementById("match");

// ***** Password *****
password.onfocus = function() {
    passwordMsgDiv.style.display = DISPLAY_BLOCK;
}

password.onblur = function() {
    var lowerCaseLetters = /[a-z]/g;
    var upperCaseLetters = /[A-Z]/g;
    var numbers = /[0-9]/g;

    if(password.value.match(lowerCaseLetters) && password.value.match(upperCaseLetters) && password.value.match(numbers) &&
       password.value.length >= 8 && password.value.length <= 16) {
        passwordMsgDiv.style.display = DISPLAY_NONE;
    }

    if(passwordc.value == password.value)
        passwordMsgDiv.style.display = DISPLAY_NONE;
}

password.onkeyup = function() {
    // Validate lowercase letters
    var lowerCaseLetters = /[a-z]/g;
    if(password.value.match(lowerCaseLetters)) {  
        letter.classList.remove(CLASS_INVALID);
        letter.classList.add(CLASS_VALID);
    } else {
        letter.classList.remove(CLASS_VALID);
        letter.classList.add(CLASS_INVALID);
    }

    // Validate capital letters
    var upperCaseLetters = /[A-Z]/g;
    if(password.value.match(upperCaseLetters)) {  
        capital.classList.remove(CLASS_INVALID);
        capital.classList.add(CLASS_VALID);
    } else {
        capital.classList.remove(CLASS_VALID);
        capital.classList.add(CLASS_INVALID);
    }

    // Validate numbers
    var numbers = /[0-9]/g;
    if(password.value.match(numbers)) {  
        number.classList.remove(CLASS_INVALID);
        number.classList.add(CLASS_VALID);
    } else {
        number.classList.remove(CLASS_VALID);
        number.classList.add(CLASS_INVALID);
    }

    // Validate password length
    if(password.value.length >= 8 && password.value.length <= 32) {
        length.classList.remove(CLASS_INVALID);
        length.classList.add(CLASS_VALID);
    } else {
        length.classList.remove(CLASS_VALID);
        length.classList.add(CLASS_INVALID);
    }

    passwordcMsgDiv.style.display = (passwordc.value == password.value) ? DISPLAY_NONE : DISPLAY_BLOCK;
    if(passwordc.value == password.value) {
        match.classList.remove(CLASS_INVALID);
        match.classList.add(CLASS_VALID);
    } else {
        match.classList.remove(CLASS_VALID);
        match.classList.add(CLASS_INVALID);
    }
}

// ~~~~~ Password ~~~~~

// ***** Password Confirm *****

passwordc.onfocus = function() {
    passwordcMsgDiv.style.display = DISPLAY_BLOCK;
    if(passwordc.value == password.value) {
        match.classList.remove(CLASS_INVALID);
        match.classList.add(CLASS_VALID);
    } else {
        match.classList.remove(CLASS_VALID);
        match.classList.add(CLASS_INVALID);
    }
}

passwordc.onblur = function() {
    if(passwordc.value == password.value)
        passwordcMsgDiv.style.display = DISPLAY_NONE;
}

passwordc.onkeyup = function() {
    if(passwordc.value == password.value) {
        match.classList.remove(CLASS_INVALID);
        match.classList.add(CLASS_VALID);
    } else {
        match.classList.remove(CLASS_VALID);
        match.classList.add(CLASS_INVALID);
    }
}

// ~~~~~ Password Confirm ~~~~~~
