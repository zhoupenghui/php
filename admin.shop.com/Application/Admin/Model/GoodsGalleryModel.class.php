<?php
/**
 * Created by PhpStorm.
 * User: zph
 * Date: 2015/11/9
 * Time: 0:44
 */

namespace Admin\Model;


use Think\Model;

class GoodsGalleryModel extends Model
{
    /**
     * 根据商品的id获取商品图片数据(id,path)---是一个数组
     * @param $goods_id
     */
    public function getGalleryByGoods_id($goods_id)
    {
        //查询某些字段的数据
        return $this->field('id,path')->where(array('goods_id' => $goods_id))->select();
    }

}