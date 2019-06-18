//am4core.ready(function() {
function loadCandle() {
  var book = 'btc_mxn';
  $.ajax({
    url: "/proyecto_criptomonedas/api/requests.php",
    contentType: "application/json; charset=utf-8",
    dataType: 'json',
    method: "GET",
    data: {'accion':'getOpenTicks', 'book': book},
    success: function(r) {
      var data = r.data;
      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Themes end

      var chart = am4core.create("chartdiv", am4charts.XYChart);
      chart.paddingRight = 20;

      chart.dateFormatter.inputDateFormat = "yyyy-MM-dd";

      var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
      dateAxis.renderer.grid.template.location = 0;

      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.tooltip.disabled = true;

      var series = chart.series.push(new am4charts.CandlestickSeries());
      series.dataFields.dateX = "date";
      series.dataFields.valueY = "close";
      series.dataFields.openValueY = "open";
      series.dataFields.lowValueY = "low";
      series.dataFields.highValueY = "high";
      series.tooltipText = "Open:${openValueY.value}\nLow:${lowValueY.value}\nHigh:${highValueY.value}\nClose:${valueY.value}";

      // important!
      // candlestick series colors are set in states.
      // series.riseFromOpenState.properties.fill = am4core.color("#00ff00");
      // series.dropFromOpenState.properties.fill = am4core.color("#FF0000");
      // series.riseFromOpenState.properties.stroke = am4core.color("#00ff00");
      // series.dropFromOpenState.properties.stroke = am4core.color("#FF0000");

      series.riseFromPreviousState.properties.fillOpacity = 1;
      series.dropFromPreviousState.properties.fillOpacity = 0;

      chart.cursor = new am4charts.XYCursor();

      // a separate series for scrollbar
      var lineSeries = chart.series.push(new am4charts.LineSeries());
      lineSeries.dataFields.dateX = "date";
      lineSeries.dataFields.valueY = "close";
      // need to set on default state, as initially series is "show"
      lineSeries.defaultState.properties.visible = false;

      // hide from legend too (in case there is one)
      lineSeries.hiddenInLegend = true;
      lineSeries.fillOpacity = 0.5;
      lineSeries.strokeOpacity = 0.5;

      var scrollbarX = new am4charts.XYChartScrollbar();
      scrollbarX.series.push(lineSeries);
      chart.scrollbarX = scrollbarX;

      chart.data = data;
    },
    error: function(data) {
      alert("Error: "+data);
    }
  });


} // end am4core.ready()
