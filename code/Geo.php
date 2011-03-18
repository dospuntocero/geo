<?php

class Geo extends Page {

	static $singular_name = "Google Map";

	// public static $db = array();
	// public static $has_many = array('Places' => 'Place');	
	// public static $has_one = array();

	static $icon = "Geo/images/treeicons/map";   

	// function getCMSFields() {		
	// 	$fields = parent::getCMSFields();  
	// 	$tablefield = new DataObjectManager(
	// 	    $this,
	// 	    'Places',
	// 	    'Place',
	// 	    array(
	// 			'Name' => 'Nombre',
	// 			'Lng' => 'Longitud',
	// 			'Lat' => 'Latitud'
	// 			
	// 	    ),
	// 	    'getCMSFields_forPopUp'
	// 	);
	// 
	// 	$tablefield->setPageSize(100);
	// 
	// 	$fields->addFieldToTab( 'Root.Content.Branches', $tablefield );
	// 	
	// 	return $fields;
	// }

}

class Geo_Controller extends Page_Controller {

}