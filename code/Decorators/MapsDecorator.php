<?php

class MapsDecorator extends Extension {
	
	public static $allowed_actions = array('Places','GetKey');

	

	function Places() {
	    $Places = DataObject::get("Place");
	    $body =  $this->owner->customise( array( 'Places' => $Places))->renderWith("KMLPlaces");

	    $response = new SS_HTTPResponse($body,200);
	    $response->addHeader('Content-type',"application/vnd.google-earth.kml+xml");
	    return $response;
	}


	function GetKey() {
		$sc = SiteConfig::current_site_config();
		return $sc->GMapsApiKey;
	}	

	function onAfterInit(){
		Requirements::javascript('http://maps.google.com/maps/api/js?sensor=false&language=es');
		Requirements::javascript('Geo/javascript/geoxml3.js');
		Requirements::javascript('Geo/javascript/ProjectedOverlay.js');
	}
	


}
