<?php if (!defined('THINK_PATH')) exit();?><!-- $Id: brand_info.htm 14216 2008-03-10 02:27:21Z testyang $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - <?php echo ($meta_title); ?> </title>
<meta name="robots" content="noindex, nofollow" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="http://admin.shop.com/Public/Admin/css/general.css" rel="stylesheet" type="text/css" />
<link href="http://admin.shop.com/Public/Admin/css/main.css" rel="stylesheet" type="text/css" />
    
    <link rel="stylesheet" href="http://admin.shop.com/Public/Admin/ztree/css/zTreeStyle/zTreeStyle.css" type="text/css">

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
                <td class="label">权限名称</td>
                <td>

                    <input type="text" name="name" maxlength="60" value="<?php echo ($name); ?>"> <span class="require-field">*</span>
                </td>
            </tr>
            <tr>
                <td class="label">权限的URL</td>
                <td>

                    <input type="text" name="url" maxlength="60" value="<?php echo ($url); ?>"> <span class="require-field">*</span>
                </td>
            </tr>
            <tr>
                <td class="label">父权限</td>
                <td>
                    <input type="hidden" name="parent_id" class="parent_id" maxlength="60">
                    <input type="text" name="parent_text" class="parent_text" maxlength="60" disabled="disabled" value="默认为顶级权限">
                    <span class="require-field">*</span>
                </td>
            </tr>
            <tr>
                <td class="label"></td>
                <td>
                    <ul id="treeDemo" class="ztree"></ul>
                </td>
            </tr>

            <tr>
                <td class="label">简介</td>
                <td>

                    <textarea name="intro" cols="60" rows="4"><?php echo ($intro); ?></textarea>
                    <span class="require-field">*</span>
                </td>
            </tr>
            <tr>
                <td class="label">状态</td>
                <td>

                    <input type="radio" class="status" name="status" value="1"/> 是<input type="radio" class="status"
                                                                                         name="status" value="0"/> 否
                    <span class="require-field">*</span>
                </td>
            </tr>
            <tr>
                <td class="label">排序</td>
                <td>

                    <input type="text" name="sort" maxlength="60" value="<?php echo ((isset($sort) && ($sort !== ""))?($sort):20); ?>"> <span
                        class="require-field">*</span>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center"><br/>
                    <input type="hidden" name="id" value="<?php echo ($id); ?>"/>
                    <input type="submit" class="button" value=" 确定 "/>
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

    <script type="text/javascript" src="http://admin.shop.com/Public/Admin/ztree/js/jquery.ztree.core-3.5.js"></script>
    <script type="text/javascript">
        $(function () {
            //1树的设置
            var setting = {
                data: {
                    simpleData: {
                        enable: true,
                        pIdKey: "parent_id",//默认的父id:pIdKey: "pId",---修改为自己的parent_id
                    }
                },
                callback: {
                    //点击树的事件,当点击时,该li显示在父分类自己
                    onClick: function (event, treeId, treeNode) {
                        //treeNode:点击的对象(包括name,id...)
                        //找到父分类及其隐藏域--给他们赋值
                        $(".parent_id").val(treeNode.id);
                        $(".parent_text").val(treeNode.name);
                    }
                }
            };
            //2.准备树中需要的数据
            var zNodes = <?php echo ($nodes); ?>;
            //3.把id为treeDemo的ul变为一颗树,返回值就是该树的对象
            var treeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
            //4.使用对象中的方法使其展开
            treeObj.expandAll(true);

            //当有id时.说明是编辑,就要回显,使用notempty(id不为空)
            <?php if(!empty($id)): ?>//根据父id找到树上的节点,然后选中
            var parent_id = <?php echo ($parent_id); ?>;//parent_id父节点
            //根据父节点.找到对应的节点
            var parentNode = treeObj.getNodeByParam('id', parent_id);//父节点
            if (!parentNode) {
                return;//如果没有找到父分类的结点,就结束,后续代码不会执行
            }
            //选中该节点
            treeObj.selectNode(parentNode);
            //将父节点(parentNode)的id和name赋给class=.parent_id,.parent_text
            $(".parent_id").val(parentNode.id);
            $(".parent_text").val(parentNode.name);<?php endif; ?>
        });
    </script>

<script type="text/javascript">
    $(function(){
        $(".status").val([<?php echo ((isset($status) && ($status !== ""))?($status):1); ?>]);
    });
</script>

</body>
</html>