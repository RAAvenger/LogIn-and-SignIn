///check validation of "password" and "password confirmation" and add some styles. 
function formValidate(formeId) {
    ///get "password" and "password confirmation".
    var password = document.forms[formeId]["password"];
    var passwordRep = document.forms[formeId]["passwordRep"];
    ///add some styles for "invalid input" to page styles.
    ///create new styleSheet.
    var style = document.createElement('style');
    ///add styleSheet to page head.
    document.head.appendChild(style);
    ///insert styles to styleSheet.
    style.sheet.insertRule(".input-box input:invalid {box-shadow: none;border-bottom-color: rgb(241, 54, 54);}");
    style.sheet.insertRule(".input-box input:invalid:focus {box-shadow: none;border-bottom-color: rgb(145, 35, 35);}");
    ///check if they "password" and "password confirmation" are equal.
    if (password.value === passwordRep.value) {
        ///if "password" and "password confirmation" are equal make "password confirmation" valid.
        passwordRep.setCustomValidity("");
        return true;
    }
    else {
        ///if "password" and "password confirmation" are not equal make "password confirmation" invalid and remove "password confirmation" text.
        passwordRep.setCustomValidity("Password confirmation doesn't match Password");
        passwordRep.value = "";
    }
}

///show or hide password text.
function PasswordShow_Hide(button, idInput) {
    ///get password input element.
    var input = document.getElementById(idInput);
    ///check if password is hidden or not.
    if (input.type === "password") {
        ///show password.
        input.type = "text";
        ///change image.
        button.src = "/images/Invisible_48px.png";
        button.alt = "hide"
    }
    else {
        ///hide password.
        input.type = "password";
        ///change image.        
        button.src = "/images/Eye_48px.png";
        button.alt = "show"
    }
}

function SetDateInputMax(inputID) {
    document.getElementById(inputID).max = new Date().toISOString().split("T")[0];
}