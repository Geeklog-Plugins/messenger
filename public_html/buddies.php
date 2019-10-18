<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +-----------------------------------------------------------------------------+
// | glMessenger Plugin 1.0 for Geeklog- The Ultimate OSS Portal                 |
// | Date: November 15, 2003                                                     |
// +-----------------------------------------------------------------------------+
// | buddies.php - Support program to administrate messenger buddies             |
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
// | This program is OpenSource but not FREE, unauthorized distribution is       |
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
//

require_once("../lib-common.php"); // Path to your lib-common.php
require_once($_CONF['path'] . 'plugins/messenger/debug.php');  // Common Debug Code

function msg_selectbuddies($uid, $allusers=false) {
    global $_USER,$_CONF,$_TABLES;
    $retval = '';
    if($allusers) {    // Show all site members - else users in selected group
        $result = DB_query( "SELECT uid,username,fullname from {$_TABLES['users']} ORDER BY username" );
        while(list($uid,$username,$fullname) = DB_fetchArray($result)) {
            if( DB_count($_TABLES['messenger_buddies'], array('uid','buddy_id'), array($_USER['uid'],$uid)) == 0 ) {
                if ($_CONF['show_fullname'] == 1 AND trim($fullname) != '') {
                    $retval .= '<option value="' . $uid . '">'. $fullname . '</option>';
                } elseif ($_CONF['show_fullname'] == 0) {
                    $retval .= '<option value="' . $uid . '">'. $username . '</option>';
                }

            }
        }
    } else {
        $result = DB_query ("SELECT user.uid,user.username,user.fullname FROM {$_TABLES['users']} user, {$_TABLES['messenger_buddies']} buddy WHERE user.uid=buddy.buddy_id AND buddy.uid={$_USER['uid']} ORDER BY username" );
        while(list($uid,$username,$fullname) = DB_fetchArray($result)) {
            if ($_CONF['show_fullname'] == 1 AND trim($fullname) != '') {
                $retval .= '<option value="' . $uid . '">'. $fullname . '</option>';
            } elseif ($_CONF['show_fullname'] == 0) {
                $retval .= '<option value="' . $uid . '">'. $username . '</option>';
            }
        }
    }
    return $retval;
}


function editbuddies() {
    global $_CONF,$LANG_MSG04,$_TABLES,$_USER,$CONF_MSG,$LANG_MSG;

    $uid = $_USER['uid'];
    $userBlockBrdcast = DB_getItem($_TABLES['messenger_userinfo'],"broadcasts", "uid='$uid'");

    if ($userBlockBrdcast)  {   // If user does not want to receive broadcast messages then I can't include them in count
        $inboxquery   = DB_query("SELECT count(*) as count FROM {$_TABLES['messenger_msg']} LEFT JOIN {$_TABLES['messenger_dist']} ON  id = msg_id WHERE (target_uid='$uid') AND archive='0' ");
        $archivequery = DB_query("SELECT count(*) as count FROM {$_TABLES['messenger_msg']} LEFT JOIN {$_TABLES['messenger_dist']} ON  id = msg_id WHERE (target_uid='$uid') AND archive='1' ");
    } else {
        $inboxquery   = DB_query("SELECT count(*) as count FROM {$_TABLES['messenger_msg']} LEFT JOIN {$_TABLES['messenger_dist']} ON  id = msg_id WHERE (target_uid='$uid' OR target_uid='0') AND archive='0' ");
        $archivequery = DB_query("SELECT count(*) as count FROM {$_TABLES['messenger_msg']} LEFT JOIN {$_TABLES['messenger_dist']} ON  id = msg_id WHERE (target_uid='$uid' OR target_uid='0') AND archive='1' ");
    }
    $outboxquery  = DB_query("SELECT COUNT(*) as count FROM {$_TABLES['messenger_msg']} LEFT JOIN {$_TABLES['messenger_dist']} ON  id = msg_id WHERE (source_uid='$uid' AND read_date is NULL) ");
    $sentquery    = DB_query("SELECT count(*) as count FROM {$_TABLES['messenger_msg']} WHERE (source_uid='$uid')");

    list($inboxCnt) = DB_fetchArray($inboxquery);
    list($outboxCnt) = DB_fetchArray($outboxquery);
    list($archiveCnt) = DB_fetchArray($archivequery);
    list($sentCnt) = DB_fetchArray($sentquery);

    $lang_inbox       = $LANG_MSG['INBOX'] ."&nbsp;($inboxCnt)";
    $lang_outbox      = $LANG_MSG['OUTBOX'] ."&nbsp;($outboxCnt)";
    $lang_sentbox     = $LANG_MSG['SENTBOX'] ."&nbsp;($sentCnt)";
    $lang_archivebox  = $LANG_MSG['ARCHIVEBOX'] ."&nbsp;($archiveCnt)";

    $retval = COM_startBlock ($LANG_MSG04['MAINHEADER'] , '', COM_getBlockTemplate ('_admin_block', 'header'));
    $buddymembers = new Template($_CONF['path_layout'] . 'messenger');
    $buddymembers->set_file (array ('buddymembers'=>'msg_buddyadmin.thtml'));
    $buddymembers->set_var ('site_url',$_CONF['site_url']);
    $buddymembers->set_var ('actionurl',$_CONF['site_url'] .'/messenger/index.php');
    $buddymembers->set_var ('imgset', $CONF_MSG['imgset'] );
    $buddymembers->set_var ('LANG_sitemembers',$LANG_MSG04['HEADER1']);
    $buddymembers->set_var ('LANG_buddies',$LANG_MSG04['HEADER2']);
    $buddymembers->set_var ('sitemembers', msg_selectbuddies(@$group,true) );
    $buddymembers->set_var ('buddy_list', msg_selectbuddies(@$group) );
    $buddymembers->set_var ('lang_inbox', $lang_inbox);
    $buddymembers->set_var ('lang_outbox', $lang_outbox);
    $buddymembers->set_var ('lang_sent', $lang_sentbox);
    $buddymembers->set_var ('lang_archive', $lang_archivebox);
    $buddymembers->set_var ('LANG_add',$LANG_MSG04['ADD']);
    $buddymembers->set_var ('LANG_remove',$LANG_MSG04['REMOVE']);
    $buddymembers->set_var ('LANG_cancel',$LANG_MSG04['CANCEL']);
    $buddymembers->set_var ('LANG_save',$LANG_MSG04['SAVE']);
    $buddymembers->parse ('output', 'buddymembers');
    $retval .= $buddymembers->finish($buddymembers->get_var('output'));
    $retval .= COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer'));
    return $retval;

}

function savebuddies($buddylist) {
    global $_USER,$_CONF, $_TABLES;
    $uid = $_USER['uid'];

    // Delete all the current buddy records for this user and add all the selected ones
    DB_query("DELETE FROM {$_TABLES['messenger_buddies']} WHERE uid='$uid'");
    $buddy = explode("|",$buddylist);
    for( $i = 0; $i < count($buddy); $i++ )    {
        $buddy_uid = COM_applyFilter($buddy[$i]);
        DB_query("INSERT INTO {$_TABLES['messenger_buddies']} (uid,buddy_id) VALUES ('$uid', '$buddy_uid')");
    }
    COM_redirect($_CONF['site_url'] . '/messenger/index.php');
}

// MAIN

if (isset($_REQUEST['mode']) && ($_REQUEST['mode'] === 'savebuddies')) {
    $display = savebuddies($_POST['buddylist']);
} else {
    $display = editbuddies();
}

$display = COM_createHTMLDocument($display);
COM_output($display);
