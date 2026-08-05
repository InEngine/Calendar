<?php

namespace InEngine\Calendar;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use InEngine\Calendar\Commands\CalendarCommand;

class CalendarServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('calendar')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_calendar_table')
            ->hasCommand(CalendarCommand::class);
    }
}
