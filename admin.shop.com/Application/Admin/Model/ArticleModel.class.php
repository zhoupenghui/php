<?php
namespace Admin\Model;

use Think\Model;

class ArticleModel extends BaseModel
{
// 自动验证定义
    protected $_validate = array(
//根据标准的字段生成验证规则,因为字段有多个,所以是一个数组,要递归判断生成
        array('name', 'require', '标题不能够为空!'),
        array('article_category_id', 'require', '文章分类不能够为空!'),
        array('times', 'require', '浏览次数不能够为空!'),
        array('inputtime', 'require', '录入时间不能够为空!'),
        array('status', 'require', '状态不能够为空!'),
        array('sort', 'require', '排序不能够为空!'),
    );
    //自动完成
    protected $_auto=array(
        array("inputtime",NOW_TIME),
    );
}