<?php

namespace Savants\PisopayWrapper;

use Illuminate\Support\ServiceProvider;

class PisopayWrapperServiceProvider extends ServiceProvider
{


  public function boot()
  {
    $this->publishes([
      __DIR__ . '/../config/pisopay.php' => config_path('pisopay.php')
    ]);
  }

  public function register()
  {
    $this->app->singleton(PisopayWrapper::class, function(){
      return new PisopayWrapper();
    });
  }
}
