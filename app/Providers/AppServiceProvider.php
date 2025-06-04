<?php

namespace App\Providers;

use Illuminate\Support\Facades\View; 
use Illuminate\Support\ServiceProvider;
use App\Models\MachineType;
use App\Models\Province;

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
        //ACA
        View::composer('maquinas', function ($view) {
            $tipos = MachineType::orderBy('name')->get();
            $view->with('tipos', $tipos);
        });

        View::composer('obras', function ($view) {
            $provincias = Province::orderBy('name')->get();
            $view->with('provincias', $provincias);
        });

        View::composer('allocate', function ($view) {
            $tipos_de_maquinas = MachineType::with(
                'machine_model',
                'machine_model.machine_brand',
                'machine_model.machines'
                )->orderBy('name')->get();
            $view->with('tipos_de_maquinas', $tipos_de_maquinas);
        });
    }
}
