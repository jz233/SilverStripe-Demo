<?php

class ArticleCategory extends DataObject{
	private static $db = array(
		'Title' => 'Varchar'
	);
	
	//���ݿ�PK�ֶε����
	private static $has_one = array(
		'ArticleHolder'=>'ArticleHolder'
	);
	
	private static $belongs_many_many = array(
		'Articles' => 'ArticlePage'
	);
	
	//���ô���������ı������
	public function getCMSFields(){
		return FieldList::create(
			TextField::create('Title')
		);
		
	}
	
}
