<?php 
/*
Plugin Name: Save Vapor Products
Plugin URI: https://shop.thevapekit.com/support
Description: This plugin will blackout your website on November 5th, 2015 (Guy Fawkes day) between 8am and 8pm local time to help teach vapers about supporting <a href="https://www.congress.gov/bill/114th-congress/house-bill/2058/text" target="_blank">H.R.2058</a>. Support for this would change the grandfather date for "deemed tobacco products" so that all of the vapor products currently on the market, can stay on the market.
Author: Aleks Blagojevich
Author URI: https://shop.thevapekit.com
Version: 1.1
*/

/*  Copyright 2007-2015 Takayuki Miyoshi (email: takayukister at gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

if (in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php')))
{
    return;
}
    
// Make sure we can redirect.
if(!function_exists('wp_redirect')) { 
    require(ABSPATH . WPINC . '/pluggable.php');
}

// Is it time to redirect the user?
$should_redirect_user = false;
// Current local time for user.
$current_time =  current_time('mysql', '0');
// Convert current_time to PHP format.
$system_time = strtotime($current_time);
// Convert the system_time for comparison.
$time_to_check = date('H:i', $system_time);
// Convert the date for comparison.
$date_to_check = date('m/d/Y', $system_time);
// On what day should we redirect users?
$redirect_date = '11/05/2015';
// What time do we start redirecting users?
$redirect_time_start = '08:00'; // 8:00AM
// What time do we stop redirecting users?
$redirect_time_end = '20:00'; // 8:00PM

// IF the redirect date matches the system date...
// AND if the system time is greater than or equal to the redirect start time...
// AND if the system time is less than the redirect end time...
if ($redirect_date == $date_to_check && ($time_to_check >= $redirect_time_start && $time_to_check < $redirect_time_end))
{
    // THEN we should redirect the user.
    $should_redirect_user = true;
}

// IF the user is not an admin...
// AND should be redirected...
if (strpos($_SERVER['REQUEST_URI'], '/wp-admin/') !== 0 && !current_user_can('activate_plugins') && $should_redirect_user)
{
    // THEN temporarily redirect the user.
    wp_redirect( plugins_url('save-vapor-products/casaa.php'), 302);
    exit();
}