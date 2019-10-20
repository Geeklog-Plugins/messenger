<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +-----------------------------------------------------------------------------+
// | glMessenger Plugin 1.0 for Geeklog- The Ultimate OSS Portal                 |
// | Date: November 15, 2003                                                     |
// +-----------------------------------------------------------------------------+
// | functions.inc - Geeklog Plugin API functions and support functions          |
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

use Geeklog\Input;

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file can not be used on its own.');
}

$langfile = $_CONF['path'] . 'plugins/messenger/language/' . $_CONF['language'] . '.php';
if (file_exists($langfile)) {
    include_once $langfile;
} else {
    include_once $_CONF['path'] . 'plugins/messenger/language/english.php';
}

require_once $_CONF['path'] . 'plugins/messenger/config.php';

/**
* Returns the user menuitem option for this plugin
* Only one menu item can be returned.
*/
function plugin_getuseroption_messenger()
{
   global $_USER, $_CONF, $_TABLES, $LANG_MSG00, $CONF_MSG;

   // If restricted access has been enabled in the plugins config.php then check access right
   if (!$CONF_MSG['RestrictedAccess'] || SEC_hasRights('messenger.user') ) {
       // Check and see if user wants to view Broadcast messages - if not exclude them
       if (DB_getItem($_TABLES['messenger_userinfo'],"broadcasts", "uid={$_USER['uid']}") == '1') {
            $sql = DB_query("SELECT count(*) as count FROM {$_TABLES['messenger_dist']} dist LEFT JOIN {$_TABLES['messenger_msg']} msg ON dist.msg_id=msg.id WHERE (target_uid = {$_USER['uid']} AND read_date is NULL) ");
       } else {
           $sql = DB_query("SELECT count(*) as count FROM {$_TABLES['messenger_dist']} dist LEFT JOIN {$_TABLES['messenger_msg']} msg ON dist.msg_id=msg.id WHERE (target_uid = {$_USER['uid']} AND read_date is NULL) OR (target_uid = '0' AND archive='0')");
       }
       list($count) = DB_fetchArray($sql);
       if ($count > 0) {
           return array($LANG_MSG00['usermenu'] . '&nbsp;(' .$count. ')', $_CONF['site_url'] . '/messenger/index.php', 0);
       } else {
           return array($LANG_MSG00['usermenu'], $_CONF['site_url'] . '/messenger/index.php', 0);
       }
   }
}

/**
* returns the administrative option for this plugin
*
*/
function plugin_getadminoption_messenger()
{
    global $_TABLES, $_CONF, $CONF_MSG;

    if ($CONF_MSG['smiliesEnabled'] && SEC_hasRights('smilie.edit')) {
        return array('Smilies', $_CONF['site_admin_url'] . '/plugins/messenger/editsmilies.php');
    } else {
        return array();
    }
}

/**
* Called if user is created - Adds a default userpref record which is used when member edits account preferences
*/
function plugin_user_create_messenger($uid)
{
    global $_TABLES, $CONF_MSG, $LANG_MSG05;

    DB_query("INSERT INTO {$_TABLES['messenger_userinfo']} (uid) VALUES ('{$uid}')");

    // Check if new members should receive the welcome private message
    if ($CONF_MSG['newmember']) {
        $toname = DB_getItem($_TABLES['users'],"username","uid=$uid");
        $subject = $LANG_MSG05['subject'];
        $message = $LANG_MSG05['message'];
        messenger_send($toname,$subject,$message);
    }
}

/**
* Called if admin deletes a user - remove all user messages as well
*/
function plugin_user_delete_messenger($uid)
{
    global $_TABLES;

    $sql = DB_query("SELECT msg_id FROM {$_TABLES['messenger_dist']} WHERE target_uid = '{$uid}'");

    while (list($msg_id) = DB_fetchArray($sql)) {
        // Only delete any actual messages if only this member was on the distribution
        if (DB_count($_TABLES['messenger_dist'],"msg_id", "$msg_id") == 1) {
            DB_query("DELETE FROM {$_TABLES['messenger_msg']} WHERE id = '{$msg_id}'");
        }

        DB_query("DELETE FROM {$_TABLES['messenger_dist']} WHERE msg_id = '{$msg_id}' AND target_uid = '{$uid}'");
    }

    // Finally - Delete the user preference record
    DB_query("DELETE FROM {$_TABLES['messenger_userinfo']} WHERE uid = '{$uid}'");
}

