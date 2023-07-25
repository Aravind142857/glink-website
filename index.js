// const submit = document.getElementById("button");
mycheckbox = document.getElementById("restricted");
mycheckbox.addEventListener('change',checkboxCallback);
window.onload = function() {
    if (mycheckbox.checked) {
        document.getElementById("radius_label").hidden = false;
        document.getElementById("mandatory-radius").hidden = false;
        var radiusSelect = document.getElementById("radius");
        radiusSelect.hidden = false;
        radiusSelect.required = true;
    }
}

var lat = document.getElementById("latitude");
lat.setValue = function(newValue) {
    this.value = newValue;
    valueReceived();
}

function valueReceived() {
    let load = document.getElementById("loadingText");
    load.innerHTML = "Location retrieved";
    load.style.color = "green";

}
function valueRequested() {
    let load = document.getElementById("loadingText");
    load.innerHTML = "Location requested. Please wait...";
    load.style.color = "red";

}
function checkboxCallback(event) {
    const radiusLabel = document.getElementById("radius_label");
    const radiusSelect = document.getElementById("radius");
    const mandatoryRadius = document.getElementById("mandatory-radius");
    if (event.currentTarget.checked) {
        radiusLabel.hidden = false;
        mandatoryRadius.hidden = false;
        radiusSelect.hidden = false;
        radiusSelect.required = true;
        valueRequested();
        getLocation();
    } else {
        radiusLabel.hidden = true;
        mandatoryRadius.hidden = true;
        radiusSelect.hidden = true;
        radiusSelect.required = false;
    }
}

function getLocation() {
    console.log("GeoLocation");
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        console.log("Your browser does not support geolocation.");
    }
}

function showPosition(position) {
    console.log("Gotten positions");
    console.log(position.coords.latitude);
    console.log(position.coords.longitude);

    document.getElementById("latitude").setValue(position.coords.latitude);
    document.getElementById("longitude").value = position.coords.longitude;
    console.log("done");
}

// submit.addEventListener('click', validate);
    function validate() {
        //e.preventDefault();
        const checked = document.getElementById("restricted");
        if (checked.checked) {
            const lat = document.getElementById("latitude");
            const long = document.getElementById("longitude");
            if (lat.value === "" || long.value === "") {
                /* wait */
                return false
            }
        }

        const url = document.getElementById("URL");
        let glink = document.getElementById("GLink");
        const error = document.getElementById("error");
        // if (!url) {
        //     /* Flag */
        // }
        let valid = true;
//        const domainExp = new RegExp("^http(s)*:\\/\\/[a-zA-Z0-9\\-]+(\\.[a-zA-Z0-9\\-]+)+[_#]*$");
	const domainExp = new RegExp("^http(s)*:\\/\\/[a-zA-Z0-9\\-]+(\\.[a-zA-Z0-9\\-]+)+[\\/_#a-zA-Z0-9\\-]*$");
        const filepathExp = new RegExp("^[a-zA-Z]+$");
        const glinkExp = new RegExp("^[a-zA-Z]*$");
        let glinkStr = glink.value;
        let count = 0;
        let index = -1;
        let domain = "";
        let filepath = "";
        for (let i = 0; i < url.value.length; i++) {
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

        if (glinkStr === "") {
            var result = window.confirm("You have left the glink field blank. A random one will be generated for you.");
            if (result === false) {
                return false;
            }
        }


        if (domain.match(domainExp) && glinkStr.match(glinkExp))/** and is available? */{
            if (error.classList.contains("visible")) {
                error.classList.remove("visible");
            }
            if (url.classList.contains("invalid")) {
                url.classList.remove("invalid");
            }
            url.classList.add("valid");
            if (glink.classList.contains("invalid")) {
                glink.classList.remove("invalid");
            }
            glink.classList.add("valid");
            error.setAttribute('aria-hidden', true);
            error.setAttribute('aria-invalid', false);
            console.log("Valid with url= " +url.value+ " glink=" +glink);
            return valid;
        } else {
            /*flag*/
            error.classList.add("visible");

            //error.classList.add("hidden");
            if (!domain.match(domainExp)) {
                if (url.classList.contains("valid")) {
                    url.classList.remove("valid");
                }
                url.classList.add("invalid");
            } else {
                if (url.classList.contains("invalid")) {
                    url.classList.remove("invalid");
                }
                url.classList.add("valid");
            }
            if (!glinkStr.match(glinkExp)) {
                if (glink.classList.contains("valid")) {
                    glink.classList.remove("valid");
                }
                glink.classList.add("invalid");
            } else {
                if (glink.classList.contains("invalid")) {
                    glink.classList.remove("invalid");
                }
                glink.classList.add("valid");
            }
            error.setAttribute('aria-hidden', false);
            error.setAttribute('aria-invalid', true);
            return false;
        }
}