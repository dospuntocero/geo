<?php

class Branch extends DataObjectDecorator {

	function extraStatics() {
		return array(
			'has_many' => array(
				'Places' => 'Place'
			)
		);
	}

	public function updateCMSFields(FieldSet &$fields) {
			$tablefield = new DataObjectManager(
			    $this->owner,
			    'Places',
			    'Place',
			    array(
					'Name' => 'Nombre',
					'Lng' => 'Longitud',
					'Lat' => 'Latitud'
			    ),
			    'getCMSFields_forPopUp'
			);
						
			
			$tablefield->setPageSize(100);
			
			$contactDetailsTab = _t('HomePage.CONTACTDETAILSTAB',"ContactDetails");

			$fields->addFieldsToTab('Root.'.$contactDetailsTab, $tablefield );
			
	}


}
