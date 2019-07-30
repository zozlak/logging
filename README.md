[![Latest Stable Version](https://poser.pugx.org/zozlak/logging/v/stable)](https://packagist.org/packages/zozlak/logging)
[![Build Status](https://travis-ci.org/zozlak/logging.svg?branch=master)](https://travis-ci.org/zozlak/logging)
[![Coverage Status](https://coveralls.io/repos/github/zozlak/logging/badge.svg?branch=master)](https://coveralls.io/github/zozlak/logging?branch=master)
[![License](https://poser.pugx.org/zozlak/logging/license)](https://packagist.org/packages/zozlak/logging)

# Logging

A simple file-based PSR-3 logging library.

* provides basic severity level filtering
* can be used as a singleton
    * also with multiple logs
* able to serialize arrays and objects (first tries with `__toString()`, then `json_encode()`)
* supports placeholders (see PSR-3)

## Installation

`composer require zozlak/logging`

## Usage

```php
// simplest possible logging
$log = new \zozlak\logging\Log('log_file');
$log->info('message');

// message formatting and filtering
$log = new \zozlak\logging\Log('log_file', \Psr\Log\LogLevel::INFO, "{LEVEL}:{TIMESTAMP}\t{MESSAGE}");
$log->info('message');
$log->debug('skipped message');

// singleton example
$log = new \zozlak\logging\Log('log_file');
\zozlak\logging\Logger::addLog($log);
\zozlak\logging\Logger::info('message');

// multiple logs
$logAll = new \zozlak\logging\Log('log_all');
$logErrors = new \zozlak\logging\Log('log_errors', \Psr\Log\LogLevel::ERROR);
\zozlak\logging\Logger::addLog($logAll, 'all');
\zozlak\logging\Logger::addLog($logErrors, 'error');

\zozlak\logging\Logger::info('message1', [], 'all');
\zozlak\logging\Logger::error('message2', [], 'error');
\zozlak\logging\Logger::error('message3'); // written to the 'error' log

\zozlak\logging\Logger::setDefaultLog('all');
\zozlak\logging\Logger::error('message4'); // written to the 'all' log
``
