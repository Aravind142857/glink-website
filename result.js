const submit = document.getElementById("button");
submit.addEventListener('click', validate);
function validate(e) {
    e.preventDefault();

    const url = document.getElementById("URL");
    const glink = document.getElementById("GLink");
    if (!url) {
        /* Flag */
    }
    let valid = true;
    const domainExp = new RegExp("http(s)*:\\/\\/[a-zA-Z0-9\\-]+(\\.[a-zA-Z0-9\\-]+)+");
    var count = 0;
    var index = -1;
    for (let i=0; i < url.value.length; i++) {
        if (url.length.charAt(i) == '/') {
            count++;
        }
        if (count == 3) {
            index = i;
            break;
        }
    }
    if (count == 3) {
        const domain = url.value.substring(0, index);
        const filepath = url.value.substring(index, url.value.length - 1);
        alert("Domain is " + domain + " filepath is " + filepath);
    }

}