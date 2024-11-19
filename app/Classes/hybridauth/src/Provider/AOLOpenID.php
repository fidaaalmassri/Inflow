<?php
/*!
* Hybridauth
* https://hybridauth.github.io | https://github.com/hybridauth/hybridauth
*  (c) 2017 Hybridauth authors | https://hybridauth.github.io/license.html
*/

namespace App\Classes\hybridauth\src\Provider;

use App\Classes\hybridauth\src\Adapter\OpenID;

/**
 * AOL OpenID provider adapter.
 */
class AOLOpenID extends OpenID
{
    /**
     * {@inheritdoc}
     */
    protected $openidIdentifier = 'http://openid.aol.com/';

    /**
     * {@inheritdoc}
     */
    protected $apiDocumentation = ''; // Not available
}