/**
 * Called by PLG_profilevariablesdisplay just before displaying a user's profile
 *
 * @param  int      $uid
 * @param  Template $template
 */
function plugin_profilevariablesdisplay_messenger($uid, $template)
{
    global $_USER, $_CONF, $_TABLES, $LANG_MSG;

    $uid = (int) $uid;

    if (isset($_USER['uid']) && ($_USER['uid'] > 1) && ($_USER['uid'] != $uid)) {
        if (DB_count($_TABLES['messenger_buddies'], array('uid', 'buddy_id'), array($_USER['uid'], $uid)) > 0) {
            $field = '<a href="' . $_CONF['site_url'] . '/messenger/index.php?action=delbuddy&amp;buddy=' . $uid
                   . '&amp;fromprofile=1">' . $LANG_MSG['DELBUDDY'] . '</a>';
        } else {
            $field = '<a href="' . $_CONF['site_url'] . '/messenger/index.php?action=addbuddy&amp;buddy=' . $uid
                   . '&amp;fromprofile=1">' . $LANG_MSG['ADDBUDDY'] . '</a>';
        }

        $template->set_var(array(
            'lang_field' => $LANG_MSG['MSGFAVORITES'],
            'field'      => $field,
        ));
        $template->parse('display_fields', 'display_field', true);
    }
}

/**
* Called by the plugin Editor to display the current plugin code version
* This may be different then the version installed and registered currently.
* If newer then you may want to run the update
*/
function plugin_chkVersion_messenger() {
    global $CONF_MSG;

    return $CONF_MSG['version'] ;
}

/**
* Called by the plugin Editor to run the SQL Update for a plugin update
*/
function plugin_upgrade_messenger() {
    global $_TABLES, $CONF_MSG;

    $curversion = DB_getItem($_TABLES['plugins'],'pi_version',"pi_name = 'messenger'");
    DB_query("UPDATE {$_TABLES['plugins']} SET pi_version = '{$CONF_MSG['version']}' WHERE pi_name = 'messenger'");

    // Check if update completed and return a message number to be shown
    return (DB_getItem($_TABLES['plugins'],'pi_version',"pi_name = 'messenger'") == $CONF_MSG['version']);
}

