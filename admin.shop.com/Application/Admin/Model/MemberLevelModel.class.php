<?php
namespace Admin\Model;

use Think\Model;

class MemberLevelModel extends BaseModel
{
// 自动验证定义
protected $_validate = array(
//根据标准的字段生成验证规则,因为字段有多个,所以是一个数组,要递归判断生成
array('name', 'require', '名称不能够为空!'),
array('bottom', 'require', '经验值下限不能够为空!'),
array('top', 'require', '经验值上限不能够为空!'),
array('discount', 'require', '折扣率不能够为空!'),
array('status', 'require', '状态不能够为空!'),
array('sort', 'require', '排序不能够为空!'),
);
}