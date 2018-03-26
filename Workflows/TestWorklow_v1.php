<?php

use Zenaton\Interfaces\WorkflowInterface;
use Zenaton\Traits\Zenatonable;
use Zenaton\Tasks\Wait;

class TestWorkflow_v1 implements WorkflowInterface
{
    use Zenatonable;

    // inform user # seconds before ETA
    const BEFORE = 3600;

    // workflow id
    protected $id;

    // estimated Time of Arrival
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

        // send message
        (new NotifyUserOfEtaTask($eta))->execute();
    }

    public function getId()
    {
        return $this->id;
    }
}
