<?php

//设置Article Page类型页面的类
class ArticlePage extends Page{
	private static $can_be_root = false;
	
	//数据库表中字段
	private static $db = array(
		'Date'=>'Date',
		'Teaser'=>'Text',
		'Author'=>'VarChar'
	);
	
	//在ArticlePage表中添加PhotoID,BrochureID两个字段(int类型)
	private static $has_one = array(
		'Photo' => 'Image',
		'Brochure' => 'File'
	
	);
	
	//ArticlePage:ArticleComment = 1:M
	private static $has_many = array(
		'Comments' => 'ArticleComment'
	);
	
	
	//ArticlePage:ArticleCategory = M:N
	private static $many_many = array(
		'Categories' => 'ArticleCategory'
	);
	
	public function getCMSFields(){
		$fields = parent::getCMSFields();
		
		//Main Content标签页
		//将类型添加到admin中页面编辑选项中,并排在Content选项之前显示
		$fields->addFieldToTab('Root.Main',		//在Main Content标签项中添加该设置项
			DateField::create('Date','Date of the article')->setConfig('showcalendar',true)	//以日历方式选择日期，避免直接输入格式错误
			,'Content'); 	//第二个参数是解释文字，代替真实类型名显示在网页上
		$fields->addFieldToTab('Root.Main',TextAreaField::create('Teaser'),'Content');
		$fields->addFieldToTab('Root.Main',TextField::create('Author','Author of the article')
			->setDescription('If mulitple authors,separate with commas')
			->setMaxLength(50)
			,'Content');
		
		//Attachment标签页
		$fields->addFieldToTab('Root.Attachments',$photo = UploadField::create('Photo'));
		$fields->addFieldToTab('Root.Attachments',$brochure = UploadField::create('Brochure','Travel brochure, optional (pdf only)'));
		
		$photo->getValidator()->setAllowedExtensions(array('png','gif','jpeg','jpg'));
		$photo->setFolderName('travel-photos');
		$brochure->getValidator()->setAllowedExtensions(array('pdf'));
		$brochure->setFolderName('travel-brochures');
		
		//Categories标签页
		$fields->addFieldToTab('Root.Categories', CheckBoxSetField::create(
			'Categories',	//name
			'Select categories',	//title
			$this->Parent()->Categories()->map('ID','Title')	//source
		));
		
		return $fields;		
	}
	
	public function CategoriesList() {
		if($this->Categories()->exists()) {
			return implode(', ', $this->Categories()->column('Title'));
		}
	}
	
	
}

class ArticlePage_Controller extends Page_Controller {
	
	//允许CommentForm操作
	private static $allowed_actions = array(
		'CommentForm'
	);
	
	public function CommentForm(){
		/**
		*	controller处理表单提交的类
		*	name提交表单时Url中显示的名字，可自定义
		*	FieldList表单的内容
		*	FieldList:FormAction处理提交表单的方法
		* 	RequiredFields提交前需要验证的内容
		*/
		
		
		$form = Form::create(
			$this,	//controller
			__FUNCTION__,		//当提交表单时Url中显示的名字，可自定义
			FieldList::create(
				TextField::create('Name',''),
				EmailField::create('Email',''),
				TextareaField::create('Comment','')
			),
			FieldList::create(
				FormAction::create('handleComment','Post Comment')	//指定处理表单提交的方法handleComment
					->setUseButtonTag(true)
					->addExtraClass('btn btn-default-color btn-lg')
			),
			RequiredFields::create('Name','Email','Comment')
		
		)->addExtraClass('form-style');
		
		foreach($form->Fields() as $field){
			$field->addExtraClass('form-control')
				->setAttribute('placeholder', $field->getName().'*');
		}
		
		$data = Session::get("FormData.{$form->getName()}.data");
		
		return $form ? $form->loadDataFrom($data):$form;
	}
	
	
	//处理评论form的提交
	public function handleComment($data, $form){
		Session::set("FormData.{$form->getName()}.data",$data);
		
		$existing = $this->Comments()->filter(array(
			'Comment' => $data['Comment']
		));
		if($existing->exists() && strlen($data['Comment'])>20){
			$form->sessionMessage('That comment already exists, spammer!','bad');
			return $this->redirectBack();
		}
		
		
		$comment = ArticleComment::create();
		$comment->ArticlePageID = $this->ID;		//每张表都自动包含ID字段
		$form->saveInto($comment);
		
		//$comment->Name = $data['Name'];
		//$comment->Email = $data['Email'];
		//$comment->Comment = $data['Comment'];
		
		$comment->write();		//写入数据库
		
		Session::clear("FormData.{$form->getName()}.data");
		$form->sessionMessage('Thanks for your comment', 'good');
		
		return $this->redirectBack();
	}
	
	
}