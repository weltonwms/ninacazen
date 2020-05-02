<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade; //add para facilitar componente blade


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
        //facilitador do blade
        Blade::component('components.breadcrumbs', 'breadcrumbs');
        Blade::component('components.toolbar', 'toolbar');
        Blade::component('components.datatables', 'datatables');
        Blade::component('components.formgroup', 'formgroup');
        \Form::component('bsText', 'components.form.text', ['name', 'value' => null, 'attributes' => []]);
        \Form::component('bsNumber', 'components.form.number', ['name', 'value' => null, 'attributes' => []]);
    }
}
