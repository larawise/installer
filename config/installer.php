<?php

return [
    /*
    |--------------------------------------------------------------------------
    | ℹ️ Installer (Status)
    |--------------------------------------------------------------------------
    |
    | You can easily complete the installation processes through the easy setup
    | wizard for the application and easily turn the system on and off, which
    | includes all the necessary checks and features related to the installer.
    |
    */
    'status'                                        => (bool) env('LARAWISE_INSTALLER', true),

    /*
    |--------------------------------------------------------------------------
    | ℹ️ Installer (Redirect)
    |--------------------------------------------------------------------------
    |
    | When the installation process is completed and you want to visit the 
    | installation wizard routes, you will be directed to the specified route by 
    | controlling it through intermediate layers. You can fully customize this route.
    |
    */
    'redirect'                                      => env('LARAWISE_INSTALLER_REDIRECT', 'web.home'),

    /*
    |--------------------------------------------------------------------------
    | ℹ️ Installer (Requirements)
    |--------------------------------------------------------------------------
    |
    | Easily configure the expandable options that need to be checked by the
    | application's setup wizard, such as system requirements, operating
    | system requirements, and directory requirements.
    |
    */
    'requirements'                                  => [
        /*
        |--------------------------------------------------------------------------
        | ℹ️ Requirements (Extension)
        |--------------------------------------------------------------------------
        |
        | PHP extensions required for the stable operation of system tasks,
        | scheduled tasks, routine operations, used libraries, and additional
        | dependency packages.
        |
        */
        'php' => [ ...array_filter(
            explode(',', env('LARAWISE_REQUIREMENTS_PHP', 'openssl,pdo,mbstring,tokenizer,JSON,cURL,gd,fileinfo,xml,ctype'))
        )],

        /*
        |--------------------------------------------------------------------------
        | ℹ️ Requirements (Apache)
        |--------------------------------------------------------------------------
        |
        | Apache Modules required for the stable operation of system tasks,
        | scheduled tasks, routine operations, used libraries, and additional
        | dependency packages.
        |
        */
        'apache' => [ ...array_filter(
            explode(',', env('LARAWISE_REQUIREMENTS_APACHE', 'mod_rewrite'))
        )],

        /*
        |--------------------------------------------------------------------------
        | ℹ️ Requirements (Permission)
        |--------------------------------------------------------------------------
        |
        | During the general operations of the application or for the storage or
        | temporary storage of certain necessary framework and application-related data,
        | the read and write permissions of the commonly used directories must be checked.
        | You can configure the directories to be checked from this area.
        |
        */
        'permissions' => [ ...array_filter(
            explode(',', env('LARAWISE_REQUIREMENTS_PERMISSIONS', '.env,storage/app,storage/framework,storage/logs'))
        )],
    ],
];
