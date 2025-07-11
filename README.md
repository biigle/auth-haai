# BIIGLE Helmholtz AAI Login Module

[![Test status](https://github.com/biigle/auth-haai/workflows/Tests/badge.svg)](https://github.com/biigle/auth-haai/actions?query=workflow%3ATests)

This is a BIIGLE module that provides authentication via [Helholtz AAI](https://hifis.net/aai/).

Information on how to register your BIIGLE instance as a new service to Helmholtz AAI can be found [here](https://hifis.net/doc/helmholtz-aai/howto-services/).

## Installation

1. Run `composer require biigle/auth-haai`.
2. Run `php artisan vendor:publish --tag=public` to refresh the public assets of the modules. Do this for every update of this module.
3. Configure your Helmholtz AAI credentials in `config/services.php` like this:
   ```php
   'haai' => [
       'client_id' => env('HAAI_CLIENT_ID'),
       'client_secret' => env('HAAI_CLIENT_SECRET'),
       'redirect' => '/auth/haai/callback',
   ],
   ```
4. Run the database migrations with `php artisan migrate`.

## Developing

Take a look at the [development guide](https://github.com/biigle/core/blob/master/DEVELOPING.md) of the core repository to get started with the development setup.

Want to develop a new module? Head over to the [biigle/module](https://github.com/biigle/module) template repository.

## Contributions and bug reports

Contributions to BIIGLE are always welcome. Check out the [contribution guide](https://github.com/biigle/core/blob/master/CONTRIBUTING.md) to get started.
