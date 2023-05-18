<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;
use Illuminate\Support\Facades\File;
use App\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class FeedXml extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'feedXml {file_name?}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Save the data of a given XML file to a database of your choice';

    protected $file_name;

    protected $files;

    // public function __construct(Filesystem $file)
    // {
    //     parent::_construct();
    //     $this->files = $file;
    // }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $db = 'sqlite';
       
        $this->create_log_file();
        
        $this->file_name = $this->argument('file_name');

        if(! $this->argument('file_name')){
            $this->write_on_log("File don't exist.");
        }

        $xmlArray = $this->proces_file($this->file_name);

        $this->feed_db($xmlArray, $db);

        $this->notify($this->file_name . ' processed!', 'You can find it on your database.');


    }

    public function create_log_file(){
        if(!Storage::disk('local')->has('log_errors.log')){
            Storage::put('log_errors.log','');
        }
    }

    public function proces_file($file){

        $xmlString = file_get_contents(storage_path() . "/". $file);
        $xmlObject = simplexml_load_string($xmlString);
                
        $json = json_encode($xmlObject);
        $xmlArray = json_decode($json, true); 

        return $xmlArray;

    }

    public function feed_db($xmlArray, $db){
        
        $item = $xmlArray["item"];

        foreach($item as $product){

            try{
                DB::connection($db)->table('product')->insert(array_filter($product));
            }catch(\Illuminate\Database\QueryException $ex){
                $this->writeOnLog($ex);
                $this->notify($this->file_name . ' Oops!', 'This data is already uploaded!');
                exit;
            }
        }
        
    }

    public function write_on_log($error){
        $channel = Log::build([
            'driver' => 'single',
            'path' => storage_path('app/log_errors.log'),
          ]);               
        Log::stack(['slack', $channel])->error($error);
    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
