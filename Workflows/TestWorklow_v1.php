<?php

use Zenaton\Interfaces\WorkflowInterface;
use Zenaton\Traits\Zenatonable;
use Zenaton\Tasks\Wait;

class TestWorkflow_v1 implements WorkflowInterface
{
    use Zenatonable;

    // duration before
    const BEFORE = 30;

    // id
    protected $id;

    // UTC timestamp of estimated time of arrival
    protected $eta;

    public function __construct($id, $eta)
    {
        $this->id = $id;
        $this->eta = $eta;
    }

    public function handle()
    {
        $event = new EtaUpdatedEvent($this->eta);

        // wait until updated target time
        while ($event) {
            $eta = $event->eta;
            $event = (new Wait(EtaUpdatedEvent::class))->timestamp($eta - self::BEFORE)->execute();
        }

        // var_dump($eta);
        // send message
        (new TellEtaTask($eta))->execute();
    }

    public function getId()
    {
        return $this->id;
    }
}
