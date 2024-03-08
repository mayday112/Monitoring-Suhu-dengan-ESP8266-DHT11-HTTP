<?php
    include("koneksi.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body style="font-size:1.5rem;font-family:Arial;">

    <!-- gauge -->
    <!-- suhu -->
    <div style="padding:3rem;" class="d-sm-flex  justify-content-center align-items-center container-sm">
        <div class="d-flex  justify-content-center align-items-center flex-column">
            <h3>Temperature</h3>
            <canvas id="foo"></canvas>
            <div>
                <span id="temperature" >0</span>
                °C
            </div>

        </div>
<!-- Kelembababan -->
        <div class="d-flex  justify-content-center align-items-center flex-column" style="padding-top:2rem;padding-bottom:2rem;">
            <h3>Humidity</h3>
            <canvas id="foo1"></canvas>
            <div>
                <span id="humidity">0</span>
                %
            </div>
        </div>
    </div>
    

    <!-- chart diagram -->
    <div class="container-md p-5 d-flex justify-content-center align-items-center flex-column">
      <canvas id="myChart" class="p-5"></canvas>
      <canvas id="humi-chart" class="p-5"></canvas>
    </div>

    <br>

</body>

<!-- gauge -->
<!-- <script src="gauge.js"></script> -->
<script src="https://bernii.github.io/gauge.js/dist/gauge.min.js"></script>
<script>

    var opts = {
      angle: 0.04, // The span of the gauge arc
      lineWidth: 0.44, // The line thickness
      radiusScale: 1, // Relative radius
      pointer: {
        length: 0.6, // // Relative to gauge radius
        strokeWidth: 0.044, // The thickness
        color: '#000000' // Fill color
      },
      limitMax: false,     // If false, max value increases automatically if value > maxValue
      limitMin: false,     // If true, the min value of the gauge will be fixed
      colorStart: '#DA8829',   // Colors
      colorStop: '#DA8829',    // just experiment with them
      strokeColor: '#DAAE8C',  // to see which ones work best for you
      generateGradient: true,
      highDpiSupport: true,     // High resolution support
      staticLabels: {
          font: "10px sans-serif",  // Specifies font
          labels: [0, 10, 20, 30, 40, 50],  // Print labels at these values
          color: "#000000",  // Optional: Label text color
          fractionDigits: 0  // Optional: Numerical precision. 0=round off.
      }

    };

    // temp
    var temperature = document.getElementById('foo'); // your canvas element
    var gaugeTemp = new Gauge(temperature).setOptions(opts); // create sexy gauge!
    gaugeTemp.maxValue = 50; // set max gauge value
    gaugeTemp.setMinValue(0);  // Prefer setter over gauge.minValue = 0
    gaugeTemp.animationSpeed = 32; // set animation speed (32 is default value)
    updateTemp();


    opts = {
      angle: 0.04, // The span of the gauge arc
      lineWidth: 0.44, // The line thickness
      radiusScale: 1, // Relative radius
      pointer: {
        length: 0.6, // // Relative to gauge radius
        strokeWidth: 0.044, // The thickness
        color: '#000000' // Fill color
      },
      limitMax: false,     // If false, max value increases automatically if value > maxValue
      limitMin: false,     // If true, the min value of the gauge will be fixed
      colorStart: '#2E5CDA',   // Colors
      colorStop: '#2E5CDA',    // just experiment with them
      strokeColor: '#A6C0DA',  // to see which ones work best for you
      generateGradient: true,
      highDpiSupport: true,     // High resolution support
      staticLabels: {
          font: "10px sans-serif",  // Specifies font
          labels: [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100],  // Print labels at these values
          color: "#000000",  // Optional: Label text color
          fractionDigits: 0  // Optional: Numerical precision. 0=round off.
      }

    };

    // humidity
    var humidity = document.getElementById('foo1'); // your canvas element
    var gaugeHumi = new Gauge(humidity).setOptions(opts); // create sexy gauge!
    gaugeHumi.maxValue = 100; // set max gauge value
    gaugeHumi.setMinValue(0);  // Prefer setter over gauge.minValue = 0
    gaugeHumi.animationSpeed = 32; // set animation speed (32 is default value)
    // gaugeHumi.set(getHumi()); // set actual value
    // document.getElementById('humidity').innerHTML = getHumi()
    updateHumi();  


    setInterval(() => {
            updateTemp();
            updateHumi();    
    }, 10000);

    function updateTemp() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            gaugeTemp.set(this.responseText); // set actual value
            document.getElementById('temperature').innerHTML = this.responseText; 
          }
        };
        xhttp.open("GET", "ambil_data_temp.php", true);
        xhttp.send();
    }

    function updateHumi() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            gaugeHumi.set(this.responseText); // set actual value
            document.getElementById('humidity').innerHTML = this.responseText;
          }
        };
        xhttp.open("GET", "ambil_data_humi.php", true);
        xhttp.send();
    }


</script>

<!-- chart -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const ctx = document.getElementById('myChart');
  const humiCtx = document.getElementById('humi-chart');
  

    var tempChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: [],
        datasets: [{
          label: 'suhu',
          data: [],
          borderWidth: 1,
          borderColor: '#FF6384',
          backgroundColor: '#FFB1C1',
        }],
      },   
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  
    var humiChart = new Chart(humiCtx, {
      type: 'line',
      data: {
        labels: [],
        datasets: [{
          label: 'kelembaban',
          data: [],
          borderWidth: 1,
        }],
      },    
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  
    setInterval(() => {
      getWaktu();
      getSuhu();
      getHumi();
    }, 10000);
    getWaktu();
    getSuhu();
    getHumi();

  function getWaktu(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        humiChart.data.labels = JSON.parse(this.responseText);
        tempChart.data.labels = JSON.parse(this.responseText);
        // console.log(JSON.parse(this.responseText));
        tempChart.update();
        humiChart.update();
      }
    };
    xhttp.open("GET", "data_waktu.php", true);
    xhttp.send();
  }
  
  function getSuhu(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        tempChart.data.datasets[0].data = JSON.parse(this.responseText);
        tempChart.update();
      }
    };
    xhttp.open("GET", "data_suhu.php", true);
    xhttp.send();
  }

  function getHumi(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        humiChart.data.datasets[0].data = JSON.parse(this.responseText);
        humiChart.update();
      }
    };
    xhttp.open("GET", "data_humi.php", true);
    xhttp.send();
  }  
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>