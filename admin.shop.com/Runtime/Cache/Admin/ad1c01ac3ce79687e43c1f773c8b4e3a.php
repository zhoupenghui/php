<?php if (!defined('THINK_PATH')) exit();?><!-- $Id: brand_info.htm 14216 2008-03-10 02:27:21Z testyang $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - <?php echo ($meta_title); ?> </title>
<meta name="robots" content="noindex, nofollow" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="http://admin.shop.com/Public/Admin/css/general.css" rel="stylesheet" type="text/css" />
<link href="http://admin.shop.com/Public/Admin/css/main.css" rel="stylesheet" type="text/css" />
    
        <!--预留的一个块. 为了让子模板覆盖它加入自己的css-->
    
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo U('index');?>"><?php echo mb_substr($meta_title,2,null,'utf-8');?>列表</a></span>
    <span class="action-span1"><a href="#">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - <?php echo ($meta_title); ?> </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div">
   
    <form method="post" action="<?php echo U();?>">
        <table cellspacing="1" cellpadding="3" width="100%">
                        <tr>
                <td class="label">名称</td>
                <td>

                   <input type="text" name="name" maxlength="60" value="<?php echo ($name); ?>">                    <span class="require-field">*</span>
                </td>
            </tr>
                        <tr>
                <td class="label">货号</td>
                <td>

                   <input type="text" name="sn" maxlength="60" value="<?php echo ($sn); ?>">                    <span class="require-field">*</span>
                </td>
            </tr>
                        <tr>
                <td class="label">商品分类</td>
                <td>

                   <input type="text" name="goods_category_id" maxlength="60" value="<?php echo ($goods_category_id); ?>">                    <span class="require-field">*</span>
                </td>
            </tr>
                        <tr>
                <td class="label">品牌</td>
                <td>

                   <input type="text" name="brand_id" maxlength="60" value="<?php echo ($brand_id); ?>">                    <span class="require-field">*</span>
                </td>
            </tr>
                        <tr>
                <td class="label">供货商</td>
                <td>

                   <input type="text" name="supplier_id" maxlength="60" value="<?php echo ($supplier_id); ?>">                    <span class="require-field">*</span>
                </td>
            </tr>
                        <tr>
                <td class="label">本店价格</td>
                <td>

                   <input type="text" name="shop_price" maxlength="60" value="<?php echo ($shop_price); ?>">                    <span class="require-field">*</span>
                </td>
            </tr>
                        <tr>
                <td class="label">市场价格</td>
                <td>

                   <input type="text" name="market_price" maxlength="60" value="<?php echo ($market_price); ?>">                    <span class="require-field">*</span>
                </td>
            </tr>
                        <tr>
                <td class="label">库存</td>
                <td>

                   <input type="text" name="stock" maxlength="60" value="<?php echo ($stock); ?>">                    <span class="require-field">*</span>
                </td>
            </tr>
                        <tr>
                <td class="label">是否上架</td>
                <td>

                   <input type="text" name="is_on_sale" maxlength="60" value="<?php echo ($is_on_sale); ?>">                    <span class="require-field">*</span>
                </td>
            </tr>
                        <tr>
                <td class="label">商品状态</td>
                <td>

                   <input type="text" name="goods_status" maxlength="60" value="<?php echo ($goods_status); ?>">                    <span class="require-field">*</span>
                </td>
            </tr>
                        <tr>
                <td class="label">关键字</td>
                <td>

                   <input type="text" name="keyword" maxlength="60" value="<?php echo ($keyword); ?>">                    <span class="require-field">*</span>
                </td>
            </tr>
                        <tr>
                <td class="label">LOGO</td>
                <td>

                   <input type="text" name="logo" maxlength="60" value="<?php echo ($logo); ?>">                    <span class="require-field">*</span>
                </td>
            </tr>
                        <tr>
                <td class="label">状态</td>
                <td>

                   <input type="radio" class="status" name="status" value="1" /> 是<input type="radio" class="status" name="status" value="0" /> 否                    <span class="require-field">*</span>
                </td>
            </tr>
                        <tr>
                <td class="label">排序</td>
                <td>

                   <input type="text" name="sort" maxlength="60" value="<?php echo ((isset($sort) && ($sort !== ""))?($sort):20); ?>">                    <span class="require-field">*</span>
                </td>
            </tr>
                        <tr>
                <td colspan="2" align="center"><br/>
                    <input type="hidden" name="id" value="<?php echo ($id); ?>"/>
                    <input type="submit" class="button ajax-post" value=" 确定 "/>
                    <input type="reset" class="button" value=" 重置 "/>
                </td>
            </tr>

        </table>
    </form>

</div>

<div id="footer">
共执行 1 个查询，用时 0.018952 秒，Gzip 已禁用，内存占用 2.197 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
<script type="text/javascript" src="http://admin.shop.com/Public/Admin/js/jquery-1.11.2.js"></script>
<script type="text/javascript" src="http://admin.shop.com/Public/Admin/layer/layer.js"></script>
<script type="text/javascript" src="http://admin.shop.com/Public/Admin/js/common.js"></script>

    <!--预留的一个块. 为了让子模板覆盖它加入自己的js-->

<script type="text/javascript">
    $(function(){
        $(".status").val([<?php echo ((isset($status) && ($status !== ""))?($status):1); ?>]);
    });
</script>

</body>
</html>