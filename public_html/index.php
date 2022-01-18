<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +-----------------------------------------------------------------------------+
// | glMessenger Plugin 1.0 for Geeklog- The Ultimate OSS Portal                 |
// | Date: November 15, 2003                                                     |
// +-----------------------------------------------------------------------------+
// | Index.php - Main glMessenger program                                        |
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

require_once '../lib-common.php';
require_once $_CONF['path'] . 'plugins/messenger/debug.php';  // Common Debug Code

if (empty($_USER['uid']) || $_USER['uid'] == 1) {
    $display = messenger_statusMessage($LANG_MSG['err01'], $_CONF['site_url'] . '/index.php', $LANG_MSG['err01']);
    $display = COM_createHTMLDocument($display);
    COM_output($display);
    exit();
} else {
    $uid = $_USER['uid'];
}

if (isset($_REQUEST['folder'])) {
    $folder = msg_cleandata($_REQUEST['folder']);
} elseif (isset($_REQUEST['curfolder'])) {
    $folder = msg_cleandata($_REQUEST['curfolder']);
} else {
    $folder = 'inbox';
}

if (isset($_REQUEST['sortoption'])) {
    $sortoption = msg_cleandata($_REQUEST['sortoption']);
} else {
    $sortoption = '2';      // Newest First
}

// Check if the page navigation is being used
$show = (int) Input::fRequest('show', 10);

// Check if page was specified
$page = (int) Input::fRequest('page', 1);

$action = msg_cleandata(Input::request('action', ''));
$mode = msg_cleandata(Input::request('mode', ''));
$id = msg_cleandata(Input::get('id', 0));
$touid = msg_cleandata(Input::request('touid', 0));
$toname = msg_cleandata(Input::request('toname', ''));
$replyid = msg_cleandata(Input::request('replyid', 0));
$userBlockBrdcast = DB_getItem($_TABLES['messenger_userinfo'], "broadcasts", "uid='{$uid}'");
$phpself = $_CONF['site_url'] . '/messenger/index.php';
$rows = '';

// Begin main logic
ob_start();

if ($mode === 'newpm' && $_POST['submit'] == $LANG_MSG['SUBMIT']) {
    if (($toname != '' || isset($_POST['chk_broadcast'])) && isset($_POST['message']) && ($_POST['message'] != '')) {
        $subject = $_POST['subject'];
        $broadcast = (empty($_POST['chk_broadcast'])) ? 0 : 1;
        $timestamp = time();
        $month = date('m', $timestamp);
        $day = date('d', $timestamp);
        $year = date('Y', $timestamp);
        $hour = date('H', $timestamp);
        $min = date('i', $timestamp);

        if (messenger_send($_POST['toname'], $subject, $_POST['message'], $_POST['replyid'], $broadcast)) {
            messenger_statusMessage(sprintf($LANG_MSG['msgsave'], $toname), $phpself, $LANG_MSG['msgreturn']);
        } else {
            messenger_statusMessage(sprintf($LANG_MSG['err03'], $toname), $phpself, $LANG_MSG['msgreturn']);
        }

        $content = ob_get_clean();
        $display = COM_createHTMLDocument($content);
        COM_output($display);
        exit;
    } else {
        echo COM_startBlock($LANG_MSG['ERROR']);
        echo $LANG_MSG['msgerror'];
        echo COM_endBlock();
    }
}

if ($mode === 'delete') {
    if ($id != '') {
        if ($folder === 'OUTBOX') {
            DB_query("DELETE FROM {$_TABLES['messenger_dist']} WHERE (msg_id = {$id})");
            DB_query("DELETE FROM {$_TABLES['messenger_msg']} WHERE (id = {$id})");
        } else {
            DB_query("DELETE FROM {$_TABLES['messenger_dist']} WHERE (msg_id = {$id}) AND ((target_uid = {$_USER['uid']}) OR target_uid = 0)");
        }
        if (DB_count($_TABLES['messenger_dist'], 'msg_id', $id) == 0) {
            DB_query("DELETE FROM {$_TABLES['messenger_msg']} WHERE (id = {$id})");
        }
        messenger_statusMessage($LANG_MSG['msgdelsuccess'], $phpself . '?folder=' . $folder, $LANG_MSG['msgreturn']);
    } else {
        echo COM_startBlock($LANG_MSG['ERROR']);
        echo $LANG_MSG['msgdelerr'];
        echo COM_endBlock("blockfooter-system.thtml");
    }

    $content = ob_get_clean();
    $display = COM_createHTMLDocument($content);
    COM_output($display);
    exit;
}

