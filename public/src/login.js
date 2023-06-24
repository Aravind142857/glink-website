let email = document.getElementById("email");
let password = document.getElementById("password");
let emailRX = new RegExp("^[a-zA-Z0-9!#$%&'*+/=?^_`{|}~-]+(\\.[a-zA-Z0-9!#$%&'*+/=?^_`{|}~-]+)*@[A-Za-z0-9-]+(\\.[A-Za-z]+)+$");
let emailError = document.getElementById("email-error");
let capsRX = new RegExp(".*[A-Z]+");
let capsError = document.getElementById("capital");
let lowRX = new RegExp(".*[a-z]+");
let lowError = document.getElementById("letter");
let numRX = new RegExp(".*[0-9]+");
let numError = document.getElementById("number");
let symbolRX = new RegExp(".*[!@#$%^&*]+");
let symbolError = document.getElementById("symbol");
let MIN_LENGTH = 10;
let lenError = document.getElementById("length");
email.addEventListener('keyup', function(event) {
    if (emailRX.test(email.value)) {
        console.log("email valid");
        email.classList.add("ring-green-400");
        email.classList.add("focus:ring-green-400");
        email.classList.remove("ring-red-400");
        email.classList.remove("focus:ring-red-400");
        emailError.classList.add("hidden");
        emailError.classList.remove("block");
        return true;
    } else {
        console.log("email invalid");
        email.classList.add("ring-red-400");
        email.classList.add("focus:ring-red-400");
        email.classList.remove("ring-green-400");
        email.classList.remove("focus:ring-green-400");
        emailError.classList.remove("hidden");
        emailError.classList.add("block");
        return false;
    }
});
password.addEventListener('keyup', function() {
    let pswd = password.value;
    if (!capsRX.test(pswd)) {
        capsError.classList.remove("hidden");
        capsError.classList.add("block");
    } else {
        capsError.classList.add("hidden");
        capsError.classList.remove("block");
    }
    if (!lowRX.test(pswd)) {
        lowError.classList.remove("hidden");
        lowError.classList.add("block");
    } else {
        lowError.classList.add("hidden");
        lowError.classList.remove("block");
    }
    if (!numRX.test(pswd)) {
        numError.classList.remove("hidden");
        numError.classList.add("block");
    } else {
        numError.classList.add("hidden");
        numError.classList.remove("block");
    }
    if (!symbolRX.test(pswd)) {
        symbolError.classList.remove("hidden");
        symbolError.classList.add("block");
    } else {
        symbolError.classList.add("hidden");
        symbolError.classList.remove("block");
    }
    if (pswd.length < MIN_LENGTH) {
        lenError.classList.remove("hidden");
        lenError.classList.add("block");
    } else {
        lenError.classList.add("hidden");
        lenError.classList.remove("block");
    }
    if (capsError.classList.contains("block") || lowError.classList.contains("block") || numError.classList.contains("block") || symbolError.classList.contains("block") || lenError.classList.contains("block")) {
        password.classList.remove("ring-green-400");
        password.classList.remove("focus:ring-green-400");
        password.classList.add("ring-red-400");
        password.classList.add("focus:ring-red-400");
    } else {
        password.classList.add("ring-green-400");
        password.classList.add("focus:ring-green-400");
        password.classList.remove("ring-red-400");
        password.classList.remove("focus:ring-red-400");
    }
})