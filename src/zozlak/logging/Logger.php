<?php

/*
 * The MIT License
 *
 * Copyright 2019 zozlak.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace zozlak\logging;

use Psr\Log\LogLevel;
use Psr\Log\LoggerInterface;

/**
 * Description of Logger
 *
 * @author zozlak
 */
class Logger {

    /**
     * 
     * @var array<LoggerInterface>
     */
    static private array $logs = [];
    static private string $defaultLog;

    static public function addLog(LoggerInterface $log, string $logName = null,
                                  bool $makeDefault = true): void {
        $logName              = $logName ?? time() . rand();
        self::$logs[$logName] = $log;
        if ($makeDefault) {
            self::$defaultLog = $logName;
        }
    }

    static public function setDefaultLog(string $logName): void {
        if (!isset(self::$logs[$logName])) {
            throw new LoggingException('No such log');
        }
        self::$defaultLog = $logName;
    }

    /**
     * 
     * @param mixed $level
     * @param mixed $message
     * @param array<mixed> $context
     * @param string|null $logName
     * @return void
     * @throws LoggingException
     */
    static public function log(mixed $level, mixed $message,
                               array $context = [], ?string $logName = null): void {
        $log = self::$logs[$logName ?? self::$defaultLog] ?? null;
        if ($log === null) {
            throw new LoggingException('No such log or default log not set');
        }
        $log->log($level, $message, $context);
    }

    /**
     * 
     * @param mixed $message
     * @param array<mixed> $context
     * @param string|null $logName
     * @return void
     */
    static public function alert(mixed $message, array $context = [],
                                 ?string $logName = null): void {
        self::log(LogLevel::ALERT, $message, $context, $logName);
    }

    /**
     * 
     * @param mixed $message
     * @param array<mixed> $context
     * @param string|null $logName
     * @return void
     */
    static public function critical(mixed $message, array $context = [],
                                    ?string $logName = null): void {
        self::log(LogLevel::CRITICAL, $message, $context, $logName);
    }

    /**
     * 
     * @param mixed $message
     * @param array<mixed> $context
     * @param string|null $logName
     * @return void
     */
    static public function debug(mixed $message, array $context = [],
                                 ?string $logName = null): void {
        self::log(LogLevel::DEBUG, $message, $context, $logName);
    }

    /**
     * 
     * @param mixed $message
     * @param array<mixed> $context
     * @param string|null $logName
     * @return void
     */
    static public function emergency(mixed $message, array $context = [],
                                     ?string $logName = null): void {
        self::log(LogLevel::EMERGENCY, $message, $context, $logName);
    }

    /**
     * 
     * @param mixed $message
     * @param array<mixed> $context
     * @param string|null $logName
     * @return void
     */
    static public function error(mixed $message, array $context = [],
                                 ?string $logName = null): void {
        self::log(LogLevel::ERROR, $message, $context, $logName);
    }

    /**
     * 
     * @param mixed $message
     * @param array<mixed> $context
     * @param string|null $logName
     * @return void
     */
    static public function info(mixed $message, array $context = [],
                                ?string $logName = null): void {
        self::log(LogLevel::INFO, $message, $context, $logName);
    }

    /**
     * 
     * @param mixed $message
     * @param array<mixed> $context
     * @param string|null $logName
     * @return void
     */
    static public function notice(mixed $message, array $context = [],
                                  ?string $logName = null): void {
        self::log(LogLevel::NOTICE, $message, $context, $logName);
    }

    /**
     * 
     * @param mixed $message
     * @param array<mixed> $context
     * @param string|null $logName
     * @return void
     */
    static public function warning(mixed $message, array $context = [],
                                   ?string $logName = null): void {
        self::log(LogLevel::WARNING, $message, $context, $logName);
    }
}
