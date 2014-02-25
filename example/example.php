<?php
/**
 * Author: Thomas Rieschl, trinet e.U.
 * Date: 19.02.14
 */

namespace Trinet\Facebook;

require_once('../src/Trinet/Facebook/Ips.php');

echo '<pre>';
echo Ips::getIpString();
echo '<br><br><br>';
print_r(Ips::getIpArray());
echo '</pre>';