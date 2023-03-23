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
        return strcmp((string) $pos1, (string) $pos2);
    }
}
