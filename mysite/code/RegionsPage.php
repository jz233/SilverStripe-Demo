
<?php

class RegionsPage extends Page{
	
	//一个RegionsPage对应多个Region
	//第一个'Regions':arbitary name
	private static $has_many = array(
		'Regions' => 'Region'
	);
	
	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->addFieldToTab('Root.Regions', GridField::create(
			'Regions',
			'Regions on this page',
			$this->Regions(),
			GridFieldConfig_RecordEditor::create()		//可编辑的GridField（本来为只读）
		));
		
		return $fields;
	}
	
}
class RegionsPage_Controller extends Page_Controller{
	
	
	
}


