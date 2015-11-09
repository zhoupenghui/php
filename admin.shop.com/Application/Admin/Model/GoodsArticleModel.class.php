<?php
/**
 * Created by PhpStorm.
 * User: zph
 * Date: 2015/11/9
 * Time: 18:39
 */

namespace Admin\Model;


use Think\Model;

class GoodsArticleModel extends Model
{
    /**
     * 根据商品的id查询出相关文章的id和name
     * @param $goods_id
     */
    public function getArticleByGoods_id($goods_id)
    {
        $sql = "SELECT a.id,a.name FROM goods_article AS ga JOIN article AS a ON ga.article_id=a.id WHERE goods_id =$goods_id";
        return $this->query($sql);
    }
}