<?php

namespace GetContent\CMS\Commands;

use Illuminate\Console\Command;

class GetContentCommand extends Command
{
    public $signature = 'getcontentcms';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
