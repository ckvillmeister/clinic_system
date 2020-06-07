
retrieve_patients_stats();
retrieve_collection_stats();

function retrieve_patients_stats(){
	$.ajax({
	    url: 'dashboard/retrieve_patients_stats',
	    method: 'POST',
	    dataType: 'JSON',
	    success: function(result) {
	    	$("#visitors-chart-canvas").empty();
	    	monthly_chart(result, '#visitors-chart-canvas');
	    }
	  });
}

function retrieve_collection_stats(){
	$.ajax({
	    url: 'dashboard/retrieve_collection_stats',
	    method: 'POST',
	    dataType: 'JSON',
	    success: function(result) {
	    	$("#collections-chart-canvas").empty();
	    	monthly_chart(result, '#collections-chart-canvas');
	    }
	  });
}

function monthly_chart(data_chart, canvas){
	var areaChartCanvas = $(canvas).get(0).getContext('2d')
    var areaChartData = {
      labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
      datasets: [
        {
			label               : 'Clinic Visitors',
			backgroundColor     : 'rgba(60,141,188,0.9)',
			borderColor         : 'rgba(60,141,188,0.8)',
			pointRadius          : false,
			pointColor          : '#3b8bba',
			pointStrokeColor    : 'rgba(60,141,188,1)',
			pointHighlightFill  : '#fff',
			pointHighlightStroke: 'rgba(60,141,188,1)',
			data                : data_chart
        }
      ]
    }

    var areaChartOptions = {
	    maintainAspectRatio : false,
	    responsive : true,
	    legend: {
	      display: false
	    },
	    scales: {
	      xAxes: [{
	        gridLines : {
	          display : true,
	        }
	      }],
	      yAxes: [{
	        gridLines : {
	          display : true,
	        }
	      }]
	    }
	  }

	var chart = new Chart(areaChartCanvas, { 
												  type: 'line', 
												  data: areaChartData, 
												  options: areaChartOptions
												}
								)
}

