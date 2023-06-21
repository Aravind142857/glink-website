
let latitude = document.getElementById("latitude");
let longitude = document.getElementById("longitude");
console.log("entered");
latitude.setValue = function (newValue) {
    this.value = newValue;
    document.getElementById("form").submit();
}
if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function (position) {
        longitude.value = position.coords.longitude;
        latitude.setValue(position.coords.latitude);
    });
} else {
    console.log("Your browser does not support geolocation.");
}

