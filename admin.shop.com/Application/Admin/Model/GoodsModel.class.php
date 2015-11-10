<?php
namespace Admin\Model;

use Think\Model;

class GoodsModel extends BaseModel
{
// 自动验证定义
    protected $_validate = array(
//根据标准的字段生成验证规则,因为字段有多个,所以是一个数组,要递归判断生成
//        array('name', 'require', '名称不能够为空!'),
////array('sn', 'require', '货号不能够为空!'),
//        array('goods_category_id', 'require', '商品分类不能够为空!'),
//        array('brand_id', 'require', '品牌不能够为空!'),
//        array('supplier_id', 'require', '供货商不能够为空!'),
//        array('shop_price', 'require', '本店价格不能够为空!'),
//        array('market_price', 'require', '市场价格不能够为空!'),
//        array('stock', 'require', '库存不能够为空!'),
//        array('is_on_sale', 'require', '是否上架不能够为空!'),
////array('goods_status', 'require', '商品状态不能够为空!'),
//        array('keyword', 'require', '关键字不能够为空!'),
//        array('logo', 'require', 'LOGO不能够为空!'),
//        array('status', 'require', '状态不能够为空!'),
//        array('sort', 'require', '排序不能够为空!'),
    );

    /**
     * 基础模型类的add添加方法不满足我们现在的操作:   要计算状态 1,2,4,  故覆盖add
     * $requestData    请求中的所有数据,
     * $this->data()   是通过create方法收集数据的,该数据已经被过滤和自动完成处理了
     */
    public function add($requestData)
    {
        $this->startTrans();//开启事务: 因为添加时是不同阶段,添加到不同的表中,如果某一个没有添加成功,那么另一个一定不会添加上去
        //1计算商品状态
        $this->handleGoodsStatus();
        //2.准备货号:日期+8为的id,id为8为,不足,前面补0,如:2015110700000001,  id的获取:先保存到数据中,就有id,再获取id,然后再更新进数据库
        $id = parent::add();//一定调用父类,的id,不然会自己调用自己,死循环了
        //判断是否保存成功---保存失败,回滚
        if ($id === false) {
            $this->rollback();//回滚
            return false;//返回false,后续代码不会执行了
        }
        //3.准备货号
        $sn = date("Ymd") . str_pad($id, 8, "0", STR_PAD_LEFT);//str_pad:填充id
        $result = parent::save(array("id" => $id, "sn" => $sn));//更新数据
        //判断是否更新成功
        if ($result === false) {
            $this->rollback();//更新失败,事务回滚
            return false;
        }

        //4.处理商品简介-商品简介是保存到goods_intro表中的故:
        $result = $this->handleGoodsIntro($id, $requestData['intro']);
        if ($result === false) {
            return false;
        }
        //5.处理商品相册--将商品图片保存到goods_gallery中
        $result = $this->handleGoodsGallery($id, $requestData['gallery_path']);
        if ($result === false) {
            return false;
        }
        //6.处理关联文章
        $result = $this->handleGoodsArticle($id, $requestData['article_id']);
        if ($result === false) {
            return false;
        }

        //7.处理商品会员价格
        $result = $this->handleGoodsMemberPrice($id, $requestData['MemberPrice']);
        if ($result === false) {
            return false;
        }

        //更新成功,提交事务
        $this->commit();
        return $id;//保存成功后返回的id
    }

    /**
     * 商品会员价格
     * @param $goods_id   商品的id
     * @param $memberPrice   商品各会员的价格(会员有多个,数组)
     * ["memberPrice"] => array(3) {
            [1] => string(3) "300"       级别id=>价格
            [2] => string(3) "200"
            [3] => string(3) "100"
    }
     */
    private function handleGoodsMemberPrice($goods_id, $memberPrices)
    {
        $rows=array();//用于存放商品会员价格和商品id,会员id
        foreach($memberPrices as $member_level_id =>$price){//循环取出商品对应的会员价格
            $rows[]=array("goods_id"=>$goods_id,"member_level_id"=>$member_level_id,"price"=>$price);
        }
        if(!empty($rows)){//判断$rows是否为空,把$rows保存到数据库中
            $goodsMemberPrice=M("GoodsMemberPrice");//实例化对象
            //根据当前商品的id,删除当前商品的会员价格,再添加
            $goodsMemberPrice->where(array("goods_id"=>$goods_id))->delete();
            $result=$goodsMemberPrice->addAll($rows);//批量添加
            if($result===false){
                $this->rollback();
                $this->error='商品会员价格保存失败!';
                return false;
            }
        }
    }

