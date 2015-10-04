<?php

class HomePage extends Page{
	
	
}
class HomePage_Controller extends Page_Controller{
	
	//Controller中的方法为public权限，在模板.ss中可以直接引用
	public function LatestArticles($count){
		return ArticlePage::get()
				->sort('Created','DESC')
				->limit($count);
		
	}
	
}


