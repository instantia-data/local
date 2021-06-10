# Local
Deal with languages and countries
## Setup
### composer
/composer.json
```
"require": {
        "instantia/local": ">=1.0"
    },
"repositories": [
        {"type": "vcs", "url": "https://instantia-data@bitbucket.org/instantia-data/local.git"}
    ]
```
### Register service provider
/config/app.php
```
'providers' => [   
        /*
         * Instantia Package Service Providers...
         */
		 ###
        Local\LocalServiceProvider::class,
		###
    ],
```
before
```
App\Providers\RouteServiceProvider::class,
```
### Publish files
```
php artisan krud:publish local

```
### RouteServiceProvider
/app/Providers/RouteServiceProvider.php
```
    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
		###
        $this->mapLocalRoutes();
    }
    /**
     * Define the  routes for local package.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapLocalRoutes()
    {
        Route::prefix('')->namespace($this->namespace)
             ->group(base_path('routes/local.php'));
    }
```