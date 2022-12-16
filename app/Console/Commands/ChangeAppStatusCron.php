<?php

namespace App\Console\Commands;
use App\Models\Device;
use App\Models\History;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ChangeAppStatusCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'changestatus:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manage device status';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
    
    	$devices = Device::where('status',1)->get();
    	$notupdated_history_ids = [];

 

    	foreach($devices as $device){
    		$updated_at = $device->updated_at;
			$now = Carbon::now();
			
			$histories = History::where('device_id',$device->id)->where('user_id',$device->user_id)->whereNull('logout_time')->get();
    	  
    		if($updated_at->diffInMinutes($now) > 1){
    			$device->status = 0;
    			$device->save();
    			
    			
    			foreach($histories as $history){
    				$history->logout_time = Carbon::now();
    				$history->save();
    				$updated_history_ids[] = $history->id;
    			}
    		}else{
    			$notupdated_history_ids = array_merge($notupdated_history_ids, $histories->pluck('id')->toArray());
    		}
    		
    		
    	}
    	$histories = History::whereNotIn('id',$notupdated_history_ids)->whereNull('logout_time')->update(['logout_time'=>time()]);
        
        return 0;
    }
}
