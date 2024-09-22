<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use simplehtmldom\HtmlWeb;
use Symfony\Component\HttpClient\HttpClient;
class CrawlData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawldata:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        echo "abc";
    }
}
