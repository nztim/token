<?php namespace NZTim\Token;

use Illuminate\Support\ServiceProvider;

class TokenServiceProvider extends ServiceProvider
{
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
