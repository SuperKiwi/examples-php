<?php

require __DIR__.'/autoload.php';

(new TestWorkflow('myId', time() + 40))->dispatch();

sleep(5);

TestWorkflow::whereId('myId')->send(new EtaUpdatedEvent(time() + 30));
