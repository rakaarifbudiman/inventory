<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Spatie\SimpleExcel\SimpleExcelReader;

class UploadProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:upload';

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
        $pathToExcel = storage_path('/app/public/products.xlsx');
        $rows = SimpleExcelReader::create($pathToExcel)->getRows();

        $rows->each(function(array $rowProperties) {
            DB::table('db_inventori.products')
            ->updateOrInsert(
                ['id' => $rowProperties['id'],
                    'nama_produk' => $rowProperties['nama_produk']],
                $rowProperties
            );
         });
        return Command::SUCCESS;
    }
}
