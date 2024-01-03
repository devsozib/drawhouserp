<?php

namespace App\Console\Commands;

use DB;
use Log;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\HRIS\Tools\ReadPunchRecords;

class PunchSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'punch:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Punch Synchronization';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $start_date = Carbon::now()->subDays(7)->startOfMonth()->format('Y-m-d');
        $end_date = Carbon::now()->endOfMonth()->format('Y-m-d');
        //$punchs = DB::connection('mysql2')->table('timesheet')->whereBetween('date',[$start_date,$end_date])->where('sync','N')->get();
        $punchs = [0,1];
        if (sizeOf($punchs) >= 1) {
            /* $lastid = ReadPunchRecords::orderBy('id', 'DESC')->pluck('id')->first() + 1;
            foreach ($punchs as $data) {
                $employee = $data->user_id;
                $dttime = $data->date.' '.$data->time;
                $datetime = $dttime ? date("Y-m-d H:i:s", strtotime(roundMinute($dttime))) : null;
                $pstate = ''; $ptype = 1; $extid = $data->id; $mcsl = $data->sn;
                if ($employee) {
                    $createdat = Carbon::now();
                    DB::insert("INSERT INTO payroll_tools_readpunchrecords (id, EmployeeID, AttnDate, PState, PunchType, created_at,extid,mcsl) VALUES ('$lastid','$employee','$datetime','$pstate','$ptype','$createdat','$extid','$mcsl')");
                    DB::connection('mysql2')->table('timesheet')->where('id',$extid)->update(['sync'=>'Y']);
                    $lastid++;
                }
            }
            \LogActivity::addToLog('Punch synchronization successful ' . $start_date . ' & ' . $end_date); */

            $time = Carbon::now()->format('Y-m-d H:i:s');
            Log::info('Punch synchronization successful with time '.$time);
            $this->info('Punch synchronization successful with time '.$time);
        } else {
            $time = Carbon::now()->format('Y-m-d H:i:s');
            Log::info('Punch synchronization failed with time '.$time);
            $this->info('Punch synchronization failed with time '.$time);
        }

        //return Command::SUCCESS;
    }
}
