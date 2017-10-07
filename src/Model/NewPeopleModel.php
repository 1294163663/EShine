<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/4
 * Time: 10:59
 */

namespace EShine\Model;

use EShine\Servers\Office;
use Workerman\MySQL\Connection;

require __DIR__ . '/../../vendor/autoload.php';

class NewPeopleModel extends Office
{
    /**
     * @var Connection
     */
    private $db;

    /**
     * @var int
     * @outName ID
     */
    public $id;

    /**
     * @var string
     * @outName 姓名
     */
    public $name;

    /**
     * @var string
     * @outName 班级
     */
    public $class;

    /**
     * @var string
     * @outName 性别
     */
    public $sex;

    /**
     * @var string
     * @outName 电话号码
     */
    public $phone;

    /**
     * @var string
     * @outName 宿舍
     */
    public $domi;

    /**
     * @var string
     * @outName 邮箱
     */
    public $email;

    /**
     * @var string
     * @outName 个人介绍
     */
    public $introduce;

    /**
     * @var string
     * @outName 兴趣爱好
     */
    public $hobby;

    /**
     * @var string
     * @outName 曾经获奖
     */
    public $prize;

    /**
     * @var string
     * @outName 工作建议及设想
     */
    public $suggestion;


    public function __construct($params = [])
    {
        $this->setParams($params);
        $old = $this->find();
        foreach ($old as $key => $value) {
            if (!isset($this->{$key})) {
                $this->{$key} = $value;
            }
        }
    }

    public function db()
    {
        if (!isset($this->db)) {
            $this->db = new Connection('localhost', '', 'root', '', 'eshine');
        }
        return $this->db;
    }

    public function setParams($params)
    {
        $vars = $this->getSelfVar();
        foreach ($params as $key => $value) {
            if (array_key_exists($key, $vars)) {
                $this->{$key} = $value;
            }
        }
    }

    public function find($params = null)
    {
        $vars = $this->getSelfVar();
        if ($params === null) {
            $params = $vars;
        }

        $row = $this->db()->select('*')->from($this->collectName());

        foreach ($params as $key => $value) {
            if (!empty($value)) {
                $row = $row->where("{$key}= '{$value}'");
            }
        }
        $row = $row->row();
        return $row;
    }

    public function save()
    {
        if (empty($this->name) || empty($this->phone)) {
            throw new \Exception("信息不完善");
        }
        $vars = $this->getSelfVar();
        if ($old = $this->find(['name' => $this->name, 'phone' => $this->phone])) {
            $vars['id'] = $old['id'];
            $flag = $this->db()->update($this->collectName())->cols($vars)->where("id={$old['id']}")->query();
        } else {
            unset($vars['id']);
            $flag  = $this->db()->insert($this->collectName())->cols($vars)->query();
        }
        if (!$flag) {
             throw new \Exception("提交失败");
        }
    }

    public function delete()
    {
        if ($old = $this->find(['name' => $this->name, 'phone' => $this->phone])) {
            $flag = $this->db()->delete($this->collectName())->where("id={$old['id']}")->query();
            if (!$flag) {
                throw new \Exception("删除失败");
            }
        } else {
            throw new \Exception("没有此人");
        }

    }

    public function getSelfVar()
    {
        $var = $this->getClassVar();
        return $var($this);
    }

    protected function getClassVar()
    {
        return create_function('$obj', 'return get_object_vars($obj);');
    }

    public function getPropertyDesc($fc){
        $func  = new \ReflectionProperty($this,$fc);
        $tmp   = $func->getDocComment();

        preg_match_all('/@outName(.*?)\n/',$tmp,$tmp);
        $tmp   = isset($tmp[1][0]) ? trim($tmp[1][0]) : '';

        return $tmp !='' ? $tmp:$fc;
    }

    public function collectName()
    {
        return 'new_people';
    }
}