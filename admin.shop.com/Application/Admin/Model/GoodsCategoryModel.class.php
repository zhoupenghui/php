<?php
namespace Admin\Model;

use Admin\Service\NestedSetsService;
use Think\Model;

class GoodsCategoryModel extends BaseModel
{
// 自动验证定义
    protected $_validate = array(
//根据标准的字段生成验证规则,因为字段有多个,所以是一个数组,要递归判断生成
        array('name', 'require', '分类名称不能够为空!'),
//        array('parent_id', 'require', '父分类不能够为空!'),//父分类可以为空,当为空时,为顶级分类---会执行DbMysqlInterfaceImplModel中的getOne方法
        array('lft', 'require', '左边界不能够为空!'),
        array('rght', 'require', '右边界不能够为空!'),
        array('level', 'require', '级别不能够为空!'),
        array('status', 'require', '状态不能够为空!'),
        array('sort', 'require', '排序不能够为空!'),
    );

    /**
     * 商品分类列表---按级别,查询左边界
     */
    public function getList()
    {
        return $this->where('status>=0')->order('lft')->select();
    }

    /**
     * 覆盖add方法,加入自己的业务逻辑
     */
    public function add()
    {
        //1.使用NestedSetsService业务逻辑类,完成边界的计算
        $dbMysqlInterfaceImplModel = new DbMysqlInterfaceImplModel();
        $nestedSetsService = new NestedSetsService($dbMysqlInterfaceImplModel, 'goods_category', 'lft', 'rght', 'parent_id', 'id', 'level');
        //2.然后将数据添加入数据库中,参数(父id,要插入的数据,插入到父类的那个位置)
        return $nestedSetsService->insert($this->data['parent_id'], $this->data, 'bottom');
    }

    /**
     * 因为修改,更新操作,Model类中的save方法不满足该操作:(修改父类,不能放到其子类中和自身)
     */
    public function save()
    {
        //1.使用NestedSetsService业务逻辑类,完成边界的计算
        $dbMysqlInterfaceImplModel = new DbMysqlInterfaceImplModel();
        $nestedSetsService = new NestedSetsService($dbMysqlInterfaceImplModel, 'goods_category', 'lft', 'rght', 'parent_id', 'id', 'level');
        //2.移动分类(不能移动到器子类和自身)--调用工具中的moveUnder()方法----$id,$parent_id在data中
        $result = $nestedSetsService->moveUnder($this->data['id'], $this->data['parent_id']);
        if ($result === false) {
            $this->error = '不能移动到自身及其子类';
            return false;
        }
        //3.修改数据(把数据更新到数据库中)
        return parent::save();
    }

    /**
     * 改变商品分类的状态时,其子类及其后代的状态也会发生改变,基本模型类中的changeStatus方法不满足先有需求故覆盖,重写一个
     * 该方法目的:
     *          将id及其子分类的id找到,该变他们的状态
     *
     * @param $id
     * @param $status
     */
    public function changeStatus($id, $status)
    {
        //1.找到id及其子分类的id--根据边界找,在左右边界之内的
        /**
         * 步骤:
         *      1.找到他及其左右边界:
         *      select lft,rght from goods_category where id=$id
         *      2.在左右边界之内的就是其子类:
         *      select child.name,child.id from goods_category as child where lft>上面的lft and rght<上面的rght
         *       把上面两条sql语句合并成一条,就找到了id下的所有子分类
         */
        $sql="select child.id from goods_category as parent,goods_category as child where child.lft>=parent.lft and child.rght<=parent.rght and child.status>=0 and parent.id=$id";
        $rows=$this->query($sql);//返回结果集(可能有多行子类的id---是一个二维数组)
        //我们要得到数组中的id,目的:改变其状态----1.循环取出   2.使用函数:array_column()
       //方法1:
//        $ids=array();
//        foreach($rows as $row){
//            $ids[]=$row['id'];
//        }
        //方法2:获取二维数组中一列的值array_column($arr,$value);该函数在php5.5中使用, function.php中定义,如果不是5.5,就要自己定义的
        $ids=array_column($rows,'id');
        //2.然后再修改其状态
        return parent::changeStatus($ids,$status);
    }

}