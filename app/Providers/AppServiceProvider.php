<?php

namespace App\Providers;

use Illuminate\Support\Facades\View; 
use Illuminate\Support\ServiceProvider;
use App\Models\MachineType;
use App\Models\Province;
use App\Models\Construction;

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
                'machine_models',
                'machine_models.machine_brand',
                'machine_models.machines'
            )->orderBy('name')->get();

            $obras = Construction::with(
                'region',
                'region.province'
            )
            ->whereIn('construction_status_id', [1, 3])
            ->orderBy('name')->get();

            $view
            ->with('tipos_de_maquinas', $tipos_de_maquinas)
            ->with('obras', $obras);

        });
    }
}
