<?php
namespace Admin\Controller;

use Think\Controller;

class GoodsCategoryController extends BaseController
{
    protected $meta_title="商品分类";

    /**
     * 从数据库中获取供应商的信息
     */
    public function index()
    {
        //1获取分类数据
        $rows = $this->model->getList();
        //2.把信息发布到页面assign
        $this->assign('rows',$rows);
        $this->assign('meta_title', $this->meta_title);
        //当我们修改,删除,添加时,状态发生改变,为了使我们操作后还是能够跳转到该页面,
        //就需要记录该页面,使用cookie保存该页面的url,当操作后,跳转到该url,
        //获取url---$_SERVER['REQUEST_URI']
        cookie('__forward__', $_SERVER['REQUEST_URI']);
        //3.选择页面display
        $this->display('index');
    }

    //在编辑页面展示之前,向页面分配数据
    protected function _before_edit_view(){
        //在页面展示之前,为添加(编辑)页面准备ztree树中的数据
        $rows = $this->model->getList();//调用模型中的方法,获取数据,因为树中节点需要的数JSOM数据,故转换成json字符串
        $this->assign('nodes',json_encode($rows));//因为树中节点需要的是JSOM数据,故转换成json字符串
    }
}