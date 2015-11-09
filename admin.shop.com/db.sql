1. supplier(供应商)
create table supplier(
  id smallint unsigned primary key auto_increment,
  name varchar(20)  not null default '' comment '名称',
  intro text comment '简介',
  status tinyint not null default 1  comment '状态',
  sort  smallint not null default 20 comment '排序'
) engine myisam default charset utf8;

准备供应商的数据
insert into supplier values(null,'北京供应商','北京供应商',1,20);
insert into supplier values(null,'天津供应商','天津供应商',1,20);
insert into supplier values(null,'重庆供应商','重庆供应商',1,20);
insert into supplier values(null,'成都供应商','成都供应商',1,20);
insert into supplier values(null,'上海供应商','上海供应商',1,20);


2.brand(品牌)
 create table brand(
      id smallint unsigned primary key auto_increment,
      name varchar(20)  not null default '' comment '品牌名称',
      url varchar(50) not null default '' comment '品牌网址',
      logo  varchar(50) not null default '' comment '品牌LOGO@file',
      intro text comment '品牌描述@text',
      status tinyint not null default 1  comment '状态@radio|1=是&0=否',
      sort  smallint not null default 20 comment '排序'
    ) engine myisam default charset utf8 comment '品牌';

show full columns from brand


3.goods_type(商品类型)
 create table goods_type(
      id tinyint unsigned primary key auto_increment,
      name varchar(20)  not null default '' comment '类型名称',
      intro text comment '类型描述@text',
      status tinyint not null default 1  comment '状态@radio|1=是&0=否',
      sort  smallint not null default 20 comment '排序'
    ) engine myisam default charset utf8 comment '商品类型';


4.goods_category(商品分类)
create table goods_category(
    id tinyint unsigned  primary key auto_increment,
    name varchar(50) not null default '' comment '名称',
    parent_id tinyint unsigned not null default 0 comment '父分类',
    lft smallint unsigned not null default 0 comment '左边界',
    rght smallint unsigned not null default 0 comment '右边界',
    level  tinyint  unsigned not null default 0 comment '级别',
    intro text comment '简介@text',
    status tinyint not null default 1 comment '状态@radio|1=是&0=否',
    sort tinyint  not null default 20 comment '排序',
    index(parent_id),
    index(lft,rght)
)engine=MyISAM comment '商品分类';


insert into goods_category values(1,'平板电视',9,3,4,3,'',1,20);
insert into goods_category values(2,'空调',9,5,6,3,'',1,20);
insert into goods_category values(3,'冰箱',9,7,8,3,'',1,20);
insert into goods_category values(4,'取暖器',8,11,14,3,'',1,20);
insert into goods_category values(5,'净化器',8,15,16,3,'',1,20);
insert into goods_category values(6,'加湿器',8,17,18,3,'',1,20);
insert into goods_category values(7,'小太阳',4,12,13,4,'',1,20);
insert into goods_category values(8,'生活电器',10,10,19,2,'',1,20);
insert into goods_category values(9,'大家电',10,2,9,2,'',1,20);
insert into goods_category values(10,'家用电器',0,1,20,1,'',1,20);


先排序后缩进:
 排序:   select  * from goods_category order by lft
 缩进:  使用jquery的插件




