<?php
namespace Admin\Action;
use Common\Action\AdminbaseAction;
class LinkAction extends AdminbaseAction{
	
	protected $link_obj;
	protected  $targets=array("_blank"=>"新标签页打开","_self"=>"本窗口打开");
	
	
	function _initialize() {
		parent::_initialize();
		$this->link_obj = D("Links");
	}
	
	function index(){
		$links=$this->link_obj->order(array("listorder"=>"asc"))->select();
		$this->assign("links",$links);
		$this->display();
	}
	
	function add(){
		$this->assign("targets",$this->targets);
		$this->display();
	}
	function add_post(){
		if(IS_POST){
			if ($this->link_obj->create()) {
				if ($this->link_obj->add()!==false) {
					$this->success("添加成功！", U("link/index"));
				} else {
					$this->error("添加失败！");
				}
			} else {
				$this->error($this->link_obj->getError());
			}
		
		}
	}
	
	
	
	function edit(){
		$id=I("get.id");
		$link=$this->link_obj->where("link_id=$id")->find();
		$this->assign($link);
		$this->assign("targets",$this->targets);
		$this->display();
	}
	
	function edit_post(){
		if (IS_POST) {
			if ($this->link_obj->create()) {
				if ($this->link_obj->save()!=false) {
					$this->success("保存成功！");
				} else {
					$this->error("保存失败！");
				}
			} else {
				$this->error($this->link_obj->getError());
			}
		}
	}
	
	//排序
	public function listorders() {
		$status = parent::_listorders($this->link_obj);
		if ($status) {
			$this->success("排序更新成功！");
		} else {
			$this->error("排序更新失败！");
		}
	}
	
	//删除
	function delete(){
		if(isset($_POST['ids'])){
			
		}else{
			$id = intval(I("get.id"));
			if ($this->link_obj->delete($id)!==false) {
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}
		}
	
	}
	
	/**
	 * 显示/隐藏
	 */
	function toggle(){
		if(isset($_POST['ids']) && $_GET["display"]){
			$ids = implode(",", $_POST['ids']);
			$data['link_status']=1;
			if ($this->link_obj->where("link_id in ($ids)")->save($data)!==false) {
				$this->success("显示成功！");
			} else {
				$this->error("显示失败！");
			}
		}
		if(isset($_POST['ids']) && $_GET["hide"]){
			$ids = implode(",", $_POST['ids']);
			$data['link_status']=0;
			if ($this->link_obj->where("link_id in ($ids)")->save($data)!==false) {
				$this->success("隐藏成功！");
			} else {
				$this->error("隐藏失败！");
			}
		}
	}
	
	
}