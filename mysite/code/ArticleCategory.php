<?php

class ArticleCategory extends DataObject{
	private static $db = array(
		'Title' => 'Varchar'
	);
	
	//数据库PK字段的添加
	private static $has_one = array(
		'ArticleHolder'=>'ArticleHolder'
	);
	
	private static $belongs_many_many = array(
		'Articles' => 'ArticlePage'
	);
	
	//设置窗口中添加文本输入框
	public function getCMSFields(){
		return FieldList::create(
			TextField::create('Title')
		);
		
	}
	
}
