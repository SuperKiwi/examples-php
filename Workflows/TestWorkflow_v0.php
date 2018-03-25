<?php

use Zenaton\Interfaces\WorkflowInterface;
use Zenaton\Traits\Zenatonable;
use Zenaton\Tasks\Wait;

class TestWorkflow_v0 implements WorkflowInterface
{
    use Zenatonable;

    // duration before
    const BEFORE = 30;

    // UTC timestamp of estimated time of arrival
    protected $eta;

    public function __construct($eta)
    {
        $this->eta = $eta;
    }

    public function handle()
    {
        (new Wait())->timestamp($this->eta - self::BEFORE)->execute();

        (new TellEtaTask($this->eta))->execute();
    }
}
