<?php
/**
 * Author: Thomas Rieschl, trinet e.U.
 * Date: 19.02.14
 */

namespace Trinet\Facebook;

use Exception;

/**
 * Class Ips
 * command to fetch the current list of Facebook IPs; as suggested by Facebook
 *
 * @link    https://developers.facebook.com/docs/ApplicationSecurity#facebook_scraper
 * @package Trinet\Facebook
 */
class Ips
{
    /**
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
        $ipList = shell_exec(self::$shellCmd);
        if (empty($ipList)) {
            throw new Exception('no data returned');
        }
        return $ipList;
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

    /**
     * @return string
     */
    public static function getIpString()
    {
        $ipList = self::getList();

        return $ipList;
    }
} 