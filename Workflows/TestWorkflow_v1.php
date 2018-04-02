<?php

use Zenaton\Interfaces\WorkflowInterface;
use Zenaton\Traits\Zenatonable;
use Zenaton\Tasks\Wait;

class TestWorkflow_v1 implements WorkflowInterface
{
    use Zenatonable;
    // inform user # seconds before ETA
    const BEFORE = 3600;
    // precision target
    const PRECISION = 120;
    // trip id
    protected $tripId;
    // user to notify
    protected $user;

    public function __construct($tripId, $user)
    {
        $this->tripId = $tripId;
        $this->user = $user;
    }

    public function handle()
    {
        // calulate current ETA
        [$duration, $eta] = $this->getTimeToArrival();

        // retry calculation until $duration is close enough to 1h
        while ($duration > self::BEFORE + self::PRECISION) {
            $wait = ($duration - self::BEFORE) / 2;
            (new Wait())->seconds($wait)->execute();

            [$duration, $eta] = $this->getTimeToArrival();
        }

        // send message
        (new InformUserOfEtaTask($this->user, $eta))->execute();
    }

    protected function getTimeToArrival()
    {
        return (new CalculateTimeToArrivalTask($this->tripId))->execute();
    }
}