if ($mode === 'archive') {
    // Check that user has rights
    $source = DB_getItem($_TABLES['messenger_msg'], 'source_uid', "id = {$id}");
    if ($source = $uid || SEC_hasRights('messenger.edit')) {
        DB_query("UPDATE {$_TABLES['messenger_dist']} SET archive = 1 WHERE msg_id = {$id}");
        messenger_statusMessage($LANG_MSG['msgarchive'], $phpself . '?folder=' . $folder, $LANG_MSG['msgreturn']);
    } else {
        messenger_statusMessage($LANG_MSG['err02'], $phpself . '?folder=' . $folder, $LANG_MSG['msgreturn']);
    }

    $content = ob_get_clean();
    $display = COM_createHTMLDocument($content);
    COM_output($display);
    exit;
}

if ($action === 'delall') {
    if ($folder === 'ARCHIVE') {
        $delquery = DB_query(
            "SELECT id FROM {$_TABLES['messenger_msg']} LEFT JOIN {$_TABLES['messenger_dist']} ON id = msg_id "
            . "WHERE (target_uid = {$uid} AND archive = 1)");
    } else {
        $delquery = DB_query(
            "SELECT id FROM {$_TABLES['messenger_msg']} LEFT JOIN {$_TABLES['messenger_dist']} ON id = msg_id "
            . "WHERE (target_uid = {$uid} AND archive = 0)");
    }

    while (list($id) = DB_fetchARRAY($delquery)) {
        DB_query("DELETE FROM {$_TABLES['messenger_dist']} WHERE (msg_id = {$id}) AND ((target_uid = {$_USER['uid']}) OR target_uid = 0)");
        if (DB_count($_TABLES['messenger_dist'], 'msg_id', $id) == 0) {
            DB_query("DELETE FROM {$_TABLES['messenger_msg']} WHERE (id = {$id})");
        }
    }
} elseif ($action === 'delolder') {
    $today = mktime(0, 0, 0, date('m'), date('d'), date('y'));
    if ($folder === 'ARCHIVE') {
        $delquery = DB_query(
            "SELECT id FROM {$_TABLES['messenger_msg']} LEFT JOIN {$_TABLES['messenger_dist']} ON id = msg_id "
            . "WHERE (target_uid = {$uid} AND (datetime < '{$today}'))"
        );
    } else {
        $delquery = DB_query(
            "SELECT id FROM {$_TABLES['messenger_msg']} LEFT JOIN {$_TABLES['messenger_dist']} ON id = msg_id "
            . "WHERE (target_uid = {$uid} AND (datetime < '$today'))");
    }

    while (list($id) = DB_fetchARRAY($delquery)) {
        DB_query("DELETE FROM {$_TABLES['messenger_dist']} WHERE (msg_id = {$id}) AND ((target_uid = {$_USER['uid']}) OR target_uid = 0)");
        if (DB_count($_TABLES[messenger_dist], 'msg_id', $id) == 0) {
            DB_query("DELETE FROM {$_TABLES['messenger_msg']} WHERE (id = {$id})");
        }
    }
} elseif ($action === 'addbuddy') {
    $buddy = (int) Input::fRequest('buddy', 0);
    DB_query("INSERT INTO {$_TABLES['messenger_buddies']} (uid, buddy_id) VALUES ({$_USER['uid']}, {$buddy})");
    if (isset($_GET['fromprofile']) && $_GET['fromprofile'] == '1') {
        COM_redirect($_CONF['site_url'] . "/users.php?mode=profile&amp;uid={$buddy}");
    }
} elseif ($action === 'delbuddy') {
    $buddy = (int) Input::fRequest('buddy', 0);
    DB_query("DELETE FROM {$_TABLES['messenger_buddies']} WHERE uid = {$_USER['uid']} AND buddy_id = {$buddy}");
    if (isset($_GET['fromprofile']) && $_GET['fromprofile'] == '1') {
        COM_redirect($_CONF['site_url'] . "/users.php?mode=profile&amp;uid={$buddy}");
    }
} elseif ($action === 'save_settings') {
    $option1 = (int) Input::fPost('msg_opt1', 0);
    $option2 = (int) Input::fPost('msg_opt2', 0);
    $option3 = (int) Input::fPost('msg_opt3', 0);
    DB_query(
        "UPDATE {$_TABLES['messenger_userinfo']} SET broadcasts = {$option1}, notifications = {$option2}, sitepreference = {$option3} "
        . "WHERE uid = {$_USER['uid']}"
    );
    COM_redirect($_CONF['site_url'] . '/messenger/index.php');
}

// Display the Top Tool Bar
// Determine message counts to show in Navbar

