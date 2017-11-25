<?php


namespace App;


class View
{
    protected $file;
    protected $values;
    protected $partialDir;

    function __construct($file)
    {
        $this->partialDir = Config::get('general')['partial-dir'];
        $this->file       = $file;
    }

    public function set($key, $value)
    {
        $this->values[$key] = $value;
    }

    public function get($key)
    {
        if ( ! array_key_exists($key, $this->values)) {
            throw new \Exception("{$key} is not set.");
        }

        return $this->values[$key];
    }

    public function output()
    {
        if ( ! file_exists($this->getFilaPath())) {
            throw new \Exception("Error loading template file {$this->file}.php.");
        }

        include $this->getFilaPath();
    }

    public function getFilaPath()
    {
        return $this->partialDir . '/' . $this->file . '.php';
    }

    public function setPartialDir($dir)
    {
        $this->partialDir = $dir;

        return $this;
    }
}