<?php
namespace Cloacker;

class User
{
    /**
     * @var
     */
    private $ipAddress;

    /**
     * @var
     */
    private $host;

    /**
     * @var
     */
    private $referer;

    /**
     * @var
     */
    private $userAgent;

    /**
     * User constructor.
     * @param $ipAddress
     * @param $host
     * @param $referer
     * @param $userAgent
     */
    function __construct($ipAddress, $host, $referer, $userAgent)
    {
        $this->ipAddress = $ipAddress;
        $this->host = $host;
        $this->referer = $referer;
        $this->userAgent = $userAgent;
    }

    /**
     * @return bool|Isp|null
     * Return Isp Object
     */
    public function getIsp()
    {
        try {
            return Isp::instanceIsp($this->ipAddress);
        }catch (Exception $e){
            return false;
        }
    }

    /**
     * @param $blockUserAgents
     * @return bool
     */
    public function isUserAgentAllowed($blockUserAgents){
        foreach ($blockUserAgents as $userAgent) {
            if (stristr($this->userAgent, $userAgent) !== FALSE) return false;
        }
        return true;
    }

    /**
     * @param $allowedRefer
     * @return bool
     */
    public function isRefferGoogle($allowedRefer){
       return (stristr($this->referer, $allowedRefer)) ?  true : false;
    }

    /**
     * @param $forbiddenHost
     * @return bool
     */
    public function isHostAllowed($forbiddenHost){
        return (stristr($this->host, $forbiddenHost)) ? false : true;
    }
}