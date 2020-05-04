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

global $_DB_table_prefix, $_TABLES, $_CONF, $CONF_MSG;

// Add to $_TABLES array the tables your plugin uses
$_TABLES['messenger_msg']      = $_DB_table_prefix . 'messenger_msg';
$_TABLES['messenger_dist']     = $_DB_table_prefix . 'messenger_dist';
$_TABLES['messenger_userinfo'] = $_DB_table_prefix . 'messenger_userinfo';
$_TABLES['messenger_buddies']  = $_DB_table_prefix . 'messenger_buddies';
$_TABLES['smilies']            = $_DB_table_prefix . 'smilies';

// Plugin info
$CONF_MSG = array(
    'pi_version' => '1.9.4',                                        // Plugin Version
    'gl_version' => '2.2.1',                                        // GL Version plugin for
    'pi_url'     => 'https://github.com/Geeklog-Plugins/messenger', // Plugin Homepage
    'GROUPS'     => array(
        'Messenger Admin' => 'Users in this group can administer the Messenger plugin',
    ),
    'FEATURES'   => array(
        'messenger.edit'            => 'Messenger Admin Rights',
        'messenger.user'            => 'Messenger User',
        'messenger.broadcast'       => 'Ability to send Broadcast Messages',
        'smilie.edit'               => 'Ability to admin Smilies',
        'config.messenger.tab_main' => 'Access to configure Messenger main settings',
     ),
    'MAPPINGS'   => array(
        'messenger.edit'            => array('Messenger Admin'),
        'messenger.user'            => array('Messenger Admin'),
        'messenger.broadcast'       => array('Messenger Admin'),
        'smilie.edit'               => array('Messenger Admin'),
        'config.messenger.tab_main' => array('Messenger Admin'),
    ),
    'TABLES'     => array(
        'messenger_msg', 'messenger_dist', 'messenger_userinfo', 'messenger_buddies', 'smilies',
    ),

    // Settings not available on Geeklog Configuration screen
    'SMILIE_PATH'                   => $_CONF['path_html'] . 'messenger/images/smilies/',
    'SMILIE_URL'                    => $_CONF['site_url'] . '/messenger/images/smilies/',
    'imgset'                        => $_CONF['site_url'] . '/messenger/images',
);
