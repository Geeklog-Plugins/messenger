<?php

// +-----------------------------------------------------------------------------+
// | glMessenger Plugin 1.0 for Geeklog- The Ultimate OSS Portal                 |
// | Date: November 15, 2003                                                     |
// +-----------------------------------------------------------------------------+
// | config.php - Main glMessenger config file                                   |
// +-----------------------------------------------------------------------------+
// | Copyright (C) 2003 by the following authors:                                |
// |                                                                             |
// | glMessenger Plugin Author:                                                  |
// | Blaine Lang   -  blaine@portalparts.com                                     |
// +-----------------------------------------------------------------------------+
// | Geeklog Common Code                                                         |
// | Copyright (C) 2000-2003 by the following authors:                           |
// |                                                                             |
// | Authors: Tony Bibbs        - tony@tonybibbs.com                             |
// |          Mark Limburg      - mlimburg@users.sourceforge.net                 |
// |          Jason Whittenburg - jwhitten@securitygeeks.com                     |
// |          Dirk Haun         - dirk@haun-online.de                            |
// +-----------------------------------------------------------------------------+
// |                                                                             |
// | This program is licensed under the terms of the GNU General Public License  |
// | as published by the Free Software Foundation; either version 2              |
// | of the License, or (at your option) any later version.                      |
// |                                                                             |
// | This program is OpenSource but not FREE. Unauthorized distribution is       |
// | illegal. Anyone caught doing so will be banished from the geeklog community |
// | You may not remove the copyright or redistribute this script in any form.   |
// |                                                                             |
// | This program is distributed in the hope that it will be useful,             |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of              |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                        |
// | See the GNU General Public License for more details.                        |
// |                                                                             |
// | You should have received a copy of the GNU General Public License           |
// | along with this program; if not, write to the Free Software Foundation,     |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.             |
// |                                                                             |
// +-----------------------------------------------------------------------------+

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file cannot be used on its own!');
}

/**
 * Plugin autoinstall function
 *
 * @param  string  $pi_name  Plugin name
 * @return   array               Plugin information
 */
function plugin_autoinstall_messenger($pi_name)
{
    global $CONF_MSG;

    require_once __DIR__ . '/config.php';
    $piName = 'messenger';

    return [
        'info'     => [
            'pi_name'         => $piName,
            'pi_display_name' => ucfirst($piName),
            'pi_version'      => $CONF_MSG['pi_version'],
            'pi_gl_version'   => $CONF_MSG['gl_version'],
            'pi_homepage'     => $CONF_MSG['pi_url'],
        ],
        'groups'   => $CONF_MSG['GROUPS'],
        'features' => $CONF_MSG['FEATURES'],
        'mappings' => $CONF_MSG['MAPPINGS'],
        'tables'   => $CONF_MSG['TABLES'],
    ];
}

/**
 * Load plugin configuration from database
 *
 * @param  string  $pi_name  Plugin name
 * @return   boolean             true on success, otherwise false
 * @see      plugin_initconfig_messenger
 */
function plugin_load_configuration_messenger($pi_name)
{
    require_once __DIR__ . '/install_defaults.php';

    return plugin_initconfig_messenger();
}

/**
 * Checks if the plugin is compatible with this Geeklog version
 *
 * @param  string  $pi_name  Plugin name
 * @return   boolean             true: plugin compatible; false: not compatible
 */
function plugin_compatible_with_this_version_messenger($pi_name)
{
    global $_DB_dbms;

    // checks if we support the DBMS the site is running on
    $dbFile = __DIR__ . '/sql/' . $_DB_dbms . '_install.php';
    clearstatcache();

    if (!file_exists($dbFile)) {
        return false;
    }

    // adds checks here
    return is_callable('COM_newTemplate') && is_callable('CTL_plugin_templatePath');
}
