# laravel-5-cascading-config

The cascading configuration system in Laravel 4 has been removed in L5 in favor of [PHP dotenv](https://github.com/vlucas/phpdotenv), the PHP version of the original Ruby [dotenv](https://github.com/bkeepers/dotenv). This simple gist is to re-enable it (and the whole shining flexibility).

## Setup
1. At the same level with your application's `config` directory, create another with the name `config.{APP_ENV}` with `{APP_ENV}` being the value set in `.env`.
1. In the new directory, place your corresponding environment config files and variables just like the good old days.
1. Overwrite `app/Providers/ConfigServiceProvider.php`, or at least its `register()` method, into your application.

## Notes
Actually in Laravel 4, the `config` directory structure looks like this:

```
├── app
│   ├── commands
│   ├── config
│   │   ├── api.php
│   │   ├── app.php
│   │   ├── auth.php
│   │   ├── ...
│   │   ├── local
│   │   │   ├── api.php
│   │   │   ├── app.php
│   │   │   ├── ...
```

In Laravel 5 though, such a structure will trigger a [fatal error](https://laracasts.com/discuss/channels/general-discussion/l5-date-default-timezone-error-on-clear-compiled/replies/30054). Basically L5 is not happy if you have two different files with the same name under its `config` directory. So I ended up with this workaround:

```
├── config
│   ├── api.php
│   ├── app.php
│   ├── auth.php
│   ├── ...
├── config.local
│   ├── app.php
│   └── auth.php
```

Not the best, but hey.

## Credits

The initial idea is from [Gnuffo1](http://stackoverflow.com/a/28050338/794641). I replaced array concatenation with `array_replace_recursive` to allow nested configuration, fixed said error, and set the repo up.
