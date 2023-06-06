//const submit = document.getElementById("button");
//submit.addEventListener('click', validate);
function validate() {
//    e.preventDefault();

    const url = document.getElementById("URL");
    const glink = document.getElementById("GLink");
    // if (!url) {
    //     /* Flag */
    // }
    let valid = true;
    const domainExp = new RegExp("http(s)*:\\/\\/[a-zA-Z0-9\\-]+(\\.[a-zA-Z0-9\\-]+)+");
    const filepathExp = new RegExp("[a-zA-Z]+");
    let count = 0;
    let index = -1;
    let domain = "";
    let filepath = "";
    for (let i=0; i < url.value.length; i++) {
        if (url.value.charAt(i) == '/') {
            count++;
        }
        if (count == 3) {
            index = i;
            break;
        }
    }
    if (count >= 3) {
        domain = url.value.substring(0, index);
        if (index == url.value.length - 1) {
            filepath = url.value.charAt(index);
        } else {
            filepath = url.value.substring(index, url.value.length - 1);
        }
        alert("Domain is " + domain + " filepath is " + filepath);
    } else {
        domain = url.value;
    }
    console.log(domain);
    if (domain.match(domainExp)) /** and is available? */{
        const error = document.getElementById("error");
        if (error.classList.contains("visible")) {
            error.classList.remove("visible");
        }
        if (url.classList.contains("invalid")) {
            url.classList.remove("invalid");
        }
        url.classList.add("valid");
        error.setAttribute('aria-hidden', true);
        error.setAttribute('aria-invalid', false);
        console.log("Valid");

	return valid;

/*	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open('GET','result.php',true);
	xmlhttp.send();
	console.log(xmlhttp.responseText);*/
    } else {

        /*flag*/
        const error = document.getElementById("error");
        error.classList.add("visible");

        //error.classList.add("hidden");
        if (url.classList.contains("valid")) {
            url.classList.remove("valid");
        }
        url.classList.add("invalid");
        error.setAttribute('aria-hidden', false);
        error.setAttribute('aria-invalid', true);
	return false;
    }

}
