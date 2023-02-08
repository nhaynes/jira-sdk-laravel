<?php

declare(strict_types=1);

/*
 * This file is part of the Jira SDK Laravel project.
 *
 * (c) Nick Haynes (https://github.com/nhaynes)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [
    /*
    |--------------------------------------------------------------------------
    | JIRA SDK Configuration
    |--------------------------------------------------------------------------
    |
    | The configuration options here will be passed to the ClientFactory class
    | to create a Jira Client instance. See the documentation for more details.
    |
    */

    'sitename' => env('JIRA_SITENAME', 'your-domain'),
    'credentials' => [
        'username' => env('JIRA_USERNAME', ''),
        'token' => env('JIRA_TOKEN', ''),
    ],
];
