<?php

// +---------------------------------------------------------------------------+
// | Universal Plugin 1.0 for Geeklog - The Ultimate Weblog                    |
// +---------------------------------------------------------------------------+
// | install.php                                                               |
// |                                                                           |
// | This file installs the data structures for the Messenger Plugin           |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2002 by the following authors:                              |
// |                                                                           |
// | Author:                                                                   |
// | Constructed with the Universal Plugin                                     |
// | Copyright (C) 2002 by the following authors:                              |
// | Tom Willett                 -    tomw@pigstye.net                         |
// | Blaine Lang                 -    geeklog@langfamily.ca                    |
// | The Universal Plugin is based on prior work by:                           |
// | Tony Bibbs                  -    tony@tonybibbs.com                       |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is free software; you can redistribute it and/or             |
// | modify it under the terms of the GNU General Public License               |
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
// | GNU General Public License for more details.                              |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// |                                                                           |
// +---------------------------------------------------------------------------+

require_once '../../../lib-common.php';
require_once $_CONF['path'] . 'plugins/messenger/config.php';
require_once $_CONF['path'] . 'plugins/messenger/functions.inc';

// Universal plugin install variables
// Change these to match your plugin
$pi_name = 'messenger';                                     // Plugin name
$pi_version = $CONF_MSG['version'];                         // Plugin Version
$gl_version = '2.2.0';                                      // GL Version plugin for
$pi_url = 'https://github.com/Geeklog-Plugins/messenger';   // Plugin Homepage

// Default data
// Insert table name and sql to insert default data for your plugin.
$DEFVALUES = array();

// Security Feature to add
// Fill in your security features here
// Note you must add these features to the uninstall routine in function.inc so that they will
// be removed when the uninstall routine runs.
// You do not have to use these particular features.  You can edit/add/delete them
// to fit your plugins security model
$NEWFEATURE = array();
$NEWFEATURE['messenger.edit']        = "Messenger Admin Rights";
$NEWFEATURE['messenger.user']        = "Messenger User";
$NEWFEATURE['messenger.broadcast']   = "Ability to send Broadcast Messages";
$NEWFEATURE['smilie.edit']           = "Ability to admin Smilies";


/**
* Checks the requirements for this plugin and if it is compatible with this
* version of Geeklog.
*
* @return   boolean     true = proceed with install, false = not compatible
*
*/
function plugin_compatible_with_this_geeklog_version ()
{
    return true;
}

// Only let Root users access this page
if (!SEC_inGroup('Root')) {
    // Someone is trying to illegally access this page
    COM_errorLog("Someone has tried to illegally access the messenger install/uninstall page.  User id: {$_USER['uid']}, Username: {$_USER['username']}, IP: $REMOTE_ADDR",1);
    $display = COM_startBlock($LANG_MSG00['access_denied'])
        . $LANG_MSG00['access_denied_msg']
        . COM_endBlock();
    $content = COM_createHTMLDocument($display);
    COM_output($content);
    exit;
}
 
