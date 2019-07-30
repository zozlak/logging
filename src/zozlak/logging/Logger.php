<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace zozlak\logging;

/**
 * Description of Logger
 *
 * @author zozlak
 */
class Logger {

    static private $logs = [];
    static private $defaultLog;

    static public function addLog(\Psr\Log\LoggerInterface $log,
                                  string $logName = null,
                                  bool $makeDefault = true) {
        $logName              = $logName ?? time() . rand();
        self::$logs[$logName] = $log;
        if ($makeDefault) {
            self::$defaultLog = $logName;
        }
    }

    static public function setDefaultLog(string $logName) {
        if (!isset(self::$logs[$logName])) {
            throw new LoggingException('No such log');
        }
        self::$defaultLog = $logName;
    }

    static public function log($level, $message, array $context = [],
                               ?string $logName = null): void {
        $log = self::$logs[$logName ?? self::$defaultLog] ?? null;
        if ($log === null) {
            throw new LoggingException('No such log or default log not set');
        }
        $log->log($level, $message, $context);
    }

    static public function alert($message, array $context = [],
                                 ?string $logName = null): void {
        self::log(\Psr\Log\LogLevel::ALERT, $message, $context, $logName);
    }

    static public function critical($message, array $context = [],
                                    ?string $logName = null): void {
        self::log(\Psr\Log\LogLevel::CRITICAL, $message, $context, $logName);
    }

    static public function debug($message, array $context = [],
                                 ?string $logName = null): void {
        self::log(\Psr\Log\LogLevel::DEBUG, $message, $context, $logName);
    }

    static public function emergency($message, array $context = [],
                                     ?string $logName = null): void {
        self::log(\Psr\Log\LogLevel::EMERGENCY, $message, $context, $logName);
    }

    static public function error($message, array $context = [],
                                 ?string $logName = null): void {
        self::log(\Psr\Log\LogLevel::ERROR, $message, $context, $logName);
    }

    static public function info($message, array $context = [],
                                ?string $logName = null): void {
        self::log(\Psr\Log\LogLevel::INFO, $message, $context, $logName);
    }

    static public function notice($message, array $context = [],
                                  ?string $logName = null): void {
        self::log(\Psr\Log\LogLevel::NOTICE, $message, $context, $logName);
    }

    static public function warning($message, array $context = [],
                                   ?string $logName = null): void {
        self::log(\Psr\Log\LogLevel::WARNING, $message, $context, $logName);
    }

}
