<?php
namespace App\Tests;

use Laravel\Lumen\Testing\TestCase as BaseTestCase;
use Laravel\Lumen\Testing\DatabaseMigrations;

abstract class TestCase extends BaseTestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        //Seed the DB
        $this->artisan('db:seed');
    }

    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }
}
