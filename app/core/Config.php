<?php
namespace App\Core;

/**
 * 封装配置类, 实现通过@号引用其它配置项, 方便配置文件组织
 * @author zhanpeng liu <liuzhanpeng@gmail.com>
 */
class Config
{
    /**
     * @var \Phalcon\Config
     */
    protected $_config;

    /**
     * 构造函数
     * @param array $data 配置数组
     */
    public function __construct(array $data)
    {
        $this->_config = new \Phalcon\Config($data); 
    }
    
    /**
     * 获取配置项
     * @param string $index 索引
     * @param mixed $defaultValue 默认值
     * @return \Phalcon\Config
     */
    public function get($index, $defaultValue = null)
    {
        $node = $this->_config->get($index, $defaultValue);

        if (is_object($node)) {
            return $this->handleRef($node->toArray());
        }

        return $node;
    }

    /**
     * 处理@引用
     * @param mixed $node 配置项
     */
    protected function handleRef($node)
    {
        if (is_array($node)) {
            $arr = [];
            $refArr = [];
            foreach ($node as $k => $v) {
                if ($k === '@' && $v != '') {
                    $refNode = $this->_config->path($v);
                    if ($refNode == null) {
                        throw new \Exception('引用无效配置@' . $v);
                    }
                    $refArr[$v] = $refNode->toArray();
                } else {
                    $arr[$k] = $this->handleRef($v);
                }
            }
            foreach ($refArr as $k => $v) {
                $arr = array_merge($v, $arr);
            }

            return new \Phalcon\Config($arr);
        }
        return $node;
    }

}