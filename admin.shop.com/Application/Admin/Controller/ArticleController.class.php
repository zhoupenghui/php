<?php
namespace Admin\Controller;

use Think\Controller;

class ArticleController extends BaseController
{
    protected $meta_title = "文章";

    /**
     * 添加文章时:
     *      在页面展示之前,显示文章的相关信息,使用到父类钩子方法
     */
    protected function _before_edit_view()
    {
        //1.获取文章的分类(该分类状态是1):从article_category表中获取文章分类信息
        $articleCategoryModel = D("ArticleCategory");
        $articleCategorys = $articleCategoryModel->getShowList();//调用父模型中的方法,获取文章分类
        $this->assign('articleCategorys', $articleCategorys);//分配到页面

    }

    /**
     * 添加数据
     */
    public function add()
    {
        if (IS_POST) {
            //1.通过create获取数据,并验证,自动提交---已经转义了
            if (($data = $this->model->create()) !== false) {
                $data['content'] = I("post.content", '', false);// 取消转义
                if ($this->model->add($data) !== false) {
                    $this->success('添加成功', cookie('__forward__'));//添加成功后返回到原页面
                    return;//添加成功,防止执行后续代码
                }
            }
            //当create验证失败时,和添加入数据库失败是
            $this->error('操作失败' . showErrors($this->model));
        } else {
            $this->_before_edit_view();
            $this->assign('meta_title', '添加' . $this->meta_title);//进入添加页面,获取该类的属性
            $this->display('edit');
        }
    }

    /**
     * 关联文章的搜索---在article表中搜索
     */
    public function search($keyword)
    {
        $articleModel = D("Article");//实例化对象
        $wheres=array();//定义一个搜索条件数组
        $wheres['name']=array('like',"%".$keyword."%");
        $rows= $articleModel->getShowList("id,name",$wheres);//传入条件和字段
        $this->ajaxReturn($rows);
    }
}
