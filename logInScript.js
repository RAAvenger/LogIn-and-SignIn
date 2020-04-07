///check validation of "password" and "password confirmation" and add some styles. 
function formValidate(formeId) {
    InsertStyle();
    ValidInput('username');
    ValidInput('phoneNumber');
    ValidInput('email');
    ///get "password" and "password confirmation" & check if they are equal.
    if (document.forms[formeId]["password"].value === document.forms[formeId]["passwordRep"].value) {
        ///if "password" and "password confirmation" are equal make "password confirmation" valid.
        ValidInput("passwordRep")
        return true;
    } else {
        ///if "password" and "password confirmation" are not equal make "password confirmation" invalid.
        InvalidInput("passwordRep", "Password confirmation doesn't match Password");
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
        button.src = "images/Invisible_48px.png";
        button.alt = "hide"
    } else {
        ///hide password.
        input.type = "password";
        ///change image.        
        button.src = "images/Eye_48px.png";
        button.alt = "show"
    }
}

///set maximum Date for "Date Input" to today.
function SetMaxDateInput(inputID) {
    document.getElementById(inputID).max = new Date().toISOString().split("T")[0];
}

///make input "invalid" and show "custom message".
function InvalidInput(idInput, message) {
    document.getElementById(idInput).setCustomValidity(message);
}

///make input "valid".
function ValidInput(idInput) {
    document.getElementById(idInput).setCustomValidity("");
}

function InsertStyle() {
    InsertStyle = function () {
    };
    ///add some styles for "invalid input" to page styles.
    ///create new styleSheet.
    var style = document.createElement('style');
    ///add styleSheet to page head.
    document.head.appendChild(style);
    ///insert styles to styleSheet.
    style.sheet.insertRule(".input-box input:invalid {box-shadow: none;border-bottom-color: rgb(241, 54, 54);}");
    style.sheet.insertRule(".input-box input:invalid:focus {box-shadow: none;border-bottom-color: rgb(145, 35, 35);}");
    style.sheet.insertRule(".input-box input:valid {box-shadow: none;border-bottom-color:  rgb(69, 247, 63);}");
    style.sheet.insertRule(".input-box input:valid:focus {box-shadow: none;border-bottom-color: rgb(32, 117, 29);}");
}

function f() {
    document.getElementById("jsResp").innerHTML = "idInput";
}