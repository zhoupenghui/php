<?php
/**
 * Created by PhpStorm.
 * User: zph
 * Date: 2015/11/10
 * Time: 21:34
 */

namespace Admin\Model;


use Think\Model;

class GoodsMemberPriceModel extends Model
{

    /**
     * @param $goods_id根据商品的id ,获取对应的会员价格,并以
     * array(
     * [1]=>100
     * [2]=>200,
     * [3]=>300,
     *
     * );形式返回
     */
    public function getMemberPrice($goods_id)
    {
        $goodsMemberPrices = $this->field('member_level_id,price')->where(array("goods_id" => $goods_id))->select();//获取相应id的商品会员价格和会员等级编号
        $member_level_ids=array_column($goodsMemberPrices,'member_level_id');//调用array_column()方法,获取会员的id数组
        $price=array_column($goodsMemberPrices,'price');//获取价格
        return array_combine($member_level_ids,$price);//返回以键名为会员编号,键值为价格的关联数组
    }
}