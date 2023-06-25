let email = document.getElementById("email");
let password = document.getElementById("password");
let pswd_visible = document.getElementById("pswd-visible");
let pswd_invisible = document.getElementById("pswd-invisible");

console.log(window.location.pathname);
pswd_visible.addEventListener('click', () => {
    pswd_visible.classList.add("hidden");
    pswd_invisible.classList.remove("hidden");
    password.type = "password";
});
pswd_invisible.addEventListener('click', () => {
    pswd_invisible.classList.add("hidden");
    pswd_visible.classList.remove("hidden");
    password.type = "text";
});
if (window.location.pathname === '/signup.html') {
    let check_pswd_visible = document.getElementById("check-pswd-visible");
    let check_pswd_invisible = document.getElementById("check-pswd-invisible");
    let check_password = document.getElementById("verify");
    check_pswd_visible.addEventListener('click', () => {
        check_pswd_visible.classList.add("hidden");
        check_pswd_invisible.classList.remove("hidden");
        check_password.type = "password";
    });
    check_pswd_invisible.addEventListener('click', () => {
        check_pswd_invisible.classList.add("hidden");
        check_pswd_visible.classList.remove("hidden");
        check_password.type = "text";
    });
}
let emailRX = new RegExp("^[a-zA-Z0-9!#$%&'*+/=?^_`{|}~-]+(\\.[a-zA-Z0-9!#$%&'*+/=?^_`{|}~-]+)*@[A-Za-z0-9-]+(\\.[A-Za-z]+)+$");
let domainError = document.getElementById("domain");
let domainRX = new RegExp("^[a-zA-Z0-9!@#$%^&*]*$");
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
if (window.location.pathname === '/login.html') {
    let auth_error = document.getElementById("auth");
    let query = window.location.search;
    const urlParams = new URLSearchParams(query);
    const errorType = urlParams.get('error');
    console.log(window.location.pathname);
    if (errorType === 'auth') {
        auth_error.classList.add('block');
        auth_error.classList.remove('hidden');
    } else {
        auth_error.classList.remove('block');
        auth_error.classList.add('hidden');
    }
}
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
password.addEventListener('keyup', () => {
    if (document.location.pathname === '/login.html') {
        if (document.getElementById('auth').classList.contains('block')) {
            document.getElementById('auth').classList.remove('block');
            document.getElementById('auth').classList.add('hidden');
        }
    } else {
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
        if (!domainRX.test(pswd)) {
            domainError.classList.remove("hidden");
            domainError.classList.add("block");
        } else {
            domainError.classList.add("hidden");
            domainError.classList.remove("block");
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
    }
});
if (window.location.pathname === '/signup.html') {
    let check_password = document.getElementById("verify");
    let check_password_error = document.getElementById("check-password-error");
    check_password.addEventListener("keyup", () => {
        let check = check_password.value;
        if (check !== password.value) {
            check_password_error.classList.remove("hidden");
            check_password_error.classList.add("block");
        } else {
            check_password_error.classList.add("hidden");
            check_password_error.classList.remove("block")
        }
        if (check_password_error.classList.contains("block")) {
            check_password.classList.remove("ring-green-400");
            check_password.classList.remove("focus:ring-green-400");
            check_password.classList.add("ring-red-400");
            check_password.classList.add("focus:ring-red-400");
        } else {
            check_password.classList.add("ring-green-400");
            check_password.classList.add("focus:ring-green-400");
            check_password.classList.remove("ring-red-400");
            check_password.classList.remove("focus:ring-red-400");
        }
    });
}