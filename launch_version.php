<?php

require __DIR__.'/autoload.php';

(new Version\ParallelWorkflow(['name' => 'shirt']))->dispatch();
