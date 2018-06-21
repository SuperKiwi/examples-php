<?php

require __DIR__ . '/autoload.php';

$workflow = new WelcomeWorkflow('user@example.com');
$workflow->dispatch();
