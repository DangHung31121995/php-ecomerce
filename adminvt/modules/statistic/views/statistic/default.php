<!-- HEAD -->
	<?php 
	
	$title = FSText :: _('Thống kê lượt truy cập, pageview'); 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
	?>
<!-- END HEAD-->

<!-- BODY-->
<div class="form_body">
	<button id="authorize-button" style="visibility:hidden">Authorize Analytics</button>
	<div id="ui" style="display:none">
	    <h3><?php echo FSText::_('Thống kê lượt truy cập, pageview')?></h3>
	    <div id='dataOverTimeConfig'></div>
		<br/>
		<br/>
	    <h3><?php echo FSText::_('Tổng lượt truy cập, pageview')?></h3>
	    <div id="scorecard"></div>
		<br/>
		<br/>
	    <h3><?php echo FSText::_('Môi trường truy cập website')?></h3>
	    <div id="traffic_visits"></div>
	 </div>  
</div>
<script src="https://www.google.com/jsapi"></script>
  <script type="text/javascript" src="/libraries/jquery/ga/gadash-1.0.js"></script>
  <script src="https://apis.google.com/js/client.js?onload=gadashInit"></script>
  <script>
  var API_KEY = '<?php echo $data['ga_api_key']->value;?>';
  var CLIENT_ID = '<?php echo $data['ga_client_id']->value;?>';
  var TABLE_ID = '<?php echo $data['ga_table_id']->value;?>';
  
  gadash.configKeys({
    'apiKey': API_KEY,
    'clientId':CLIENT_ID
  });


  // Create new Chart.
  var dataOverTime = new gadash.Chart();
  var scoreCard = new gadash.Chart();
  var sourceMediumTable = new gadash.Chart();
  var trafficVisitsPie = new gadash.Chart();


  // Base chart configuration. Used for all charts.
  var baseConfig = {
    'last-n-days': 30,
    'query': {
      'metrics': 'ga:visits, ga:pageviews',
    },
    'chartOptions': {
      width: 1100
    }
  };


  // Configuration for data over time graph.
  var dataOverTimeConfig = {
    'divContainer': 'dataOverTimeConfig',
    'type': 'LineChart',
    'query': {
      'dimensions': 'ga:date',
      'sort': 'ga:date'
    },
    'chartOptions': {
      height: 300,
      legend: {position: 'bottom'},
      hAxis: {title:'Ngày',gridlines:{color: '#DDD', count: 5}},
      colors:['red','#FF9900'],
      curveType: 'function'
    }
  };


  // Configuration for totals for each metric.
  var scoreCardConfig = {
    'divContainer': 'scorecard',
    'chartOptions': {
        width: 500
      }
  };	
  
  // Configuration for totals for pie Chart.
  var traffic_visits = {
    'divContainer': 'traffic_visits',
    'type': 'PieChart',
    'query': {
    	'metrics': 'ga:visits',
        'dimensions': 'ga:medium',
      },
    'chartOptions': {
    	'is3D':true,
        width: 500
      }
  };	


  // Configuration for source medium table.
  var sourceMediumTableConfig = {
    'divContainer': 'sourceMediumTableConfig',
    'query': {
      'dimensions': 'ga:source,ga:medium',
      'sort': '-ga:visitors',
      'max-results': 100
    }
  };

  renderGraph();
  /**
   * Handler for the run demo button.
   * Uses the table ID in the form to update the baseConfig object. Then
   * sets baseConfig into each of the charts. Then each chart's specific
   * configuration parameters are set. Finally all are rendered.
   */
  function renderGraph() {
     // Add the table id to the base configuration object.
     baseConfig.query.ids = TABLE_ID;

     dataOverTime.set(baseConfig).set(dataOverTimeConfig).render();
     scoreCard.set(baseConfig).set(scoreCardConfig).render();
     trafficVisitsPie.set(baseConfig).set(traffic_visits).render();
//     sourceMediumTable.set(baseConfig).set(sourceMediumTableConfig).render();

     // Display UI.
     document.getElementById('ui').style.display = 'block';
   }
  </script>
<!-- END BODY-->
