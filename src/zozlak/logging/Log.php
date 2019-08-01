<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace zozlak\logging;

use DateTime;

/**
 * Description of Log
 *
 * @author zozlak
 */
class Log extends \Psr\Log\AbstractLogger {

    private $fileName;
    private $minLevel;
    private $format;

    public function __construct(string $fileName,
                                string $level = \Psr\Log\LogLevel::DEBUG,
                                string $format = "{TIMESTAMP}\t{LEVEL}\t{MESSAGE}") {
        $this->fileName = $fileName;
        LogLevel::compare($level, $level); // check if level is valid
        $this->minLevel = $level;
        $this->format   = $format;
    }

    public function setLevel(string $level): void {
        LogLevel::compare($level, $level); // check if level is valid
        $this->minLevel = $level;
    }

    public function log($level, $message, array $context = array()): void {
        $test = LogLevel::compare($level, $this->minLevel);
        if ($test >= 0) {
            $message = $this->serialize($message, $context);
            $output  = $this->format . "\n";
            $output  = str_replace('{TIMESTAMP}', (new DateTime())->format('Y-m-d H:i:s.u'), $output);
            $output  = str_replace('{LEVEL}', $level, $output);
            $output  = str_replace('{MESSAGE}', $message, $output);
            error_log($output, 3, $this->fileName);
        }
    }

    private function serialize($message, array $context): string {
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
