<?php
	class TeamController extends Controller{
		
		private static $allowed_actions = array(
			'players','index'
		);
		
		public function index(SS_HttpRequest $request){
			echo "Index() called";
			return "additional data from index()";
		}
		
		public function players(SS_HttpRequest $request){
			print_r($request->allParams());
			
		}
		
		public function testaction(SS_HTTPRequest $request){
			$this->response = new SS_HTTPResponse();
			$this->response->setStatusCode(200);
			$this->response->setBody("OK!!!");
			
			return $this->response;
			
			//Render with TeamController.ss
		}
		
		
	}


?>