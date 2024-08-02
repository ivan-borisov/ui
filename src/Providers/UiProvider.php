<?php

namespace Borisov\Ui\Providers;

use Borisov\Ui\Commands\ComponentCommand;
use Borisov\Ui\Commands\CrudCommand;
use Borisov\Ui\Commands\InstallCommand;
use Borisov\Ui\Commands\MigrateCommand;
use Borisov\Ui\Commands\ModelCommand;
use Borisov\Ui\Components\ModalComponent;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class UiProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ComponentCommand::class,
                CrudCommand::class,
                InstallCommand::class,
                MigrateCommand::class,
                ModelCommand::class,
            ]);
        }

        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'ui');

        $this->publishes([
            __DIR__ . '/../../config/ui.php' => config_path('ui.php'),
        ], ['ui', 'ui:config']);

        $this->publishes([
            __DIR__ . '/../../resources/stubs/crud' => resource_path('stubs/vendor/ui/crud'),
            __DIR__ . '/../../resources/stubs/make' => resource_path('stubs/vendor/ui/make'),
        ], ['ui', 'ui:stubs']);

        $this->publishes([
            __DIR__ . '/../../resources/views' => resource_path('views/vendor/ui'),
        ], ['ui', 'ui:views']);

        Livewire::component('modal', ModalComponent::class);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/ui.php', 'ui');
    }
}
