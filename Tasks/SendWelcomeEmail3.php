<?php

use Zenaton\Traits\Zenatonable;
use Zenaton\Interfaces\TaskInterface;

class SendWelcomeEmail3 implements TaskInterface
{
    use Zenatonable;

    protected $email;

    public function __construct(String $email)
    {
        $this->email = $email;
    }

    public function handle()
    {
        echo 'Sending welcome email 3 to :' . $this->email . PHP_EOL;
        sleep(10);
        echo '- email 3 sent' . PHP_EOL;
    }
}
