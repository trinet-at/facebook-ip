<?php
/**
 * Author: Thomas Rieschl, trinet e.U.
 */

use Trinet\Facebook\Ips;

require_once('../src/Trinet/Facebook/Ips.php');

header('Content-type: text/plain; charset=utf-8');

echo "As String:\n\n";
echo Ips::getIpString();

echo "\n\nAs ";
print_r(Ips::getIpArray());
