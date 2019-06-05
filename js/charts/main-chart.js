// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

function loadData(book, intervalo) {
  $.ajax({
    url: "/proyecto_criptomonedas/api/requests.php",
    contentType: "application/json; charset=utf-8",
    dataType: 'json',
    method: "GET",
    data: {'accion':'getTicks', 'book': book, 'intervalo': intervalo},
    success: function(data) {
      var arrTickDate = [];
      var arrTickHour = [];
      var arrLast = [];
      var arrVolume = [];
      var arrVwap = [];
      var arrAsk = [];
      var arrBid = [];
      var arrStatus = [];
      var lastColor = '#6495ED';
      var lastColorLight = '#00BFFF';
      var bidColor = '#56C78B';
      var bidColorLight = '#69E1A1';
      var askColor = '#FA4141';
      var askColorLight = '#F67575';
      var vwapColor = '#753396';
      var vwapColorLight = '#9d55c1';
      for(var i in data) {
        var timestamp = (data[i].created_at).split(" "); // divide el timestamp en fecha y hora
        arrTickDate.push(data[i].created_at); // fecha
        arrTickHour.push(timestamp[1].substring(0,5)); // hora
        arrLast.push(data[i].status == 1 ? data[i].last : NaN);
        arrVolume.push(data[i].status == 1 ? data[i].volume : NaN);
        arrVwap.push(data[i].status == 1 ? data[i].vwap : NaN);
        arrAsk.push(data[i].status == 1 ? data[i].ask : NaN);
        arrBid.push(data[i].status == 1 ? data[i].bid : NaN);
        arrStatus.push(data[i].status);
      }

      var ctx = document.getElementById("myAreaChart");
      var myLineChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: arrTickDate,
          datasets: [{
            label: "Último Precio",
            backgroundColor: 'transparent',
            borderColor: lastColor,
            pointHoverBackgroundColor: lastColorLight,
            borderWidth: 1,
            pointRadius: 2,
            pointBorderColor: lastColor,
            pointBackgroundColor: lastColor,
            pointStyle: 'circle',
            data: arrLast,
          }, {
            label: "Precio de Compra",
            backgroundColor: 'transparent',
            borderColor: askColor,
            pointHoverBackgroundColor: askColorLight,
            borderWidth: 1,
            pointRadius: 2,
            pointBorderColor: askColor,
            pointBackgroundColor: askColor,
            pointStyle: 'circle',
            data: arrAsk,
          }, {
            label: "Precio de Venta",
            backgroundColor: 'transparent',
            borderColor: bidColor,
            pointHoverBackgroundColor: bidColorLight,
            borderWidth: 1,
            pointRadius: 2,
            pointBorderColor: bidColor,
            pointBackgroundColor: bidColor,
            pointStyle: 'circle',
            data: arrBid,
          }, {
            label: "Precio Medio Ponderado (VWAP)",
            backgroundColor: 'transparent',
            borderColor: vwapColor,
            pointHoverBackgroundColor: vwapColorLight,
            borderWidth: 1,
            pointRadius: 2,
            pointBorderColor: vwapColor,
            pointBackgroundColor: vwapColor,
            pointStyle: 'circle',
            data: arrVwap,
          }
        ],
        },
        options: {
          maintainAspectRatio: false,
          layout: {
            padding: {
              left: 10,
              right: 25,
              top: 25,
              bottom: 0
            }
          },
          scales: {
            xAxes: [{
              type: 'time',
              time: {
                unit: 'hour',
                unitStepSize: 1,
                tooltipFormat: "DD/MMMM/YYYY, h:mm a",
                displayFormats: {
                  hour: 'H:mm'
                }
              },
              ticks: {
                maxTicksLimit: 10
              }
            }],
            yAxes: [{
              ticks: {
                maxTicksLimit: 5,
                padding: 10,
                // Include a dollar sign in the ticks
                callback: function(value, index, values) {
                  return '$' + number_format(value);
                }
              },
              gridLines: {
                color: "rgb(234, 236, 244)",
                zeroLineColor: "rgb(234, 236, 244)",
                drawBorder: false,
                borderDash: [2],
                zeroLineBorderDash: [2]
              }
            }],
          },
          legend: {
            labels: {
              usePointStyle: true
            }
          },
          tooltips: {
            bodyFontColor: "#858796",
            titleMarginBottom: 10,
            titleFontColor: '#6e707e',
            titleFontSize: 14,
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: true,
            intersect: false,
            mode: 'index',
            caretPadding: 10,
            callbacks: {
              label: function(tooltipItem, chart) {
                var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                return datasetLabel + ': $' + number_format(tooltipItem.yLabel);
              }
            }
          }
        }
      });
    },
    error: function(data) {
      alert("Error: "+data);
    }
  });
}

function number_format(number, decimals, dec_point, thousands_sep) {
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
  number = (number + '').replace(',', '').replace(' ', '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}
