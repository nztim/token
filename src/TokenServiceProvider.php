<?php namespace NZTim\Token;

use App;
use Illuminate\Cache\Repository;
use Illuminate\Mail\Mailer;
use Illuminate\Support\ServiceProvider;

class TokenServiceProvider extends ServiceProvider
{
    protected $defer = false;

    protected $commands = [
        AddMigrationCommand::class,
    ];

    public function register()
    {
        $this->commands($this->commands);
    }

    public function boot()
    {
        //
    }
}
