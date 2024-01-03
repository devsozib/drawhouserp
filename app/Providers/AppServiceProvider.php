<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Request;
use Session;
use View;
use Sentinel;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        date_default_timezone_set('Asia/Dhaka');
        Carbon::setWeekStartsAt(Carbon::SATURDAY);
        Carbon::setWeekEndsAt(Carbon::FRIDAY);
        Carbon::setWeekendDays([Carbon::FRIDAY]);
        Carbon::useMonthsOverflow(false);
        Carbon::useYearsOverflow(false);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view::composer('*',function($view){
            $view->with([
                'view' => Session::has('view') ? Request::session()->get('view') : null,
                'create' => Session::has('create') ? Request::session()->get('create') : null,
                'edit' => Session::has('edit') ? Request::session()->get('edit') : null,
                'delete' => Session::has('delete') ? Request::session()->get('delete') : null,
                'perms' => Session::has('perms') ? Request::session()->get('perms') : null,
                'hroptions' => Session::has('hroptions') ? Request::session()->get('hroptions') : null,
                'userid' => Sentinel::getUser() ? Sentinel::getUser()->id : null,
                'complists' => Sentinel::getUser() ? getCompanyList() : '',
                'inputDate' => date('Y-m-d', time()),
                'domain' => request()->getHost(),
                'imgpath' => url('/'),
                'filepath' => url('/'),
                'first' => 1,
                'last' => 999999,
            ]);
        });
    }
}
