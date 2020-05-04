<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +-----------------------------------------------------------------------------+
// | glMessenger Plugin 1.0 for Geeklog- The Ultimate OSS Portal                 |
// | Date: November 15, 2003                                                     |
// +-----------------------------------------------------------------------------+
// | memberlist.php - Support program to show memberslist in a window            |
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

require_once '../lib-common.php';

$charset = COM_getCharset();

$sql = "SELECT uid, username, fullname 
	FROM {$_TABLES['users']} 
	WHERE (uid > 1) AND (uid <> {$_USER['uid']}) 
	AND (status = " . USER_ACCOUNT_ACTIVE . " OR status = " . USER_ACCOUNT_NEW_EMAIL . " OR status = " . USER_ACCOUNT_NEW_PASSWORD . ") 
	ORDER BY username";

$sql = DB_query($sql);
header('Content-Type: text/html;' . $charset);
echo <<<HTML
<!DOCTYPE html>
<html>
<head>
<title>{$LANG_MSG['MEMBERS']}</title>
<link rel="stylesheet" href="{$_CONF['site_url']}/layout/{$_CONF['theme']}/style.css" type="text/css">
<script type="text/javascript">
<!--
function add_name(name,uid)
{
opener.window.top.document.newpm.toname.value += name + ";";
opener.window.top.document.newpm.touid.value += uid + "";
//return true;
}
//-->
</script>
</head>
<body class="msgText">
<div style="text-align: center; font-size: small;"><strong>{$_CONF['site_name']} {$LANG_MSG['MEMBERS']}</strong></div>
<table style="width: 100%; border-collapse: collapse;" class="msgText">
HTML;

while ($A = DB_fetchArray($sql)) {
    $uid = $A['uid'];
    
    if ($_CONF['show_fullname'] == 1 && trim($A['fullname']) != '') {
        $name = $A['fullname'];
    } else {
        $name = $A['username'];
    }

    echo '<tr><td align="center>" class="msgText">&raquo; <a href="javascript:add_name(\'' . $name . '\', \'' . $uid . '\')">'
        . htmlspecialchars($name, ENT_QUOTES, $charset) . '</a></td></tr>';
}

echo <<<HTML
</table>
<hr>
<div style="text-align: center;"><input type="button" value="Close" onClick="window.close()"></div>
</body>
</html>
HTML;