/**
* Removes the datastructures for this plugin from the Geeklog database
* This may get called by the install routine to undue anything created during the install.
* Added check to see that plugin is first disabled.
*/
function plugin_uninstall_messenger($installCheck='')
{
    global $_TABLES, $LANG_MSG00, $_CONF;

    $pi_name = 'messenger';
    $FEATURES = array('messenger.user', 'messenger.edit', 'messenger.broadcast', 'smilie.edit');
    $TABLES = array('messenger_msg', 'messenger_dist', 'messenger_userinfo', 'messenger_buddies', 'smilies');

    // Check and see if plugin is still enabled - if so display warning and exit
    if ($installCheck != '' && DB_getItem($_TABLES['plugins'],'pi_enabled', 'pi_name = "' . $pi_name . '"')) {
        COM_errorLog("Plugin is installed and enabled. Disable first if you want to de-install it", 1);
        $display = COM_startBlock($LANG_MSG00['warning'])
            . $LANG_MSG00['enabled']
            . COM_endBlock();
        $display = COM_createHTMLDocument($display);
        COM_output($display);
        exit;
    }

    // Ok to proceed and delete plugin - Unregister the plugin with Geeklog
    COM_errorLog('Attempting to unregister the Messenger plugin from Geeklog', 1);
    DB_query("DELETE FROM {$_TABLES['plugins']} WHERE pi_name = 'messenger'", 1);
    
    // Drop Messenger Plugin tables
    foreach($TABLES as $table) {
        $t = $_TABLES["$table"];
        COM_errorLog("Removing Table $t", 1);
        DB_query("DROP TABLE $t", 1);
    }

    // Remove Admin Security for this plugin
    $grp_id = DB_getItem($_TABLES['vars'], 'value', "name = '{$pi_name}_admin'");
    COM_errorLog("Removing $pi_name Admin Group", 1);
    DB_query("DELETE FROM {$_TABLES['groups']} WHERE grp_id = $grp_id", 1);
    DB_query("DELETE FROM {$_TABLES['vars']} WHERE name = '{$pi_name}_admin'");
    COM_errorLog("Removing root users from admin of $pi_name");
    DB_query("DELETE FROM {$_TABLES['group_assignments']} WHERE ug_main_grp_id = $grp_id", 1);

    // Remove all the associated features - access rights. The feature ID's were stored in the vars table during install.
    foreach ($FEATURES as $feature) {
        COM_errorLog("Removing $feature feature and rights to it", 1);
        $feat_id = DB_getItem($_TABLES['features'], 'ft_id', "ft_name = '$feature'");
        COM_errorLog("DELETE FROM {$_TABLES['access']} WHERE acc_ft_id = $feat_id");
        DB_query("DELETE FROM {$_TABLES['access']} WHERE acc_ft_id = $feat_id", 1);
        DB_query("DELETE FROM {$_TABLES['features']} WHERE ft_id = $feat_id", 1);
    }
    
    /* DO NOT REMOVE OR CHANGE THE FOLLOWING CODE UNDER ANY CONDITION */
    /* This Plugin requires a license to be installed and information collected is only used to track that license */
    /* Blaine Lang: glmessenger author */
    $message =  'Completed plugin DE-INSTALL: ' .date('m d Y',time()) . "   AT " . date('H:i', time()) . "\n";
    $message .= 'Site: ' . $_CONF['site_url'] . ' and Sitename: ' . $_CONF['site_name'] . "\n";
    $message .= 'Admin: ' . $_CONF['site_mail'] . "\n";
    $message .= 'Hostname: ' . $_ENV['HOSTNAME'] . ' and RemoteAddress: ' .$_ENV['REMOTE_ADDR'];
    COM_mail('glmessenger@portalparts.com','glMessenger DE-INSTALL',$message);
    COM_errorLog('...success',1);
    return true;
}

function messenger_statusMessage($message = '', $url, $prompt) {
    global $_CONF,$_USER,$LANG_MSG,$CONF_MSG;

    include_once $_CONF['path'] . 'plugins/messenger/config.php';

    if (empty($prompt)) {
        $prompt = $LANG_MSG['statusmsg2'];
    }

    echo COM_startBlock();
    echo "<font class='alert'><br><p/>$message</font>";
    echo "<br><p/>";

    if ($CONF_MSG['automsg'] == "0") {
        echo sprintf($LANG_MSG['statusmsg1'], $prompt, $url);
        echo "<br><p>";
    } else {
        echo '<script language="javascript1.1">';
        echo 'window.setTimeout("window.location.href=\'' . $url . '\'",' . $CONF_MSG['messagedelay'] . ');';
        echo '<!-- window.location.replace("'. $url . '");';
        echo '// --> </script>';
        echo sprintf($LANG_MSG['statusmsg3'], $url);
        echo "<br><p>";
    }

    echo COM_endBlock();

    return;
}

/**
* Replace emoticons in string with formated HTML of smilies.
* Emoticon mapping to images are defined in a the table.
* This function will replace all the emoticons in the past string.
* @param   string  $text  The text
* @return  string  The text, possibly with emoticons replaced with the HTML img tags for the smilie image.
*/
function msg_replaceEmoticons( $text ) {
    global $CONF_MSG, $_TABLES;

    $arr_smilies = array();
    $sql = DB_query("SELECT code,smile_url,emoticon from {$_TABLES['smilies']} ORDER BY length(code) desc");

    while ( list($code,$icon,$emoticon) = DB_fetchARRAY($sql)) {
        $text = str_replace(
            $code,
            '<img src="' . $CONF_MSG['SMILIE_URL'] . $icon . '" ALT="' . $emoticon . '" TITLE="' . $emoticon . '" BORDER="0">',
            $text
        );
    }

    return $text;
}

