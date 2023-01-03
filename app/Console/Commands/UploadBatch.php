<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Spatie\SimpleExcel\SimpleExcelReader;

class UploadBatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:batch-upload';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $pathToExcel = storage_path('/app/public/batches.xlsx');
        $rows = SimpleExcelReader::create($pathToExcel)->getRows();

        $rows->each(function(array $rowProperties) {
            DB::table('db_inventori.batches')
            ->updateOrInsert(
                ['id' => $rowProperties['id'],
                    'no_batch' => $rowProperties['no_batch']],
                $rowProperties
            );
         });
        return Command::SUCCESS;
    }
}
