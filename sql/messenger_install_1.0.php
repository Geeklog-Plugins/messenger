<?php

#
# Table structure for table `gl_messenger_dist`
#

$_SQL[] = "CREATE TABLE {$_TABLES['messenger_dist']} (
  msg_id mediumint(8) NOT NULL default '0',
  target_uid mediumint(8) NOT NULL default '0',
  read_date int(11) default NULL,
  archive tinyint(1) NOT NULL default '0',
  KEY target_uid (target_uid),
  KEY msg_id (msg_id)
) TYPE=MyISAM COMMENT='Message distribution table for Messenger Plugin';";


#
# Table structure for table `gl_messenger_msg`
#

$_SQL[] = "CREATE TABLE {$_TABLES['messenger_msg']} (
  id mediumint(8) NOT NULL auto_increment,
  source_uid mediumint(8) NOT NULL default '0',
  subject varchar(64) NOT NULL default '',
  message longtext NOT NULL,
  datetime int(11) NOT NULL default '0',
  reply_msgid mediumint(8) NOT NULL default '0',
  ip varchar(16) NOT NULL default '',
  PRIMARY KEY  (id),
  KEY source_uid (source_uid)
) TYPE=MyISAM COMMENT='Main Table for the Messenger Plugin';";



$_SQL[] = "CREATE TABLE {$_TABLES['smilies']} (
  smilie_id smallint(5) unsigned NOT NULL auto_increment,
  code varchar(50) default NULL,
  smile_url varchar(100) default NULL,
  emoticon varchar(75) default NULL,
  PRIMARY KEY  (smilie_id)
) TYPE=MyISAM;";


$_SQL[] = "CREATE TABLE {$_TABLES['messenger_userinfo']} (
  uid mediumint(8) NOT NULL default '0',
  broadcasts tinyint(1) NOT NULL default '1',
  notifications tinyint(1) NOT NULL default '1',
  sitepreference tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`uid`)
) TYPE=MyISAM;";


# Table structure for table `gl_messenger_buddies`

$_SQL[] = "CREATE TABLE {$_TABLES['messenger_buddies']} (
  uid mediumint(8) NOT NULL default '0',
  buddy_id mediumint(8) NOT NULL default '0',
  KEY uid (`uid`),
  KEY buddy_id (`buddy_id`)
) TYPE=MyISAM COMMENT='Messenger buddy list for a user';";

#
# Dumping data for table `{$_TABLES['smilies']}`
#

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


?>