    /**
     * 根据商品的id和选中文章的id,把她们保存到goods_article表中
     * @param $goods_id   商品的id
     * @param $article_ids   关联文章的id(多篇关联文章---数组)
     */
    private function handleGoodsArticle($goods_id, $article_ids)
    {
        //取出每篇关联文章的id与之对应的商品id(循环取出),包她们保存到一个数组中
        $rows = array();//存放关联的id
        foreach ($article_ids as $article_id) {
            $rows[] = array("goods_id" => $goods_id, "article_id" => $article_id);
        }
        //$rows可能为空,在这种情况下会出错
        if (!empty($rows)) {
            $goodsArticleModel = M("GoodsArticle");//实例化GoodsArticle对象,用于要保存的对象
            $goodsArticleModel->where(array("goods_id" => $goods_id))->delete();//先删除所有,再添加,完成更新的功能
            $result = $goodsArticleModel->addAll($rows);//批量保存
            if ($result === false) {
                $this->rollback();
                $this->error = "保存关联文章出错";
                return false;
            }
        }
    }

    /**
     * 请求中的商品状态的值,计算出一整数代表商品状态
     */
    private function handleGoodsStatus()
    {
        //1.处理请求中的商品状态 装换成一个整数(通过二进制和并)---请求中的是一个数组,故要循环取出来
        $goods_status = 0;//准备一个初始状态
        foreach ($this->data['goods_status'] as $v) {
            $goods_status = $goods_status | $v;//请求中的每个状态和初始状态 |
        }
        $this->data['goods_status'] = $goods_status;//把data中的goods_status替换掉
    }

    /**
     * 处理商品简介
     * @param $goods_id  商品的id
     * @param $intro    商品的简介
     * @return bool     是否保存成功
     */
    private function handleGoodsIntro($goods_id, $intro)
    {
        //.处理商品简介-商品简介是保存到goods_intro表中的故:
        $goodsIntroModel = M('GoodsIntro');//使用M()方法,因为没有GoodsIntro控制器
        $goodsIntroModel->where(array("goods_id" => $goods_id))->delete();//先删除,在添加
        $result = $goodsIntroModel->add(array('goods_id' => $goods_id, 'intro' => $intro));//不用data的原因:当提交时,create会过滤goods表中的不合法的数据字段
        if ($result === false) {
            $this->rollback();//添加商品简介失败事务回滚
            $this->error = '保存商品简介失败';
            return false;
        }
    }

    /**
     * 添加商品图片到goods_gallery表中,可以批量添加(addAll())
     * @param $id   商品id
     * @param $gallerys  商品图片地址(是一个数组)
     *
     */
    private function handleGoodsGallery($id, $gallerys)
    {
        //循环取出商品图片和id,放到一个数组中,
        $row = array();//定义一个数组,用于存放id和gallery
        foreach ($gallerys as $gallery) {
            $row[] = array('goods_id' => $id, 'path' => $gallery);
        }
        //判断$rows有没有值,没有值就不添加
        if (!empty($row)) {
            $goodsGallery = M('GoodsGallery');//没有GoodsGallery模型
            $resutlt = $goodsGallery->addAll($row);//添加,并判断是否添加成功
            if ($resutlt === false) {
                $this->rollback();
                $this->error = '商品图片保存失败';
                return false;
            }
        }
    }

    /**基础的save不满足我们的需求,故要重写save
     * 根据请求中的所有数据进行更新
     * @param mixed|string $requestData 请求中的所有数据
     * @return bool
     */
    public function save($requestData)
    {
        $this->startTrans();//开启事务
        //1.计算商品的状态
        $this->handleGoodsStatus();

        //2.将请求中的商品简介更新到goods_intro表中(根据商品的id)
//        $goodsIntroModel=M("GoodsIntro");
//        $result=$goodsIntroModel->where(array("goods_id"=>$this->data['id']))->setField("intro",$requestData['intro']);//更新字段:setField
//        if($result===false){
//            $this->rollback();
//            $this->error="商品简介更新失败!";
//            return false;
//        }
        $result = $this->handleGoodsIntro($this->data['id'], $requestData['intro']);
        if ($requestData === false) {
            return false;
        }
        //3.将请求中的商品图片更新到goods_gallery中--就是把隐藏域中的value值(value中数据为路径)添加到该表中(和添加时是一样的)
        $result = $this->handleGoodsGallery($this->data['id'], $requestData['gallery_path']);
        if ($result === false) {
            return false;
        }

        //4.处理相关文章
        $result = $this->handleGoodsArticle($this->data['id'], $requestData['article_id']);
        if ($result === false) {
            return false;
        }
        //5.处理商品会员价格
       $result= $this->handleGoodsMemberPrice($this->data['id'], $requestData['MemberPrice']);
        if ($result === false) {
            return false;
        }
        
        //3.更新数据
        $result = parent::save();
        if ($result === false) {
            $this->rollback();
            $this->error = '更新数据失败';
            return false;
        }
        $this->commit();//提交事务
        return $result;//返回结果
    }
}