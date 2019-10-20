<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +-----------------------------------------------------------------------------+
// | glMessenger Plugin 1.0 for Geeklog- The Ultimate OSS Portal                 |
// | Date: November 15, 2003                                                     |
// +-----------------------------------------------------------------------------+
// | english.php - English Language Filem                                        |
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
//

$LANG_MSG00 = array (
    'usermenu'          => 'Private Messages',
    'plugin'            => 'Plugin',
    'access_denied'     => 'Access Denied',
    'access_denied_msg' => 'Only Root Users have Access to this Page.  Your user name and IP have been recorded.',
    'admin'             => 'Plugin Admin',
    'install_header'    => 'Install/Uninstall Plugin',
    'installed'         => 'The glMessenger Plugin and Smilie Editor are now installed.<p />Next Steps:<br>1) Update your Theme(s) and CSS as per the install notes<br>2) Create a notification.log file if you want to log notifications<p><i>Enjoy,<br><a href="MAILTO:langmail@sympatico.ca">Blaine</a></i>',
    'uninstalled'       => 'The Plugin is Not Installed',
    'install_success'   => 'Installation Successful', 
    'install_failed'    => 'Installation Failed -- See your error log to find out why.',
    'uninstall_msg'     => 'Plugin Successfully Uninstalled',
    'install'           => 'Install',
    'uninstall'         => 'Remove',
    'enabled'           => '<br>Plugin is installed and enabled.<br>Disable first if you want to De-Install it.<p>',
    'warning'           => 'Messenger De-Install Warning',
    'editor'            => 'Return to Plugin Editor',

);

$LANG_MSG  = array(
    'err01'             => 'Access not permitted to this feature',
    'err02'             => 'Attempt to perform an illegal operation',
    'err03'             => 'Error: One of more members names are invalid',
    'BLOCKHEADER'       => 'Private Messages',
    'RE'                => 'Re:',
    'ERROR'             => 'Error!',
    'FROM'              => 'From',
    'TO'                => 'To',
    'SUBJECT'           => 'Subject',
    'PM'                => 'PM',
    'NEW_PM'            => 'NewPM',
    'NEW'               => 'New',
    'NEWMESSAGE'        => 'New Message',
    'DATE'              => 'Date',
    'ARCHIVE'           => '&nbsp;Archive&nbsp;',
    'ARCHIVEMSG'        => 'Archive Message',
    'REPLY'             => '&nbsp;Reply&nbsp;',
    'REPLYMSG'          => 'Reply to sender',
    'DELETE'            => '&nbsp;Delete&nbsp;',
    'DELETEMSG'         => 'Delete Message',
    'INBOX'             => 'Inbox',
    'OUTBOX'            => 'Outbox',
    'SENTBOX'           => 'Sent',
    'ARCHIVEBOX'        => 'Archive',
    'REMOVE'            => 'Delete this message',
    'SUBMIT'            => 'Submit',
    'CANCEL'            => 'Cancel',
    'PREVIEW'           => 'Preview',
    'MESSAGE'           => 'Message',
    'MEMBERS'           => 'Members',
    'MEMBERSLIST'       => 'Memberslist',
    'ANONYMOUS'         => 'Guest',
    'BROADCAST'         => 'Broadcast',
    'BROADCAST_MSG'     => 'Broadcast Message',
    'EXPIRE_MSG'        => 'Message will auto delete on %s',
    'OPTIONS'           => 'Options',
    'DELALL'            => 'Delete All',
    'DELALLMSG'         => 'Delete all messages',
    'DELOLDER'          => 'Delete older',
    'DELOLDERMSG'       => 'Delete all messages before today',
    'VIEWORIGINAL'      => '<hr>View&nbsp;<a href="%s">Original </a>&nbsp;Message',
    'MYBUDDIES'         => 'My Buddies',
    'MSGFAVORITES'      => 'Messenger Favorites',
    'ADDBUDDY'          => 'Add Buddy',
    'DELBUDDY'          => 'Delete Buddy',
    'HOME'              => 'Home',
    'SETTINGS'          => 'Settings',
    'prompt01'          => 'the page does not automatically reload, please click <a href=%s>here</a>',
    'prompt02'          => '* Broadcast message. Only originator or Admin can delete.<br>&nbsp;Delete will remove all copies.',
    'prompt02b'         => '* Broadcast message. Only originator or Admin can delete.',
    'prompt03'          => 'Sent on: ',
    'statusmsg1'        => '%s Click <a href="%s">here</a> to continue.',
    'statusmsg2'        => 'to continue',
    'statusmsg3'        => 'This page should return automatically. If you do not wish to wait, click <a href="%s">here</a>',
    'msgsent'           => 'Message Sent!',
    'msgsave'           => 'Your message to %s has been sent.',
    'msgreturn'         => 'to return to your inbox.',
    'msgerror'          => 'Your message has not been sent. Please go <a href="javascript:history.back()">back</a> and make sure you have all fields filled.',
    'msgdelok'          => 'Delete Successful',
    'msgdelsuccess'     => 'You have sucessfully deleted this message.',
    'msgdelerr'         => 'The message has not been deleted. Please go <a href=\"javascript:history.back()\">back</a> and choose one.',
    'msgpriv'           => 'Private Messages',
    'msgprivnote1'      => 'You have %s private message in your %s folder.',
    'msgprivnote2'      => 'You have %s private messages in your %s folder.',
    'msgto'             => 'To :',
    'msgmembers'        => 'Member List.',
    'msgarchive'        => 'Message has been moved to your Archive folder',
    'newmsghelp'        => 'Create a new message',
    'lang_broadcasts'   => 'PM Broadcasts',
    'help_broadcasts'   => 'Block Messenger Broadcasts',
    'lang_notifications'       => 'Notifications',
    'help_notifications'       => 'Enable email notifications for new Private Messages or subscribed updates',
    'lang_sitenotifications'   => 'Messenger as default',
    'help_sitenotifications'   => 'Send all notifications to my Messenger inbox',
    'outboxmsg'         => 'Outbox messages can not be deleted. They represent the messages still in receipient\'s INBOX.',
    'show_smilies'      => 'Show Smilies',
    'hide_smilies'      => 'Hide Smilies',
);


