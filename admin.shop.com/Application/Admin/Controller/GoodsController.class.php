<?php
namespace Admin\Controller;

use Think\Controller;

class GoodsController extends BaseController
{
    protected $meta_title = "商品";

    /**
     * 页面展示之前被调用,想页面上分配数据
     */
    protected function _before_edit_view()
    {
        //1.准备商品分类的数据
        $goodModel = D('GoodsCategory');//实例化商品分类模板(从中取出分类数据)
        $goodsCategorys = $goodModel->getList();//调用商品分类模板中的方法获取数据
        $this->assign('nodes', json_encode($goodsCategorys));//返回json数据,给树用

        //2.准备品牌数据,分配到页面
        $brandModel = D('Brand');//实例化品牌分类模板(从中取出分类数据)
        $brands = $brandModel->getShowList();//获取状态为1的品牌数据(值显示要显示的品牌)
        $this->assign('brands', $brands);

        //3.准备供货商数据,分配到页面
        $supplierModel = D('Supplier');//实例化品牌分类模板(从中取出分类数据)
        $suppliers = $supplierModel->getShowList();//获取状态为1的品牌数据(值显示要显示的品牌)
        $this->assign('suppliers', $suppliers);

        //4.准备会员级别的数据,分配到页面
        $MemberLevelModle=D("MemberLevel");
        $MemberLevels=$MemberLevelModle->getShowList('id,name');
        $this->assign('MemberLevels',$MemberLevels);


        //编辑时
        $id = I("get.id", "");//获取商品的id,如果没有id,则默认值为空
        if (!empty($id)) {//id不为空时,表示编辑,执行
            //4.1当编辑时,准备商品简介数据---从goods_intro表中根据商品的id获取数据,分配到页面(编辑时,添加时就不需要了)
            $goodsIntroModel = M("GoodsIntro");//实例化商品简介对象---因为没有改模型,故从基础模型类中来
            $intro = $goodsIntroModel->getFieldByGoods_id($id, "intro");//根据某个字段获取某个值
            $this->assign("intro", $intro);//把数据分配到页面
            //4.2编辑时,准备商品图片数据---从goods_gallery表中,根据id获取表goods_gallery的Id和图片路径path
            $goodsGalleryModel = D('GoodsGallery');
            $goodsGallerys = $goodsGalleryModel->getGalleryByGoods_id($id);
            $this->assign('goodsGallerys', $goodsGallerys);//把图片数据分配到页面
            //4.3准备当前商品的相关文章数据
            $goodsArticleModel=D("GoodsArticle");//商品的模型
            $goodsArticles=$goodsArticleModel->getArticleByGoods_id($id);//根据商品id,查询出对应的文章数据
            $this->assign('goodsArticles',$goodsArticles);
            //4.4根据当前商品的id,把当前商品的会员价格查询出来
            $goodsMemberPriceModel=D("GoodsMemberPrice");//实例化商品会员价格关联表
            $goodsMemberPrice=$goodsMemberPriceModel->getMemberPrice($id);//调用方法getMemberPrice(),根据id获取商品对应会员的价格
            $this->assign('goodsMemberPrice',$goodsMemberPrice);
        }
    }

    /**
     * 基类中的方法不满足我们的操作,故覆盖之
     */
    public function add()
    {
        if (IS_POST) {
            //1.通过create获取数据,并验证,自动提交
            if ($this->model->create() !== false) {
                //2.进行添加add--判断添加是否成功
                $requestData = I("post.");//获取请求中的所有数据,并传给模型的add()方法,用I()方法安全,数据已经被转义
                $requestData['intro'] = I("post.intro", "", false);//参数设置为false,表示不再进行任何过滤
                if ($this->model->add($requestData) !== false) {
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
     * 编辑,更新
     */
    public function edit($id)
    {
        if (IS_POST) {
            //通过create获取数据
            //1.判断create是否验证成功和自动提交成功
            if ($this->model->create() !== false) {
                //2.判断更新到数据库是否成功
                $requestData = I("post.");//获取请求中的所有数据,并传给模型的add()方法,用I()方法安全,数据已经被转义
                $requestData['intro'] = I("post.intro", "", false);//参数设置为false,表示不再进行任何过滤
                if ($this->model->save($requestData) !== false) {
                    $this->success('更新成功', cookie('__forward__'));//编辑后跳转到当前页
                    return;//跳转后,防止执行后续代码
                }
            }
            //验证失败,更新失败
            $this->error('操作失败' . showErrors($this->model));//调用公共函数中的方法,获取错误信息
        } else {
            //get方式,通过id获取一条记录
            //1.通过id获取要编辑的数据  find
            $row = $this->model->find($id);
            //2.把数据分布到页面上
            $this->assign($row);
            $this->_before_edit_view();//调用钩子方法,回显数据
            $this->assign('meta_title', '编辑' . $this->meta_title);
            //3.选择要分布的页面
            $this->display('edit');
        }
    }

    /**
     * 根据商品图片id删除该图片
     */
    public function deleteGallery($gallery_id)
    {
        $goodsGalleryModel = D('GoodsGallery');//实例化商品图片的对象
        $rst = $goodsGalleryModel->delete($gallery_id);//调用对象中的delete()方法,进行删除操作
        $result = array('success' => false);
        if ($rst !== false) {
            $result['success'] = true;
        }
        $this->ajaxReturn($result);//返回ajax数据
    }


}