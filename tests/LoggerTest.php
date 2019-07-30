<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace zozlak\logging;

/**
 * Description of LoggerTest
 *
 * @author zozlak
 */
class LoggerTest extends \PHPUnit\Framework\TestCase {

    public function getFileName(int $i = 0): string {
        return __DIR__ . '/log' . $i;
    }

    public function cleanup(): void {
        for ($i = 0; $i < 10; $i++) {
            $f = $this->getFileName($i);
            if (file_exists($f)) {
                unlink($f);
            }
        }
    }

    public function testLogSimple() {
        $this->cleanup();
        $log = new Log($this->getFileName(), LogLevel::INFO, "{LEVEL}\t{MESSAGE}");
        $log->info('aaa');
        $log->error('bbb');
        $log->debug('ccc');
        $this->assertEquals("info\taaa\nerror\tbbb\n", file_get_contents($this->getFileName()));
        $this->cleanup();
    }

    public function testLogObjects() {
        $this->cleanup();
        $log        = new Log($this->getFileName(), LogLevel::INFO, "{MESSAGE}");
        $template   = [];
        $log->info('aaa');
        $template[] = 'aaa';
        $log->info([1, 2]);
        $template[] = '[1,2]';
        $log->info(['a' => 3, 'b' => 4]);
        $template[] = '{"a":3,"b":4}';
        $log->info((object) ['c' => 5, 'd' => 6]);
        $template[] = '{"c":5,"d":6}';
        $log->info(new TestException('sample exception'));
        $template[] = 'sample exception';
        $this->assertEquals(implode("\n", $template) . "\n", file_get_contents($this->getFileName()));
        $this->cleanup();
    }

    public function testLogPlaceholders() {
        $this->cleanup();
        $log = new Log($this->getFileName(), LogLevel::INFO, "{MESSAGE}");
        $log->setLevel(LogLevel::DEBUG);
        $log->debug('foo {bar}', ['bar' => 'foo']);
        $this->assertEquals("foo foo\n", file_get_contents($this->getFileName()));
        $this->cleanup();
    }

    public function testLoggerBasic() {
        $this->cleanup();
        Logger::addLog(new Log($this->getFileName(), LogLevel::INFO, "{MESSAGE}"));
        Logger::info('aaa');
        $this->assertEquals("aaa\n", file_get_contents($this->getFileName()));
        $this->cleanup();
    }

    public function testLoggerMany() {
        $this->cleanup();
        Logger::addLog(new Log($this->getFileName(1), LogLevel::INFO, "{MESSAGE}"), 'log1');
        Logger::addLog(new Log($this->getFileName(2), LogLevel::INFO, "{MESSAGE}"), 'log2', false);
        Logger::info('aaa');
        Logger::info('bbb', [], 'log1');
        Logger::info('ccc', [], 'log2');
        Logger::setDefaultLog('log2');
        Logger::info('ddd');        
        $this->assertEquals("aaa\nbbb\n", file_get_contents($this->getFileName(1)));
        $this->assertEquals("ccc\nddd\n", file_get_contents($this->getFileName(2)));
        $this->cleanup();
    }

    public function testLogLevelException() {
        $this->expectExceptionMessage('Wrong level(s)');
        LogLevel::compare('aaa', LogLevel::WARNING);
    }

    public function testLoggerNoSuchLog1() {
        $this->expectExceptionMessage('No such log or default log not set');
        Logger::info('aaa', [], 'xxx');
    }
    public function testLoggerNoSuchLog2() {
        $this->expectExceptionMessage('No such log');
        Logger::setDefaultLog('xxx');
    }
    
    public function testLoggerAllMethods() {
        $this->cleanup();
        Logger::addLog(new Log($this->getFileName(3), LogLevel::DEBUG, '{LEVEL}:{MESSAGE}'));
        Logger::debug('a');
        Logger::info('b');
        Logger::notice('c');
        Logger::warning('d');
        Logger::error('e');
        Logger::critical('f');
        Logger::alert('g');
        Logger::emergency('h');
        $this->assertEquals("debug:a\ninfo:b\nnotice:c\nwarning:d\nerror:e\ncritical:f\nalert:g\nemergency:h\n", file_get_contents($this->getFileName(3)));
        $this->cleanup();
    }
}

class TestException extends \Exception {

    public function __toString(): string {
        return $this->message;
    }

}
