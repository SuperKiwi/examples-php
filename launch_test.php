<?php

require __DIR__.'/autoload.php';

$time = time();
(new TestWorkflow('myId', $time + 40))->dispatch();

sleep(5);

// TestWorkflow::whereId('myId')->kill();

TestWorkflow::whereId('myId')->send(new EtaUpdatedEvent($time + 50));

sleep(20);

TestWorkflow::whereId('myId')->send(new EtaUpdatedEvent($time + 55));

sleep(5);

TestWorkflow::whereId('myId')->send(new EtaUpdatedEvent($time + 60));

sleep(5);

TestWorkflow::whereId('myId')->send(new EtaUpdatedEvent($time + 65));

sleep(5);

TestWorkflow::whereId('myId')->send(new EtaUpdatedEvent($time + 70));

sleep(5);

TestWorkflow::whereId('myId')->send(new EtaUpdatedEvent($time + 75));

sleep(5);

TestWorkflow::whereId('myId')->send(new EtaUpdatedEvent($time + 90));
