<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +-----------------------------------------------------------------------------+
// | glMessenger Plugin 1.0 for Geeklog- The Ultimate OSS Portal                 |
// | Date: November 15, 2003                                                     |
// +-----------------------------------------------------------------------------+
// | editsmilies.php - glMessenger Smilie Admin program                          |
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

use Geeklog\Input;

require_once '../../../lib-common.php';
require_once $_CONF['path'] . 'plugins/messenger/debug.php';  // Common Debug Code

ob_start();
echo COM_startBlock($LANG_MSG02['BLOCKHEADER']);

if (Input::post('edit') == $LANG_MSG02['EDITSUBMIT']) {
    $pos = strrpos($_POST['sel_smilie'], '/') + 1;
    $image_filename = strtolower(substr($_POST['sel_smilie'], $pos));
    DB_query(
        "UPDATE {$_TABLES['smilies']} SET code = '{$_POST['smile_code']}', smile_url = '{$image_filename}', emoticon ='{$_POST['smile_desc']}' "
        . "WHERE smilie_id = {$_POST['id']} "
    );
    echo '<p>Smilie Record Updated ...';
}

if (Input::post('add') == $LANG_MSG02['ADDSUBMIT']) {
    $pos = strrpos($_POST['sel_smilie'], '/') + 1;
    $image_filename = strtolower(substr($_POST['sel_smilie'], $pos));
    DB_query(
        "INSERT INTO {$_TABLES['smilies']} (code, smile_url, emoticon) VALUES ('{$_POST['smile_code']}', '$image_filename', '{$_POST['smile_desc']}')"
    );
    echo '<p>Smilie Record Added ...';
}

$phpself = $_CONF['site_admin_url'] . '/plugins/messenger/editsmilies.php';

function fill_smilieSelect($currentSmilie = '')
{
    global $_CONF, $CONF_MSG;

    $baseUrl = $CONF_MSG['SMILIE_URL'];
    $dirPath = $CONF_MSG['SMILIE_PATH'];

    if ($handle = opendir($dirPath)) {
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != "..") {
                $filesArr[] = trim($file);
            }
        }
        closedir($handle);
    }

    $smilies_select = '';
    foreach ($filesArr as $file) {
        $smilies_select .= '<option value="' . $baseUrl . $file . '" ';
        if ($file == $currentSmilie) {
            $smilies_select .= 'selected="selected"';
        }
        $smilies_select .= '>' . $file . '</option>';
    }

    return $smilies_select;
}


function display_smilies()
{
    global $_CONF, $CONF_MSG, $_TABLES, $phpself, $LANG_MSG02;

    $baseUrl = $CONF_MSG['SMILIE_URL'];
    $query = DB_query("SELECT smilie_id, code, smile_url, emoticon FROM {$_TABLES['smilies']} ORDER BY smilie_id");
    $header = COM_newTemplate(CTL_plugin_templatePath('messenger', 'admin'));
    $header->set_file(['header' => 'smiliedisp_header.thtml']);
    $header->set_var('help_msg', $LANG_MSG02['HELPMSG1']);
    $header->set_var('phpself', $phpself);
    $header->set_var('LANG_image', $LANG_MSG02['IMAGE']);
    $header->set_var('LANG_code', $LANG_MSG02['CODE']);
    $header->set_var('LANG_description', $LANG_MSG02['DESCRIPTION']);
    $header->set_var('LANG_addsmilie', $LANG_MSG02['ADDSMILIE']);
    $header->parse('output', 'header');
    $retval = $header->finish($header->get_var('output'));

    while (list($smilie_id, $code, $smile_url, $emoticon) = DB_fetchARRAY($query)) {
        $cssId = $smilie_id % 2 + 1;
        $row = COM_newTemplate(CTL_plugin_templatePath('messenger', 'admin'));
        $row->set_file(['row' => 'smiliedisp_row.thtml']);
        $row->set_var('phpself', $phpself);
        $row->set_var('cssid', $cssId);
        $row->set_var('smilie_url', $baseUrl . $smile_url);
        $row->set_var('code', $code);
        $row->set_var('emoticon', $emoticon);
        $row->set_var('smilie_id', $smilie_id);
        $row->set_var('LANG_edit', $LANG_MSG02['EDIT']);
        $row->set_var('LANG_delete', $LANG_MSG02['DELETE']);
        $row->parse('output', 'row');
        $retval .= $row->finish($row->get_var('output'));
    }

    $retval .= '</table>';

    return $retval;
}

