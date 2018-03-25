<?php

use Zenaton\Interfaces\WorkflowInterface;
use Zenaton\Traits\Zenatonable;
use Zenaton\Tasks\Wait;

class TestWorkflow_v2 implements WorkflowInterface
{
    use Zenatonable;

    // duration before
    const BEFORE = 30;

    // duration before
    const PRECISION = 30;

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
        // fake event
        $event = new EtaUpdatedEvent($this->eta);

        // wait until updated target time
        while ($event) {
            $event = (new Wait(EtaUpdatedEvent::class))->timestamp($event->eta - self::BEFORE)->execute();
        }

        // send message
        (new TellEtaTask($this->eta))->execute();

        // continue to wait to inform user of significant changes
        $event = new EtaUpdatedEvent($this->eta);
        while ($event) {
            $event = (new Wait(EtaUpdatedEvent::class))->timestamp($event->eta)->execute();
            if ($event && abs($this->eta - $event->eta) >= self::PRECISION) {
                $this->eta = $event->eta;
                (new TellEtaTask($this->eta))->execute();
            }
        }
    }

    public function getId()
    {
        return $this->id;
    }
}
