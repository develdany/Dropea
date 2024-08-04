<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ApiService;

class GetAndStoreEntities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:get-store-entities';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get entities from API and store in BD';

    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        parent::__construct();
        $this->apiService = $apiService;
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->apiService->getAndStoreEntities();
        $this->info('Entities have been stored successfully.');
    }
}
