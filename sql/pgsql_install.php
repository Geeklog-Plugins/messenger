<?php

// +-----------------------------------------------------------------------------+
// | glMessenger Plugin 1.0 for Geeklog- The Ultimate OSS Portal                 |
// | Date: November 15, 2003                                                     |
// +-----------------------------------------------------------------------------+
// | pgsql_install.php                                                           |
// +-----------------------------------------------------------------------------+
// | Copyright (C) 2003-2019 by the following authors:                           |
// |                                                                             |
// | glMessenger Plugin Author:                                                  |
// | Blaine Lang   -  blaine@portalparts.com                                     |
// | Kenji ITO     -  mystralkk AT gmail DOT com                                 |
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

$_SQL = [];

// Table structure for table `gl_messenger_dist`
$_SQL[] = "CREATE TABLE {$_TABLES['messenger_dist']} (
  msg_id INT NOT NULL DEFAULT 0,
  target_uid INT NOT NULL DEFAULT 0,
  read_date INT DEFAULT NULL,
  archive SMALLINT NOT NULL DEFAULT 0
)";
$_SQL[] = "CREATE UNIQUE INDEX messenger_dist_idx ON {$_TABLES['messenger_dist']} (target_uid, msg_id)";

// Table structure for table `gl_messenger_msg`
$_SQL[] = "CREATE TABLE {$_TABLES['messenger_msg']} (
  id SERIAL,
  source_uid INT NOT NULL DEFAULT 0,
  subject VARCHAR(64) NOT NULL DEFAULT '',
  message TEXT NOT NULL,
  datetime INT NOT NULL DEFAULT 0,
  reply_msgid INT NOT NULL DEFAULT 0,
  ip VARCHAR(16) NOT NULL DEFAULT '',
  PRIMARY KEY (id)
)";

$_SQL[] = "CREATE TABLE {$_TABLES['smilies']} (
  smilie_id SERIAL,
  code VARCHAR(50) DEFAULT NULL,
  smile_url VARCHAR(100) DEFAULT NULL,
  emoticon VARCHAR(75) DEFAULT NULL,
  PRIMARY KEY (smilie_id)
);";

$_SQL[] = "CREATE TABLE {$_TABLES['messenger_userinfo']} (
  uid INT NOT NULL DEFAULT 0,
  broadcasts SMALLINT NOT NULL DEFAULT 1,
  notifications SMALLINT NOT NULL DEFAULT 1,
  sitepreference SMALLINT NOT NULL DEFAULT 0,
  PRIMARY KEY (uid)
);";

// Table structure for table `gl_messenger_buddies`
$_SQL[] = "CREATE TABLE {$_TABLES['messenger_buddies']} (
  uid INT NOT NULL DEFAULT 0,
  buddy_id INT NOT NULL DEFAULT 0
)";
$_SQL[] = "CREATE INDEX messenger_buddies_idx ON {$_TABLES['messenger_buddies']} (uid, buddy_id)";

// Dumping data for table `{$_TABLES['smilies']}`
$_SQL[] = "INSERT INTO {$_TABLES['smilies']} VALUES (1, ':D', 'icon_biggrin.gif', 'Very Happy');";
$_SQL[] = "INSERT INTO {$_TABLES['smilies']} VALUES (2, ':)', 'icon_smile.gif', 'Smile');";
$_SQL[] = "INSERT INTO {$_TABLES['smilies']} VALUES (3, ':(', 'icon_sad.gif', 'Sad');";
$_SQL[] = "INSERT INTO {$_TABLES['smilies']} VALUES (4, ':o', 'icon_surprised.gif', 'Surprised');";
$_SQL[] = "INSERT INTO {$_TABLES['smilies']} VALUES (5, ':eek:', 'icon_surprised.gif', 'Surprised');";
$_SQL[] = "INSERT INTO {$_TABLES['smilies']} VALUES (6, ':shock:', 'icon_eek.gif', 'Shocked');";
$_SQL[] = "INSERT INTO {$_TABLES['smilies']} VALUES (7, ':?', 'icon_confused.gif', 'Confused');";
$_SQL[] = "INSERT INTO {$_TABLES['smilies']} VALUES (8, '8)', 'icon_cool.gif', 'Cool');";
$_SQL[] = "INSERT INTO {$_TABLES['smilies']} VALUES (9, ':cool:', 'icon_cool.gif', 'Cool');";
$_SQL[] = "INSERT INTO {$_TABLES['smilies']} VALUES (10, ':lol:', 'icon_lol.gif', 'Laughing');";
$_SQL[] = "INSERT INTO {$_TABLES['smilies']} VALUES (11, ':x', 'icon_mad.gif', 'Mad');";
$_SQL[] = "INSERT INTO {$_TABLES['smilies']} VALUES (12, ':mad:', 'icon_mad.gif', 'Mad');";
$_SQL[] = "INSERT INTO {$_TABLES['smilies']} VALUES (13, ':P', 'icon_razz.gif', 'Razz');";
$_SQL[] = "INSERT INTO {$_TABLES['smilies']} VALUES (14, ':oops:', 'icon_redface.gif', 'Embarassed');";
$_SQL[] = "INSERT INTO {$_TABLES['smilies']} VALUES (15, ':cry:', 'icon_cry.gif', 'Crying or Very sad');";
$_SQL[] = "INSERT INTO {$_TABLES['smilies']} VALUES (16, ':evil:', 'icon_evil.gif', 'Evil or Very Mad');";
$_SQL[] = "INSERT INTO {$_TABLES['smilies']} VALUES (17, ':roll:', 'icon_rolleyes.gif', 'Rolling Eyes');";
$_SQL[] = "INSERT INTO {$_TABLES['smilies']} VALUES (18, ':wink:', 'icon_wink.gif', 'Wink');";
$_SQL[] = "INSERT INTO {$_TABLES['smilies']} VALUES (19, ';)', 'icon_wink.gif', 'Wink');";
$_SQL[] = "INSERT INTO {$_TABLES['smilies']} VALUES (20, ':!:', 'icon_exclaim.gif', 'Exclamation');";
$_SQL[] = "INSERT INTO {$_TABLES['smilies']} VALUES (21, ':?:', 'icon_question.gif', 'Question');";
$_SQL[] = "INSERT INTO {$_TABLES['smilies']} VALUES (22, ':idea:', 'icon_idea.gif', 'Idea');";
$_SQL[] = "INSERT INTO {$_TABLES['smilies']} VALUES (23, ':arrow:', 'icon_arrow.gif', 'Arrow');";
$_SQL[] = "INSERT INTO {$_TABLES['smilies']} VALUES (24, ':|', 'icon_neutral.gif', 'Neutral');";
$_SQL[] = "INSERT INTO {$_TABLES['smilies']} VALUES (25, ':mrgreen:', 'icon_mrgreen.gif', 'Mr. Green');";
