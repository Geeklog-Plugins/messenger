<?php

/* Reminder: always indent with 4 spaces (no tabs). */
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

global $_DB_table_prefix;

$CONF_MSG['version']             = '1.9.0';

$CONF_MSG['SMILIE_PATH']         = $_CONF['path_html'] . '/images/smilies/';
$CONF_MSG['SMILIE_URL']          = $_CONF['site_url'] . '/images/smilies/';
$CONF_MSG['imgset']              = $_CONF['layout_url'] .'/messenger/images';
$CONF_MSG['debug']               = false;   // Set true to display POST and GET vars

// Global setting for plugin
$CONF_MSG['smiliesEnabled']        = true;    // Set to true to display and format smilies in Messenger
$CONF_MSG['RestrictedAccess']      = false;   // Set to true to only allow access with messenger.user access rights
$CONF_MSG['messagedelay']          = 1000;    // Set auto delay in ms for status messages to user. 5000 = 5 sec.
$CONF_MSG['automsg']               = 1;       // Set to 1 to have status messages pause and then continue or 0 for full stop
$CONF_MSG['notification']          = true;    // Set to True to enable site notifications of Private messages
$CONF_MSG['mailoff']               = false;   // Set to True to disable outgoing mail notifications
$CONF_MSG['RootBdcastNotificaton'] = true;    // Set to True if notifications should also be sent out for Broadcast message
$CONF_MSG['newmember']             = true;    // Set to True if you want to send out a PM to new members upon signup
/* Note: New Member message is defined in the language file => $LANG_MSG05 */

// User Defaults - user can override these from their account profile - if template changes have been applied
$CONF_MSG['USER_PMBLOCK']          = false;    // Set true if users should not receive broadcast messages
$CONF_MSG['USER_NOTIFY']           = true;    // Set true if user should receive email notifications of new PM's by default

// Note: Only for plugins that use the glMessenger messenger_sendNotification() to send notifications
$CONF_MSG['USER_INBOX']            = false;    // Set true if all system and plugin notifications should be sent to users INBOX


/**********************************************************************************/
/*  DO NOT MAKE ANY CHANGES TO THE SETTINGS BELOW THIS AREA                       */
/**********************************************************************************/
$_TABLES['messenger_msg']        =  $_DB_table_prefix . 'messenger_msg';
$_TABLES['messenger_dist']       =  $_DB_table_prefix . 'messenger_dist';
$_TABLES['messenger_userinfo']   =  $_DB_table_prefix . 'messenger_userinfo';
$_TABLES['messenger_buddies']    =  $_DB_table_prefix . 'messenger_buddies';
$_TABLES['smilies']              = $_DB_table_prefix . 'smilies';
