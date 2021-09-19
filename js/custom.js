$(function () {
  var FROMDATE = '1995-05-01';
  var TODATE = '1995-05-31';
  dashboardDisplay(FROMDATE, TODATE);
});

function dashboardDisplay(start, end) {
  fetch('./api?f=' + start + '&t=' + end)
    .then(function(response) {
      return response.json();
    })
    .then(function(data) {
      onDataArrived(data, start, end);
    });
}

function onDataArrived(data, start, end) {
  $('#dashboard-date').text('MAY 1995');
  $('#dashboard-total-sales').text('$ ' + Math.floor(data.totalSales * 100) / 100);
  $('#dashboard-total-orders').text(data.totalOrders);

  var dailySalesData = data.dailySales.map(function(d){ return { x: new Date(d.date), y: Math.floor(d.sales * 100)/100}; });
  var dailySalesDom = document.querySelector("#dashboard-daily-sales");
  var dailySalesChart = new ApexCharts(dailySalesDom, {
    chart: {
      type: 'line'
    },
    series: [{
      data: dailySalesData,
    }]
  });
  dailySalesChart.render();

  var productQuantityDom = document.querySelector("#dashboard-product-quantity");
  var productQuantityChart = new ApexCharts(productQuantityDom, {
    chart: {
      type: 'donut'
    },
    series: data.productQuantity.map(function(p) {return p.quantity;}),
    labels: data.productQuantity.map(function(p) {return p.name;}),
  });
  productQuantityChart.render();
}

// var dailySalesArray = <?php echo $dailySalesArray; ?>;
// var options = {
//   chart: {
//     type: 'column'
//   },
//   series: [{
//   data: dailySalesArray.map(s => {'x':s['date'],'y':s['count']}),
//   }],
//   xaxis: {
//     type: 'datetime',
//   }
// }

// var chart = new ApexCharts(document.querySelector("#daily-sales"), options);

// chart.render();
