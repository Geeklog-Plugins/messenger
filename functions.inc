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

if (stripos($_SERVER['PHP_SELF'], 'functions.inc') !== false) {
    die('This file cannot be used on its own.');
}

// Language file Include
$langfile = __DIR__ . '/language/' . $_CONF['language'] . '.php';
clearstatcache();

if (file_exists($langfile)) {
    include_once $langfile;
} else {
    include_once __DIR__ . '/language/english.php';
}

// Loads the plugin configuration
global $CONF_MSG;

require_once $_CONF['path'] . 'plugins/messenger/config.php';
MSG_loadConfig();

// +---------------------------------------------------------------------------+
// | Geeklog Plugin API Implementations                                        |
// +---------------------------------------------------------------------------+

/**
* Returns a URL to icon
*/
function plugin_geticon_messenger() {
    global $_CONF;

    return $_CONF['site_url'] . '/messenger/images/messenger.gif';
}

/**
* Returns code to be added to <head> section
*/
function plugin_getheadercode_messenger() {
    global $_CONF;

    return '<script type="text/javascript" src="' . $_CONF['site_url'] . '/messenger/library.js"></script>';
}

/**
* Returns code to be added to footer
*
* @since  GL-1.8.0
*/
function plugin_getfootercode_messenger() {
    global $_CONF;
    
}

/**
* Callback function when an item was just saved
*
* @param   string  $id     unique ID of the item
* @param   string  $type   type of the item, e.g. 'article'
* @param   string  $old_id (optional) old ID when the ID was changed
*/
function plugin_itemsaved_messenger($id, $type, $old_id) {
    global $_CONF;
    
}

/**
* Checks to see if this plugin uses comments
*
* @return   boolean true or false
*/
function plugin_commentsupport_messenger() {
    return false;
}

/**
* Shows the statistics for the plugin on stats.php.  If
* $showsitestats is 1 then we are to only print the overall stats in the 'site
* statistics' box otherwise we show the detailed stats for the plugin
*
* Universal Plugin:  Modify/uncomment use it
*
* @param    int showsitestate   Flag to let us know which stats to get
* @return   string  returns formatted HTML to insert in stats page
*/
function plugin_showstats_messenger($showsitestats) {
//    global $_CONF, $_TABLES;

//    $stat_templates = new Template($_CONF['path_layout'] . 'stats');
//    $stat_templates->set_file(array('itemstats'=>'itemstatistics.thtml',
//                            'statrow'=>'singlestat.thtml'));
        $retval='';
//    if ($showsitestats == 1) {
        // This shows in the summary box
//        $total_pages=DB_count($_TABLES['table1']);     // Fill this with count for summary
//        $summary_label = "messenger";                   // Fill this with label displayed
        
//        $retval  = '<table border = "0" width="100%" cellspacing="0" cellpadding="0">';
//        $retval .= '<tr><td>{$summary_label}</td>';
//        $retval .= '<td align="right">' . $total_pages . '&nbsp;&nbsp;</td></tr></table>';
//    } else {
        // This fills the top the box  Use the following as a template
//        $result = DB_query("SELECT id, title, hits FROM {$_TABLES['table1'] WHERE (hits > 0) ORDER BY hits desc LIMIT 10");
//        $nrows  = DB_numRows($result);
//        $retval .= COM_startBlock("Top Ten Static Pages");
//        if ($nrows > 0) {
//            $stat_templates->set_var('item_label', "Page Title");
//            $stat_templates->set_var('stat_name', "Hits");
//            for ($i = 0; $i < $nrows; $i++) {
//                $A = DB_fetchArray($result);
//                $stat_templates->set_var('item_url', $_CONF['site_url'] . '/messenger/index.php?item=' . $A['id']);
//                $stat_templates->set_var('item_text', $A['title']);
//                $stat_templates->set_var('item_stat', $A['hits']);
//                $stat_templates->parse('stat_row','statrow', true); 
//            }
//            $stat_templates->parse('output', 'itemstats');
//            $retval .= $stat_templates->finish($stat_templates->get_var('output'));
//        } else {
//            $retval .= 'It appears that there are no messengers on this site or no one has ever viewed them.';
//        } 
//        $retval .= COM_endBlock();
//    }
    return $retval;
}

