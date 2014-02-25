<?php
/**
 * Author: Thomas Rieschl, trinet e.U.
 */

namespace Trinet\Facebook;

use Exception;

/**
 * Class Ips
 * Class to fetch the current list of Facebook IPs; as suggested by Facebook
 *
 * @link    https://developers.facebook.com/docs/ApplicationSecurity#facebook_scraper
 * @package Trinet\Facebook
 */
class Ips
{
    /**
     * command to query the Facebook AS
     *
     * @var string
     */
    private static $shellCmd = "whois -h whois.radb.net -- '-i origin AS32934' | grep ^route";

    /**
     * @return array
     */
    public static function getIpArray()
    {
        $ipList = self::getList();
        $ipList = explode("\n", $ipList);

        return $ipList;
    }

    /**
     * @return string
     */
    public static function getIpString()
    {
        $ipList = self::getList();

        return $ipList;
    }

    /**
     * @return string
     */
    private static function getList()
    {
        $ipList = self::fetchList();
        $ipList = self::cleanList($ipList);
        return $ipList;
    }

    /**
     * @return string
     * @throws Exception
     */
    private static function fetchList()
    {
        // check requirements
        self::checkShellExec();
        self::checkWhois();

        $ipList = shell_exec(self::$shellCmd);
        if (empty($ipList)) {
            throw new Exception('no data returned');
        }
        return $ipList;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    private static function checkShellExec()
    {
        if (!function_exists('shell_exec')) {
            throw new Exception('The function "shell_exec" must be enabled!');
        }

        return true;
    }

    /**
     * Checks if the command "whois" is available
     *
     * @return bool
     * @throws Exception
     */
    private static function checkWhois()
    {
        self::checkShellExec();

        $cmd = (strtolower(PHP_OS) == 'winnt') ? 'where' : 'which';
        $exists = shell_exec("$cmd whois");

        if (empty($exists)) {
            throw new Exception('The program "whois" must be installed!');
        }

        return true;
    }

    /**
     * @param string $ipList
     * @return string
     */
    private static function cleanList($ipList)
    {
        $ipList = str_replace("\r", '', $ipList);
        $ipList = str_replace("route:", '', $ipList);
        $ipList = str_replace("route6:", '', $ipList);
        $ipList = str_replace(" ", '', $ipList);
        $ipList = trim($ipList);

        return $ipList;
    }

}