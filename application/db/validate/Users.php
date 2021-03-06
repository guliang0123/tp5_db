<?php
/**
 * @Class: Users.php
 * @Description: user验证器
 * @Author: gl
 * @Date: 2018/6/11
 */
namespace app\db\validate;
use app\db\validate\BaseValidate;


class Users extends BaseValidate
{
    // 验证规则
    protected $rule = [
        'uid' => 'require|number|gt:0',
        'username' => 'require|min:4|max:16|checkTrue|unique:users',
        'realname' => 'require|min:2|max:8',
        'groupid' => 'require|number',
        'status' => 'require|number',
        'id' => 'require|isNumber',
        'sex' => 'require|in:0,1',
        'balance' => 'require|float',
        'ids' => 'require|checkNumber'
    ];
    // 错误消息
    protected $message = [
        'uid.require' => 'uid必填',
        'uid.number' => 'uid必须是数字',
        'uid.gt' => 'uid必须大于0',
        'username.require' => '用户名不能为空',
        'username.min' => '用户名长度至少为3个字符',
        'username.max' => '用户名长度最多为16个字符',
        // 'username.unique' => '当前用户名已经存在',
        'realname.require' => '真实姓名不能为空',
        'realname.min' => '真实姓名最少为2位',
        'realname.max' => '真实姓名最多为8位',
        'groupid.require' => '分组不能为空',
        'groupid.number' => '分组必须为数字',
        'status.require' => '状态不能为空',
        'status.number' => '状态必须为数字',
        'sex' => '性别参数有误',
        'balance' => '账户余额参数有误',
        'ids'=> 'ids必须是以逗号隔开正整数拼接的字符串'
    ];
    //验证用户名或真实姓名
    protected function checkTrue($value,$rule,$data,$field){
        if(preg_match('/^\w+/',$value)){
            return true;
        }else{
            return $field.'格式错误'.$data[$field];
        }
    }

    /**
     * @description 使用父类的方法循环检查传入的ids字符串是否合法
     * @param $value
     * @return bool
     */
    protected function checkNumber($value){
        $idsArr = explode(',',$value);
        if($idsArr){
            foreach($idsArr as $id){
               if(!$this->positive_integer($id)){
                   return false;
                   break;
               }
            }
        }else{
            return false;
        }
    }
    //验证场景
    protected $scene = [
        'get' => ['uid'],
        'add'  => ['username', 'realname', 'groupid','status'],
        'edit' => ['uid','username', 'realname', 'groupid','status'],
        'editrealname' => ['uid','realname'],
        'edituser' => ['uid','sex','balance','realname'],
        'lock' => ['uid','status'],
        'del'  => ['uid'],
    ];
}