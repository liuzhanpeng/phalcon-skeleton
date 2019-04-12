<?php
namespace App\Core;

/**
 * 配置解析器
 * 实现配置的"@"和"^"功能
 * @author zhanpeng liu <liuzhanpeng@gmail.com>
 */
class ConfigParser
{
    /**
     * 原始配置数组
     * @var array
     */
    private $data;

    /**
     * 引用缓存
     * @var array
     */
    private $cache = [];

    public function __construct(array $data)
    {
        $this->data = $data; 
    }

    /**
     * 返回处理后的配置对象
     * @return Phalcon\Config
     */
    public function getConfig()
    {
        return new \Phalcon\Config($this->parse($this->data));
    }
   
    /**
     * 解析配置数组，处理特殊符号"@"和"^"
     * @param array $data 配置数组
     * @return array
     */
    public function parse(array $data)
    {
        $result = [];
        foreach ($data as $nodeKey => $nodeVal) {
            if (substr($nodeKey, 0, 1) === '@') {   // 处理@
                if (!is_string($nodeVal)) {
                    throw new \Exeception('@' . $nodeKey . '对应的项必须为字符串');
                }
                $key = substr($nodeKey, 1);
                $val = self::getRefNode($nodeVal);
                if (is_array($val)) {
                    $result[$key] = $this->parse($val);
                } else {
                    $result[$key] = $val;
                }
            } elseif (($index = strpos($nodeKey, '^')) !== false) { // 处理^
                if (!is_array($nodeVal)) {
                    throw new \Exception('^' . $nodeKey . '扩展对应项必须为数组');
                }
                $key = substr($nodeKey, 0, $index);
                $val = $this->getRefNode(substr($nodeKey, $index + 1));
                // 当前项覆盖引用项
                // $val = $this->parse(array_merge_recursive($val, $nodeVal));
                $result[$key] = $this->parse(array_merge($val, $nodeVal));
            } elseif (is_array($nodeVal)) { // 其它数组项递归处理
                $result[$nodeKey] = $this->parse($nodeVal);
            } else {
                $result[$nodeKey] = $nodeVal;
            }
        }

        return $result;
    }

    /**
     * 获取引用的节点
     * @param string $path 数组路径; 支持点语法; 如 "params.test.value"
     * @return mixed
     */
    private function getRefNode(string $path)
    {
        if (!isset($this->cache[$path])) {
            $result = null;
            $keys = explode('.', $path);
            while (($key = array_shift($keys)) != null) {
                if ($result == null) {
                    if (!isset($this->data[$key])) {
                        throw new \Exception('无效数组路径@' . $path);
                    }
                    $result = $this->data[$key];
                } else {
                    if (!isset($result[$key])) {
                        throw new \Exception('无效数组路径@' . $path);
                    }
                    $result = $result[$key];
                }
            }
            $this->cache[$path] = $result;
        }

        return $this->cache[$path];
    }
}