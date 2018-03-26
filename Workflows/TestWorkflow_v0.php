<?php

use Zenaton\Interfaces\WorkflowInterface;
use Zenaton\Traits\Zenatonable;
use Zenaton\Tasks\Wait;

class NotifyEtaWorkflow_v0 implements WorkflowInterface
{
    use Zenatonable;

    // inform user # seconds before ETA
    const BEFORE = 3600;

    // estimated Time of Arrival
    protected $eta;

    public function __construct($eta)
    {
        $this->eta = $eta;
    }

    public function handle()
    {
        (new Wait())->timestamp($this->eta - self::BEFORE)->execute();

        (new NotifyUserOfEtaTask($this->eta))->execute();
    }
}
