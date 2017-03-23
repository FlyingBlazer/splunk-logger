<?php

namespace SplunkLogger;

use Monolog\Handler\StreamHandler;
use Monolog\Logger as MonoLogger;

class Logger
{
    private $logger;

    public function __construct()
    {
        $log_prefix = env('SPLUNK_LOG_APP', 'APP');
        $log_path = env('SPLUNK_LOG_PATH', 'storage/logs/splunk.log');

        $this->logger = new MonoLogger($log_prefix);
        $handler = new StreamHandler($log_path, MonoLogger::INFO);
        $handler->setFormatter(new SplunkFormatter());
        $this->logger->pushHandler($handler);
    }

    public function log($message, $context = [])
    {
        $this->logger->info($message, $context);
    }
}
