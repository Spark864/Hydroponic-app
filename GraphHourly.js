/*
 * LINE CHART
 * ----------
 */
// LINE randomly generated data

$(() => {
  const labels = [
    "12am",
    "1am",
    "2am",
    "3am",
    "4am",
    "5am",
    "6am",
    "7am",
    "8am",
    "9am",
    "10am",
    "11am",
    "12pm",
    "1pm",
    "2pm",
    "3pm",
    "4pm",
    "5pm",
    "6pm",
    "7pm",
    "8pm",
    "9pm",
    "10pm",
    "11pm",
    "12am",
  ];

  const chartdata = {
    labels,
    datasets: [
      {
        label: "Humidity",
        backgroundColor: "rgb(255, 99, 132)",
        borderColor: "rgb(255, 99, 132)",
        data: [0, 10, 5, 2, 20, 30, 45, 34, 12],
      },
    ],
  };

  const config = {
    type: "line",
    data: chartdata,
    options: {
      maintainAspectRatio: false,
    },
  };
  ctx = document.querySelector("#myChart");
  console.log(ctx);
  const myChart = new Chart(ctx, config);
  function removeData(chart) {
    chart.data.datasets.forEach((dataset) => {
      dataset.data.shift();
    });
    chart.update();
  }

  function addData(chart, data) {
    chart.data.datasets.forEach((dataset) => {
      dataset.data.push(data);
    });
    chart.update();
  }

  console.log(myChart.data.labels);
  console.log(myChart.data.datasets[0].data);
  removeData(myChart);
  addData(myChart, 21);
  const updateInterval = 3000; // Fetch data ever x milliseconds
  const realtime = "on"; // If == to on then fetch data every x seconds. else stop fetching
  function update() {
    // interactive_plot3.setData([getRandomData()]);
    removeData(myChart);
    addData(myChart, 21);
    // Since the axes don't change, we don't need to call plot.setupGrid()

    // interactive_plot3.draw();
    myChart.update();
    if (realtime === "on") {
      setTimeout(update, updateInterval);
    }
  }

  update();
});

/* END LINE CHART */
