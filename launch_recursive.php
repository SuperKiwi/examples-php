<?php

require __DIR__ . '/autoload.php';

// if you need to kill an existing workflow, use:
// RecursiveWorkflow::whereId(0)->kill();

(new RecursiveWorkflow(0, 10))->dispatch();
