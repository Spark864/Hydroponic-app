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
  //chartdata1
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
  //end
  //chartdata2
  const chartdata2 = {
    labels,
    datasets: [
      {
        label: "Temperature",
        backgroundColor: "rgb(255, 99, 132)",
        borderColor: "rgb(255, 99, 132)",
        data: [0, 10, 5, 2, 20, 30, 45, 34, 12],
      },
    ],
  };

  const config2 = {
    type: "line",
    data: chartdata2,
    options: {
      maintainAspectRatio: false,
    },
  };
  ctx2 = document.querySelector("#myChart2");
  console.log(ctx2);
  const myChart2 = new Chart(ctx2, config2);
  //end
  //chartdata3
  const chartdata3 = {
    labels,
    datasets: [
      {
        label: "PH",
        backgroundColor: "rgb(255, 99, 132)",
        borderColor: "rgb(255, 99, 132)",
        data: [0, 10, 5, 2, 20, 30, 45, 34, 12],
      },
    ],
  };

  const config3 = {
    type: "line",
    data: chartdata3,
    options: {
      maintainAspectRatio: false,
    },
  };
  ctx3 = document.querySelector("#myChart3");
  console.log(ctx3);
  const myChart3 = new Chart(ctx3, config3);
  //end
  //chartdata4
  const chartdata4 = {
    labels,
    datasets: [
      {
        label: "PPM",
        backgroundColor: "rgb(255, 99, 132)",
        borderColor: "rgb(255, 99, 132)",
        data: [0, 10, 5, 2, 20, 30, 45, 34, 12],
      },
    ],
  };

  const config4 = {
    type: "line",
    data: chartdata4,
    options: {
      maintainAspectRatio: false,
    },
  };
  ctx4 = document.querySelector("#myChart4");
  console.log(ctx4);
  const myChart4 = new Chart(ctx4, config4);
  //end
  //chartdata5
  const chartdata5 = {
    labels,
    datasets: [
      {
        label: "Sunlight",
        backgroundColor: "rgb(255, 99, 132)",
        borderColor: "rgb(255, 99, 132)",
        data: [0, 10, 5, 2, 20, 30, 45, 34, 12],
      },
    ],
  };

  const config5 = {
    type: "line",
    data: chartdata5,
    options: {
      maintainAspectRatio: false,
    },
  };
  ctx5 = document.querySelector("#myChart5");
  console.log(ctx5);
  const myChart5 = new Chart(ctx5, config5);
  //end
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

  function update() {
    // interactive_plot3.setData([getRandomData()]);
    removeData(myChart);
    addData(myChart, 28);
    removeData(myChart2);
    addData(myChart2, 24);
    removeData(myChart3);
    addData(myChart3, 7);
    removeData(myChart4);
    addData(myChart4, 12);
    removeData(myChart5);
    addData(myChart5, 9);
    // Since the axes don't change, we don't need to call plot.setupGrid()

    // interactive_plot3.draw();
    myChart.update();
    setTimeout(update, updateInterval);
  }
  update();
  //const realtime = "humidity"; // If == to on then fetch data every x seconds. else stop fetching
  //const button = document.querySelector("#realtime .btn");
  $("#realtime .btn").click(function () {
    console.log(this);
    if (this.dataset.toggle === "humidity") {
      if (ctx.style.display === "none") {
        ctx2.style.display = "none";
        ctx3.style.display = "none";
        ctx4.style.display = "none";
        ctx5.style.display = "none";
        ctx.style.display = "block";
      }
    }
    if (this.dataset.toggle === "temperature") {
      if (ctx2.style.display === "none") {
        ctx.style.display = "none";
        ctx3.style.display = "none";
        ctx4.style.display = "none";
        ctx5.style.display = "none";
        ctx2.style.display = "block";
      }
    }
    if (this.dataset.toggle === "ph") {
      if (ctx3.style.display === "none") {
        ctx.style.display = "none";
        ctx2.style.display = "none";
        ctx4.style.display = "none";
        ctx5.style.display = "none";
        ctx3.style.display = "block";
      }
    }
    if (this.dataset.toggle === "ppm") {
      if (ctx4.style.display === "none") {
        ctx.style.display = "none";
        ctx2.style.display = "none";
        ctx3.style.display = "none";
        ctx5.style.display = "none";
        ctx4.style.display = "block";
      }
    }
    if (this.dataset.toggle === "sunlight") {
      if (ctx5.style.display === "none") {
        ctx.style.display = "none";
        ctx2.style.display = "none";
        ctx3.style.display = "none";
        ctx4.style.display = "none";
        ctx5.style.display = "block";
      }
    }
  });
});
/* END LINE CHART */
