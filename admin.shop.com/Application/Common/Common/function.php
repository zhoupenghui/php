<?php
/**
 * 设置公用的函数
 */

/**
 * 从模型中获取错误信息,并拼接成ul
 */
function showErrors($model)
{
    //获取错误信息(可能是一个数组)
    $errors = $model->getError();
    //判断该错误信息是否是一个数组
    $msg = "<ul>";
    if (is_array($errors)) {
        foreach ($errors as $error) {
            //遍历每个错误
            $msg .= "<li>$error</li>";
        }
    } else {
        $msg .= "<li>$errors</li>";//把错误信息拼到li
    }
    $msg .= "</ul>";
    return $msg;
}

/**
 * 返回$rows数组中键值为$column_value的列，
 * 如果指定了可选参数index_key，那么input数组中的这一列的值将作为返回数组中对应值的键。
 * @param $rows
 * @param $column_value
 * @return array
 */
if(!function_exists(array_column)){
    function array_column($rows,$column_value){
        $temp=array();//存放循环的结果
        foreach ($rows as $row) {
            $temp[]=$row[$column_value];//把数组中的值存放到$temp中
        }
        return $temp;
    }
}


/**
 * 根据传入的名字和rows,生成一个下拉列表
 * @param $name  表单元素的名字
 * @param $rows 下拉列表中的数据
 */
function arr2select($name,$rows,$defaultValue,$filedName='id',$filedValue='name'){
    $html="<select name='$name' class='{$name}'>
                    <option value=''>--请选择--</option>";
            foreach($rows as $row){
                $selected='';//根据默认值比对每一行,从而生成selected='selected',然后在option中使用
                if($row[$filedName]==$defaultValue){
                    $selected="selected='selected'";
                }
                $html.="<option value='{$row[$filedName]}' {$selected}>{$row[$filedValue]}</option>";
            }
            $html.="</<select>";
    echo $html;
    
}
