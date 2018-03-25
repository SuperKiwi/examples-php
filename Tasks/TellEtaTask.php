<?php

use Zenaton\Interfaces\TaskInterface;
use Zenaton\Traits\Zenatonable;

class TellEtaTask implements TaskInterface
{
    use Zenatonable;

    protected $eta;
    protected $changed;

    public function __construc($eta, $changed = false)
    {
        var_dump($eta);
        $this->eta = $eta;
        $this->changed = $changed;
    }

    public function handle()
    {
        echo $this->changed ? 'Updated Time of Arrival: '.$this->eta : 'Estimated Time of Arrival: '.$this->eta;
    }
}