if ($userBlockBrdcast) {   // If user does not want to receive broadcast messages then I can't include them in count
    $inboxquery = DB_query(
        "SELECT COUNT(*) AS count FROM {$_TABLES['messenger_msg']} LEFT JOIN {$_TABLES['messenger_dist']} ON id = msg_id "
        . "WHERE (target_uid = {$uid}) AND archive = 0"
    );
    $archivequery = DB_query(
        "SELECT COUNT(*) AS count FROM {$_TABLES['messenger_msg']} LEFT JOIN {$_TABLES['messenger_dist']} ON id = msg_id "
        . "WHERE (target_uid = {$uid}) AND archive = 1"
    );
} else {
    $inboxquery = DB_query(
        "SELECT COUNT(*) AS count FROM {$_TABLES['messenger_msg']} LEFT JOIN {$_TABLES['messenger_dist']} ON id = msg_id "
        . "WHERE (target_uid = {$uid} OR target_uid = 0) AND archive = 0"
    );
    $archivequery = DB_query(
        "SELECT COUNT(*) AS count FROM {$_TABLES['messenger_msg']} LEFT JOIN {$_TABLES['messenger_dist']} ON id = msg_id "
        . "WHERE (target_uid = {$uid} OR target_uid = 0) AND archive = 1"
    );
}

$outboxquery = DB_query(
    "SELECT COUNT(*) AS count FROM {$_TABLES['messenger_msg']} LEFT JOIN {$_TABLES['messenger_dist']} ON id = msg_id "
    . "WHERE (source_uid = {$uid} AND read_date is NULL)"
);
$sentquery = DB_query(
    "SELECT COUNT(*) AS count FROM {$_TABLES['messenger_msg']} WHERE (source_uid = {$uid})"
);

list($inboxCnt) = DB_fetchArray($inboxquery);
list($outboxCnt) = DB_fetchArray($outboxquery);
list($archiveCnt) = DB_fetchArray($archivequery);
list($sentCnt) = DB_fetchArray($sentquery);

$lang_inbox = $LANG_MSG['INBOX'] . "&nbsp;({$inboxCnt})";
$lang_outbox = $LANG_MSG['OUTBOX'] . "&nbsp;({$outboxCnt})";
$lang_sentbox = $LANG_MSG['SENTBOX'] . "&nbsp;({$sentCnt})";
$lang_archivebox = $LANG_MSG['ARCHIVEBOX'] . "&nbsp;({$archiveCnt})";

$msg_main = COM_newTemplate(CTL_plugin_templatePath('messenger'));
$msg_main->set_file([
    'msg_main'   => 'msg_main.thtml',
    'msg_navbar' => 'msg_mainoptions.thtml',
]);
$msg_main->set_var('selected_folder', $folder);

switch ($folder) {
    case 'SENT' :
        $lang_sentbox = "<b>{$LANG_MSG['SENTBOX']}</b>&nbsp;({$sentCnt})";
        if (empty($replyid)) {
            $query = DB_query(
                "SELECT COUNT(*) AS count FROM {$_TABLES['messenger_msg']} LEFT JOIN {$_TABLES['messenger_dist']} ON id = msg_id "
                . "WHERE (source_uid = {$uid})"
            );
        } else {
            $query = DB_query(
                "SELECT COUNT(*) AS count FROM {$_TABLES['messenger_msg']} LEFT JOIN {$_TABLES['messenger_dist']} ON id = msg_id "
                . "WHERE id = {$replyid}"
            );
        }
        list ($nrows) = DB_fetchArray($query);
        break;

    case 'ARCHIVE' :
        $lang_archivebox = "<b>{$LANG_MSG['ARCHIVEBOX']}</b>&nbsp;({$archiveCnt})";
        $nrows = $archiveCnt;
        break;

    case 'OUTBOX' :
        $lang_outbox = "<b>{$LANG_MSG['OUTBOX']}</b>&nbsp;({$outboxCnt})";
        $nrows = $outboxCnt;
        break;

    default:
        $folder = 'INBOX';
        $lang_inbox = "<b>{$LANG_MSG['INBOX']}</b>&nbsp;({$inboxCnt})";
        $nrows = $inboxCnt;
        break;
}

$numpages = ceil($nrows / $show);
$offset = ($page - 1) * $show;
$base_url = $_CONF['site_url'] . '/messenger/index.php?folder=' . $folder . '&amp;show=' . $show
    . '&amp;page=' . $page . '&amp;sortoption=' . $sortoption;

if ($nrows == 1) {
    $pm_note = sprintf($LANG_MSG['msgprivnote1'], $nrows, $folder);
} else {
    $pm_note = sprintf($LANG_MSG['msgprivnote2'], $nrows, $folder);
}

switch ($sortoption) {
    case 1:
        $orderby = 'ORDER BY datetime asc';
        $sel1 = 'selected';
        $sel2 = '';
        $sel3 = '';
        break;

    case 2:
        $orderby = 'ORDER BY datetime desc';
        $sel1 = '';
        $sel2 = 'selected';
        $sel3 = '';
        break;

    case 3:
        $orderby = 'ORDER BY source_uid asc';
        $sel1 = '';
        $sel2 = '';
        $sel3 = 'selected';
        break;
}

