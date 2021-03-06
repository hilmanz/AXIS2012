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
class Project extends SQLData{
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
		$update= $this->Request->getPost('update');
		if		($act=='insert-budget'){return $this->inbudget();}
		elseif	($act=='create-project'){return $this->createProject();}
		elseif	($act=='edit-project'){return $this->editProject($id);}
		elseif	($act=='update-project' && $update==1){return $this->updateProject($id);}
		elseif	($act=='delete-project'){return $this->deleteProject($id);}
		else	{return $this->main();}
	}

	function main(){
		$pList = $this->model->getProjectList();
		
		$this->View->assign('pList',$pList);
		return $this->View->toString("dashboard/admin/project/list_project.html");
	}
	function deleteProject($delete){
		$deleteProject = $this->model->deleteProject($delete);
		if($deleteProject){
			$ok= "Project has been deleted";
		}else{
			$msg= "Delete fail";
		}
		$pList = $this->model->getProjectList();
		$this->View->assign('pList',$pList);
		$this->View->assign('msg',$msg);
		$this->View->assign('ok',$ok);
		return $this->View->toString("dashboard/admin/project/list_project.html");
	}
	function editProject($edit){
		//Get Project Data
		$pData = $this->model->getProjectData($edit);
		$this->View->assign('pData',$pData);
		
		//Get Project KPI
		$pKPI = $this->model->getProjectKPI($edit);
		$this->View->assign('pKPI',$pKPI);
		
		//Get User Access
		$pUsr= $this->model->getProjectAccess($edit);
		$this->View->assign('pUsr', $pUsr);
		// print_r('<pre>');
		// print_r($pUsr);exit;
		
		//Get User List
		$userList= $this->model->getUser();
		$this->View->assign('userList', $userList);
		
		$this->View->assign('projID', $edit);
		return $this->View->toString("dashboard/admin/project/edit_project.html");
	}
	function updateProject($upd){
		//Update Project Data
		$update= $this->Request->getPost('update');
		$proName= $this->Request->getPost('projectName');
		$startD= $this->Request->getPost('startDate');
		$endD= $this->Request->getPost('endDate');
		$seo= $this->Request->getPost('seo');
		$sem= $this->Request->getPost('sem');
		$soc= $this->Request->getPost('social');
		$proStats= $this->Request->getPost('projectStatus');
		$proChannel= $this->Request->getPost('projectChannel');
		$proDesc= $this->Request->getPost('projectDesc');
		
		$clickTot= $this->Request->getPost('clickTot');
		$clickMonth= $this->Request->getPost('clickMonth');
		$clickDaily= $this->Request->getPost('clickDaily');
		$budgetTot= $this->Request->getPost('budgetTot');
		$budgetMonth= $this->Request->getPost('budgetMonth');
		$budgetDaily= $this->Request->getPost('budgetDaily');
		$ctrTot= $this->Request->getPost('ctrTot');
		$ctrMonth= $this->Request->getPost('ctrMonth');
		$ctrDaily= $this->Request->getPost('ctrDaily');
		
		$user = $_POST['projectAccess'];

		if($update==1){
			if($proName=='' || $startD=='' || $endD==''){
				$msg = 'Please Complete Create Project Form!';
			}else{
				//Project
				$data = array(
						"name"=>$proName,
						"start"=>$startD,
						"end"=>$endD,
						"seo"=>intval($seo),
						"sem"=>intval($sem),
						"soc"=>intval($soc),
						"kpi"=>0,
						"proStats"=>intval($proStats),
						"channel"=>$proChannel,
						"proDesc"=>$proDesc
						);
				$kpi = array(
						"click" => array(floatval($clickTot),floatval($clickMonth),floatval($clickDaily)),
						"budget" => array(floatval($budgetTot),floatval($budgetMonth),floatval($budgetDaily)),
						"ctr" => array(floatval($ctrTot),floatval($ctrMonth),floatval($ctrDaily))
						);
				$insert = $this->model->updateProject($upd, $data);
				if($insert){
					$insertkpi = $this->model->updateProjectDetails($upd ,$kpi, $user);			
					$ok = 'Update Project has been success!';
				}else{
					$msg = 'Update Project Failed!';
				}
			}
		}
		
		$this->View->assign('msg',$msg);
		$this->View->assign('ok',$ok);
		
		sendRedirect('index.php?s=project');
		return $this->View->toString("dashboard/admin/project/list_project.html");
		
	}
	function createProject(){
		//Retrieve Data
		$create= $this->Request->getPost('create');
		$proName= $this->Request->getPost('projectName');
		$startD= $this->Request->getPost('startDate');
		$endD= $this->Request->getPost('endDate');
		$seo= $this->Request->getPost('seo');
		$sem= $this->Request->getPost('sem');
		$soc= $this->Request->getPost('social');
		$proStats= $this->Request->getPost('projectStatus');
		$proChannel= $this->Request->getPost('projectChannel');
		$proDesc= $this->Request->getPost('projectDesc');
		
		$clickTot= $this->Request->getPost('clickTot');
		$clickMonth= $this->Request->getPost('clickMonth');
		$clickDaily= $this->Request->getPost('clickDaily');
		$budgetTot= $this->Request->getPost('budgetTot');
		$budgetMonth= $this->Request->getPost('budgetMonth');
		$budgetDaily= $this->Request->getPost('budgetDaily');
		$ctrTot= $this->Request->getPost('ctrTot');
		$ctrMonth= $this->Request->getPost('ctrMonth');
		$ctrDaily= $this->Request->getPost('ctrDaily');
		
		$user= $_POST['projectAccess'];
		
		// var_dump(intval($proStats));exit;
		//Insert Database
		if($create==1){
			if($proName=='' || $startD=='' || $endD==''){
				$msg = 'Please Complete Create Project Form!';
			}else{
				//Project
				$data = array(
						"name"=>$proName,
						"start"=>$startD,
						"end"=>$endD,
						"seo"=>intval($seo),
						"sem"=>intval($sem),
						"soc"=>intval($soc),
						"kpi"=>0,
						"proStats"=>intval($proStats),
						"channel"=>$proChannel,
						"proDesc"=>$proDesc
						);
				$kpi = array(
						"click" => array(floatval($clickTot),floatval($clickMonth),floatval($clickDaily)),
						"budget" => array(floatval($budgetTot),floatval($budgetMonth),floatval($budgetDaily)),
						"ctr" => array(floatval($ctrTot),floatval($ctrMonth),floatval($ctrDaily))
						);
				
				// var_dump($kpi['click']);exit;
				$insert = $this->model->createProject($data);
				if($insert){
					$proID = $this->model->getCurrentProject($proName);
					$insertkpi = $this->model->createProjectDetails($proID ,$kpi, $user);			
					$ok = 'Success Create Project!';
				}else{
					$msg = 'Create Project Failed!';
				}
			}
		}
		
		//Get User List
		$userList= $this->model->getUser();
		$this->View->assign('userList', $userList);
		
		$this->View->assign('msg',$msg);
		$this->View->assign('ok',$ok);
		return $this->View->toString("dashboard/admin/project/create_project.html");
	}
	function inbudget(){
		$plist = $this->model->getProjectList();
		// print_r($plist);exit;
		$save = $this->Request->getPost('save');
		if($save==1){
			$project = $this->Request->getPost('project');
			$budget = $this->Request->getPost('budget');
			if($project=='' || $budget==''){
				$msg = 'Please Complete Form!';
			}else{
				if(!is_numeric($budget)){
				$msg = 'Budget must be numeric';
				}else{
					$data = array("project"=>$project,"budget"=>$budget);
					$insert = $this->model->insertBudget($data);
					if($insert){
						$ok = 'Success Insert Budget!';
					}else{
						$msg = 'Insert Budget Failed!';
					}
				}
			}
		}
		$this->View->assign('project',$project);
		$this->View->assign('budget',$budget);
		$this->View->assign('plist',$plist);
		$this->View->assign('msg',$msg);
		$this->View->assign('ok',$ok);
		return $this->View->toString("dashboard/admin/project/insert_budget.html");
	}
}