/**
* Replace formatted smilie HTML for emoticons - so message can be edited
* @param   string  $text  The text, possibly with HTML img tags for the smilie image
* @return  string  The text, possibly with the replaced smilie emoticon.
*/
function msg_restoreEmoticons( $text ) {
    global $CONF_MSG, $_TABLES;

    $arr_smilies = array();
    $sql = DB_query("SELECT code,smile_url,emoticon from {$_TABLES['smilies']} ORDER BY length(code) desc");

    while (list($code, $icon, $emoticon) = DB_fetchArray($sql)) {
        // Check for HTML that is formatted the new way and how it was used in earlier releases
        $text = str_replace(
            '<img src="' . $CONF_MSG['SMILIE_URL'] . $icon . '" ALT="' . $emoticon . '" TITLE="' . $emoticon .'" BORDER="0">',
            $code,
            $text
        );
        $text = str_replace(
            '<img src=' . $CONF_MSG['SMILIE_URL'] . $icon . ' BORDER="0">',
            $code,
            $text
        );
    }

    return $text;
}

function msg_showsmilies() {
    global $_TABLES, $_CONF, $CONF_MSG;

    $baseurl = $CONF_MSG['SMILIE_URL'];
    $dirPath = $CONF_MSG['SMILIE_PATH'];

    // Build an array of the smilies and possible emoticon codes that can be entered
    // Since I can have multiple emoticons for the same smilie image,
    // I need to sort this out and only show 1 but display a help message with all the possible codes
    $arr_emoticons = array();
    $query = DB_query("SELECT smilie_id,code,smile_url,emoticon FROM {$_TABLES['smilies']}");

    while (list($smilie_id, $code, $smile_url, $emoticon) = DB_fetchArray($query)) {
        if (!array_key_exists($smile_url, $arr_emoticons)) {
            $arr_emoticons[$smile_url]['code'] = 'Emoticon ' . $emoticon . ', codes => ' . $code;
        } else {
            $arr_emoticons[$smile_url]['code'] .= ' , ' . $code;
        }
    }

    // Now build the HTML to return with the smilie images and help line when you hover over image
    $smilies = '';

    foreach ($arr_emoticons as $key => $smilie) {
        $pos1 = strpos($smilie['code'], '=>') + 3;
        $pos2 = strpos($smilie['code'], ',', $pos1);

        if ($pos2 > 0) {
            $len = $pos2 - $pos1;
            $code = substr($smilie['code'], $pos1, $len);
        } else {
            $code = substr($smilie['code'], $pos1);
        }

        $smilies .= '<a href="javascript:emoticon(\'' . $code . '\')"><img style="border-width: 0;" src="'
            . $baseurl . $key . '" alt="' . $smilie['code'] . '" title="' . $smilie['code'] . '"></a> ';
    }

    return $smilies;
}

// Callback Function for the array walk function below to apply the data filters to clean any posted data
function msg_cleanfield(&$field) {
    $p = COM_stripslashes( $field );
    $p = strip_tags( $p );
    $p = COM_killJS( $p ); // doesn't help a lot right now, but still ...
    $pa = explode( "'", $p );
    $pa = explode( '"', $pa[0] );
    $pa = explode( '`', $pa[0] );
    $field = $pa[0];
}

// Function to clean any posted data
function msg_cleandata($parameter) {
    if (gettype($parameter) === 'array') {
        array_walk($parameter, 'msg_cleanfield');
    } else {
       msg_cleanfield($parameter);
    }
    
    return $parameter;
}

function msg_preparefordb($message, $postmode = 'text', $censor = true, $htmlfilter = true) {
    if ($censor) {
        $message = COM_checkWords($message);
    }

    if ($postmode === 'html') {
        if ($htmlfilter) {
            // Need to call addslahes again as COM_checkHTML stips it out
            $message = addslashes(nl2br(COM_checkHTML($message)));
        } elseif (!get_magic_quotes_gpc()) {
            $message = addslashes(nl2br($message));
        }
    } else {
        if(get_magic_quotes_gpc()) {
            $message = htmlspecialchars($message);
        } else {
            $message = addslashes(htmlspecialchars($message));
        }
    }

    return $message;
}

