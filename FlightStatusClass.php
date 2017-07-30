<?php
	/*
		Name:		FlightConnect
		Desc:		FlightConnect connect to sabre Rest service
		Version:	V1.0
		Date:		6/24/2017 @Sabre HackertonTTX
		Author:		Prince Adeyemi
		Contact:	prince@vegasnewspaper.com
		Facebook:	fb.com/YourVegasPrince
		
		Usage:
		include_once "FlightConnect.php";
		
		$sabre = new FlightConnect( );
		$response = $sabre->_doConnect( "http://sabre.uri.to.connect.to" );
		var_dump( $response );
		
	*/


	if( !class_exists('FlightConnect') )
	{
		class FlightConnect
		{
			private $_link;
			private $client_id;
			private $client_secret;
			private $token;
			private $data;
			private $token_type;
			
			
			public function __construct( $secret, $clientid )
			{	
				$this->client_id = ( $clientid != '' ) ? $clientid : '' ;
				$this->client_secret = ( $secret != '' ) ? $secret : '' ;
				
				$this->client_id = ( !empty( $this->client_id ) ) ? base64_encode($this->client_id ) : '' ;
				$this->client_secret = ( !empty( $this->client_secret ) ) ? base64_encode( $this->client_secret ) : '' ;
				
				//$this->token = base64_encode($this->client_id.":".$this->client_secret);
				$this->token = $this->client_id.":".$this->client_secret;
				$this->data='grant_type=client_credentials';
		
			}
			
			
			public function _doConnect( $url=null, $flight="LH400" )
			{
				
				
				$headers = array(
					'Authorization: Bearer '.$this->token,
					'Accept: */*',
					'Content-Type: application/x-www-form-urlencoded'
				);
				    $ch = curl_init();
				   
					$host = "https://api.lufthansa.com/";

					$flight = ( $data=['flight_number'] ) ?  $data=['flight_number'] : 'LH400';
					$date = ( $data['date'] ) ?  $data['date'] : "2017-6-26";
					
					$endpoint = $host . 'v1/operations/flightstatus/' . $flight . '/' . $date;


				    curl_setopt($ch,CURLOPT_URL,"https://api.lufthansa.com/v1/oauth/token");
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					curl_setopt($ch,CURLOPT_POST,1);
					curl_setopt($ch,CURLOPT_POSTFIELDS,$this->data);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					
					$res = curl_exec($ch);
					curl_close($ch);
					$resf = json_decode($res);
				
					
				   $access_token = $resf->access_token; // token provided from sabre
				   $expires_in_seconds = $resf->expires_in;
				   $token_type = $resf->token_type;
					// //  END get access token 
					
					
					//$endpoint = 'https://api.test.sabre.com/v1/shop/flights?origin=NYC&destination=LAS&departuredate=2017-07-10&returndate=2017-07-20&onlineitinerariesonly=N&limit=10&offset=1&eticketsonly=Y&sortby=totalfare&order=asc&sortby2=departuretime&order2=asc&pointofsalecountry=US';
					
					$url = ( $url != null ) ? $url : $endpoint;
					
					$headers2 = array(
						'Authorization: bearer '.$access_token,
						'protocol: HTTP 1.1 ',
						"Content-Type: application/json"
					 );
					 
					 
					 
					 $ch2 = curl_init();


					curl_setopt($ch2,CURLOPT_HTTPHEADER,$headers2);
					curl_setopt($ch2, CURLOPT_URL, $url);
					//curl_setopt($ch2, CURLOPT_POST, TRUE);
					//curl_setopt($ch2, CURLOPT_POSTFIELDS, $postData);
					//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
					curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, FALSE);

					$results = json_decode(curl_exec($ch2));
					
					if( $results )
					{
						return $results;
					}
					//echo '<pre>' . print_r( $results, 1 ) . '</pre>';
			}
			
			
			public function parseResult()
			{
				
			}


		} // end of classss
	} // end of checkdate

	
?>









