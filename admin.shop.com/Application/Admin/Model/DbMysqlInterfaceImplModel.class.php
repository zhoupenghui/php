<?php
/**
 * Created by PhpStorm.
 * User: zph
 * Date: 2015/11/7
 * Time: 0:00
 */

namespace Admin\Model;


class DbMysqlInterfaceImplModel implements DbMysqlInterfaceModel
{
    public function connect()
    {
        echo 'connect';
        exit;
    }

    public function disconnect()
    {
        echo 'disconnect';
        exit;
    }

    public function free($result)
    {
        echo 'free';
        exit;
    }

    public function query($sql, array $args = array())
    {
      $targetSql=$this->buildSql(func_get_args());
       return M()->execute($targetSql);//执行sql,返回的是一个boolean值,成功或失败
    }

    public function insert($sql, array $args = array())
    {
        /**
        dump(func_get_args()):传过来的参数是一个数组,如下:
        array(3) {
        [0] => string(21) "INSERT INTO ?T SET ?%"
        [1] => string(14) "goods_category"
        [2] => array(9) {
        ["name"] => string(12) "涓ぎ绌鸿皟"
        ["parent_id"] => int(2)
        ["intro"] => string(6) "寰堝ソ"
        ["status"] => string(1) "0"
        ["sort"] => string(2) "20"
        ["id"] => string(0) ""
        ["lft"] => int(10)
        ["rght"] => int(11)
        ["level"] => int(4)
        }
        }
         * 我们要把他拼接成: INSERT INTO goods_category SET name='ぎ绌鸿皟',parent_id=2,intro='寰堝ソ',..这种格式,才能插入数据库中
         * 步骤如下:
         */
        //1.获取参数
        $params=func_get_args();
        //2.取出参数的第一个元素(是一个模板sql)
        $sql=$params[0];
        //3.用数组中的的第二个元素(表名),替换模板sql中的?T
        $sql=str_replace('?T',$params[1],$sql);
        //4.取出#params中的第三个元素(一个数组),循环拼接(键和值拼接到一起),并放到一个数组中,
        $values=array();//存放拼接好的元素
        foreach($params[2] as $k=>$v){
            $values[]="$k='$v'";
        }
        //5.把拼接好的数组用 , 连接起来组成一个字符串
        $values=implode(',',$values);
        //6.用$values替换模板sql中的?%
        $sql=str_replace('?%',$values,$sql);//当id=''时,可能会报错,修改mysql的配置即可
//        $sql=str_replace("id=''","id=NULL",$sql);
        $result=M()->execute($sql);//执行SQL语句,返回: 成功返回参入的id,失败返回false
        if($result!==false){
            return M()->getLastInsID();//返回最后插入的id
        }else{
            return false;//执行失败
        }
    }

    public function update($sql, array $args = array())
    {
        echo 'update';
        exit;
    }

    public function getAll($sql, array $args = array())
    {
        echo 'getAll';
        exit;
    }

    public function getAssoc($sql, array $args = array())
    {
        echo 'getAssoc';
        exit;
    }

    public function getRow($sql, array $args = array())
    {

        /**
         * dump(func_get_args());//获取函数在真正执行时传递过来的参数,参数如下:该sq语句是获取父类的所有记录
         * array(8) {
         * [0] => string(43) "SELECT ?F, ?F, ?F, ?F FROM ?T WHERE ?F = ?N"
         * [1] => string(9) "parent_id"
         * [2] => string(3) "lft"
         * [3] => string(4) "rght"
         * [4] => string(5) "level"
         * [5] => string(14) "goods_category"
         * [6] => string(2) "id"
         * [7] => int(2)
         * }
         *1.完整的sql:  SELECT parent_id,lft,rght,level FROM goods_category WHERE id = 2  ----查询出来结果为:父类的一条记录
         * 2.要弄成以上sql语句,就要取出 [0] => string(43) "SELECT ?F, ?F, ?F, ?F FROM ?T WHERE ?F = ?N" 按 ?N  进行分割
         * 3.分割后是一个数组array('SELECT',' ',' ',' ',' ',' FROM ',' ',' WHERE ',' ',' = ',' ')
         * 4.然后把 parent_id,lft,rght..这些值追加到数组相应的位置,再以 , 连接成字符串, 就变成:
         *       SELECT parent_id,lft,rght,level FROM goods_category WHERE id = 2  样了
         * 步骤如下:
         */
//        $params = func_get_args();//获取函数在真正执行时传递过来的参数
//        $sql=array_shift($params);//将$params中的第一个元素弹出,弹出的是一个sql模板
//        $sqls=preg_split("/\?[TFN]/",$sql);//利用正则把$sql按?TNF进行分割,分割后是一个数组
//        //把弹出后的$params数据追加到$sqls中,这里需要循环执行,并拼接成字符串
//        $targeteSql='';//目标sql语句字符串
//        foreach($sqls as $k =>$v){
//            $targeteSql.=$v.$params[$k];//把sql模板和实际参数进行拼接成完成的sql
//        }
        //1.先拼好sql
        $targeteSql=$this->buildSql(func_get_args());
        //2.执行sql语句,获取返回的结果集
        $rows=M()->query($targeteSql);
        if(!empty($rows)){
            return $rows[0];//只能获取返回过来的一条数据,返回数据不为空,说明成功了,   该方法执行成功后会再去执行query()方法
        }
    }

    /**
     *自定义一个方法:
     *      根据传过来的参数,拼sql语句,发挥一个拼接好的sql语句字符串
     */
    public function buildSql($params){
        $sql=array_shift($params);//将$params中的第一个元素弹出,弹出的是一个sql模板
        $sqls=preg_split("/\?[TFN]/",$sql);//利用正则把$sql按?TNF进行分割,分割后是一个数组
        //把弹出后的$params数据追加到$sqls中,这里需要循环执行,并拼接成字符串
        $targeteSql='';//目标sql语句字符串
        foreach($sqls as $k =>$v){
            $targeteSql.=$v.$params[$k];//把sql模板和实际参数进行拼接成完成的sql
        }
        return $targeteSql;
    }



    public function getCol($sql, array $args = array())
    {
        echo 'getCol';
        exit;
    }

    public function getOne($sql, array $args = array())
    {
        //1.先拼好sql
        $targeteSql=$this->buildSql(func_get_args());
        //2.执行sql语句,获取返回的结果集
        $rows=M()->query($targeteSql);
        //获取关联数组中的第一个值
        $value=array_values($rows[0]);
        return $value[0];//返回改值
    }

}