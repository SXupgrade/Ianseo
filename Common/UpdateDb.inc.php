<?php
include_once('F2FGrid.inc.php');
include_once('UpdateFunctions.inc.php');

/*
ogni step viene salvato separatamente al proprio numero di versione...
creato un numero di versione DB apposito...
Se la versione è troppo vecchia include i vecchi file

*/

if($version <= '2011-01-01 00:00:00') require_once('Common/UpdateDb-2010.inc.php');
if($version <= '2012-01-01 00:00:00') require_once('Common/UpdateDb-2011.inc.php');
if($version <= '2013-01-01 00:00:00') require_once('Common/UpdateDb-2012.inc.php');
if($version <= '2014-01-01 00:00:00') require_once('Common/UpdateDb-2013.inc.php');

if($version<'2014-01-15 22:00:10') {
	safe_w_sql("drop table if exists TargetGroups");
	$q="CREATE TABLE IF NOT EXISTS `TargetGroups` (
		`TgTournament` int(10) NOT NULL,
		`TgSession` varchar(1) NOT NULL,
		`TgTargetNo` varchar(4) NOT NULL,
		`TgGroup` varchar(25) NOT NULL,
		PRIMARY KEY (`TgTournament`,`TgTargetNo`),
		KEY `TgTournament` (`TgTournament`,`TgGroup`,`TgTargetNo`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8";
	$r=safe_w_sql($q,false,array(1060));

	db_save_version('2014-01-15 22:00:10');
}

if($version<'2014-01-17 19:40:00') {
	$q="ALTER TABLE  `Qualifications` CHANGE  `QuD1Arrowstring`  `QuD1Arrowstring` VARCHAR( 90 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , CHANGE  `QuD2Arrowstring`  `QuD2Arrowstring` VARCHAR( 90 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL";
	$r=safe_w_sql($q,false,array(1060));

	db_save_version('2014-01-17 19:40:00');
}

if($version<'2014-01-18 18:32:00') {
	safe_w_sql("drop table if exists Emails");
	$q="CREATE TABLE IF NOT EXISTS `Emails` (
		`EmTournament` int(10) NOT NULL,
		`EmTitle` varchar(20) NOT NULL,
		`EmSubject` varchar(60) NOT NULL,
		`EmBody` text NOT NULL,
		`EmFilter` text NOT NULL,
		`EmSentDate` datetime NOT NULL,
		PRIMARY KEY (`EmTournament`,`EmTitle`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8";
	$r=safe_w_sql($q,false,array(1060));

	safe_w_sql("drop table if exists ExtraData");
	$q="CREATE TABLE IF NOT EXISTS `ExtraData` (
		`EdId` int(10) NOT NULL,
		`EdType` varchar(1) NOT NULL,
		`EdEmail` varchar(100) NOT NULL,
		`EdExtra` text NOT NULL,
		PRIMARY KEY (`EdId`,`EdType`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8";
	$r=safe_w_sql($q,false,array(1060));

	$q="ALTER TABLE  `Qualifications` ADD  `QuSubClassRank` SMALLINT NOT NULL AFTER  `QuClRank`, add index(QuClRank), add index (QuSubClassRank)";
	$r=safe_w_sql($q,false,array(1060));

	db_save_version('2014-01-18 18:32:00');
}

if($version<'2014-01-19 11:34:00') {
	safe_w_sql("drop table if exists Awarded");
	$q="CREATE TABLE IF NOT EXISTS `Awarded` (
		`AwEntry` int(10) NOT NULL,
		`AwTournament` int(10) not null,
		`AwDivision` varchar(2) not null,
		`AwClass` varchar(2) not null,
		`AwSubClass` varchar(2) not null,
		`AwRank` int(10) not null,
		`AwValue` decimal(12,2) NOT NULL,
		`AwPrinted` varchar(1) not null,
		`AwMailed` varchar(1) not null,
		`AwReference` varchar(25) not null,
		`AwExtra` text NOT NULL,
		PRIMARY KEY (`AwEntry`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	$r=safe_w_sql($q,false,array(1060));

	db_save_version('2014-01-19 11:34:00');
}

if($version<'2014-01-20 12:00:00') {
	$q="ALTER TABLE `TournamentDistances` drop primary key ";
	$r=safe_w_sql($q,false,array(1060));
	$q="ALTER TABLE `TournamentDistances` add primary key (TdTournament, TdType, TdClasses)";
	$r=safe_w_sql($q,false,array(1060));

	db_save_version('2014-01-20 12:00:00');
}

if($version<'2014-01-29 12:00:00') {
	$q="ALTER TABLE  `BackNumber` ADD  `BnIncludeSession` TINYINT NOT NULL";
	$r=safe_w_sql($q,false,array(1060));

	db_save_version('2014-01-29 12:00:00');
}

if($version<'2014-01-31 11:35:00') {
	$q="ALTER TABLE Qualifications DROP QuRank";
	$r=safe_w_sql($q,false,array(1091));

	$q="ALTER TABLE Qualifications ADD QuClRankOld SMALLINT NOT NULL AFTER QuSubClassRank";
	$r=safe_w_sql($q,false,array(1060));

	$q="ALTER TABLE Qualifications ADD QuSubClassRankOld SMALLINT NOT NULL AFTER QuClRankOld";
	$r=safe_w_sql($q,false,array(1060));

	$q="ALTER TABLE Qualifications ADD QuHitsCalcOld INT NOT NULL AFTER QuSubClassRankOld";
	$r=safe_w_sql($q,false,array(1060));

	$q="ALTER TABLE Individuals ADD IndRankOld SMALLINT NOT NULL AFTER IndRank";
	$r=safe_w_sql($q,false,array(1060));

	db_save_version('2014-01-31 11:35:00');
}

if($version<'2014-01-31 12:25:00') {
	$q="ALTER TABLE Qualifications ADD QuHitsSubClassCalcOld INT NOT NULL AFTER QuHitsCalcOld";
	$r=safe_w_sql($q,false,array(1060));

	$q="ALTER TABLE Individuals ADD IndRankCalcOld INT NOT NULL AFTER IndRankOld";
	$r=safe_w_sql($q,false,array(1060));

	db_save_version('2014-01-31 12:25:00');
}

if($version<'2014-01-31 20:00:00') {
	$q="ALTER TABLE Teams ADD TeRankOld TINYINT NOT NULL AFTER TeRank";
	$r=safe_w_sql($q,false,array(1060));

	$q="ALTER TABLE Teams ADD TeHitsCalcOld SMALLINT NOT NULL AFTER TeRankOld";
	$r=safe_w_sql($q,false,array(1060));

	db_save_version('2014-01-31 20:00:00');
}

if($version<'2014-02-04 17:00:00') {
	$q="CREATE TABLE IF NOT EXISTS `QualOldPositions` (
		`QopId` int(10) unsigned NOT NULL,
		`QopHits` int(11) NOT NULL,
		`QopClRank` smallint(6) NOT NULL,
		`QopSubClassRank` smallint(6) NOT NULL,
		PRIMARY KEY (`QopId`,`QopHits`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8";
	$r=safe_w_sql($q,false,array(1050));

	$q="CREATE TABLE IF NOT EXISTS `IndOldPositions` (
		`IopId` int(10) unsigned NOT NULL,
		`IopEvent` varchar(4) NOT NULL,
		`IopTournament` int(11) NOT NULL,
		`IopHits` int(11) NOT NULL,
		`IopRank` smallint(6) NOT NULL,
		PRIMARY KEY (`IopId`,`IopEvent`,`IopTournament`,`IopHits`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	$r=safe_w_sql($q,false,array(1050));

	$q="ALTER TABLE Qualifications DROP QuClRankOld";
	$r=safe_w_sql($q,false,array(1091));
	$q="ALTER TABLE Qualifications DROP QuSubClassRankOld";
	$r=safe_w_sql($q,false,array(1091));
	$q="ALTER TABLE Qualifications DROP QuHitsCalcOld";
	$r=safe_w_sql($q,false,array(1091));
	$q="ALTER TABLE Qualifications DROP QuHitsSubClassCalcOld";
	$r=safe_w_sql($q,false,array(1091));

	$q="ALTER TABLE Individuals DROP IndRankOld";
	$r=safe_w_sql($q,false,array(1091));
	$q="ALTER TABLE Individuals DROP IndRankCalcOld";
	$r=safe_w_sql($q,false,array(1091));

	$q="ALTER TABLE Teams DROP TeRankOld";
	$r=safe_w_sql($q,false,array(1091));
	$q="ALTER TABLE Teams DROP TeRankCalcOld";
	$r=safe_w_sql($q,false,array(1091));


	db_save_version('2014-02-04 17:00:00');
}

if($version<'2014-02-25 19:50:00') {
	$q="replace into TourTypes set TtId=32, TtType='type_NFAA_Indoor', TtDistance=2, TtOrderBy=32";
	$r=safe_w_sql($q,false,array(1060));

	$q="replace into Targets set TarId=13, TarDescr='TrgNfaaInd', TarArray='TrgNfaaInd', TarOrder=13,
		A_size=0,
		B_size=50,
		B_color='000000',
		C_size=40,
		C_color='000000',
		D_size=30,
		D_color='000000',
		E_size=20,
		E_color='000000',
		F_size=10,
		F_color='ffffff',
		Z_size=5,
		Z_color='ffffff'";
	$r=safe_w_sql($q,false,array(1060));

	db_save_version('2014-02-25 19:50:00');
}

if($version<'2014-02-28 08:50:00') {
	$q="ALTER TABLE  Finals ADD INDEX (FinTournament,  FinEvent,  FinAthlete,  FinMatchNo)";
	$r=safe_w_sql($q,false,array(1060));

	db_save_version('2014-02-28 08:50:00');
}

if($version<'2014-03-02 08:50:00') {
	$q="ALTER TABLE Teams ADD INDEX (TeTournament, TeFinEvent, TeEvent, TeScore)";
	$r=safe_w_sql($q,false,array(1060));
	$q="ALTER TABLE Teams ADD INDEX (TeTournament, TeSO, TeEvent)";
	$r=safe_w_sql($q,false,array(1060));
	$q="ALTER TABLE Teams ADD INDEX (TeTournament, TeEvent, TeFinEvent, TeScore)";
	$r=safe_w_sql($q,false,array(1060));
	$q="ALTER TABLE Teams ADD INDEX (TeTournament, TeFinEvent, TeEvent, TeSO)";
	$r=safe_w_sql($q,false,array(1060));

	db_save_version('2014-03-02 08:50:00');
}

if($version<'2014-03-07 11:50:00') {
	$q="ALTER TABLE DistanceInformation
		add DiStartDay date not null after DiMaxPoints,
		add DiStartTime time not null after DiStartDay,
		add DiEndDay date not null after DiStartTime,
		add DiEndTime time not null after DiEndDay,
		add DiWarmDay date not null after DiEndTime,
		add DiWarmTime time not null after DiWarmDay,
		ADD INDEX (DiStartDay, DiStartTime, DiEndDay, DiEndTime)";
	$r=safe_w_sql($q,false,array(1060));
	$q="update DistanceInformation
		set DiStartDay=date(DiStart),
		DiStartTime=time(DiStart),
		DiEndDay=date(DiEnd),
		DiEndTime=time(DiEnd),
		DiWarmDay=date(DiWarmup),
		DiWarmTime=time(DiWarmup)";
	$r=safe_w_sql($q,false,array(1060));
	$q="ALTER TABLE DistanceInformation
		drop DiStart,
		drop DiEnd,
		drop DiWarmup";
	$r=safe_w_sql($q,false,array(1060));
	db_save_version('2014-03-07 11:50:00');
}

if($version<'2014-03-08 08:50:00') {
	$q="ALTER TABLE Classes ADD INDEX (ClTournament, ClAthlete, ClViewOrder)";
	$r=safe_w_sql($q,false,array(1060));
	$q="ALTER TABLE Divisions ADD INDEX (DivTournament, DivAthlete, DivViewOrder)";
	$r=safe_w_sql($q,false,array(1060));

	db_save_version('2014-03-08 08:50:00');
}

if($version<'2014-03-21 16:00:00') {
	$q="DROP TABLE IF EXISTS IskDevices";
	$r=safe_w_sql($q,false,array(1060));
	$q="CREATE TABLE IF NOT EXISTS `IskDevices` (
		`IdTournament` int(10) NOT NULL,
		`IdIp` varchar(15) NOT NULL,
		`IdRegistration` datetime NOT NULL,
		`IdLastSeen` datetime NOT NULL,
		`IdDevice` varchar(255) NOT NULL,
		PRIMARY KEY (`IdTournament`,`IdIp`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	$r=safe_w_sql($q,false,array(1050));

	db_save_version('2014-03-21 16:00:00');
}

if($version<'2014-03-22 14:00:00') {
	UpdateWinLose_20140322();
	db_save_version('2014-03-22 14:00:00');
}

if($version<'2014-03-30 11:00:00') {
	$q="ALTER TABLE `TargetGroups` ADD `TgSesType` varchar(2) NOT NULL DEFAULT 'Q' ";
	$r=safe_w_sql($q,false,array(1060));

	db_save_version('2014-03-30 11:00:00');
}

if($version<'2014-03-30 12:00:00') {
	$q="ALTER TABLE `TargetGroups` drop primary key";
	$r=safe_w_sql($q,false,array(1060));
	$q="ALTER TABLE `TargetGroups` add primary key (TgTournament, TgSession, TgTargetNo, TgSesType)";
	$r=safe_w_sql($q,false,array(1060));

	db_save_version('2014-03-30 12:00:00');
}

if($version<'2014-05-04 15:35:00') {
	$q="ALTER TABLE `ACL` DROP AclAccess";
	$r=safe_w_sql($q,false,array(1091));
	$q="ALTER TABLE `ACL`
		ADD AclEnabled TINYINT NOT NULL DEFAULT 0,
		ADD  AclFeature TINYINT NOT NULL DEFAULT 0,
		ADD  AclFeatureExtra VARCHAR(50) NOT NULL ,
		ADD  AclLevel TINYINT NOT NULL DEFAULT 0";
	$r=safe_w_sql($q,false,array(1060));
	db_save_version('2014-05-04 15:35:00');
}

if($version<'2014-05-18 19:00:01') {
	$q="ALTER TABLE DistanceInformation
		add DiType varchar(1) not null default 'Q',
		add DiDay date not null,
		add DiWarmStart time not null,
		add DiWarmDuration int(5) not null,
		add DiStart time not null,
		add DiDuration int(5) not null,
		add index (DiDay, DiStart, DiDuration),
		add index (DiDay, DiWarmStart, DiWarmDuration)";
	$r=safe_w_sql($q,false,array(1060));
	safe_w_sql("update DistanceInformation
		set DiDay=DiStartDay,
			DiWarmStart=DiWarmTime,
			DiWarmDuration=TIMESTAMPDIFF(MINUTE, concat(DiStartDay, ' ', DiStartTime), concat(DiStartDay, ' ', DiWarmTime)),
			DiStart=DiStartTime,
			DiDuration=TIMESTAMPDIFF(MINUTE, concat(DiStartDay, ' ', DiEndTime), concat(DiStartDay, ' ', DiStartTime))");

	$q="ALTER TABLE DistanceInformation
		drop DiStartDay,
		drop DiStartTime,
		drop DiEndDay,
		drop DiEndTime,
		drop DiWarmDay,
		drop DiWarmTime";
	$r=safe_w_sql($q,false,array(1060));
	db_save_version('2014-05-18 19:00:01');
}

if($version<'2014-05-21 12:30:02') {
	safe_w_sql("drop table if exists FinWarmup");
	$q="CREATE TABLE IF NOT EXISTS FinWarmup (
		FwTournament int(10) NOT NULL,
		FwEvent varchar(4) NOT NULL,
		FwTeamEvent int(1) not null,
		FwDay date NOT NULL,
		FwTime time NOT NULL,
		FwDuration int(5) NOT NULL,
		FwMatchTime time not null,
		FwTargets text not null,
		FwOptions text not null,
		PRIMARY KEY (FwTournament, FwEvent, FwTeamEvent, FwDay, FwTime),
		UNIQUE (FwTournament, FwEvent, FwTeamEvent, FwDay, FwMatchTime)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8";
	$r=safe_w_sql($q,false,array(1060));

	db_save_version('2014-05-21 12:30:02');
}

if($version<'2014-05-23 16:00:00') {
	$q="ALTER TABLE Scheduler
		ADD SchDay DATE NOT NULL,
		add SchStart time not null,
		add SchDuration int(5) not null,
		add SchTitle varchar(255) not null,
		add SchSubTitle varchar (255) not null,
		add SchText varchar(255) not null,
		add index (SchTournament, SchDay, SchStart)
		";
	$r=safe_w_sql($q,false,array(1060));

	safe_w_sql("update Scheduler
		left join Session on SchTournament=SesTournament and SchSesOrder=SesOrder and SchSesType=SesType
		set SchDay=date(SchDateStart), SchStart=time(SchDateStart), SchDuration=TIMESTAMPDIFF(MINUTE, SchDateStart, SchDateEnd), SchText=SchDescr, SchTitle=SesName
		");

	db_save_version('2014-05-23 16:00:00');
}

if($version<'2014-05-25 11:10:00') {
	$q="ALTER TABLE `Events`
		ADD `EvTargetSize` INT(11) NOT NULL DEFAULT 0 AFTER  `EvFinalTargetType`,
		ADD `EvDistance` VARCHAR(10) NOT NULL AFTER `EvTargetSize`";
	$r=safe_w_sql($q,false,array(1060));
	db_save_version('2014-05-25 11:10:00');
}

if($version<'2014-05-25 18:15:00') {
	$q="ALTER TABLE Scheduler
		drop PRIMARY KEY";
	$r=safe_w_sql($q,false,array(1060));
	$q="ALTER TABLE Scheduler
		ADD PRIMARY KEY (SchTournament, SchDay, SchStart, SchOrder)";
	$r=safe_w_sql($q,false,array(1060));
	db_save_version('2014-05-25 18:15:00');
}

if($version<'2014-05-30 12:15:00') {
	$q="ALTER TABLE `Events`
		CHANGE  `EvDistance` `EvDistance` SMALLINT NOT NULL";
	$r=safe_w_sql($q,false,array(1060));
	db_save_version('2014-05-30 12:15:00');
}

if($version<'2014-06-15 18:34:00') {
	$q="ALTER TABLE `Scheduler` ADD `SchShift` int(4) NULL default null";
	$r=safe_w_sql($q,false,array(1060));
	$q="ALTER TABLE `DistanceInformation` ADD `DiShift` int(4) NULL default null";
	$r=safe_w_sql($q,false,array(1060));
	$q="ALTER TABLE `FinSchedule` ADD `FsShift` int(4) NULL default null";
	$r=safe_w_sql($q,false,array(1060));

	db_save_version('2014-06-15 18:34:00');
}

if($version<'2014-06-19 16:36:01') {
	$q="ALTER TABLE FinWarmup drop key FwTournament, add index (FwTournament, FwEvent, FwTeamEvent, FwDay, FwMatchTime, FwTime)";
	$r=safe_w_sql($q,false,array(1060));

	db_save_version('2014-06-19 16:36:01');
}

if($version<'2014-06-25 19:00:04') {
	safe_w_sql("drop table if exists IdCardElements");
	$q="CREATE TABLE IdCardElements (
		IceTournament int(10) NOT NULL,
		IceOrder int(4) NOT NULL,
		IceType varchar(25) not null,
		IceContent blob not null,
		IceMimeType varchar(25) not null,
		IceOptions text not null,
		IceNewOrder int(4) NOT NULL,
		index (IceTournament, IceOrder)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8";
	$r=safe_w_sql($q,false,array(1060));

	db_save_version('2014-06-25 19:00:04');
}

if($version<'2014-07-01 08:00:02') {
	$q="CREATE TABLE if not exists IdCards (
		IcTournament int(10) NOT NULL,
		IcBackground blob NOT NULL,
		IcSettings text not null,
		primary key (IcTournament)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8";
	$r=safe_w_sql($q,false,array(1060));

	db_save_version('2014-07-01 08:00:02');
}

/*

// TEMPLATE
if($version<'2014-05-20 19:00:00') {
	$q="ALTER TABLE `LookUpEntries` ADD `LueStatusValidUntil` DATE NOT NULL DEFAULT '0000-00-00' AFTER `LueStatus` ";
	$r=safe_w_sql($q,false,array(1060));

	db_save_version('2014-05-20 19:00:00');
}

REMEMBER TO CHANGE ALSO Common/Lib/UpdateTournament.inc.php!!!

*/

db_save_version($newversion);

function db_save_version($newversion) {
	//Aggiorno alla versione attuale SOLO le gare che erano alla versione immediatamente precedente
	$oldDbVersion = GetParameter('DBUpdate');
	safe_w_sql("UPDATE Tournament SET ToDbVersion='{$newversion}' WHERE ToDbVersion='{$oldDbVersion}'");

	SetParameter('DBUpdate', $newversion);
	SetParameter('SwUpdate', ProgramVersion);
}
?>