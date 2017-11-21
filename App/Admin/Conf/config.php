<?php
return array(
	//'配置项'=>'配置值'
    //PDO连接方式
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_USER'   => 'root', // 用户名
    'DB_PWD'    => 'root', // 密码
    'DB_PREFIX' => 'think_', // 数据库表前缀
    'DB_DSN'    => 'mysql:host=localhost;dbname=rbactest;charset=UTF8',
    //显示页面Trace信息
    //'SHOW_PAGE_TRACE' => true,

    //配置css路径信息
    'TMPL_PARSE_STRING'  =>array(
        //相对路径,相对于唯一入口文件index.php的路径
        '__CSS__'    => __DIRROOT__.'/Public/Admin/css/', // 增加新的CSS类库路径替换规则
        '__IMG__'    => __DIRROOT__.'/Public/Admin/images/', // 增加新的images类库路径替换规则
        '__JS__'     => __DIRROOT__.'/Public/Admin/js/', // 增加新的js类库路径替换规则
    ),

);