#
# Table structure for table 'tx_dakosyreservations_domain_model_reservation'
#
CREATE TABLE tx_dakosyreservations_domain_model_reservation (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	status int(11) DEFAULT '0' NOT NULL,
	company int(11) unsigned DEFAULT '0',
	contact int(11) unsigned DEFAULT '0',
	participants int(11) unsigned DEFAULT '0' NOT NULL,
	notifications int(11) unsigned DEFAULT '0' NOT NULL,
	lesson int(11) unsigned DEFAULT '0',
	privacy_statement_accepted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	offers_accepted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	contact_is_participant tinyint(4) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
 KEY language (l10n_parent,sys_language_uid)

);


#
# Table structure for table 'tx_dakosyreservations_reservation_participants_person_mm'
#
CREATE TABLE tx_dakosyreservations_reservation_participants_person_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);

#
# Table structure for table 'tx_dakosyreservations_domain_model_company'
#
CREATE TABLE tx_dakosyreservations_domain_model_company (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	address text NOT NULL,
	zip varchar(255) DEFAULT '' NOT NULL,
	city varchar(255) DEFAULT '' NOT NULL,
	country varchar(255) DEFAULT '' NOT NULL,
	tx_extbase_type varchar(255) DEFAULT '' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

# from seminars
#
# Table structure for table 'tx_t3events_domain_model_event'
#
CREATE TABLE tx_t3events_domain_model_event (

	abstract text NOT NULL,
	goals text NOT NULL,
	targetgroup_desc text NOT NULL,
	requirements text NOT NULL,
	audience int(11) unsigned DEFAULT '0' NOT NULL,
	lessons int(11) unsigned DEFAULT '0' NOT NULL,
	newUntil int(10) unsigned DEFAULT '0' NOT NULL,
	archivedate int(10) unsigned DEFAULT '0' NOT NULL,
	tx_extbase_type varchar(255) DEFAULT '' NOT NULL,

	listview_exclusion tinyint(1) unsigned DEFAULT '0' NOT NULL,
	export_openqcat tinyint(1) unsigned DEFAULT '0' NOT NULL,
	export_wis tinyint(1) unsigned DEFAULT '0' NOT NULL,
	export_bison tinyint(1) unsigned DEFAULT '0' NOT NULL,
	export_rce tinyint(1) unsigned DEFAULT '0' NOT NULL,
	export_ea tinyint(1) unsigned DEFAULT '0' NOT NULL,
	export_print tinyint(1) unsigned DEFAULT '0' NOT NULL,

	exam_costs double(11,2) DEFAULT '0.00' NOT NULL,
	exam_remarks text NOT NULL,
	degree_type int(11) DEFAULT '0' NOT NULL,
	mode_instructionform int(11) DEFAULT '0' NOT NULL,

	certificate varchar(255) default '',
	certificate_desc text NOT NULL,
	list_view_image tinytext NOT NULL,
	image_gallery tinytext NOT NULL,
	testimonials tinytext NOT NULL,
	branch tinytext NOT NULL,
	course_contacts tinytext NOT NULL,
	contact_person tinytext NOT NULL,
	partner tinytext NOT NULL,
	categories tinytext NOT NULL,
	program_agenda int(11) DEFAULT '0' NOT NULL,
);

#
# Table structure for table 'tx_wispascourse_course_courseschedules_mm'
#
#
CREATE TABLE tx_t3events_domain_model_event_programagenda_mm (
	uid_local int(11) DEFAULT '0' NOT NULL,
	uid_foreign int(11) DEFAULT '0' NOT NULL,
	tablenames varchar(30) DEFAULT '' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,
	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);


#
# Table structure for table 'tx_dakosyreservations_domain_model_audience'
#
CREATE TABLE tx_dakosyreservations_domain_model_audience (

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
# Table structure for table 'tx_t3events_domain_model_performance'
#
CREATE TABLE tx_t3events_domain_model_performance (

	course int(11) unsigned DEFAULT '0' NOT NULL,

	deadline int(11) DEFAULT '0' NOT NULL,
	date_end int(11) DEFAULT '0' NOT NULL,
	registration_begin int(11) DEFAULT '0' NOT NULL,
	duration varchar(255) DEFAULT '' NOT NULL,
	price double(11,2) DEFAULT '0.00' NOT NULL,
	places int(11) DEFAULT '0' NOT NULL,
	free_of_charge tinyint(1) unsigned DEFAULT '0' NOT NULL,
	date_remarks text NOT NULL,
	registration_remarks text NOT NULL,
	external_registration_link tinytext NOT NULL,
	class_time text NOT NULL,
	document_based_registration tinyint(1) unsigned DEFAULT '0' NOT NULL,
	external_registration tinyint(1) unsigned DEFAULT '0' NOT NULL,
	tx_extbase_type varchar(255) DEFAULT '' NOT NULL,
	registration_documents tinytext NOT NULL,
);

#
# Table structure for table 'tx_t3events_domain_model_performance'
#
CREATE TABLE tx_t3events_domain_model_performance (

	course  int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_t3events_domain_model_event'
#
CREATE TABLE tx_t3events_domain_model_event (
	categories int(11) unsigned DEFAULT '0' NOT NULL,
);

#
# Table structure for table 'tx_dakosyreservations_course_audience_mm'
#
CREATE TABLE tx_dakosyreservations_course_audience_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);

#
# Table structure for table 'tx_dakosyreservations_domain_model_person'
#
CREATE TABLE tx_dakosyreservations_domain_model_person (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	gender int(11) DEFAULT '0' NOT NULL,
	type int(11) DEFAULT '0' NOT NULL,
	reservation int(11) DEFAULT '0' NOT NULL,
	first_name varchar(255) DEFAULT '' NOT NULL,
	name varchar(255) DEFAULT '' NOT NULL,
	address text NOT NULL,
	zip varchar(255) DEFAULT '' NOT NULL,
	city varchar(255) DEFAULT '' NOT NULL,
	phone varchar(255) DEFAULT '' NOT NULL,
	email varchar(255) DEFAULT '' NOT NULL,

	tx_extbase_type varchar(255) DEFAULT '' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
 KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_t3events_domain_model_performance'
#
CREATE TABLE tx_t3events_domain_model_performance (
	participants int(11) unsigned DEFAULT '0' NOT NULL,
);

#
# Table structure for table 'tx_dakosyreservations_lesson_participants_person_mm'
#
CREATE TABLE tx_dakosyreservations_lesson_participants_person_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);

###
#
# Table structure for table 'tx_dakosyreservations_domain_model_notification'
#
CREATE TABLE tx_dakosyreservations_domain_model_notification (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	recipient varchar(255) DEFAULT '' NOT NULL,
	sender varchar(255) DEFAULT '' NOT NULL,
	subject varchar(255) DEFAULT '' NOT NULL,
	bodytext text NOT NULL,
	format varchar(255) DEFAULT '' NOT NULL,
	sent_at int(11) unsigned DEFAULT '0' NOT NULL,
	reservation int(11) unsigned DEFAULT '0' NOT NULL,


	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
);
