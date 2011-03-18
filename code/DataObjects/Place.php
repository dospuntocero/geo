<?php 
	class Place extends DataObject{

	public static $singular_name = 'Sucursal';
	public static $plural_name = 'Sucursales';

	public static $db = array(
		'Name' => 'Varchar(255)',
		'Address' => 'Varchar(255)',
		'City' => 'Varchar(255)',
		'State' => 'Varchar(150)',
		'Zip' => 'Varchar(32)',
		'Description' => 'HTMLText',
		'Lat' => 'Varchar(100)',// Decimal(10,6)
		'Lng' => 'Varchar(100)',
		'IsHQ' => 'Boolean',
	);
	
	static $has_one = array(
		'PlaceImage' => 'Image',
		'Geo' => 'Geo',
		'SiteConfig' => 'SiteConfig',
		'Branch' => 'Branch'
	);

	public static $casting = array(
	  'JsLat' => 'Varchar(100)',
	  'JsLng' => 'Varchar(100)'
	);

	public function getJsLat() {
		return	str_replace(',','.',$this->Lat);
	}

	public function getJsLng() {
		return	str_replace(',','.',$this->Lng);
	}


	public function getCMSFields_forPopUp() {
		$fields = new FieldSet(
			new TextField('Name','Nombre'),
			new CheckboxField('IsHQ',_t('Place.ISHQ',"Is this the HQ?")),
			new TextField('Address','Dirección'),
			new TextField('City','Ciudad'),
			new TextField('State','Región'),
			new TextField('Zip','Código Postal'),
			new HiddenField('Lat'),
			new HiddenField('Lng'),
			new TextAreaField('Description','Descripción'),
			new ImageUploadField('PlaceImage','Image')
		);
		$this->extend('updateCMSFields', $fields);
	   	
		return $fields;
	}

	public function geocodeMe() {
		$address = "";

		if (!empty($this->Address)) {
			$address .= $this->Address;
		}else{
			Debug::show("sin dirección no se puede agregar en el mapa");
			
			return false;
		}
		if (!empty($this->City)) {
			$address .= ', '. $this->City;
		}
		if (!empty($this->State)) {
			$address .= ', '. $this->State;
		}
		if (!empty($this->Zip)) {
			$address .= ', '. $this->Zip;
		}
		
		$g = new GoogleGeocoder();

		$point = $g->addressToPoint($address);

		if (!$point instanceof GeoPoint) {
			$point = YahooGeocoder::addressToPoint($address);
		}else{
			$this->Lat = $point->Lat;
			$this->Lng = $point->Lng;
		}
		if ($point instanceof GeoPoint) {
			return true;
		}

  }


  public function onBeforeWrite() {
  	parent::onBeforeWrite();
  	// GeoCode The Address
  	$this->geocodeMe();
  }

}