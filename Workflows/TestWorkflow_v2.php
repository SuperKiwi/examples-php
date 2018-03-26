<?php

use Zenaton\Interfaces\WorkflowInterface;
use Zenaton\Traits\Zenatonable;
use Zenaton\Tasks\Wait;

class TestWorkflow_v2 implements WorkflowInterface
{
    use Zenatonable;

    // inform user # seconds before ETA
    const BEFORE = 3600;

    // update threshold : inform user if ETA changed more than # seconds
    const UPDATE = 1200;

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
        // wait until updated ETA - self::BEFORE
        $event = new EtaUpdatedEvent($this->eta);
        while ($event) {
            $eta = $event->eta;
            $event = (new Wait(EtaUpdatedEvent::class))->timestamp($eta - self::BEFORE)->execute();
        }

        // inform user of ETA
        (new NotifyUserOfEtaTask($eta))->execute();

        // inform user of significant change of ETA until arrival
        $event = new EtaUpdatedEvent($eta);
        while ($event) {
            $event = (new Wait(EtaUpdatedEvent::class))->timestamp($event->eta)->execute();
            if ($event && abs($eta - $event->eta) >= self::UPDATE) {
                // inform user of updated ETA
                $eta = $event->eta;
                (new NotifyUserOfUpdatedEtaTask($eta))->execute();
            }
        }
    }

    public function getId()
    {
        return $this->id;
    }
}
