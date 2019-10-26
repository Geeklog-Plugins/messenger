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
* Messenger default settings
*
* Initial Installation Defaults used when loading the online configuration
* records.  These settings are only used during the initial installation
* and not referenced any more once the plugin is installed
*/
global $_CONF, $_MSG_DEFAULT;

$_MSG_DEFAULT = array();

// Global setting for plugin
$_MSG_DEFAULT['debug']                 = false;   // Set true to display POST and GET vars
$_MSG_DEFAULT['smiliesEnabled']        = true;    // Set to true to display and format smilies in Messenger
$_MSG_DEFAULT['RestrictedAccess']      = false;   // Set to true to only allow access with messenger.user access rights
$_MSG_DEFAULT['messagedelay']          = 1000;    // Set auto delay in ms for status messages to user. 5000 = 5 sec.
$_MSG_DEFAULT['automsg']               = 1;       // Set to 1 to have status messages pause and then continue or 0 for full stop
$_MSG_DEFAULT['notification']          = true;    // Set to true to enable site notifications of Private messages
$_MSG_DEFAULT['mailoff']               = false;   // Set to true to disable outgoing mail notifications
$_MSG_DEFAULT['RootBdcastNotificaton'] = true;    // Set to true if notifications should also be sent out for Broadcast message
$_MSG_DEFAULT['newmember']             = true;    // Set to true if you want to send out a PM to new members upon signup
// Note: New Member message is defined in the language file => $LANG_MSG05

// User Defaults - user can override these from their account profile - if template changes have been applied
$_MSG_DEFAULT['USER_PMBLOCK']          = false;   // Set true if users should not receive broadcast messages
$_MSG_DEFAULT['USER_NOTIFY']           = true;    // Set true if user should receive email notifications of new PM's by default

// Note: Only for plugins that use the glMessenger messenger_sendNotification() to send notifications
$_MSG_DEFAULT['USER_INBOX']            = false;   // Set true if all system and plugin notifications should be sent to users INBOX

/**
* Initializes Messenger plugin configuration
*
* Creates the database entries for the configuation if they don't already
* exist.  Initial values will be taken from $_MSG_DEFAULT
* if available (e.g. from an old config.php), uses $_MSG_DEFAULT
* otherwise.
*
* @return  bool  true on success, false otherwise
*/
function plugin_initconfig_messenger() {
    global $_MSG_DEFAULT, $_MSG_DEFAULT;

    if (is_array($_MSG_DEFAULT) && (count($_MSG_DEFAULT) > 0)) {
        $_MSG_DEFAULT = array_merge($_MSG_DEFAULT, $_MSG_DEFAULT);
    }

    $me = 'messenger';
    $c = config::get_instance();
    
    if ($c->group_exists($me)) {
        return true;
    }
    
    $sg = 0;
    $fs = 0;
    $tab = 0;
    $so = 0;

    $c->add('sg_main', null, 'subgroup', $sg, $fs, null, $so, true, $me);
    $c->add('tab_main', null, 'tab', $sg, $fs, null, $so, true, $me);
    $c->add('fs_main', null, 'fieldset', $sg, $fs, null, $so, true, $me);

    $c->add('debug', $_MSG_DEFAULT['debug'], 'select', $sg, $fs, 1, $so, true, $me, $tab);
    $so += 10;

    $c->add('smiliesEnabled', $_MSG_DEFAULT['smiliesEnabled'], 'select', $sg, $fs, 1, $so, true, $me, $tab);
    $so += 10;

    $c->add('RestrictedAccess', $_MSG_DEFAULT['RestrictedAccess'], 'select', $sg, $fs, 1, $so, true, $me, $tab);
    $so += 10;

    $c->add('messagedelay', $_MSG_DEFAULT['messagedelay'], 'text', $sg, $fs, null, $so, true, $me, $tab);
    $so += 10;

    $c->add('automsg', $_MSG_DEFAULT['automsg'], 'select', $sg, $fs, 0, $so, true, $me, $tab);
    $so += 10;

    $c->add('notification', $_MSG_DEFAULT['notification'], 'select', $sg, $fs, 1, $so, true, $me, $tab);
    $so += 10;

    $c->add('mailoff', $_MSG_DEFAULT['mailoff'], 'select', $sg, $fs, 1, $so, true, $me, $tab);
    $so += 10;

    $c->add('RootBdcastNotificaton', $_MSG_DEFAULT['RootBdcastNotificaton'], 'select', $sg, $fs, 1, $so, true, $me, $tab);
    $so += 10;

    $c->add('newmember', $_MSG_DEFAULT['newmember'], 'select', $sg, $fs, 1, $so, true, $me, $tab);
    $so += 10;

    $c->add('USER_PMBLOCK', $_MSG_DEFAULT['USER_PMBLOCK'], 'select', $sg, $fs, 1, $so, true, $me, $tab);
    $so += 10;

    $c->add('USER_NOTIFY', $_MSG_DEFAULT['USER_NOTIFY'], 'select', $sg, $fs, 1, $so, true, $me, $tab);
    $so += 10;

    $c->add('USER_INBOX', $_MSG_DEFAULT['USER_INBOX'], 'select', $sg, $fs, 1, $so, true, $me, $tab);
    $so += 10;

    return true;
}
