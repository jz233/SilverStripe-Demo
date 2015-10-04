<?php
class ArticleHolder extends Page{
	
	private static $allowed_children = array(
		'ArticlePage'
	);
	
	//ArticleHolder:ArticleCategory = 1:M
	//"Categories"是别名alias，指代ArticleCategory
	private static $has_many = array(
		'Categories' => 'ArticleCategory'
	);
	
	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->addFieldToTab('Root.Categories', GridField::create(
			'Categories',		//Tab标题
			'Article categories',
			$this->Categories(),	//与has_many中第一个字段相同。(数据源--->ArticleCategory表中的记录集)
			GridFieldConfig_RecordEditor::create()	//激活编辑器(如果没有，只能看列表不能编辑)
		));
		
		return $fields;
	}
	
	
}

class ArticleHolder_Controller extends Page_Controller {
	
	
}

