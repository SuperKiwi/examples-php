<?php

use Zenaton\Interfaces\EventInterface;

class EtaUpdatedEvent implements EventInterface
{
    public $eta;

    public function __construct($eta)
    {
        $this->eta = $eta;
    }
}
