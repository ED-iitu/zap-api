<?php
/**
 * Created by PhpStorm.
 * User: eduard
 * Date: 10.05.2022
 * Time: 16:47
 */

namespace App\Jobs;

use App\Imports\ProductImport;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use App\Imports\TransactionsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ImportProducts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $uploadFile;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($uploadFile)
    {
        $this->uploadFile = $uploadFile;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Excel::import(new ProductImport, $this->uploadFile);
    }
}