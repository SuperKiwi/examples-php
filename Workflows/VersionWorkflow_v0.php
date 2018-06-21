<?php

use Zenaton\Tasks\Wait;
use Zenaton\Traits\Zenatonable;
use Zenaton\Interfaces\WorkflowInterface;

class VersionWorkflow_v0 implements WorkflowInterface
{
    use Zenatonable;

    public function handle()
    {
        (new TaskA())->execute();

        (new Wait)->seconds(100)->execute();

        (new TaskB())->execute();
    }
}
