<?php
namespace Admin\Model;

use Admin\Service\NestedSetsService;
use Think\Model;

class PermissionModel extends BaseModel
{
// 自动验证定义
    protected $_validate = array(
//根据标准的字段生成验证规则,因为字段有多个,所以是一个数组,要递归判断生成
        array('name', 'require', '权限名称不能够为空!'),
        array('status', 'require', '状态不能够为空!'),
        array('sort', 'require', '排序不能够为空!'),
    );

    /**
     * 覆盖基础模型中的add
     * @return mixed
     */
    public function add()
    {
        //1.计算左右边界
        //1.使用NestedSetsService业务逻辑类,完成边界的计算
        $dbMysqlInterfaceImplModel = D("DbMysqlInterfaceImpl");
        $nestedSetsService = new NestedSetsService($dbMysqlInterfaceImplModel, 'permission', 'lft', 'rght', 'parent_id', 'id', 'level');
        //2.然后将数据添加入数据库中,参数(父id,要插入的数据,插入到父类的那个位置)
        return $nestedSetsService->insert($this->data['parent_id'], $this->data, 'bottom');
    }

    /**
     * @return bool
     */
    public function save(){
        //1.使用NestedSetsService业务逻辑类,完成边界的计算
        $dbMysqlInterfaceImplModel = D("DbMysqlInterfaceImpl");
        $nestedSetsService = new NestedSetsService($dbMysqlInterfaceImplModel, 'permission', 'lft', 'rght', 'parent_id', 'id', 'level');
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
     * @param string $filed
     * @return mixed
     */
    public function getList($filed = "id,name,parent_id")
    {
        return $this->where("status>=0")->field($filed)->order("lft")->select();
    }

}