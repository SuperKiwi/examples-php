<?php

use Zenaton\Workflows\Version;

class TestWorkflow extends Version
{
    public function versions()
    {
        return [
            TestWorkflow_v0::class,
            TestWorkflow_v1::class,
            TestWorkflow_v2::class,
        ];
    }
}
