<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace zozlak\logging;

/**
 * Description of LogLevel
 *
 * @author zozlak
 */
class LogLevel extends \Psr\Log\LogLevel {

    /**
     * Compares two log levels. Returns -1 if $level1 is less severe than $level2,
     * 0 if both levels match and 1 if $level1 is more severe than $level2.
     * 
     * @param string $level1 
     * @param string $level2
     * @return int
     * @throws LoggingException
     */
    public static function compare(string $level1, string $level2): int {
        $levels = [
            self::DEBUG,
            self::INFO,
            self::NOTICE,
            self::WARNING,
            self::ERROR,
            self::CRITICAL,
            self::ALERT,
            self::EMERGENCY,
        ];
        $pos1   = array_search($level1, $levels);
        $pos2   = array_search($level2, $levels);
        if ($pos1 === false || $pos2 === false) {
            throw new LoggingException('Wrong level(s)');
        }
        return strcmp($pos1, $pos2);
    }

}
