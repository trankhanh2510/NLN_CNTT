<?php

namespace App\Providers;
use App\Models\Product;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        paginator::useBootstrap();
        view()->composer('*',function($view) {
            $min = Product::min('sp_gia');
            $max = Product::max('sp_gia') + 100000;
            $min_td = $min - 100000 ;
            $max_td = $max + 5000000;
            $view->with('min',$min)->with('max',$max)->with('min_td',$min_td)->with('max_td',$max_td);
        });
    }
}