function messenger_send($towhom,$subject,$message,$reply_msgid=0,$broadcast=false,$notify=true)
{
    global $_CONF, $_TABLES, $_USER, $REMOTE_ADDR, $CONF_MSG,$LANG_MSG01;

    $subject = msg_preparefordb($subject, 'html');
    $message = msg_preparefordb($message, 'html');

    if ($reply_msgid == '') {
        $reply_msgid = 0;
    }

    if ($broadcast) {
        $target_uid = "0";
        DB_query("INSERT INTO $_TABLES[messenger_msg] (message,source_uid,subject,datetime,reply_msgid,ip) VALUES ('$message','$_USER[uid]','$subject',UNIX_TIMESTAMP(),$reply_msgid,'$REMOTE_ADDR')");
        $lastmsg_id = DB_insertID();
        DB_query("INSERT INTO $_TABLES[messenger_dist] (msg_id,target_uid,archive) VALUES ('$lastmsg_id','$target_uid','0')");

        // If admin then allow notifications to be sent to all members
        if (SEC_inGroup('Root') && $CONF_MSG['RootBdcastNotificaton'] && $CONF_MSG['notification']) {
           $query = DB_query("SELECT username,uid from {$_TABLES['users']} where uid != {$_USER['uid']} AND uid > 1");

           while (list($target_user, $target_uid) = DB_fetchARRAY($query)) {
                $query2 = DB_query("SELECT broadcasts, notifications,sitepreference FROM {$_TABLES['messenger_userinfo']} WHERE uid={$target_uid}");
                list($broadcastblock,$notifyoption,$sitepreference) = DB_fetchArray($query2);

                // Check if user has messenger_userinfo record and possibly disabled notifications
                // Also don't need to send a notification if user has messenger as their default for notifications
                if ((DB_numRows($query2) == 0) || ($broadcastblock == 0 && $notifyoption == 1 && $sitepreference == 0)) {
                    $notifySubject = '' . $_CONF['site_name'] . ' ' . $LANG_MSG01['BROADCAST']. '';
                    $notifyMessage  = $LANG_MSG01['HELLO'] . ' ' . $target_user . ",\n\n";
                    $notifyMessage .= sprintf($LANG_MSG01['LINE1B'], $_USER['username'], $subject);
                    $notifyMessage .= $LANG_MSG01['LINE2'];
                    $notifyMessage .= $LANG_MSG01['LINE3'] . $_CONF['site_name'] . ' ' . $LANG_MSG01['ADMIN'] . "\n";
                    $notifyMessage .= "\n" . $_CONF[site_url] . "\n";
                    msg_sendNotification($target_user, $notifySubject, $notifyMessage, 'messenger');
                }
            }
        }
    } else {
        $target_users = explode(';', $towhom);

        // Check that all users are valid members before saving message and sending notifications out;
        foreach ($target_users as $target_user) {
            $target_user = trim($target_user);

            if ($_CONF['show_fullname'] == 1) {
                if ($target_user != '' && DB_getItem($_TABLES['users'], "uid", "fullname = '$target_user'") < 1) {
                    return false;
                }
            } else {
                if ($target_user != '' && DB_getItem($_TABLES['users'],"uid", "username = '$target_user'") < 1) {
                    return false;
                }
            }
        }

        reset($target_users);
        DB_query("INSERT INTO $_TABLES[messenger_msg] (message,source_uid,subject,datetime,reply_msgid,ip) VALUES ('$message','$_USER[uid]','$subject',UNIX_TIMESTAMP(),$reply_msgid,'$REMOTE_ADDR')");
        $lastmsg_id = DB_insertID();

        if ($notify) {
            // Send out Notifications to all users on distribution
            foreach ($target_users as $target_user) {
                $target_user = trim(strtolower($target_user));

                if ($target_user != '') {
                    if ($_CONF['show_fullname'] == 1) {
                        $target_uid = DB_getItem($_TABLES['users'],"uid", "fullname='{$target_user}'");
                    } else {
                        $target_uid = DB_getItem($_TABLES['users'],"uid", "username='{$target_user}'");
                    }

                    $query2 = DB_query("SELECT notifications,sitepreference FROM {$_TABLES['messenger_userinfo']} WHERE uid={$target_uid}");
                    list($notifyoption,$sitepreference) = DB_fetchArray($query2);

                    // Check if user has messenger_userinfo record and possibly disabled notifications
                    // Also don't need to send a notification if user has messenger as their default for notifications
                    if (DB_numRows($query2) == 0 || (DB_numRows($query2) == 1 && $notifyoption == 1 && $sitepreference == 0)) {
                        DB_query("INSERT INTO $_TABLES[messenger_dist] (msg_id,target_uid,archive) VALUES ('$lastmsg_id','$target_uid','0')");
                        $notifySubject = '' . $_CONF['site_name'] . ' ' . $LANG_MSG01['SUBJECT'] . '';
                        $notifyMessage  = $LANG_MSG01['HELLO'] . ' ' . $target_user . ",\n\n";
                        $notifyMessage .= sprintf($LANG_MSG01['LINE1'], $_USER['username'], $subject);
                        $notifyMessage .= $LANG_MSG01['LINE2'];
                        $notifyMessage .= $LANG_MSG01['LINE3'] . $_CONF['site_name'] . ' ' . $LANG_MSG01['ADMIN'] ."\n";
                        $notifyMessage .= "\n" . $_CONF['site_url'] . "\n";
                        msg_sendNotification($target_user, $notifySubject, $notifyMessage, 'messenger');
                    } else {
                        DB_query("INSERT INTO $_TABLES[messenger_dist] (msg_id,target_uid,archive) VALUES ('$lastmsg_id','$target_uid','0')");
                    }
                }
            }
        }
    }

    return true;
}

