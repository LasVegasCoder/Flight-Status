<?php

echo "Welcome to SabreTTX<br>";
include_once('FlightStatusClass.php');
/*

	Key: 6vjy7hh6x5u9dxwsy2qvxgh5 
	Secret: FNUv6fPjPn 



*/
$data = array('flight_number' => 'LH400',
			'date' => "2017-06-26"
);

$flight = new FlightConnect('FNUv6fPjPn', '6vjy7hh6x5u9dxwsy2qvxgh5');


$response = $flight->_doConnect(null, $data);

echo "<pre>" . print_r($response, true ) . '</pre>' ;





?>