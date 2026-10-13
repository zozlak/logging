<?php

/*
 * The MIT License
 *
 * Copyright 2026 zozlak.
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
 * Description of LogTrait
 *
 * @author zozlak
 */
trait LogTrait {

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
}
