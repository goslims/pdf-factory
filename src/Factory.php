<?php
namespace SLiMS\Pdf;

final class Factory {
    private static ?Factory $instance = null;
    private array $providers = [];
    private ?object $pdf = null;
    private array $providerCommands = [
        'setContent','download', 
        'stream', 'saveToFile'
    ];

    private function __construct() {}

    public static function getInstance(): Factory
    {
        if (self::$instance === null) self::$instance = new Factory;
        return self::$instance;
    }

    public static function registerProvider(string $name, string $providerClass):void
    {
        self::getInstance()->providers[$name] = $providerClass;
    }

    public static function use(string $providerName, array $options = [])
    {
        $class = self::getInstance()->providers[$providerName]??null;
        if ($class === null) throw new \Exception("$providerName isn't registered!");
        $providerInstance = new $class(...$options);
        
        if (!$providerInstance instanceof Contract) throw new \Exception("$class is not use PDF contract!");

        self::getInstance()->pdf = $providerInstance;
    }

    public static function __callStatic(string $method, array $arguments)
    {
        if (in_array($method, self::getInstance()->providerCommands));
        {
            return call_user_func_array([self::getInstance()->pdf, $method], $arguments);
        }
    }
}