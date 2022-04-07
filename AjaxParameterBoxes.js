const h3humidity = document.querySelector("h3[id='humidityvalue']");
const h3temperature = document.querySelector("h3[id='temperaturevalue']");
const h3ph = document.querySelector("h3[id='phvalue']");
const h3ppm = document.querySelector("h3[id='ppmvalue']");
const h3sunlight = document.querySelector("h3[id='sunlighvalue']");
function loadBoxes() {
  $(document).ready(function () {
    $.ajax({
      url: "GetLatestDateForAjax.php",
      type: "get",
      dataType: "json",
      statusCode: {
        404: function () {
          alert("page not found");
        },
      },
      success: function (response) {
        h3humidity.innerHTML = `<h3 id=humidityvalue>${response[0].humidity}<sup style="font-size: 20px">%</sup></h3>`;
        h3temperature.innerHTML = `<h3 id=temperaturevalue>${response[0].temperature}</h3>`;
        h3ph.innerHTML = `<h3 id=temperaturevalue>${response[0].ph}</h3>`;
        h3ppm.innerHTML = `<h3 id=temperaturevalue>${response[0].ppm}</h3>`;
        h3sunlight.innerHTML = `<h3 id=temperaturevalue>${response[0].lum}</h3>`;
      },
    });
  });
  setTimeout(loadBoxes, 5000);
}
loadBoxes();
