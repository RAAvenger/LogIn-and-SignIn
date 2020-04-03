function formValidate(formeId) {
    var password = document.forms[formeId]["password"];
    var passwordRep = document.forms[formeId]["passwordRep"];
    if (password.value === passwordRep.value) {
        passwordRep.setCustomValidity("");
        return true;
    }
    else {
        passwordRep.setCustomValidity("Password confirmation doesn't match Password");
        passwordRep.value = "";
    }
}