function add_smilie()
{
    global $_CONF, $CONF_MSG, $_TABLES, $phpself, $LANG_MSG02;

    $currentSmilie = $CONF_MSG['SMILIE_URL'] . 'icon_smile.gif';
    $smilies_select = fill_smilieSelect();
    $addSmilie = COM_newTemplate(CTL_plugin_templatePath('messenger', 'admin'));
    $addSmilie->set_file(['addsmilie' => 'addsmilie.thtml']);
    $addSmilie->set_var('phpself', $phpself);
    $addSmilie->set_var('smilies_select', $smilies_select);
    $addSmilie->set_var('currentsmilie', $currentSmilie);
    $addSmilie->set_var('emoticon', $emoticon);
    $addSmilie->set_var('smilie_id', $smilie_id);
    $addSmilie->set_var('LANG_add', $LANG_MSG02['ADDPROMPT']);
    $addSmilie->set_var('LANG_filename', $LANG_MSG02['FILENAME']);
    $addSmilie->set_var('LANG_description', $LANG_MSG02['DESCRIPTION']);
    $addSmilie->set_var('LANG_filename', $LANG_MSG02['FILENAME']);
    $addSmilie->set_var('LANG_emoticon', $LANG_MSG02['CODE']);
    $addSmilie->set_var('LANG_addsmilie', $LANG_MSG02['ADDSUBMIT']);
    $addSmilie->parse('output', 'addsmilie');

    return $addSmilie->finish($addSmilie->get_var('output'));
}

function edit_smilie($id)
{
    global $_CONF, $_TABLES, $phpself, $LANG_MSG02, $CONF_MSG;

    $baseUrl = $CONF_MSG['SMILIE_URL'];
    $query = DB_query("SELECT code, smile_url, emoticon FROM {$_TABLES['smilies']} WHERE smilie_id = {$id} ");
    list($code, $smile_url, $emoticon) = DB_fetchARRAY($query);
    if (!empty($smile_url)) {
        $currentSmilie = $baseUrl . $smile_url;
    } else {
        $currentSmilie = $baseUrl . 'icon_smile.gif';
    }

    $smilies_select = fill_smilieSelect($smile_url);

    $editSmilie = COM_newTemplate(CTL_plugin_templatePath('messenger', 'admin'));
    $editSmilie->set_file(['editsmilie' => 'editsmilie.thtml']);
    $editSmilie->set_var('phpself', $phpself);
    $editSmilie->set_var('smilies_select', $smilies_select);
    $editSmilie->set_var('currentsmilie', $currentSmilie);
    $editSmilie->set_var('code', $code);
    $editSmilie->set_var('emoticon', $emoticon);
    $editSmilie->set_var('id', $id);
    $editSmilie->set_var('LANG_edit', $LANG_MSG02['EDITPROMPT']);
    $editSmilie->set_var('LANG_filename', $LANG_MSG02['FILENAME']);
    $editSmilie->set_var('LANG_description', $LANG_MSG02['DESCRIPTION']);
    $editSmilie->set_var('LANG_filename', $LANG_MSG02['FILENAME']);
    $editSmilie->set_var('LANG_emoticon', $LANG_MSG02['CODE']);
    $editSmilie->set_var('LANG_editsmilie', $LANG_MSG02['EDITSUBMIT']);
    $editSmilie->parse('output', 'editsmilie');

    return $editSmilie->finish($editSmilie->get_var('output'));
}

$id = (int) Input::fGet('id', 0);
$action = Input::request('action');

switch ($action) {
    case 'delete':
        DB_query("DELETE FROM {$_TABLES['smilies']} WHERE smilie_id = {$id}");
        echo display_smilies();
        break;

    case 'edit':
        echo edit_smilie($id);
        break;

    case 'new':
        echo add_smilie();
        break;

    default:
        echo display_smilies();
        break;

}

echo COM_endBlock();
$content = ob_get_clean();
$content = COM_createHTMLDocument($content);
COM_output($content);
