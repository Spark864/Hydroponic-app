// const alertLighthtml = `<div class="alert alert-warning" role="alert"> Warning! Lumen is higher than 2 </div>`;
// const h3humidity = document.querySelector("h3[name='humidityvalue']");
// const h3temperature = document.querySelector("h3[name='temperaturevalue']");
// const h3ph = document.querySelector("h3[name='phvalue']");
// const h3ppm = document.querySelector("h3[name='ppmvalue']");
// const h3sunlight = document.querySelector("h3[name='sunlighvalue']");
function loadalert() {
  $(document).ready(function () {
    jQuery.ajax({
      url: "notificationpage.php",
      data: $("#notificationform").serialize(),
      cache: false,
      contentType: false,
      processData: false,
      method: "POST",
      type: "POST", // For jQuery < 1.9
      success: function (data) {
        console.log($("#alerthumidity").html());

        // h3humidity.innerHTML = `<h3 id=humidityvalue>${response[0].humidity}<sup style="font-size: 20px">%</sup></h3>`;
        // h3temperature.innerHTML = `<h3 id=temperaturevalue>${response[0].temperature}</h3>`;
        // h3ph.innerHTML = `<h3 id=temperaturevalue>${response[0].ph}</h3>`;
        // h3ppm.innerHTML = `<h3 id=temperaturevalue>${response[0].ppm}</h3>`;
        // h3sunlight.innerHTML = `<h3 id=temperaturevalue>${response[0].lum}</h3>`;
      },
    });
  });
  setTimeout(loadalert, 5000);
}
loadalert();