$msg_main->set_var('phpself', $_CONF['site_url'] . '/messenger/index.php');
$msg_main->set_var('site_url', $_CONF['site_url']);
$msg_main->set_var('startblock', COM_startBlock($LANG_MSG['BLOCKHEADER']));
$msg_main->set_var('lang_inbox', $lang_inbox);
$msg_main->set_var('lang_outbox', $lang_outbox);
$msg_main->set_var('lang_sent', $lang_sentbox);
$msg_main->set_var('lang_archive', $lang_archivebox);
$msg_main->set_var('LANG_NEWMESSAGE', $LANG_MSG['NEWMESSAGE']);
$msg_main->set_var('pm_note', $pm_note);
$msg_main->set_var('imgset', $CONF_MSG['imgset']);
$msg_main->set_var('pm', $LANG_MSG['PM']);
$msg_main->set_var('home', $LANG_MSG['HOME']);
$msg_main->set_var('new', $LANG_MSG['NEW']);
$msg_main->set_var('date', $LANG_MSG['DATE']);
$msg_main->set_var('message', $LANG_MSG['MESSAGE']);
$msg_main->set_var('options', $LANG_MSG['OPTIONS']);
$msg_main->set_var('curfolder', $folder);
$msg_main->set_var('LANG_newmsghelp', $LANG_MSG['newmsghelp']);
$msg_main->set_var('LANG_SETTINGS', $LANG_MSG['SETTINGS']);
$msg_main->set_var('rows', $rows);

if ($folder === 'SENT') {
    $msg_main->set_var('show_info', '');
    $msg_main->set_var('info_message', $LANG_MSG['outboxmsg']);
} else {
    $msg_main->set_var('show_info', 'none');
    $msg_main->set_var('info_message', '');
}

if ($folder !== 'SENT') {
    $msg_main->set_var('delall_link', $phpself . '?action=delall&amp;curfolder=' . $folder);
    $msg_main->set_var('LANG_delall', $LANG_MSG['DELALL']);
    $msg_main->set_var('delolder_link', $phpself . '?action=delolder&amp;curfolder=' . $folder);
    $msg_main->set_var('LANG_delolder', $LANG_MSG['DELOLDER']);
}

if ($action !== 'newpm' && $mode !== 'newpm') {
    $pagenavigation = COM_printPageNavigation($base_url, $page, $numpages);
    if ($pagenavigation == '') {
        $msg_main->set_var('show_navigation', 'none');
    }
    $msg_main->set_var('pagenavigation', COM_printPageNavigation($base_url, $page, $numpages));
    $msg_main->set_var('LANG_sortedby', $LANG_MSG03['SORTBY']);
    $msg_main->set_var('LANG_oldest', $LANG_MSG03['OLDFIRST']);
    $msg_main->set_var('LANG_newest', $LANG_MSG03['NEWFIRST']);
    $msg_main->set_var('LANG_members', $LANG_MSG03['MEMBER']);
    $msg_main->set_var('LANG_buddyadmin', $LANG_MSG03['BUDDYADMIN']);
    $msg_main->set_var('sel1', $sel1);
    $msg_main->set_var('sel2', $sel2);
    $msg_main->set_var('sel3', $sel3);
    $msg_main->parse('msg_options', 'msg_navbar', true);
}

$archive = '';
$delete = '';
$footernote = '';
$msg_main->parse('output', 'msg_main');
echo $msg_main->finish($msg_main->get_var('output'));