/**
* Puts an option for the plugin in the command and control block on moderation.php
*
* @return   array   Array containing (plugin name, admin url, url of plugin icon)
*/
function plugin_cclabel_messenger() {
    global $_CONF;
    
    if (SEC_hasRights('messenger.edit')) {
        $pi_name   = 'Smilies';
        $admin_url = $_CONF['site_admin_url'] . '/plugins/messenger/editsmilies.php';
        $icon_url  = plugin_geticon_messenger();

        return array($pi_name, $admin_url, $icon_url);
    } else {
        return array();
    }
}

/**
 * Returns the administrative option for this plugin
 *
 * @return   array   Array containing (plugin name, plugin admin url, # of items in plugin or '')
 */
function plugin_getadminoption_messenger() {
    global $_CONF, $CONF_MSG;

    if ($CONF_MSG['smiliesEnabled'] && SEC_hasRights('smilie.edit')) {
        return array('Smilies', $_CONF['site_admin_url'] . '/plugins/messenger/editsmilies.php');
    } else {
        return array();
    }
}

/**
 * Called if user is created - Adds a default userpref record which is used when member edits account preferences
 *
 * @param   int  $uid
 */
function plugin_user_create_messenger($uid)
{
    global $_TABLES, $CONF_MSG, $LANG_MSG05;

    $uid = (int) $uid;
    if ($uid <= 1) {
        return;
    }

    DB_query("INSERT INTO {$_TABLES['messenger_userinfo']} (uid) VALUES ({$uid})");

    // Check if new members should receive the welcome private message
    if ($CONF_MSG['newmember']) {
        $toname = DB_getItem($_TABLES['users'], 'username', "uid={$uid}");
        messenger_send($toname, $LANG_MSG05['subject'], $LANG_MSG05['message']);
    }
}

/**
 * Called if admin deletes a user - remove all user messages as well
 *
 * @param   int  $uid
 */
