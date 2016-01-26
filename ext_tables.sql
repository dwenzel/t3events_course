# from seminars
#
# Table structure for table 'tx_t3events_domain_model_event'
#
CREATE TABLE tx_t3events_domain_model_event (

	targetgroup_desc text NOT NULL,
	requirements text NOT NULL,
	lessons int(11) unsigned DEFAULT '0' NOT NULL,
	tx_extbase_type varchar(255) DEFAULT '' NOT NULL,
	exam_costs double(11,2) DEFAULT '0.00' NOT NULL,
	exam_remarks text NOT NULL,
	degree_type int(11) DEFAULT '0' NOT NULL,
	mode_instruction_form int(11) DEFAULT '0' NOT NULL,

	certificate text NOT NULL,
);


#
# Table structure for table 'tx_t3events_domain_model_performance'
#
CREATE TABLE tx_t3events_domain_model_performance (

	course int(11) unsigned DEFAULT '0' NOT NULL,
	duration varchar(255) DEFAULT '' NOT NULL,
	class_time text NOT NULL,
	tx_extbase_type varchar(255) DEFAULT '' NOT NULL
);



#
# Table structure for table 'tx_t3events_domain_model_certificatetype'
#
CREATE TABLE tx_t3eventscourse_domain_model_certificatetype (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	description text NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_t3events_domain_model_certificate'
#
CREATE TABLE tx_t3eventscourse_domain_model_certificate (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	short_pas1045 varchar(100) DEFAULT '' NOT NULL,
	short_qcat varchar(100) DEFAULT '' NOT NULL,
	description text NOT NULL,
	type int(11) DEFAULT '0' NOT NULL,
	link text NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

