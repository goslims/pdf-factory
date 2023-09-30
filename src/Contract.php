<?php
namespace SLiMS\Pdf;

use Closure;

abstract class Contract
{
    protected string $name = '';
    protected ?object $pdf = null;

    public function __construct()
    {
        if (empty($this->name)) {
            $this->name = '123';
        }
        $this->setPdf();
    }

    abstract protected function setPdf():void;
    abstract protected function setContent():void;
    abstract protected function download(string $filname):void;
    abstract protected function stream(?string $filname = null, ?array $options = null):void;
    abstract protected function saveToFile(string $filepath, ?Closure $callback = null):void;
}