📃 开源协议 Apache License Version 2.0 see http://www.apache.org/licenses/LICENSE-2.0.html
# 简介

基于phpreis拓展开发的简约、高效、可靠的Redis操作句柄
支持断线自动重连功能


版本说明
--------------------------------------------------------------------------

PHP7.0+版本 必须安装phpredis拓展

安装教程
--------------------------------------------------------------------------

composer require v10086/redis:v1.0

使用示例
--------------------------------------------------------------------------


```php

<?php
        //设置配置信息
        \v10086\Redis::$cofing=[
                'default'=>[
                    'host'          =>  'redis',//地址
                    'port'          => '6379',//端口
                    'password'      =>'pass',//密码
                    'persistent'    =>TRUE, //是否长连接  true 是 false 否
                    'timeout'=>FALSE
                ],
                'other'=>[
                    'host'          =>  'other_redis',//地址
                    'port'          => '6379',//端口
                    'password'      =>'other_pass',//密码
                    'persistent'    =>TRUE, //是否长连接  true 是 false 否
                    'timeout'=>FALSE
                ],
        ];
        //默认default 可设置为其他配置
        \v10086\Redis::connection('default');

        //句柄所具备的操作函数跟redis官方所提供的命令一致,可到redis官网查阅
        \v10086\Redis::set('key','val');
        \v10086\Redis::get('key');





```