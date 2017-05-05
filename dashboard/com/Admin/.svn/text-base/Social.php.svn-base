<?php
	/* 
		PROJECT CONTROLLER
		AUTHOR BABAR
		AND
		@cendekiApp
	*/
global $ENGINE_PATH;
include_once $ENGINE_PATH."Utility/Paginate.php";
include_once APP_PATH."Admin/model/ProjectModel.php";
class Social extends SQLData{
	var $model;
	function __construct($req){
		parent::SQLData();
		$this->Request = $req;
		$this->View = new BasicView();
		$this->User = new UserManager();
		$this->model = new ProjectModel();
	}
	function admin(){
		$act = $this->Request->getParam('act');
		$id = $this->Request->getParam('id');
		
		if($act=='update-circle'){
			$circle = $this->Request->getPost('circle');
			$date = $this->Request->getPost('startDate');
			return $this->updateCircle($circle, $date);
		}
		else{return $this->main();}
	}

	function main(){
		$circle = $this->model->showCircle();
		
		$this->View->assign('circle',$circle);
		return $this->View->toString("dashboard/admin/social/index.html");
	}
	
	function updateCircle($circle, $date){
		$insert = $this->model->updateCircle($circle, $date);
		if($insert){
			$ok = 'Update Circle has been success!';
		}else{
			$msg = 'Update Circle Failed!';
		}
		$this->View->assign('ok',$ok);
		$this->View->assign('msg',$msg);
		sendRedirect('index.php?s=social');
		return $this->View->toString("dashboard/admin/social/index.html");
	}
}