// Language used for Notification Feature
$LANG_MSG01 = array (
    'HELLO'          => "Hello",
    'ADMIN'          => "Site Administrator",
    'SUBJECT'        => "- New Private Message Notifiction",
    'BROADCAST'      => "- Broadcast Message Notifiction",
    'LINE1'          => "You have a new Private message from fellow site member: %s\nSubject:%s",
    'LINE1B'         => "There is a new broadcast message waiting in your private message area from: %s\nSubject: %s",
    'LINE2'          => "\n \nYou are receiving this because you requested to be notified of any new Private Messages.\n\n",
    'LINE3'          => "Have a great day!\n"
);

// Language used for Admin screens
$LANG_MSG02 = array (
    'BLOCKHEADER'     => "Smilie Administration",
    'IMAGE'           => "Image",
    'CODE'            => "Emoticon",
    'DESCRIPTION'     => "Description",
    'ADDSMILIE'       => "Add Smilie",
    'EDIT'            => "Edit",
    'DELETE'          => "Delete",
    'ADDPROMPT'       => "Add New Smilie",
    'ADDSUBMIT'       => "Add New Smilie",
    'EDITPROMPT'      => "Edit Smilie",
    'EDITSUBMIT'      => "Update Smilie",
    'FILENAME'        => "Image Filename",
    'EDIT'            => "Edit",
    'HELPMSG1'        => 'You are able to Add, Edit or Delete the allowable smilies. It is possible to have multiple emoticons for a single smilie image. To add a new smilie, upload the image to your smilie images directory on you server and use Add link to add a new emoticon record. Use Edit to change the emoticon or change the assigned image.'
);

// Language used for Sortby Filter in main message view
$LANG_MSG03 = array (
    'BUDDYADMIN'  => "Buddy Admin",
    'SORTBY'      => "Sorted by",
    'OLDFIRST'    => "Oldest First",
    'NEWFIRST'    => "Newest First",
    'MEMBER'      => "Member Name"
);

// Language used in the Buddy Admin screen
$LANG_MSG04 = array (
    'MAINHEADER'      => "Buddy Administration",
    'HEADER1'         => "Available Members",
    'HEADER2'         => "My Buddies",
    'ADD'             => "Add",
    'REMOVE'          => "Remove",
    'CANCEL'          => "Cancel",
    'SAVE'           => "Save"
);


// Language used to send message to new members - intro message
$LANG_MSG05 = array (
    'subject'     => "Welcome to my site!",
    'message'     => "Thank you for joining portalparts.com. I hope that you enjoy being a member :) If you have any questions, please search the FAQ or forum first.<p />Regards,<br><i>Site Administrator</i>"
);
