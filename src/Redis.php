<?php
namespace v10086;

//Redis 操作句柄  要求安装phpredis扩展
class Redis {
    
    static $instance;//实例组
    static $handler;//当前操作句柄实例
    static $config;//配置信息
    
    //初始化redis客服端并连接服务器端
    public static function connection($conn='default'){
        $conn && self::$handler=$conn;  !self::$handler && self::$handler ='default';
        
        if (!isset(self::$instance[self::$handler]) || !self::$instance[self::$handler]){
            if(!self::$config){
                throw new \Exception('请先设置配置信息');
            }
            $config=self::$config[self::$handler];
            if(!isset(self::$instance[self::$handler]) || empty(self::$instance[self::$handler]) ){
                self::$instance[self::$handler] =new \Redis();
                $func = $config['persistent'] ? 'pconnect' : 'connect';
                $config['timeout'] === false ?
                self::$instance[self::$handler]->$func($config['host'], $config['port']) :
                self::$instance[self::$handler]->$func($config['host'], $config['port'], $config['timeout']);
                $config['password'] &&  self::$instance[self::$handler]->auth($config['password']);
            }
        }
        
        return self::$instance[self::$handler];
    }
    
    
//     @desc 以static 方式编码 执行Redis方法 例如 Redis::pop();
//     @param method 需要执行的方法
//     @param arguments method所需参数
//     @return redis执行结果
    public static function __callStatic($method, $arguments) {
        try{
            if (!isset(self::$instance[self::$handler]) || !self::$instance[self::$handler]) self::connection(self::$handler);
            return call_user_func_array([self::$instance[self::$handler], $method], $arguments); 
        } catch (\RedisException $e) {
            if ($e->getMessage() == 'Redis server went away' || $e->getMessage() == 'Invalid connect timeout') {
                self::$instance[self::$handler]=null;
                self::connection(self::$handler);
                return call_user_func_array([self::$instance[self::$handler], $method], $arguments); 
            }else{
                throw new \Exception($e->getMessage());
            }
        }
        
    }

}
