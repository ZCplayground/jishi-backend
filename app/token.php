
<?php
// 生成token，copy自 https://blog.csdn.net/qq_26291823/article/details/53337518
function createtoken() 
{
    $str = md5(uniqid(md5(microtime(true)),true));  //生成一个不会重复的字符串
    $str = sha1($str);  //加密
    return $str;
}
/* token验证逻辑，检查token是否相同且是否过期。
$id: int型，用户id，User表的主码
$token: stirng，前端发来的要验证的token

每个接口都必须调用这个函数验证token
*/
function checktoken($id, $token)
{   
    $user = User::where('id', $id);
    if($user)
    {
        if($user->token == $token)
        {
            if((time() - $user->time_out) > 0)
            {
                return 'timeout'; // 长时间未操作，token超时，要重新登陆
            }
            $new_time_out = time() + 7200; // 更新token时间，7200秒是两小时
            $user->time_out = $new_time_out; 
            return 'success'; // token验证成功并刷新时间，可以继续获得接口信息。
        }
        else 
            return 'tokenerror'; // token有误
    }
    else 
        return 'iderror'; // user id 有误
}