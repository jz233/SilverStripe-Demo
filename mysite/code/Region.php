<?php

class Region extends DataObject{
	private static $db = array(
		'Title' => 'Varchar',
		'Description' => 'Text'
	);
	
	
	//在Region表中添加PhotoID,RegionsPageID两个字段
	private static $has_one = array(
		'Photo' => 'Image',
		'RegionsPage' => 'RegionsPage'	//每个Region对应一个RegionsPage
	);
	
	//第二个是解释文字
	private static $summary_fields = array(
		'GridThumbnail' => 'Thumbnail',		//SS会自动调用get方法，即getGridThumbnail()
		'Title' => 'Title of the region',
		'Description' => 'Short Description'
	);

	public function getGridThumbnail(){
		if($this->Photo()->exists()){
			return $this->Photo()->SetWidth(100);
		}
		return '(no img)';
	}

	//添加设置选项
	public function getCMSFields(){
		$fields = FieldList::create(
			TextField::create('Title'),
			TextareaField::create('Description'),
			$uploader = UploadField::create('Photo')
			
		);
		
		$uploader->setFolderName('region-photos');
		$uploader->getValidator()->setAllowedExtensions(array(
			'png','gif','jpeg','jpg'
		));
		
		return $fields;
		
	}
	
}



