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
        //当我们修改,删除,添加时,状态发生改变,为了使我们操作后还是能够跳转到该页面,
        //就需要记录该页面,使用cookie保存该页面的url,当操作后,跳转到该url,
        //获取url---$_SERVER['REQUEST_URI']
        cookie('__forward__', $_SERVER['REQUEST_URI']);
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