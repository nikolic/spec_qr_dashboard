google.load('visualization', '1', {packages:['table', 'corechart']});
//google.setOnLoadCallback(drawCharts);

var Statistics = function(){
  var self = this;

  this.init = function(){
    self.drawCharts();
  }

  this.drawTable = function (tableData) {

    var data = new google.visualization.DataTable();

    data.addColumn('string', 'Secret');
    data.addColumn('string', 'Filename');
    data.addColumn('boolean', 'Used');
    data.addColumn('number', 'Weight');

    data.addRows(tableData);

    var options = {
      page: 'enable',
      pageSize: 10,
      pagingSymbols: {prev: 'prev', next: 'next'},
      pagingButtonsConfiguration: 'auto',
      showRowNumber: true
    };

    var table = new google.visualization.Table(document.getElementById('table_div'));

    table.draw(data, options);
  }


  this.drawChart = function (data) {

    var data = google.visualization.arrayToDataTable([
      ['Codes', 'Used - Unused'],
      ['Unused',     data.unused],
      ['Used',    data.used]
    ]);

    var options = {
      is3D: true,
      backgroundColor : "rgb(204, 204, 204)"
    };

    var chart = new google.visualization.PieChart(document.getElementById('piechart'));

    chart.draw(data, options);
  }


  this.drawCharts = function (){

    $.ajax({
      type: "POST",
      url: GET_DATA_PATH,
      data: null,
      contentType: "application/json; charset=utf-8",
      dataType: "json",
      success: function(data){
        drawChart(data.chartData);
        drawTable(data.tableData);
      },
      error : function(err){
        console.log(err);
        $("#table_div").html(" ~> Error ~> ");
        $("#piechart").html(" ~> Error ~> ");
      }
    });

  }



  this.init();
};



function drawTable(tableData) {

  var data = new google.visualization.DataTable();

  data.addColumn('string', 'Secret');
  data.addColumn('string', 'Filename');
  data.addColumn('boolean', 'Used');
  data.addColumn('number', 'Weight');

  data.addRows(tableData);

  var options = {
    page: 'enable',
    pageSize: 10,
    pagingSymbols: {prev: 'prev', next: 'next'},
    pagingButtonsConfiguration: 'auto',
    showRowNumber: true
  };

  var table = new google.visualization.Table(document.getElementById('table_div'));

  table.draw(data, options);
}


function drawChart(data) {

  var data = google.visualization.arrayToDataTable([
    ['Codes', 'Used - Unused'],
    ['Unused',     data.unused],
    ['Used',    data.used]
  ]);

  var options = {
    is3D: true,
    backgroundColor : "rgb(204, 204, 204)"
  };

  var chart = new google.visualization.PieChart(document.getElementById('piechart'));

  chart.draw(data, options);
}


function drawCharts(){

  $.ajax({
    type: "POST",
    url: GET_DATA_PATH,
    data: null,
    contentType: "application/json; charset=utf-8",
    dataType: "json",
    success: function(data){
      drawChart(data.chartData);
      drawTable(data.tableData);
    },
    error : function(err){
      console.log(err);
      $("#table_div").html(" ~> Error ~> ");
      $("#piechart").html(" ~> Error ~> ");
    }
  });

}