if ($action === 'newpm' || $mode === 'newpm') {
    if (isset($_POST['subject'])) {
        $subject = $_POST['subject'];
    } elseif (!empty($replyid)) {
        $subject = DB_getItem($_TABLES['messenger_msg'], 'subject', "id = '{$replyid}'");
        if (strpos($subject, $LANG_MSG['RE']) === false) {
            $subject = $LANG_MSG['RE'] . "&nbsp;{$subject}";
        }
    } else {
        $subject = '';
    }

    $buddies = '';
    $buddyquery = DB_query(
        "SELECT buddy_id, username, fullname FROM {$_TABLES['messenger_buddies']} buddies "
        . "LEFT JOIN {$_TABLES['users']} users on buddies.buddy_id = users.uid "
        . "WHERE buddies.uid = {$_USER['uid']} ORDER BY username"
    );

    if (!DB_error() && (DB_numRows($buddyquery) > 0)) {
        while ($A = DB_fetchArray($buddyquery)) {
            if ($_CONF['show_fullname'] == 1) {
                $buddies .= '<a href=\'javascript:add_name("' . $A['fullname'] . '","' . $A['buddy_id'] . '")\'>' . $A['fullname'] . '</a><br>';
            } else {
                $buddies .= '<a href=\'javascript:add_name("' . $A['username'] . '","' . $A['buddy_id'] . '")\'>' . $A['username'] . '</a><br>';
            }
        }
    }

    $msg_new = COM_newTemplate(CTL_plugin_templatePath('messenger'));
    $msg_new->set_file(['msg_new' => 'msg_new.thtml']);
    $rows = '';

    if (isset($_POST['submit']) && ($_POST['submit'] == $LANG_MSG['PREVIEW'])) {
        echo '<br><p>';

        if (is_callable('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
            $message = stripslashes($message);
        }

        if ($CONF_MSG['smiliesEnabled']) {
            $message = msg_replaceEmoticons($_POST['message']);
        } else {
            $message = $_POST['message'];
        }

        if (is_callable('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
            $message = stripslashes($message);
            $subject = stripslashes($subject);
        }

        $msg_row = COM_newTemplate(CTL_plugin_templatePath('messenger'));
        $msg_row->set_file(['msg_row' => 'msg_row.thtml']);
        $msg_row->set_var('LANG_subject', $LANG_MSG['SUBJECT']);
        $msg_row->set_var('subject', $subject);
        $msg_row->set_var('LANG_whom', $LANG_MSG['TO']);
        $msg_row->set_var('name', $toname);
        $msg_row->set_var('imgset', $CONF_MSG['imgset']);
        $msg_row->set_var('message', nl2br($message));
        $msg_row->set_var('delete', $delete);
        $msg_row->set_var('archive', $archive);
        $msg_row->set_var('preview_on', '<!--');
        $msg_row->set_var('preview_off', '-->');
        $msg_row->parse('output', 'msg_row');
        $rows .= $msg_row->finish($msg_row->get_var('output'));
        echo $msg_row->finish($msg_row->get_var('output'));

        if (is_callable('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
            $msg_new->set_var('preview', stripslashes($_POST['message']));
        } else {
            $msg_new->set_var('preview', $_POST['message']);
        }
    }

    $msg_new->set_var('phpself', $phpself);
    $msg_new->set_var('imgset', $CONF_MSG['imgset']);

    $msg_new->set_var('LANG_to', $LANG_MSG['TO']);
    $msg_new->set_var('LANG_subject', $LANG_MSG['SUBJECT']);
    $msg_new->set_var('subject', $subject);

    if ($CONF_MSG['smiliesEnabled']) {
        $msg_new->set_var('smilies', msg_showsmilies());
    } else {
        $msg_new->set_var('smilies', '');
    }

    $msg_new->set_var('toname', $toname);
    $msg_new->set_var('touid', $touid);
    $msg_new->set_var('buddies', @$buddies);
    $msg_new->set_var('LANG_memberslist', $LANG_MSG['MEMBERSLIST']);
    $msg_new->set_var('LANG_mybuddies', $LANG_MSG['MYBUDDIES']);
    $msg_new->set_var('LANG_members', $LANG_MSG['MEMBERS']);
    $msg_new->set_var('LANG_submit', $LANG_MSG['SUBMIT']);
    $msg_new->set_var('LANG_preview', $LANG_MSG['PREVIEW']);

    if (SEC_hasRights('messenger.broadcast')) {
        if (isset($_POST['chk_broadcast'])) {
            $msg_new->set_var('broadcast_option', '<label for="chk01">' . $LANG_MSG['BROADCAST'] . '</label>: <input type="Checkbox" name="chk_broadcast" id="chk01" checked>');
        } else {
            $msg_new->set_var('broadcast_option', '<label for="chk01">' . $LANG_MSG['BROADCAST'] . '</label>: <input type="Checkbox" name="chk_broadcast" id="chk01">');
        }
    }

    $msg_new->set_var('message', $LANG_MSG['MESSAGE']);
    $msg_new->set_var('replyid', $replyid);
    $msg_new->set_var('endblock', COM_endBlock());
    $msg_new->set_var('show_smilies', $LANG_MSG['show_smilies']);
    $msg_new->set_var('hide_smilies', $LANG_MSG['hide_smilies']);
    $msg_new->parse('output', 'msg_new');
    echo $msg_new->finish($msg_new->get_var('output'));
} elseif ($action === 'settings') {
    $uid = (int) $_USER['uid'];

    if (DB_count($_TABLES['messenger_userinfo'], 'uid', $uid) == 0) {
        $CONF_MSG['USER_PMBLOCK'] = empty($CONF_MSG['USER_PMBLOCK']) ? 0 : 1;
        $CONF_MSG['USER_NOTIFY'] = empty($CONF_MSG['USER_NOTIFY']) ? 0 : 1;
        $CONF_MSG['USER_INBOX'] = empty($CONF_MSG['USER_INBOX']) ? 0 : 1;
        DB_query(
            "INSERT INTO {$_TABLES['messenger_userinfo']} (uid, broadcasts, notifications, sitepreference) "
            . "VALUES ({$uid}, {$CONF_MSG['USER_PMBLOCK']}, {$CONF_MSG['USER_NOTIFY']}, {$CONF_MSG['USER_INBOX']})"
        );
    }

    $result = DB_query(
        "SELECT broadcasts, notifications, sitepreference FROM {$_TABLES['messenger_userinfo']} "
        . "WHERE uid = {$uid}"
    );
    list($option1, $option2, $option3) = DB_fetchArray($result);
    $T = COM_newTemplate(CTL_plugin_templatePath('messenger'));
    $T->set_file(['settings' => 'msg_settings.thtml']);
    $T->set_var([
        'action'                      => $_CONF['site_url'] . '/messenger/index.php?action=save_settings',
        'option1'                     => (empty($option1) ? '' : ' checked="checked"'),
        'option2'                     => (empty($option2) ? '' : ' checked="checked"'),
        'option3'                     => (empty($option3) ? '' : ' checked="checked"'),
        'lang_title'                  => $LANG_MSG['SETTINGS'],
        'lang_broadcasts'             => $LANG_MSG['lang_broadcasts'],
        'lang_help_broadcasts'        => $LANG_MSG['help_broadcasts'],
        'lang_notifications'          => $LANG_MSG['lang_notifications'],
        'lang_help_notifications'     => $LANG_MSG['help_notifications'],
        'lang_sitenotifications'      => $LANG_MSG['lang_sitenotifications'],
        'lang_help_sitenotifications' => $LANG_MSG['help_sitenotifications'],
        'lang_submit'                 => $LANG_MSG['SUBMIT'],
        'lang_cancel'                 => $LANG_MSG['CANCEL'],
    ]);
    $T->parse('output', 'settings');
    echo $T->finish($T->get_var('output'));
} else {
    if ($mode == '') {
        switch ($folder) {
            case 'SENT' :
                if (empty($replyid)) {
                    $query = DB_query(
                        "SELECT id, source_uid, target_uid, message, subject, datetime, read_date, reply_msgid FROM {$_TABLES['messenger_msg']} "
                        . "LEFT JOIN {$_TABLES['messenger_dist']} ON id = msg_id "
                        . "WHERE (source_uid = {$uid}) {$orderby} LIMIT {$offset}, {$show}"
                    );
                } else {
                    $query = DB_query(
                        "SELECT id, source_uid, target_uid, message, subject, datetime, read_date, reply_msgid FROM {$_TABLES['messenger_msg']} "
                        . "LEFT JOIN {$_TABLES['messenger_dist']} ON id = msg_id "
                        . "WHERE (id = {$replyid}) {$orderby} LIMIT {$offset}, {$show}"
                    );
                }
                break;

            case 'ARCHIVE' :
                $query = DB_query(
                    "SELECT id, source_uid, target_uid, message, subject, datetime, read_date, reply_msgid FROM {$_TABLES['messenger_msg']} "
                    . "LEFT JOIN {$_TABLES['messenger_dist']} ON id = msg_id "
                    . "WHERE (target_uid = {$uid} OR target_uid = 0) AND archive = 1 {$orderby} LIMIT {$offset}, {$show}"
                );
                break;

            case 'OUTBOX' :
                $query = DB_query(
                    "SELECT id, source_uid, target_uid, message, subject, datetime, read_date, reply_msgid FROM {$_TABLES['messenger_msg']} "
                    . "LEFT JOIN {$_TABLES['messenger_dist']} ON id = msg_id "
                    . "WHERE (source_uid = {$uid} AND read_date is NULL) {$orderby} LIMIT {$offset}, {$show}");
                break;

            default:
                $folder = 'INBOX';
                $query = DB_query(
                    "SELECT id, source_uid, target_uid, message, subject, datetime, read_date, reply_msgid FROM {$_TABLES['messenger_msg']} "
                    . "LEFT JOIN {$_TABLES['messenger_dist']} ON id = msg_id "
                    . "WHERE (target_uid = {$uid} OR target_uid = 0) AND archive = 0 {$orderby} LIMIT {$offset}, {$show}"
                );
                break;
        }

        // Display all Broadcast Messages and Private Messages for this user
        $numMessages = 0;
        $cssid = 1;
        $rows = '';

        while (list($msg_id, $source, $target, $message, $subject, $datetime, $read_date, $reply_msgid) = DB_fetchARRAY($query)) {
            if (($target == '0' && !$userBlockBrdcast) || $target > 0) {
                $numMessages++;
                $long_date = strftime('%b %d %Y @ %H:%M', $datetime);
                $datePostedMsg = $LANG_MSG['prompt03'] . $long_date . "'";
                $delete = '';
                $reply = '';
                $archive = '';

                $msg_row = COM_newTemplate(CTL_plugin_templatePath('messenger'));
                $msg_row->set_file(['msg_row' => 'msg_row.thtml']);
                $msg_row->set_var('imgset', $CONF_MSG['imgset']);
                $msg_row->set_var('spacing', '1');
                $msg_row->set_var('cssid', $cssid);
                $msg_row->set_var('date', $long_date);

                // If message has not been read - then update the field with the current timestamp
                if (empty($read_date) && ($folder !== 'OUTBOX' && $folder !== 'SENT')) {
                    DB_query(
                        "UPDATE {$_TABLES['messenger_dist']} SET read_date = UNIX_TIMESTAMP() "
                        . "WHERE msg_id = {$msg_id} AND (target_uid = {$uid} OR target_uid = 0)"
                    );
                    $newmsg_flag = '<img src="' . $CONF_MSG['imgset'] . '/pm_new.gif" border="0" alt="' . $LANG_MSG['NEW'] . '"><br>';
                } else {
                    $newmsg_flag = '';
                }

                // Setup message if there is atleast 1 broadcast message
                if ($target == 0) {
                    if ($source == $uid || (SEC_inGroup('Root'))) {
                        $footernote = $LANG_MSG['prompt02'];
                    } else {
                        $footernote = $LANG_MSG['prompt02b'];
                    }
                }

                // Set name for message listing

                if ((($folder === 'SENT') && ($target > 0)) || (($folder === 'OUTBOX') && ($source == $uid))) {
                    $uname_sql = DB_query("SELECT uid, username, fullname FROM {$_TABLES['users']} WHERE uid = {$target}");
                    $N = DB_fetchArray($uname_sql);

                    if ($_CONF['show_fullname'] == 1 && $N['fullname'] != '') {
                        $name = '<a href="' . $_CONF['site_url'] . '/users.php?mode=profile&amp;uid=' . $target . '">' . $N['fullname'] . '</a>';
                    } else {
                        $name = '<a href="' . $_CONF['site_url'] . '/users.php?mode=profile&amp;uid=' . $target . '">' . $N['username'] . '</a>';
                    }
                } elseif ($source > 1) {
                    $uname_sql = DB_query("SELECT uid, username, fullname FROM {$_TABLES['users']} WHERE uid = {$source}");
                    $N = DB_fetchArray($uname_sql);

                    if ($_CONF['show_fullname'] == 1 && $N['fullname'] != '') {
                        $name = '<a href="' . $_CONF['site_url'] . '/users.php?mode=profile&amp;uid=' . $source . '">' . $N['fullname'] . '</a>';
                    } else {
                        $name = '<a href="' . $_CONF['site_url'] . '/users.php?mode=profile&amp;uid=' . $source . '">' . $N['username'] . '</a>';
                    }
                } else {
                    $name = $LANG_MSG['ANONYMOUS'];
                }

                // Set Delete Option
                if ((SEC_hasRIGHTS('messenger.edit') || ($target == $uid)) && ($folder !== 'SENT')) {
                    $deletelink = '<a class="btn1" href="' . $phpself . '?mode=delete&amp;id=' . $msg_id
                        . '&amp;folder=' . $folder . '"><img src="' . $CONF_MSG['imgset']
                        . '/pm_delete.gif" align="absmiddle" border="0" alt="' . $LANG_MSG['DELETEMSG'] . '">';
                    $msg_row->set_var('link1_end', '</a>');
                } elseif (($source == $uid) && ($folder === 'OUTBOX')) {
                    $deletelink = '<a class="btn1" href="' . $phpself . '?mode=delete&amp;id=' . $msg_id
                        . '&folder=' . $folder . '"><img src="' . $CONF_MSG['imgset']
                        . '/pm_delete.gif" align="absmiddle" border="0" alt="' . $LANG_MSG['DELETEMSG'] . '">';
                    $msg_row->set_var('link1_end', '</a>');
                } else {
                    $deletelink = '<div class="msgDisabledBtn">';
                    $msg_row->set_var('link1_end', '</div>');
                }

                // Set Reply Option
                if (($source > 1) && ($folder === 'INBOX' || $folder === 'ARCHIVE')) {
                    if ($_CONF['show_fullname'] == 1) {
                        $toname = $N['fullname'];
                    } else {
                        $toname = $N['username'];
                    }

                    $replylink = '<a class="btn1" href="' . $phpself . '?action=newpm&amp;toname=' . $toname
                        . ';&amp;touid=' . $N['uid'] . '&amp;replyid=' . $msg_id . '"><img src="' . $CONF_MSG['imgset']
                        . '/pm_reply.gif" align="absmiddle" border="0" alt="' . $LANG_MSG['REPLYMSG'] . '">';
                    $msg_row->set_var('link3_end', '</a>');
                } else {
                    $replylink = '<div class="msgDisabledBtn">';
                    $msg_row->set_var('link3_end', '</div>');
                }

                // Set Archive Option
                if (($source > 1) && ($folder === 'INBOX') && (($target == $uid) || (SEC_hasRights('messenger.edit')))) {
                    $archivelink = '<a class="btn1" href="' . $phpself . '?mode=archive&id=' . $msg_id
                        . '"><img src="' . $CONF_MSG['imgset'] . '/pm_archive.gif" align="absmiddle" border="0" alt="'
                        . $LANG_MSG['ARCHIVEMSG'] . '">';
                    $msg_row->set_var('link2_end', '</a>');
                } else {
                    $archivelink = '<div class="msgDisabledBtn">';
                    $msg_row->set_var('link2_end', '</div>');
                }

                // Set View Original Message Link - active if this is a reply to one of your messages
                if ($reply_msgid > 0 && DB_count($_TABLES['messenger_msg'], 'id', $reply_msgid)) {
                    $view_sentmsg = sprintf(
                        $LANG_MSG['VIEWORIGINAL'],
                        $_CONF['site_url'] . '/messenger/index.php?folder=SENT&amp;replyid=' . $reply_msgid
                    );
                } else {
                    $view_sentmsg = '';
                }

                // Set Broadcast Display flag
                $buddylink = '';
                $broadcast_flag = ($target == 0)
                    ? '<IMG SRC="' . $CONF_MSG['imgset'] . '/pm_broadcast.gif" border="0" align="absmiddle" alt="' . $LANG_MSG['BROADCAST_MSG'] . '">'
                    : '';

                if ($source != $_USER['uid']) {
                    if (DB_count($_TABLES['messenger_buddies'], ['uid', 'buddy_id'], [$_USER['uid'], $source]) > 0) {
                        $LANG_buddy = $LANG_MSG['DELBUDDY'];
                        $buddylink = '<a href="' . $phpself . '?action=delbuddy&amp;buddy=' . $source . '&sortoption=' . $sortoption
                            . '"><img align="absmiddle" src="' . $CONF_MSG['imgset'] . '/del_buddy.gif" border="0" ALT="' . $LANG_buddy . '">';
                    } else {
                        $LANG_buddy = $LANG_MSG['ADDBUDDY'];
                        $buddylink = '<a href="' . $phpself . '?action=addbuddy&amp;buddy=' . $source . '&sortoption=' . $sortoption
                            . '"><img align="absmiddle" src="' . $CONF_MSG['imgset'] . '/add_buddy.gif" border="0" ALT="' . $LANG_buddy . '">';
                    }
                }

                if ($CONF_MSG['smiliesEnabled']) {
                    $message = msg_replaceEmoticons($message);
                }

                if ($folder === 'INBOX' || $folder === 'ARCHIVE') {
                    $msg_row->set_var('LANG_whom', $LANG_MSG['FROM']);
                } else {
                    $msg_row->set_var('LANG_whom', $LANG_MSG['TO']);
                }

                $msg_row->set_var('new', $newmsg_flag);
                $msg_row->set_var('broadcast', $broadcast_flag);
                $msg_row->set_var('name', $name);
                $msg_row->set_var('viewlink', $view_sentmsg);
                $msg_row->set_var('message', $message);
                $msg_row->set_var('LANG_subject', $LANG_MSG['SUBJECT']);
                $msg_row->set_var('subject', $subject);
                $msg_row->set_var('LANG_buddy', $LANG_MSG['MYBUDDIES']);
                $msg_row->set_var('buddylink', $buddylink);
                $msg_row->set_var('replylink', $replylink);
                $msg_row->set_var('LANG_reply', $LANG_MSG['REPLY']);
                $msg_row->set_var('deletelink', $deletelink);
                $msg_row->set_var('LANG_delete', $LANG_MSG['DELETE']);
                $msg_row->set_var('archivelink', $archivelink);
                $msg_row->set_var('LANG_archive', $LANG_MSG['ARCHIVE']);
                $msg_row->parse('output', 'msg_row');
                $rows .= $msg_row->finish($msg_row->get_var('output'));
                echo $msg_row->finish($msg_row->get_var('output'));
                $cssid = ($cssid == 1) ? 2 : 1;
            }
        }
    }
}

if ($action !== 'newpm' && $mode !== 'newpm') {
    $msg_footer = COM_newTemplate(CTL_plugin_templatePath('messenger'));
    $msg_footer->set_file(['msg_footer' => 'msg_footer.thtml']);
    $msg_footer->set_var('pagenavigation', COM_printPageNavigation($base_url, $page, $numpages));

    if ($footernote == '') {
        $msg_footer->set_var('show_footermsg', 'none');
    }

    $msg_footer->set_var('footernote', $footernote);
    $msg_footer->set_var('endblock', COM_endBlock());
    $msg_footer->set_var('imgset', $CONF_MSG['imgset']);
    $msg_footer->parse('output', 'msg_footer');
    echo $msg_footer->finish($msg_footer->get_var('output'));
} else {
    echo '</td></tr></table>';
}

$content = ob_get_clean();
$display = COM_createHTMLDocument($content);
COM_output($display);