function msg_sendNotification($user, $subject, $message, $type = '') {
    global $_USER, $_CONF, $_TABLES, $CONF_MSG;

    // Added to handle domain\user.name type usernames - occured at Inco where we have NTLM integration
    if (!get_magic_quotes_gpc()) {
       $user = addslashes($user);
    }

    if ($_CONF['show_fullname'] == 1) {
        $target_uid = DB_getItem($_TABLES['users'],"uid", "fullname='{$user}'");
    } else {
        $target_uid = DB_getItem($_TABLES['users'],"uid", "username='{$user}'");
    }

    $sql = DB_query("SELECT sitepreference FROM {$_TABLES['messenger_userinfo']} WHERE uid='$target_uid'");
    list($sitepreference) = DB_fetchArray($sql);
    $emailaddress = DB_getItem($_TABLES['users'], "email", "uid = '$target_uid'");

    // Check if user has enabled Messenger to be used for a notification messages
    if (isset($sitepreference) && $sitepreference) {
        messenger_send($user, $subject, $message, 0, false, false);
    } else {
        // Send out regular email notificaton
        if (empty($LANG_CHARSET)) {
            $charset = $_CONF['default_charset'];
            if (empty($charset)) {
                $charset = "iso-8859-1";
            }
        } else {
            $charset = $LANG_CHARSET;
        }

        $headers = "MIME-Version: 1.0\r \n";
        $headers .= "Content-type: text/plain; charset=iso-8859-1\r \n";
        $headers .= 'From: "' .$_CONF['site_name']. '" <' .$_CONF['site_mail']. ">\r \n";
        $headers .= 'Reply-To: "' .$_CONF['site_name'] .'" <' .$_CONF['site_mail']. ">\r \n";
        $headers .= "X-Priority: 3\r \n";
        $headers .= "X-MSMail-Priority: Normal\r \n";
        $headers .= "X-Mailer: " .$_CONF['site_name']. " Server";
        if ($CONF_MSG['mailoff']) {
            COM_errorLOG("PM notification to $emailaddress NOT sent - Messenger config.php 'mailoff' setting.");
        } else {
            //@mail($emailaddress, $subject, $message, $headers);
            COM_mail($emailaddress, $subject, $message);
       }
    }

    // Log notification for admin viewing and tracking
    $type = ($type == '') ? 'unknown' : $type;
    $logentry = "$type ,.$user ($emailaddress), .$subject";
    msg_logNotification($logentry);

    return true;
}

function msg_logNotification($logentry) {
    global $_CONF, $LANG01;

    $timestamp = strftime('%b %d %H:%M');
    $logfile = $_CONF['path_log'] . 'notification.log';
    @file_put_contents($logfile, "$timestamp,$logentry \n", FILE_APPEND);
}

/**
* Returns the items for this plugin that should appear on the main menu
*/
function plugin_getHeaderCode_messenger()
{
    global $_CONF;

    return '<script type="text/javascript" src="' . $_CONF['site_url'] . '/messenger/library.js"></script>';
}
