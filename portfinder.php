<?php

$db = new SQLite3('port_data.sqlite');

$result = $db->query('SELECT minport, maxport, description FROM portmap');

$sum_ports = array();
$sum_ports_byname = array();
while($data = $result->fetchArray()) {
	$ports = range($data['minport'], $data['maxport']);
	foreach($ports as $port) {
		$sum_ports_byname[$port][] = $data['description'];
	}

	$sum_ports = array_merge($sum_ports, $ports);
}

if(isset($argv[1])) {
	if( isset($sum_ports_byname[$argv[1]]) ){
		foreach($sum_ports_byname[$argv[1]] as $item) {
			echo " - " . $item . "\n";
		}
	}else{
		echo "Not Found\n";
	}
}else{
	do {
		echo ".";
		$random = rand(0, 65535);
	}while( in_array($random, $sum_ports) );

	echo "random port:" . $random . "\n";
}