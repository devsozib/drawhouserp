<?php

namespace App\Helpers;

use Request;
use App\Models\LogActivity as LogActivityModel;
use Sentinel;
use DB;
use Carbon\Carbon;

class LogActivity
{
    public static function addToLog($subject, $olddata = [], $newdata = [])
    {
        //if(!DeveloperCheck(Sentinel::getUser()->id)){
        $log = [];
        $log['subject'] = $subject;
        $log['url'] = Request::fullUrl();
        $log['method'] = Request::method();
        $log['ip'] = Request::ip();
        $log['localip'] = Request::session()->get('LocalIP');
        $log['agent'] = Request::header('user-agent');
        $log['olddata'] = implode(", ", $olddata);
        $log['newdata'] = implode(", ", $newdata);
        $log['user_id'] = Sentinel::getUser()->id;
        LogActivityModel::create($log);
        //}
    }
    public static function addToLog2($subject)
    {
        //if(!DeveloperCheck(Sentinel::getUser()->id)){
        $time = Carbon::now();
        $subject = $subject;
        $url = Request::fullUrl();
        $method = Request::method();
        $ip = Request::ip();
        $localip = Request::session()->get('LocalIP');
        $agent = Request::header('user-agent');
        $user_id = Sentinel::getUser()->id;
        DB::connection('mysql2')->table('log_activities')->insert(array('subject' => $subject, 'url' => $url, 'method' => $method, 'ip' => $ip, 'localip' => $localip, 'agent' => $agent, 'user_id' => 0, 'user_id2' => $user_id, 'created_at' => $time,));
        //}
    }
    public static function addToLog3($subject)
    {
        //if(!DeveloperCheck(Sentinel::getUser()->id)){
        $time = Carbon::now();
        $subject = $subject;
        $url = Request::fullUrl();
        $method = Request::method();
        $ip = Request::ip();
        $localip = Request::session()->get('LocalIP');
        $agent = Request::header('user-agent');
        $user_id = Sentinel::getUser()->id;
        DB::connection('mysql3')->table('log_activities')->insert(array('subject' => $subject, 'url' => $url, 'method' => $method, 'ip' => $ip, 'localip' => $localip, 'agent' => $agent, 'user_id' => 0, 'user_id2' => $user_id, 'created_at' => $time,));
        //}
    }
    public static function logActivityLists()
    {
        return LogActivityModel::latest()->get();
    }
}
