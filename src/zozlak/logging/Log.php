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

use DateTime;

/**
 * Description of Log
 *
 * @author zozlak
 */
class Log extends \Psr\Log\AbstractLogger {

    private string $fileName;
    private string $minLevel;
    private string $format;
    private bool $trace;

    public function __construct(string $fileName,
                                string $level = \Psr\Log\LogLevel::DEBUG,
                                string $format = "{TIMESTAMP}\t{LEVEL}\t{MESSAGE}") {
        $this->fileName = $fileName;
        LogLevel::compare($level, $level); // check if level is valid
        $this->minLevel = $level;
        $this->format   = $format;
        $this->trace    = (bool) preg_match('/{FILE}|{LINE}/', $format);
    }

    public function setLevel(string $level): void {
        LogLevel::compare($level, $level); // check if level is valid
        $this->minLevel = $level;
    }

    /**
     * 
     * @param mixed $level
     * @param mixed $message
     * @param array<mixed> $context
     * @return void
     */
    public function log(mixed $level, mixed $message, array $context = []): void {
        $test = LogLevel::compare($level, $this->minLevel);
        if ($test >= 0) {
            $message = $this->serialize($message, $context);
            $output  = $this->format . "\n";
            $output  = str_replace('{TIMESTAMP}', (new DateTime())->format('Y-m-d H:i:s.u'), $output);
            $output  = str_replace('{LEVEL}', $level, $output);
            if ($this->trace) {
                $trace  = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 5);
                $caller = [];
                foreach ($trace as $i) {
                    if (dirname($i['file'] ?? '') !== __DIR__) {
                        $caller = $i;
                        break;
                    }
                }
                $output = str_replace('{FILE}', $caller['file'] ?? '', $output);
                $output = str_replace('{LINE}', (string) ($caller['line'] ?? ''), $output);
            }
            $output = str_replace('{MESSAGE}', $message, $output);
            error_log($output, 3, $this->fileName);
        }
    }

    /**
     * 
     * @param mixed $message
     * @param array<mixed> $context
     * @return void
     */
    public function alert(mixed $message, array $context = []): void {
        $this->log(LogLevel::ALERT, $message, $context);
    }

    /**
     * 
     * @param mixed $message
     * @param array<mixed> $context
     * @return void
     */
    public function critical(mixed $message, array $context = []): void {
        $this->log(LogLevel::CRITICAL, $message, $context);
    }

    /**
     * 
     * @param mixed $message
     * @param array<mixed> $context
     * @return void
     */
    public function debug(mixed $message, array $context = []): void {
        $this->log(LogLevel::DEBUG, $message, $context);
    }

    /**
     * 
     * @param mixed $message
     * @param array<mixed> $context
     * @return void
     */
    public function emergency(mixed $message, array $context = []): void {
        $this->log(LogLevel::EMERGENCY, $message, $context);
    }

    /**
     * 
     * @param mixed $message
     * @param array<mixed> $context
     * @return void
     */
    public function error(mixed $message, array $context = []): void {
        $this->log(LogLevel::ERROR, $message, $context);
    }

    /**
     * 
     * @param mixed $message
     * @param array<mixed> $context
     * @return void
     */
    public function info(mixed $message, array $context = []): void {
        $this->log(LogLevel::INFO, $message, $context);
    }

    /**
     * 
     * @param mixed $message
     * @param array<mixed> $context
     * @return void
     */
    public function notice(mixed $message, array $context = []): void {
        $this->log(LogLevel::NOTICE, $message, $context);
    }

    /**
     * 
     * @param mixed $message
     * @param array<mixed> $context
     * @return void
     */
    public function warning(mixed $message, array $context = []): void {
        $this->log(LogLevel::WARNING, $message, $context);
    }

    /**
     * 
     * @param mixed $message
     * @param array<mixed> $context
     * @return string
     */
    private function serialize(mixed $message, array $context): string {
        if (is_array($message)) {
            $message = json_encode($message);
        } else if (is_object($message)) {
            if (method_exists($message, '__toString')) {
                $message = $message->__toString();
            } else {
                $message = json_encode($message);
            }
        } else {
            $message = (string) $message;
        }

        $replace = [];
        foreach ($context as $key => $val) {
            if (!is_array($val) && (!is_object($val) || method_exists($val, '__toString'))) {
                $replace['{' . $key . '}'] = $val;
            }
        }
        $message = strtr($message, $replace);

        return $message;
    }
}
