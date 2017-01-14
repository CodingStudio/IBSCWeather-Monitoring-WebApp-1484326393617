	
<html lang="en">
 
<head>
    <title>IBSC Weather Monitoring Dashboard</title>
    
    <script src="//ajax.googleapis.com/ajax/libs/dojo/1.10.4/dojo/dojo.js" data-dojo-config="async:true"></script>  
    
    <script>
	<?php 
		require('vendor/autoload.php'); 
		$services_json = json_decode(getenv('VCAP_SERVICES'),true); 
		$VcapSvs = $services_json["cloudantNoSQLDB"][0]["credentials"]; 
		$username = $VcapSvs["username"]; 
		$password = $VcapSvs["password"]; 
		
		try 
		{ 
			$sag = new Sag($username . ".cloudant.com"); 
			$sag->login($username, $password);
 
            $sag->setDatabase("weather-db");
 
            $currentRow = 0;
            echo "var humidityData = [";
                 
            $resultCount = $sag->getAllDocs()->body->total_rows;
                 
            foreach($sag->getAllDocs()->body->rows as $row)
            {
                    $currentRow = $currentRow + 1;
                     
                    $id = $row->id;
                    $value = $sag->get($id)->body->d->humidity;
                                         
                    echo $value;
                                
                    if($currentRow < $resultCount) 
                    {
                    	echo ","; 
                    } 
			} 	
			echo "];"; 
			
			$currentRow = 0; 
			echo "var tempData = ["; 
			$resultCount = $sag->getAllDocs()->body->total_rows;
                 
            foreach($sag->getAllDocs()->body->rows as $row)
            {
                    $currentRow = $currentRow + 1;
                     
                    $id = $row->id;
                    $value = $sag->get($id)->body->d->tempC;
                                         
                    echo $value;
                                
                    if($currentRow < $resultCount) 
                    {
                    	echo ","; 
                    } 
			} 
			echo "];"; 
		} 
		catch(Exception $e) 
		{ 
			echo " [INFO] There was an error getting data from Cloudant "; 
			echo $e->getMessage();
        }	
		
	?>
	
	require([
             // Basic Chart Class
            "dojox/charting/Chart",
         
            // Orange Theme
            "dojox/charting/themes/PlotKit/orange",
         
            // Plot Lines
            "dojox/charting/plot2d/Lines",
         
            // Load Legend, Tooltip, and Magnify classes
            "dojox/charting/widget/Legend",
            "dojox/charting/action2d/Tooltip",
            "dojox/charting/action2d/Magnify",
         
            // Markers
            "dojox/charting/plot2d/Markers",
         
            // Default x/y Axes
            "dojox/charting/axis2d/Default",
         
            // Wait for DOM to be ready
            "dojo/domReady!"
        ], function(Chart, theme, LinesPlot, Legend, Tooltip, Magnify)
        {
            // Create chart within it's "holding" node
            var chart = new Chart("chartNode");
         
            // Set the theme
            chart.setTheme(theme);
         
            // Add the only/default plot
            chart.addPlot("default", {
                type: LinesPlot,
                markers: true,
                labels: true,
                labelStyle: "outside"
            });
         
            // Add axes
            chart.addAxis("x");
            chart.addAxis("y", { min: -50, max: 270, vertical: true, fixLower: "major", fixUpper: "major" });
         
            // Add the series of data
            chart.addSeries("Humidity", humidityData);
            chart.addSeries("Temperature (C)", tempData);
         
            // Create the tooltip
            var tip = new Tooltip(chart,"default");
         
            // Create the magnifier
            var mag = new Magnify(chart,"default");
         
            // Render the chart
            chart.render();
         
            // Create the legend
            var legend = new Legend({ chart: chart }, "legend");
        });
	
	</script>
	
     
</head>
 
<body style="background-color: #F5EEE6">
 
<div style="align: center;"><font size="5px">IBSC Weather Monitoring Dashboard</font></div>
 
<div id="chartNode" style="width:800px;height:400px;"></div>
 
<div id="legend"></div>

<script type="text/javascript">
        init();
</script>         
    
</body>
</html>