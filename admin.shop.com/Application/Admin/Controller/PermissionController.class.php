<?php
namespace Admin\Controller;

use Think\Controller;

class PermissionController extends BaseController
{
    protected $meta_title="权限";
    /**
     * 从数据库中获取权限信息
     */
    public function index()
    {
        //获取去权限列表
        $rows=$this->model->getList("id,name,parent_id,status,level,sort");
        //把数据分配到页面
        $this->assign("meta_title",$this->meta_title);
        $this->assign("rows",$rows);
        //.选择页面display
        $this->display('index');
    }


    /**
     * 页面展示之前,向页面添加数据
     */
    public function _before_edit_view(){
        //1.准备页面上树需要的数据
        $rows=$this->model->getList();
        $this->assign("nodes",json_encode($rows));
    }

}