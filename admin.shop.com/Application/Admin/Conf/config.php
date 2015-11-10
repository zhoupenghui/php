<?php
define('WEB_URL', 'http://admin.shop.com');//设置域名
return array(
    'TMPL_PARSE_STRING' => array(
        '__CSS__' => WEB_URL . '/Public/Admin/css',//设置css样式
        '__JS__' => WEB_URL . '/Public/Admin/js',//设置js样式
        '__IMG__' => WEB_URL . '/Public/Admin/images',//设置Images样式
        '__LAYER__' => WEB_URL . '/Public/Admin/layer/layer.js',//设置layer样式(js效果)
        '__UPLOADIFY__' => WEB_URL . '/Public/Admin/uploadify',//设置layer样式(js效果)
        '__BRAND__' => "http://itsource-brand.b0.upaiyun.com",//brand又拍云的ip地址
        '__GOODS__' => "http://itsource-goods.b0.upaiyun.com",//goods又拍云的ip地址
        '__TREEGRID1__' => WEB_URL . "/Public/Admin/treegrid1",//设置treegrid1---生成树
        '__ZTREE__' => WEB_URL . "/Public/Admin/ztree",//设置ztree树的展示插件
        '__UEDITOR__' => WEB_URL . "/Public/Admin/ueditor",//设置在线编辑器展示插件
    ),
);

