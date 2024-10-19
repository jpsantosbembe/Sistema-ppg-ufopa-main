<?php

namespace App\Providers;

use App\Models\Upload;
use App\Observers\UploadObserver;
use App\Service\IndicadoresPessoa;
use App\Service\IndicadoresProducao;
use App\Service\IndicadoresProjetos;
use App\Service\IndicadoresTCC;
use App\Service\IndicadoresVinculos;
use App\Service\interfaces\IndicadoresPessoasInterface;
use App\Service\interfaces\IndicadoresProducaoInterface;
use App\Service\interfaces\IndicadoresProjetosInterface;
use App\Service\interfaces\IndicadoresTCCInterface;
use App\Service\interfaces\IndicadoresVinculosInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    private readonly array $services;
    public function __construct($app)
    {
        parent::__construct($app);
        $this->services = [
            IndicadoresTCCInterface::class => fn(Application $app) => new IndicadoresTCC(),
            IndicadoresProjetosInterface::class => fn(Application $app) => new IndicadoresProjetos(),
            IndicadoresVinculosInterface::class => fn(Application $app) => new IndicadoresVinculos(),
            IndicadoresProducaoInterface::class => fn(Application $app) => new IndicadoresProducao(),
            IndicadoresPessoasInterface::class => fn(Application $app) => new IndicadoresPessoa(),
        ];
    }


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
        Upload::observe(UploadObserver::class);
        foreach ($this->services as $contract => $implementation) {
            $this->app->bind($contract, $implementation);
        }
    }
}