function plugin_user_delete_messenger($uid)
{
    global $_TABLES;

    $uid = (int) $uid;
    if ($uid <= 1) {
        return;
    }

    $sql = DB_query("SELECT msg_id FROM {$_TABLES['messenger_dist']} WHERE target_uid = {$uid}");

    while (list($msg_id) = DB_fetchArray($sql)) {
        // Only delete any actual messages if only this member was on the distribution
        if (DB_count($_TABLES['messenger_dist'], 'msg_id', $msg_id) == 1) {
            DB_query("DELETE FROM {$_TABLES['messenger_msg']} WHERE id = {$msg_id}");
        }

        DB_query("DELETE FROM {$_TABLES['messenger_dist']} WHERE msg_id = {$msg_id} AND target_uid = {$uid}");
    }

    // Finally - Delete the user preference record
    DB_query("DELETE FROM {$_TABLES['messenger_userinfo']} WHERE uid = {$uid}");
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
* Returns the version for this plugin
*
* @return string VersionNo
*/
function plugin_chkVersion_messenger() {
    global $CONF_MSG;
    
    return $CONF_MSG['pi_version'];
}

/**
* Returns the user option for this plugin
*
* @return  array  Array containing (plugin name, plugin user url, 0)
*/
function plugin_getuseroption_messenger() {
   global $_USER, $_CONF, $_TABLES, $LANG_MSG, $CONF_MSG;

   // If restricted access has been enabled in the plugin's configuration, then check access right
   if (!$CONF_MSG['RestrictedAccess'] || SEC_hasRights('messenger.user')) {
       // Check and see if user wants to view Broadcast messages - if not exclude them
       if (DB_getItem($_TABLES['messenger_userinfo'], 'broadcasts', "uid={$_USER['uid']}") == '1') {
            $sql = DB_query(
                "SELECT COUNT(*) AS count FROM {$_TABLES['messenger_dist']} dist "
                . "LEFT JOIN {$_TABLES['messenger_msg']} msg ON dist.msg_id = msg.id "
                . "WHERE (target_uid = {$_USER['uid']} AND read_date is NULL)"
            );
       } else {
           $sql = DB_query(
                "SELECT COUNT(*) AS count FROM {$_TABLES['messenger_dist']} dist "
                . "LEFT JOIN {$_TABLES['messenger_msg']} msg ON dist.msg_id = msg.id "
                . "WHERE (target_uid = {$_USER['uid']} AND read_date is NULL) OR (target_uid = 0 AND archive = 0)");
       }
       
       list($count) = DB_fetchArray($sql);
       
       if ($count > 0) {
           return array($LANG_MSG['usermenu'] . '&nbsp;(' .$count. ')', $_CONF['site_url'] . '/messenger/index.php', 0);
       } else {
           return array($LANG_MSG['usermenu'], $_CONF['site_url'] . '/messenger/index.php', 0);
       }
   }
}

/**
* Upgrade the plugin
*
* @return   boolean true (= success)
*/
function plugin_upgrade_messenger() {
    global $_CONF, $_TABLES, $CONF_MSG;

    $sql = "SELECT pi_version FROM {$_TABLES['plugins']} "
        . "WHERE (pi_name = 'messenger') ";
    $result = DB_query($sql);
    $A = DB_fetchArray($result);
    $installed_version = $A['pi_version'];     // Version info stored in database
	$pi_version = $installed_version;
    
    // Do upgrading
    if (version_compare($pi_version, '1.9.1', '<=')) {
        require_once __DIR__ . '/install_defaults.php';
        plugin_initconfig_messenger();
        $pi_version = '1.9.2';
    }

    while (version_compare($pi_version, $CONF_MSG['pi_version'], '<')) {
        switch ($pi_version) {
            case '1.9.2':
			case '1.9.3':
            default:
                $pi_version = $CONF_MSG['pi_version'];
                break;
        }
    }
	
    // Updates plugin info
    $sql = "UPDATE {$_TABLES['plugins']} "
         . "SET pi_version = '" . DB_escapeString($CONF_MSG['pi_version']) . "' "
		 . ",  pi_gl_version = '" . DB_escapeString($CONF_MSG['gl_version']) . "' "
		 . ",  pi_homepage = '" . DB_escapeString($CONF_MSG['pi_url']) . "' "
         . "WHERE (pi_name = 'messenger') ";
    DB_query($sql);
	
	COM_errorLog( "Updated Messenger plugin from v$installed_version to v{$CONF_MSG['pi_version']}", 1 );
	
    return true;
}

/**
* Automatic uninstall function for plugins
*
* @return   array
*/
function plugin_autouninstall_messenger() {
    global $_CONF, $CONF_MSG;

    require_once __DIR__ . '/config.php';

    return array (
        // give the name of the tables, without $_TABLES[]
        'tables' => $CONF_MSG['TABLES'],
        // give the full name of the group, as in the db
        'groups' => array_keys($CONF_MSG['GROUPS']),
        // give the full name of the feature, as in the db
        'features' => array_keys($CONF_MSG['FEATURES']),
        // give the full name of the block, including 'phpblock_', etc
        'php_blocks' => array(),
        // give all vars with their name
        'vars'=> array('messenger_status'),
    );
}

// NOTE: DISABLED CONFIGURATION DOCS AS NONE HAVE BEEN WRITTEN YET
/**
* Returns the URL to a given document
*/
/*
function plugin_getdocumentationurl_messenger($file) {
    global $_CONF;
    
    $lang = COM_getLanguageName();
    $path = $_CONF['path_html'] . 'admin/plugins/messenger/docs/' . $lang . '/' . $file . '.html';
    clearstatcache();
    
    if (!file_exists($path)) {
        $lang = 'english';
    }

    $retval = $_CONF['site_admin_url'] . '/plugins/messenger/docs/' . $lang . '/' . $file . '.html';

    return $retval;
} */

/**
* Provides text for a Configuration tooltip
*
* @param    string  $id     Id of config value
* @return   mixed           Text to use regular tooltip, null to use config 
*                           tooltip hack, or empty string when not available
*/
/*
function plugin_getconfigtooltip_messenger($id) {
    // Use config tooltip hack where tooltip is read from the config documentation
    return;
}*/ 

/**
* Loads config infor with config.class.php
*/
function MSG_loadConfig() {
    global $CONF_MSG;

    $config = config::get_instance();

    if ($config->group_exists('messenger')) {
        $temp = $config->get_config('messenger');
        if (is_array($temp) && (count($temp) > 0)) {
            $CONF_MSG = array_merge($CONF_MSG, $temp);
        }
    }
}

/**
* Gets Geeklog blocks from plugins
*
* Returns data for blocks on a given side and, potentially, for
* a given topic.
*
* @param    string  $side   Side to get blocks for (right or left for now)
* @param    string  $topic  Only get blocks for this topic
* @return   array           array of block data
* @link     http://wiki.geeklog.net/index.php/Dynamic_Blocks
*/
function plugin_getBlocks_messenger($side, $topic = '') {
    return array();
}

function messenger_statusMessage($message = '', $url, $prompt) {
    global $_CONF, $_USER, $LANG_MSG, $CONF_MSG;

    if (empty($prompt)) {
        $prompt = $LANG_MSG['statusmsg2'];
    }

    echo COM_startBlock();
    echo "<font class='alert'><br><p/>{$message}</font>";
    echo "<br><p/>";

    if ($CONF_MSG['automsg'] == 0) {
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
}

/**
 * Replace emoticons in string with formated HTML of smilies.
 * Emoticon mapping to images are defined in a the table.
 * This function will replace all the emoticons in the past string.
 *
 * @param   string  $text  The text
 * @return  string  The text, possibly with emoticons replaced with the HTML img tags for the smilie image.
 */
function msg_replaceEmoticons($text) {
    global $CONF_MSG, $_TABLES;

    $arr_smilies = array();
    $sql = DB_query("SELECT code, smile_url, emoticon FROM {$_TABLES['smilies']} ORDER BY length(code) DESC");

    while (list($code, $icon, $emoticon) = DB_fetchArray($sql)) {
        $text = str_replace(
            $code,
            '<img src="' . $CONF_MSG['SMILIE_URL'] . $icon . '" alt="' . $emoticon . '" title="' . $emoticon . '" border="0">',
            $text
        );
    }

    return $text;
}

/**
 * Replace formatted smilie HTML for emoticons - so message can be edited
 *
 * @param   string  $text  The text, possibly with HTML img tags for the smilie image
 * @return  string  The text, possibly with the replaced smilie emoticon.
 */
function msg_restoreEmoticons($text) {
    global $CONF_MSG, $_TABLES;

    $arr_smilies = array();
    $sql = DB_query("SELECT code, smile_url, emoticon FROM {$_TABLES['smilies']} ORDER BY length(code) DESC");

    while (list($code, $icon, $emoticon) = DB_fetchArray($sql)) {
        // Check for HTML that is formatted the new way and how it was used in earlier releases
        $text = str_replace(
            '<img src="' . $CONF_MSG['SMILIE_URL'] . $icon . '" alt="' . $emoticon . '" title="' . $emoticon .'" border="0">',
            $code,
            $text
        );
        $text = str_replace(
            '<img src=' . $CONF_MSG['SMILIE_URL'] . $icon . ' border="0">',
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
    $query = DB_query("SELECT smilie_id, code, smile_url, emoticon FROM {$_TABLES['smilies']}");

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

        $smilies .= '<a href="javascript:emoticon(\'' . $code . '\')"><img align=absmiddle  vspace="1" src="'
            . $baseurl . $key . '" alt="' . $smilie['code'] . '" title="' . $smilie['code'] . '" border="0"></a> ';
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
    global $_CONF, $_TABLES, $_USER, $CONF_MSG,$LANG_MSG01;

    $subject = msg_preparefordb($subject, 'html');
    $message = msg_preparefordb($message, 'html');

    if ($reply_msgid == '') {
        $reply_msgid = 0;
    }

    $ip = $_SERVER['REMOTE_ADDR'];

    if ($broadcast) {
        $target_uid = "0";
        $now = time();
        DB_query(
            "INSERT INTO {$_TABLES['messenger_msg']} (message, source_uid, subject, datetime, reply_msgid, ip) "
            . "VALUES ('{$message}', {$_USER['uid']}, '{$subject}', {$now}, {$reply_msgid}, '{$ip}')");
        $lastmsg_id = DB_insertID();
        DB_query(
            "INSERT INTO $_TABLES[messenger_dist] (msg_id, target_uid, archive) "
            . "VALUES ({$lastmsg_id}, {$target_uid}, 0)");

        // If admin then allow notifications to be sent to all members
        if (SEC_inGroup('Root') && $CONF_MSG['RootBdcastNotificaton'] && $CONF_MSG['notification']) {
           $query = DB_query("SELECT username, uid FROM {$_TABLES['users']} WHERE uid <> {$_USER['uid']} AND uid > 1");

           while (list($target_user, $target_uid) = DB_fetchARRAY($query)) {
                $query2 = DB_query("SELECT broadcasts, notifications,sitepreference FROM {$_TABLES['messenger_userinfo']} WHERE uid= {$target_uid}");
                list($broadcastblock,$notifyoption,$sitepreference) = DB_fetchArray($query2);

                // Check if user has messenger_userinfo record and possibly disabled notifications
                // Also don't need to send a notification if user has messenger as their default for notifications
                if ((DB_numRows($query2) == 0) || ($broadcastblock == 0 && $notifyoption == 1 && $sitepreference == 0)) {
                    $notifySubject = '' . $_CONF['site_name'] . ' ' . $LANG_MSG01['BROADCAST']. '';
                    $notifyMessage  = $LANG_MSG01['HELLO'] . ' ' . $target_user . ",\n\n";
                    $notifyMessage .= sprintf($LANG_MSG01['LINE1B'], $_USER['username'], $subject);
                    $notifyMessage .= $LANG_MSG01['LINE2'];
                    $notifyMessage .= $LANG_MSG01['LINE3'] . $_CONF['site_name'] . ' ' . $LANG_MSG01['ADMIN'] . "\n";
                    $notifyMessage .= "\n" . $_CONF['site_url'] . "\n";
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

        $now = time();
        DB_query(
            "INSERT INTO {$_TABLES['messenger_msg']} (message, source_uid, subject, datetime, reply_msgid, ip) "
            . "VALUES ('{$message}', {$_USER['uid']}, '{$subject}', {$now}, {$reply_msgid}, '{$ip}')");
        $lastmsg_id = DB_insertID();

        if ($notify) {
            // Send out Notifications to all users on distribution
            foreach ($target_users as $target_user) {
                $target_user = DB_escapeString(trim($target_user));

                if ($target_user != '') {
                    if ($_CONF['show_fullname'] == 1) {
                        $target_uid = DB_getItem($_TABLES['users'], 'uid', "fullname = '{$target_user}'");
                    } else {
                        $target_uid = DB_getItem($_TABLES['users'], 'uid', "username = '{$target_user}'");
                    }

                    $query2 = DB_query("SELECT notifications, sitepreference FROM {$_TABLES['messenger_userinfo']} WHERE uid = {$target_uid}");
                    list($notifyoption,$sitepreference) = DB_fetchArray($query2);

                    // Check if user has messenger_userinfo record and possibly disabled notifications
                    // Also don't need to send a notification if user has messenger as their default for notifications
                    if (DB_numRows($query2) == 0 || (DB_numRows($query2) == 1 && $notifyoption == 1 && $sitepreference == 0)) {
                        DB_query(
                            "INSERT INTO $_TABLES[messenger_dist] (msg_id, target_uid, archive) "
                            . "VALUES ({$lastmsg_id}, {$target_uid}, 0)");
                        $notifySubject = '' . $_CONF['site_name'] . ' ' . $LANG_MSG01['SUBJECT'] . '';
                        $notifyMessage  = $LANG_MSG01['HELLO'] . ' ' . $target_user . ",\n\n";
                        $notifyMessage .= sprintf($LANG_MSG01['LINE1'], $_USER['username'], $subject);
                        $notifyMessage .= $LANG_MSG01['LINE2'];
                        $notifyMessage .= $LANG_MSG01['LINE3'] . $_CONF['site_name'] . ' ' . $LANG_MSG01['ADMIN'] ."\n";
                        $notifyMessage .= "\n" . $_CONF['site_url'] . "\n";
                        msg_sendNotification($target_user, $notifySubject, $notifyMessage, 'messenger');
                    } else {
                        DB_query(
                            "INSERT INTO $_TABLES[messenger_dist] (msg_id, target_uid, archive) "
                            . "VALUES ({$lastmsg_id}, {$target_uid}, 0)");
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

    $sql = DB_query("SELECT sitepreference FROM {$_TABLES['messenger_userinfo']} WHERE uid = {$target_uid}");
    list($sitepreference) = DB_fetchArray($sql);
    $emailaddress = DB_getItem($_TABLES['users'], 'email', "uid = {$target_uid}");

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

    if (version_compare(VERSION, '2.2.1', '>=')) {
        Geeklog\Log::notification($logentry);
    } else {
        $timestamp = strftime('%b %d %H:%M');
        $logfile = $_CONF['path_log'] . 'notification.log';
        @file_put_contents($logfile, "$timestamp,$logentry \n", FILE_APPEND);
    }
}
