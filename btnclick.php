<?php
    // include class
    require('phpMQTT.php');
    	
    if(isset($_GET['on'])) {
        onoffFunc('on');
    }
    if(isset($_GET['off'])) {
        onoffFunc('off');
    }

    function onoffFunc($val){
    	
    	// set configuration values
		$config = array(
			 'org_id' => '4pwavp',
			 'port' => '1883',
			 'iotf_user' => 'use-token-auth',
			 'iotf_token' => '12345678' 
		);
		

		$config['server'] = $config['org_id'] . '.messaging.internetofthings.ibmcloud.com';
		//$config['client_id'] = 'a:' . $config['org_id'] . ':' . $config['app_id'];
		$config['client_id'] = 'd:' . $config['org_id'] . ':phpAppDT:phpApp';
		$location = array();
		
		// initialize client
		$mqtt = new phpMQTT($config['server'], $config['port'], $config['client_id']); 
		$mqtt->debug = false;
		
		// connect to broker
		if(!$mqtt->connect(true, null, $config['iotf_user'], $config['iotf_token'])){
		  echo 'ERROR: Could not connect to IoT cloud';
			exit();
		} 
		else
		{
			if($val == 'on')
				$mqtt->publish("iot-2/evt/text/fmt/json","{ \"d\": { \"text\": \"ON\"}}", 0);
			else
				$mqtt->publish("iot-2/evt/text/fmt/json","{ \"d\": { \"text\": \"OFF\"}}", 0);
			
		  	$mqtt->close();
		}
		
		header("location:javascript://history.go(-1)");
    }
    
    
?>