/**
* Puts the datastructures for this plugin into the Geeklog database
*
* Note: Corresponding uninstall routine is in functions.inc
* 
* @return    boolean    True if successful False otherwise
*
*/
function plugin_install_now()
{
    global $pi_name, $pi_version, $gl_version, $pi_url, $NEWTABLE, $DEFVALUES, $NEWFEATURE;
    global $_TABLES, $_CONF,$_ENV;

    COM_errorLog("Attempting to install the $pi_name Plugin",1);
    $uninstall_plugin = 'plugin_uninstall_' . $pi_name;

    // Create the Plugins Tables
    require_once $_CONF['path'] . 'plugins/messenger/sql/messenger_install_1.0.php';
    $progress = '';

    foreach ($_SQL as $sql) {
        $progress .= "executing " . $sql . "<br>\n";
        COM_errorLOG("executing " . $sql);
        DB_query($sql);

        if (DB_error()) {
            COM_errorLog('Error Creating a table', 1);
            $uninstall_plugin('DeletePlugin');
            return false;
        }
    }

    COM_errorLog('Success - Created tables', 1);

    // Insert Default Data
    foreach ($DEFVALUES as $table => $sql) {
        COM_errorLog("Inserting default data into $table table",1);
        DB_query($sql,1);
        if (DB_error()) {
            COM_errorLog("Error inserting default data into $table table",1);
            $uninstall_plugin ();
            return false;
            exit;
        }
        COM_errorLog("Success - inserting data into $table table",1);
    }
    
    // Create the plugin admin security group
    COM_errorLog("Attempting to create $pi_name admin group", 1);
    DB_query("INSERT INTO {$_TABLES['groups']} (grp_name, grp_descr) "
        . "VALUES ('$pi_name Admin', 'Users in this group can administer the $pi_name plugin')",1);
    if (DB_error()) {
        plugin_install_now();
        return false;
        exit;
    }
    COM_errorLog('...success',1);
    $group_id = DB_insertId();
    
    // Save the grp id for later uninstall
    COM_errorLog('About to save group_id to vars table for use during uninstall',1);
    DB_query("INSERT INTO {$_TABLES['vars']} VALUES ('{$pi_name}_admin', $group_id)",1);
    if (DB_error()) {
        $uninstall_plugin ();
        return false;
        exit;
    }
    COM_errorLog('...success',1);
    
    // Add plugin Features
    foreach ($NEWFEATURE as $feature => $desc) {
        COM_errorLog("Adding $feature feature",1);
        DB_query("INSERT INTO {$_TABLES['features']} (ft_name, ft_descr) "
            . "VALUES ('$feature','$desc')",1);
        if (DB_error()) {
            COM_errorLog("Failure adding $feature feature",1);
            $uninstall_plugin ();
            return false;
            exit;
        }
        $feat_id = DB_insertId();
        COM_errorLog("Success",1);
        COM_errorLog("Adding $feature feature to admin group",1);
        DB_query("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ($feat_id, $group_id)");
        if (DB_error()) {
            COM_errorLog("Failure adding $feature feature to admin group",1);
            $uninstall_plugin ();
            return false;
            exit;
        }
        COM_errorLog("Success",1);
    }        
    
    // OK, now give Root users access to this plugin now! NOTE: Root group should always be 1
    COM_errorLog("Attempting to give all users in Root group access to $pi_name admin group",1);
    DB_query("INSERT INTO {$_TABLES['group_assignments']} VALUES ($group_id, NULL, 1)");
    if (DB_error()) {
        $uninstall_plugin ();
        return false;
        exit;
    }

    // Register the plugin with Geeklog
    COM_errorLog("Registering $pi_name plugin with Geeklog", 1);
    DB_delete($_TABLES['plugins'],'pi_name','messenger');
    DB_query("INSERT INTO {$_TABLES['plugins']} (pi_name, pi_version, pi_gl_version, pi_homepage, pi_enabled) "
        . "VALUES ('$pi_name', '$pi_version', '$gl_version', '$pi_url', 1)");

    if (DB_error()) {
        $uninstall_plugin ();
        return false;
        exit;
    }

    DB_query("INSERT INTO {$_TABLES['vars']} VALUES ('{$pi_name}_status', 1)",1);

    /* DO NOT REMOVE OR CHANGE THE FOLLOWING CODE UNDER ANY CONDITION */
    /* This Plugin requires a license to be installed and information collected is ONLY used to track that license */
    /* Blaine Lang: glmessenger author */
    $message =  'Completed plugin install: ' .date('m d Y',time()) . "   AT " . date('H:i', time()) . "\n";
    $message .= 'Site: ' . $_CONF['site_url'] . ' and Sitename: ' . $_CONF['site_name'] . "\n";
    $message .= 'Admin: ' . $_CONF['site_mail'] . "\n";
    $message .= 'Hostname: ' . @$_ENV['HOSTNAME'] . ' and RemoteAddress: ' . @$_ENV['REMOTE_ADDR'];
    @mail('glmessenger@portalparts.com','glMessenger Install successfull',$message);

    COM_errorLog("Succesfully installed the $pi_name Plugin!",1);
    return true;
}

// MAIN
$display = '';

if ($_REQUEST['action'] == 'uninstall') {
    $uninstall_plugin = 'plugin_uninstall_' . $pi_name;
    if ($uninstall_plugin ()) {
        COM_redirect($_CONF['site_admin_url'] . '/plugins.php?msg=45');
    } else {
        COM_redirect($_CONF['site_admin_url'] . '/plugins.php?msg=73');
    }
} else if (DB_count ($_TABLES['plugins'], 'pi_name', $pi_name) == 0) {
    // plugin not installed
    if (plugin_compatible_with_this_geeklog_version ()) {
        if (plugin_install_now ()) {
            COM_redirect($_CONF['site_admin_url'] . '/plugins.php?msg=44');
        } else {
            COM_redirect($_CONF['site_admin_url'] . '/plugins.php?msg=72');
        }
    } else {
        // plugin needs a newer version of Geeklog
        $display = COM_startBlock($LANG32[8])
                 . '<p>' . $LANG32[9] . '</p>'
                 . COM_endBlock();
    }
} else {
    // plugin already installed
    $display = COM_startBlock($LANG32[6])
             . '<p>' . $LANG32[7] . '</p>'
             . COM_endBlock();
}

$display = COM_createHTMLDocument($display);
COM_output($display);
