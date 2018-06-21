<?php

use Zenaton\Parallel\Parallel;
use Zenaton\Traits\Zenatonable;
use Zenaton\Interfaces\WorkflowInterface;

class VersionWorkflow_v1 implements WorkflowInterface
{
    use Zenatonable;

    public function handle()
    {
        (new Parallel(
            new TaskA(),
            new TaskB()
        ))->execute();
    }
}
