<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Modules\Inventory\App\Models\MedicineTransactionItem;
use App\Observers\StockMovementObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        MedicineTransactionItem::observe(StockMovementObserver::class);
    }
}
