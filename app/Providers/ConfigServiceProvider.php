<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Symfony\Component\Finder\Finder;
use Illuminate\Foundation\AliasLoader;

class ConfigServiceProvider extends ServiceProvider {

    /**
     * Overwrite any vendor / package configuration.
     *
     * This service provider is intended to provide a convenient location for you
     * to overwrite any "vendor" or package configuration that you may want to
     * modify before the application handles the incoming request / command.
     *
     * @return void
     */
    public function register()
    {
        $envConfigPath = config_path() . '/../config.' . env('APP_ENV');
        $config = app('config');

        foreach (Finder::create()->files()->name('*.php')->in($envConfigPath) as $file)
        {
            // Run through all PHP files in the current environment's config directory.
            // With each file, check if there's a current config key with the name.
            // If there's not, initialize it as an empty array.
            // Then, use array_replace_recursive() to merge the environment config values 
            // into the base values.
            
            $key_name = basename($file->getRealPath(), '.php');

            $old_values = $config->get($key_name) ?: [];
            $new_values = require $file->getRealPath();

            // Replace any matching values in the old config with the new ones.
            $config->set($key_name, array_replace_recursive($old_values, $new_values));

        }

        // Load new aliases
        $loader = AliasLoader::getInstance();
        foreach($config->get('app.aliases') as $alias => $class) {
            $loader->alias($alias, $class);
        }
    }

}

