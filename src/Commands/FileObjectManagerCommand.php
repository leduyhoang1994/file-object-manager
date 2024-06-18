<?php

namespace RedFlag\FileObjectManager\Commands;

use Illuminate\Console\Command;

class FileObjectManagerCommand extends Command
{
    public $signature = 'file-object-manager';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
