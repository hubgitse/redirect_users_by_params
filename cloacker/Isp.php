<?php
namespace Cloacker;


class Isp
{
    /**
     * @var null
     * Instance of Isp Object (Singleton)
     */
    static private $instanceIsp = null;

    /**
     * @var
     * Country of user
     */
    private $country;

    /**
     * @var
     * User's internet provider
     */
    private $internetProviderName;

    /**
     * URL of service to check Country, Internet Provider
     */
    const URL = 'https://ipinfo.io/';

    /**
     * Prefix for full URL of service
     */
    const PREFIX = 'token';

    /**
     * Token for full URL of service
     */
    const TOKEN = 'some_token';

    /**
    * Isp constructor.
    * @param $country
    * @param $internetProviderName
    */
    private function __construct($country, $internetProviderName)
    {
        $this->country = $country;
        $this->internetProviderName = $internetProviderName;
    }

    /**
     * @return string
     * Return country of user
     */
    public function getCountry()
    {
        return strtolower($this->country);
    }

    /**
     * @return mixed
     * Return Internet Provider Name of user
     */
    public function getInternetProvidername()
    {
        return $this->internetProviderName;
    }

    /**
     * @param $myCountry
     * @return bool
     * Check if country of user matches to targeted country
     */
    public function isSameCountry($myCountry)
    {
        return $this->getCountry() === $myCountry;
    }

    /**
     * @param $forbiddenInternetProvider
     * @return bool
     * Check if Internet Provider of user matches to targeted internet provider
     */
    public function isInternetProviderAllowed($forbiddenInternetProvider)
    {
        return (stristr($this->getInternetProvidername(), $forbiddenInternetProvider)) ? false : true;
    }

    /**
     * @param $ip
     * @return Isp|null
     */
    public static function instanceISP($ip)
    {
        if (self::$instanceIsp === null){
            $requestUrl = self::URL.$ip.'/json?'.self::PREFIX.'='.self::TOKEN;

            $curl = curl_init($requestUrl );

            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, FALSE);

            $responseJson = curl_exec($curl);
            $curl_errorno = curl_errno($curl);

            $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            curl_close($curl);

            if ($curl_errorno === 0 && $status === 200) {
                $response = json_decode($responseJson, true);
                return self::$instanceIsp = new self($response['country'], $response['org']);
            }else{
                throw new Exception("An error occured or response status not 200");
            }
        }else{
            return self::$instanceIsp;
        }
    }
}