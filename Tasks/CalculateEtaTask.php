<?php

use Zenaton\Interfaces\TaskInterface;
use Zenaton\Traits\Zenatonable;

class CalculateEtaTask implements TaskInterface
{
    use Zenatonable;

    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function handle()
    {
        return 10;
    }
}
