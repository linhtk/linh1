<?php
/**
 * Created by PhpStorm.
 * User: PhucNN
 * Date: 26/10/2016
 * Time: 09:50
 */
namespace App\Helpers;
use Monolog\Formatter\LineFormatter;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class CBMLog{

    public static function writeLog($message, $uniqueTime, $structure, $flagLevel = Logger::INFO){
        $file = date('d')."_{$structure}_info.log";
        $level = Logger::INFO;

        if($flagLevel == Logger::ERROR){
            $file = date('d')."_{$structure}_error.log";
            $level = Logger::ERROR;
        }

        $structure = storage_path()."/logs/{$structure}/".date('Y').'/'.date('m').'/';

        // the default date format is "Y-m-d H:i:s"
        $dateFormat = "Y-m-d H:i:s";
        // the default output format is "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n"
        $output = "%datetime% > %level_name% > %message% %context% %extra%\n";
        // finally, create a formatter
        $formatter = new LineFormatter($output, $dateFormat);

        // Create a handler
        $stream = new StreamHandler($structure.$file, $level);
        $stream->setFormatter($formatter);
        // bind it to a logger object
        $securityLogger = new Logger($structure);
        $securityLogger->pushHandler($stream);

        // add records to the log
        if($level == Logger::ERROR) {
            $securityLogger->error($uniqueTime.' >> '.$message);
        }else{
            $securityLogger->info($uniqueTime.' >> '.$message);
        }
    }
}