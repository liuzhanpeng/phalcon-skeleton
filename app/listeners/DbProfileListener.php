<?php
namespace App\Listeners;

/**
 * 数据库语句分析监听器
 * @author zhanpeng liu <liuzhanpeng@gmail.com>
 */
class DbProfileListener
{
    /**
     * 日志文件
     * @var string
     */
    protected $logFile;

    /**
     * 数据库语句分析器
     * @var \Phalcon\Db\Profiler;
     */
    protected $profiler;

    /**
     * 构造函数
     * @param string $logFile 日志文件路径
     */
    public function __construct($params)
    {
        $this->logFile = $params->get('logFile');
        $this->profiler = new \Phalcon\Db\Profiler();
    }

    public function beforeQuery(\Phalcon\Events\Event $event, $connection)
    {
        $this->profiler->startProfile($connection->getSQLStatement(), $connection->getSqlVariables());
    }

    public function afterQuery(\Phalcon\Events\Event $event, $connection)
    {
        $this->profiler->stopProfile();

        $logger = new \Phalcon\Logger\Adapter\File($this->logFile);
        $profile = $this->profiler->getLastProfile();
        $logger->log(sprintf('%s [%s] %s', $profile->getSQLStatement(), json_encode($profile->getSqlVariables()), $profile->getTotalElapsedSeconds()));
    }
}
