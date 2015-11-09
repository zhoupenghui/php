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
    <link href="http://admin.shop.com/Public/Admin/uploadify/uploadify.css" rel="stylesheet" type="text/css" />


</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo U('index');?>"><?php echo mb_substr($meta_title,2,null,'utf-8');?>列表</a></span>
    <span class="action-span1"><a href="#">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - <?php echo ($meta_title); ?> </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div">
   
    <div id="tabbar-div">
        <p>
            <span class="tab-front">通用信息</span>
            <span class="tab-back">商品描述</span>
            <span class="tab-back">会员价格</span>
            <span class="tab-back">商品属性</span>
            <span class="tab-back">商品相册</span>
            <span class="tab-back">关联文章</span>
        </p>
    </div>
    <form method="post" action="<?php echo U();?>">
        <table cellspacing="1" cellpadding="3" width="100%">
            <tr>
                <td class="label">名称</td>
                <td>
                   <input type="text" name="name" maxlength="60" value="<?php echo ($name); ?>">                    <span class="require-field">*</span>
                </td>
            </tr>
            <tr>
                <td class="label">商品分类</td>
                <td>
                   <input type="hidden" name="goods_category_id" class="goods_category_id" maxlength="60" value="<?php echo ($goods_category_id); ?>">
                   <input type="text" name="goods_category_text" class="goods_category_text" maxlength="60" disabled="disabled" value="请选择下面的分类">                    <span class="require-field">*</span>
                </td>
            </tr>
            <tr>
                <td class="label"></td>
                <td>
                    <ul id="treeDemo" class="ztree"></ul>
                </td>
            </tr>
            <tr>
                <td class="label">品牌</td>
                <td>
                    <?php echo arr2select('brand_id',$brands,$brand_id);?>
                </td>
            </tr>
            <tr>
                <td class="label">供货商</td>
                <td>
                    <?php echo arr2select('supplier_id',$suppliers,$supplier_id);?>
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
                    <input type="radio" class="is_on_sale" name="is_on_sale" value="1" /> 是
                    <input type="radio" class="is_on_sale" name="is_on_sale" value="0" /> 否
                </td>
            </tr>
            <tr>
                <td class="label">商品状态</td>
                <td>
                    <input type="checkbox" class="goods_status" name="goods_status[]" value="1" /> 精品
                    <input type="checkbox" class="goods_status"  name="goods_status[]" value="2" /> 新品
                    <input type="checkbox" class="goods_status" name="goods_status[]" value="4" /> 热销
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
                    <input type="file" name="upload-logo" id="upload-logo" maxlength="60">
                    <input type="hidden" name="logo" class="logo"  value="<?php echo ($logo); ?>">
                    <div class="upload-img-box upload-logo-box" style="display: <?php echo ($logo?'block':none); ?>">
                        <div class="upload-pre-item" >
                            <img src="http://itsource-goods.b0.upaiyun.com/<?php echo ($logo); ?>">
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="label">状态</td>
                <td>
                   <input type="radio" class="status" name="status" value="1" /> 是
                    <input type="radio" class="status" name="status" value="0" /> 否
                    <span class="require-field">*</span>
                </td>
            </tr>
            <tr>
                <td class="label">排序</td>
                <td>
                    <input type="text" name="sort" maxlength="60" value="<?php echo ((isset($sort) && ($sort !== ""))?($sort):20); ?>">                    <span class="require-field">*</span>
                </td>
            </tr>
        </table>
        <table cellspacing="1" cellpadding="3" width="100%" style="display: none">
            <tr>
                <td>
                    <textarea name="intro" id="intro"><?php echo ($intro); ?></textarea>
                </td>
            </tr>
        </table>
        <table cellspacing="1" cellpadding="3" width="100%"  style="display: none">
            <tr>
                <td class="label">会员价格</td>
                <td>
                    <input type="text" ><span class="require-field">*</span>
                </td>
            </tr>
        </table>
        <table cellspacing="1" cellpadding="3" width="100%"  style="display: none">
            <tr>
                <td class="label">商品属性</td>
                <td>
                    <input type="text" ><span class="require-field">*</span>
                </td>
            </tr>
        </table>
        <style type="text/css">
            .upload-pre-item{
                position: relative;
                float: left;
            }
            .upload-pre-item a{
                position: absolute;
                top: 0px;
                right: 0px;
                display: block;
                background-color: red;
            }
        </style>
        <table cellspacing="1" cellpadding="3" width="100%"  style="display: none">
            <tr>
                <td>
                    <div class="upload-img-box upload-gallery-box"  style="display: inline-block;">
                        <?php if(is_array($goodsGallerys)): $i = 0; $__LIST__ = $goodsGallerys;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$goodsGallery): $mod = ($i % 2 );++$i;?><div class="upload-pre-item">
                                <img src="http://itsource-goods.b0.upaiyun.com/<?php echo ($goodsGallery["path"]); ?>">
                                <a  dbid="<?php echo ($goodsGallery["id"]); ?>" href="javascript:;">X</a>
                            </div><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="file" id="upload-gallery" />
                </td>
            </tr>
        </table>
        <table cellspacing="1" cellpadding="3" width="100%"  style="display: none">
            <tr>
                <td style="text-align: left">
                    关联文章: <input type="text"  name="keyword" class="keyword" /><input type="button" class="search_article" value="搜索" />
                </td>
                <td></td>
            </tr>
            <tr>
                <td style="text-align: left;width: 50%">
                    <select multiple="multiple" class="left-select" style="width: 80%;height: 300px;">
                    </select>
                </td>
                <td style="text-align: left;width: 50%">
                    <div class="selecteOption">
                        <?php if(is_array($goodsArticles)): $i = 0; $__LIST__ = $goodsArticles;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$goodsArticle): $mod = ($i % 2 );++$i;?><input type="hidden" name="article_d[]" value="<?php echo ($goodsArticle["id"]); ?>"/><?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                    <select multiple="multiple" class="right-select" style="width: 80%;height: 300px;">
                        <?php if(is_array($goodsArticles)): $i = 0; $__LIST__ = $goodsArticles;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$goodsArticle): $mod = ($i % 2 );++$i;?><option value="<?php echo ($goodsArticle["id"]); ?>"><?php echo ($goodsArticle["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </td>
            </tr>
        </table>
        <div style="text-align: center">
            <input type="hidden" name="id" value="<?php echo ($id); ?>"/>
            <input type="submit" class="button" value=" 确定 "/>
            <input type="reset" class="button" value=" 重置 "/>
        </div>
    </form>

</div>

<div id="footer">
共执行 1 个查询，用时 0.018952 秒，Gzip 已禁用，内存占用 2.197 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
<script type="text/javascript" src="http://admin.shop.com/Public/Admin/js/jquery-1.11.2.js"></script>
<script type="text/javascript" src="http://admin.shop.com/Public/Admin/layer/layer.js"></script>
<script type="text/javascript" src="http://admin.shop.com/Public/Admin/js/common.js"></script>

    <script type="text/javascript" src="http://admin.shop.com/Public/Admin/ztree/js/jquery.ztree.core-3.5.js"></script>
    <script type="text/javascript" src="http://admin.shop.com/Public/Admin/uploadify/jquery.uploadify.min.js" ></script>
    <script type="text/javascript" charset="utf-8" src="http://admin.shop.com/Public/Admin/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="http://admin.shop.com/Public/Admin/ueditor/ueditor.all.min.js"> </script>
    <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
    <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
    <script type="text/javascript" charset="utf-8" src="http://admin.shop.com/Public/Admin/ueditor/lang/zh-cn/zh-cn.js"></script>
    <script type="text/javascript">
        $(function(){
            $(".is_on_sale").val([1]);

            ////////////////////////切换特效    开始///////////////////////
            //1.在所有的span标签上添加点击事件
            $("#tabbar-div span").click(function () {
                //2.因为不知道点击那个标签,故点击时,先让所有的class='tab-front'都变为class='tab-back'
                $("#tabbar-div span").removeClass("tab-front").addClass('tab-back');
                //3.再改变当前的span,改为tab-front
                $(this).removeClass('tab-back').addClass('tab-front');
                //4.找到form下的所有table,先把他们全部隐藏,再将对应的显示出来
                $("form>table").hide();
                //5.找到对应的span---当前所有的span中,点击的是哪一个
                var index=$(this).index();//点击的是第几个span
                $("form>table").eq(index).show();//显示这个span

                if(index==1){
                    //当点击时,才加载在线编辑器,这样可以提高性能
                    ////////////////////////商品的在线编辑器    开始///////////////////////
                    var ue = UE.getEditor('intro',
                            {initialFrameHeight:400,
                                initialFrameWidth:800
                            }
                    );
                    ////////////////////////商品的在线编辑器     结束///////////////////////
                }

            });
            ////////////////////////切换特效    结束///////////////////////


            ////////////////////////商品分类树    开始///////////////////////
            //1树的设置
            var setting = {
                data: {
                    simpleData: {
                        enable: true,
                        pIdKey: "parent_id",//默认的父id:pIdKey: "pId",---修改为自己的parent_id
                    }
                },
                callback: {
                    beforeClick:function(treeId, treeNode, clickFlag){
                        //用于单击节点之前的事件回调函数，并且根据返回值确定是否允许单击操作
                        if(treeNode.isParent){
                                //当是一个父分类时,提示,是一个父分类
                            layer.msg('必须选择最小分类', {
                                icon:0,//表示笑脸图形---成功为1,失败为0
                                offset: 0,
                                //shift: 6,//  跳动
                                time: 1000 //定义时间
                            });
                        }
                        return !treeNode.isParent;//如果分类有子节点,就返回false,表示不选中
                    },
                    //点击树的事件,当点击时,该li显示在父分类自己
                    onClick: function (event, treeId, treeNode) {
                        //treeNode:点击的对象(包括name,id...)
                        //找到父分类及其隐藏域--给他们赋值
                        $(".goods_category_id").val(treeNode.id);
                        $(".goods_category_text").val(treeNode.name);
                    }
                }
            };
            //2.准备树中需要的数据
            var zNodes = <?php echo ($nodes); ?>;
            //3.把id为treeDemo的ul变为一颗树,返回值就是该树的对象
            var treeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
            //下面的代码是编辑时要执行的---编辑时有id,当有id时(id不为空),就是编辑,要选中树的节点
            <?php if(!empty($id)): ?>var goods_category_id=<?php echo ($goods_category_id); ?>;//根据商品的id找(回显时有商品的id)
                    var node=treeObj.getNodeByParam('id',goods_category_id);//根据goods_category_id找到商品的id的节点
                    treeObj.selectNode(node);//选中
                    //并且将id,name设置
                    $(".goods_category_id").val(node.id);
                    $(".goods_category_text").val(node.name);
                 <?php else: ?>
                    //4.使用对象中的方法使其展开
                     treeObj.expandAll(true);<?php endif; ?>

            ////////////////////////商品分类树     结束///////////////////////

            ////////////////////////商品的LOGO上传插件     结束///////////////////////
            window.setTimeout(function(){
                //当页面加载完后,10 毫秒再加载,避免出错
                $("#upload-logo").uploadify({
                    height        : 25,//指定插件的宽高
                    width         : 145,
                    'buttonText' : '选择图片',//定义上传按钮的文字
                    'fileSizeLimit' : '100000KB',//指定文件上传的大小
                    swf           : 'http://admin.shop.com/Public/Admin/uploadify/uploadify.swf',//指定swf的地址
                    uploader      : '<?php echo U("Upload/index");?>',//在服务器上处理上传的代码
//                'fileObjName' : 'the_files',//上传文件时,name的名字  $_FIELDS['the_files'], ----它有一个默认值Filedata,搜易这里不必指定,直接用$_FIELDS['Filedata']获取文件信息
                    'formData'      : {'dir' : 'goods'},//通过post方式,传入额外的参数---参数(上传文件的目录)
                    'multi'    : false,//是否支持多文件上传
                    'onUploadError' : function(file, errorCode, errorMsg, errorString) {
                        alert('该文件上传失败,错误为: ' + errorString);
                    },
                    'onUploadSuccess' : function(file, data, response) {
                        //上传成功后返回data,就包括文件上传后的路径,把该路劲放到.logo的隐藏域中,与数据一起保存到数据库中
                        $(".logo").val(data);
                        $(".upload-img-box").show();//当返回值时,显示
                        $(".upload-logo-box img").attr("src","http://itsource-goods.b0.upaiyun.com/"+data);//要显示图片的路径
                    }
                });
            },10);
            ////////////////////////商品的LOGO上传插件     结束///////////////////////


            ////////////////////////编辑时回显商品状态    开始///////////////////////
            <?php if(!empty($id)): ?>var goods_status=<?php echo ($goods_status); ?>;//获取数据库中商品的状态,是一个整数
            var goods_status_values=new Array();
            if((goods_status & 1) >0){
                goods_status_values.push(1);
                //如果goods_status和 1 相与为真,就填充1到数组中,一下类似
            }
            if((goods_status & 2) >0){
                goods_status_values.push(2);
            }
            if((goods_status & 4) >0){
                goods_status_values.push(4);
            }
            $(".goods_status").val(goods_status_values);
            //val()中是一个数组找到商品状态---根据数据库中的状态来确认有哪些状态<?php endif; ?>
            ////////////////////////编辑时回显商品状态     结束///////////////////////


            ////////////////////////商品上传图片插件     结束///////////////////////
            window.setTimeout(function(){
                //当页面加载完后,10 毫秒再加载,避免出错
                $("#upload-gallery").uploadify({
                    height        : 25,//指定插件的宽高
                    width         : 145,
                    'buttonText' : '选择图片',//定义上传按钮的文字
                    'fileSizeLimit' : '100000KB',//指定文件上传的大小
                    swf           : 'http://admin.shop.com/Public/Admin/uploadify/uploadify.swf',//指定swf的地址
                    uploader      : '<?php echo U("Upload/index");?>',//在服务器上处理上传的代码
//                'fileObjName' : 'the_files',//上传文件时,name的名字  $_FIELDS['the_files'], ----它有一个默认值Filedata,搜易这里不必指定,直接用$_FIELDS['Filedata']获取文件信息
                    'formData'      : {'dir' : 'goods'},//通过post方式,传入额外的参数---参数(上传文件的目录)
                    'multi'    : true,//是否支持多文件上传
                    'onUploadError' : function(file, errorCode, errorMsg, errorString) {
                        alert('该文件上传失败,错误为: ' + errorString);
                    },
                    'onUploadSuccess' : function(file, data, response) {
                        //上传成功后返回data,就包括文件上传后的路径,把该路劲放到.logo的隐藏域中,与数据一起保存到数据库中
                        var itemHtml='<div class="upload-pre-item">\
                                <img src="http://itsource-goods.b0.upaiyun.com/'+data+'">\
                                <input type="hidden" name="gallery_path[]" value="'+data+'!m" />\
                                <a href="javascript:;">X</a>\
                                </div>';
                        $(itemHtml).appendTo(".upload-gallery-box");
                         }
                });
            },10);
            //删除商品图片--使用时间委派(因为a标签是新添加上去的)
            //找到a标签
            $(".upload-gallery-box").on('click',"a", function () {
                //1.判断该图片在数据库中是否存在(怎样判断:在a标签上添加dbid属性,该值是图片的id,如果有id,就表示是从数据库中的来的)
                var dbid=$(this).attr('dbid');//得到dbid
                var that=$(this);//保存当前a标签对象
                if(dbid){
                    ///2.如果存在,则需发送ajax请求,让服务器删除数据库中的数据
                    $.post('<?php echo U("deleteGallery");?>',{gallery_id:dbid}, function (data) {
                        if(data.success){
                            that.closest('div').remove();
                        }
                    });
                }else{
                    //3.如果不存在,则直接删除
                    $(this).closest('div').remove();
                }
            })

            ////////////////////////商品上传图片插件    结束///////////////////////


            ////////////////////////商品关联文章    开始///////////////////////
            $(".keyword").keypress(function (event) {
                    if(event.keyCode==13){
                        loadArticle();
                        return false;//当按回车键时,才取消默认操作
                    }
            });
            $(".search_article").click(function () {
                loadArticle();
            });
            //根据关键字查询文章
            function loadArticle(){
                //1.在点击时,先清除内容
                $(".left-select").empty();
                //2.发送ajax请求,getJSON
                $.getJSON('<?php echo U("Article/search");?>',{keyword:$(".keyword").val()}, function (rows) {
                    var optionHtml='';
                    $(rows).each(function () {
                        optionHtml+="<option value='"+this.id+"'>"+this.name+"</option>"
                    });
                    $(optionHtml).appendTo(".left-select");//把option追加到左边的select中
                });
            }

            //给左边的option加上点击事件,用事件委派--(把左边的放到右边)
            $(".left-select").on('dblclick',"option", function () {
                    $(this).appendTo(".right-select");
                    selecte2Hidden();
            });
            //给右边的option加上点击事件,用事件委派--(把右边的放到左边)
            $(".right-select").on("dblclick","option",function(){
                $(this).appendTo(".left-select");
                selecte2Hidden();
            });
            //当双击右边的option时,我们要把文章的id和商品的id保存到一张表中,故要获取文章的id用一个隐藏域保存,放到class=selecteOption中
            function selecte2Hidden(){
                //找到右边option,循环,
                $hiddenHtml='';
                $(".right-select option").each(function () {
                    $hiddenHtml+="<input type='hidden' name='article_id[]' value='"+this.value+"'>";
                });
                $(".selecteOption").empty();//在放到".selecteOption"之前,应该先请空
                $($hiddenHtml).appendTo(".selecteOption");//把文章的id放到selecteOption中
            }
            ////////////////////////商品关联文章    结束///////////////////////

        })
    </script>

<script type="text/javascript">
    $(function(){
        $(".status").val([<?php echo ((isset($status) && ($status !== ""))?($status):1); ?>]);
    });
</script>

</body>
</html>