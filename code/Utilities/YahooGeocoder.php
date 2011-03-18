<?php

define("YAHOO_GEOCODER_URL", "http://local.yahooapis.com/MapsService/V1/geocode");

/**
 * Server-side connector to the Google Geocoding API.
 * Uses YAHOOMAPS_API_KEY for the API key
 * 
 * Usage:
 * <pre>
 * $g = new YahooGeocoder();
 * $geoPoint = $g->addressToPoint("123 Victoria St, Te Aro, Wellington, NZ");
 * $otherGeoPoint = $g->addressPartsToPoint("123", "Adelaide Rd", "Newtown", "Wellington", "NZ");
 * </pre>
 */
class YahooGeocoder {
	

	/**
	 * Returns a Google Geopoint matching the given address parts
	 */
	static function addressPartsToPoint($streetNumber, $street, $suburb, $city, $country) {
		return self::addressToPoint("$streetNumber, $street, $suburb, $city, $country");
	}

	/**
	 * Returns a Google Geopoint matching the given address.
	 */
	static function addressToPoint($address) {
		$baseURL = YAHOO_GEOCODER_URL;
		
		$requestURL = $baseURL . "?appid=".GeoKeys::$yahoo_maps_api."&output=php&location=" . urlencode($address);

		// Do a curl request to get the actual contents
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $requestURL);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
	    $raw_response = curl_exec ($ch);
        if (curl_errno($ch)) {
            $result = array_merge(curl_getinfo($ch), array( 'status' => 'BAD', 'error_code' => curl_errno($ch), 'error_message' => curl_error($ch), 'raw' => $raw_response ));
        } else {
            $header_size = curl_getinfo($ch,CURLINFO_HEADER_SIZE);
            $result = Array();
            $result['status'] = 'OK';
            $result['header'] = substr($raw_response, 0, $header_size);
            $result['body'] = substr( $raw_response, $header_size );
            $result['http_code'] = curl_getinfo($ch,CURLINFO_HTTP_CODE);
            $result['last_url'] = curl_getinfo($ch,CURLINFO_EFFECTIVE_URL);
            $result['raw'] = $raw_response;
            
        }
        
    	/*
     	 * Close The Curl Connection
        */
        curl_close ($ch);
        $rslt = false;
        if ($result['status'] == 'OK') {
                    
            $geodata = unserialize($result['body']);
            echo var_export($geodata,true);
            $georslt = $geodata['ResultSet']['Result'];
            // hack to fix multiple returned results
            if (isset($georslt[0])) {
            	$georslt = $georslt[0];
            }
            try {
            	if (!isset($georslt['warning'])) {
            		$lat = $georslt['Latitude'];
            		$lng = $georslt['Longitude'];
            		$rslt =  GeoPoint::from_x_y($lng, $lat);
            
            	}
            } catch (Exception $e) {
    			echo 'Caught exception: ',  $e->getMessage(), "\n";
    			echo var_export($geodata,true);
    			$rslt = false;
            }
            
        }
        return $rslt;
        //var_export($result);
        //var_export($geodata);
		//return false;
		
		$delay = 0;
		
		$status = "620";
		while(strcmp($status, "620") == 0) {		
	    	$xml = simplexml_load_file($requestURL) or user_error("Can't access $url", E_USER_WARNING);
			if(!$xml) return;
			
		    $status = $xml->Response->Status->code;
		    if (strcmp($status, "200") == 0) {
				// Successful geocode
				$coordinates = $xml->Response->Placemark->Point->coordinates;
				$coordinatesSplit = split(",", $coordinates);
				// Format: Longitude, Latitude, Altitude
				$lat = $coordinatesSplit[1];
				$lng = $coordinatesSplit[0];
				return GeoPoint::from_x_y($lng, $lat);

		    } else if (strcmp($status, "620") == 0) {
				// sent geocodes too fast
				$delay += 100000;
			}
		}
	}
}

?>