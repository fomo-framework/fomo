<?php

namespace App\Jobs\Dispatch;

use stdClass;
use Tower\Job\Contract;

class ExampleJob implements Contract
{
    public function handle(stdClass $data): void
    {
        //
    }
}