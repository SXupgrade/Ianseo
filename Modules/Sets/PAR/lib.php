<?php

// these go here as it is a "global" definition, used or not
$tourCollation = '';
$tourDetIocCode = '';
if(empty($SubRule)) $SubRule='1';

function CreateStandardDivisions($TourId, $Type='FITA') {
	$i=1;
	CreateDivision($TourId, $i++, 'CO', 'Open Compound');
	CreateDivision($TourId, $i++, 'C1', 'Compound W1');
	CreateDivision($TourId, $i++, 'RS', 'Recurve Standing');
	CreateDivision($TourId, $i++, 'R2', 'Recurve W2');
	CreateDivision($TourId, $i++, 'VI', 'Visually Impaired');
}

function CreateStandardClasses($TourId, $SubRule) {
	CreateClass($TourId, 1, 1,100, 0, 'M', 'M', '~M');
	CreateClass($TourId, 2, 1,100, 1, 'W', 'W', '~F');
//	CreateClass($TourId, 3, 1, 20, 0, 'JM', 'JM,M', '~JM');
//	CreateClass($TourId, 4, 1, 20, 1, 'JW', 'JW,W', '~JF');
}

function CreateStandardEvents($TourId, $SubRule, $Outdoor=true) {
	$TargetR=($Outdoor?5:2);
	$TargetC=($Outdoor?9:4);
	$TargetSizeR=($Outdoor ? 122 : 40);
	$TargetSizeC=($Outdoor ? 80 : 40);
	$TargetSizeV=($Outdoor ? 80 : 60);
	$DistanceR=($Outdoor ? 70 : 18);
	$DistanceC=($Outdoor ? 50 : 18);
	$DistanceV=($Outdoor ? 30 : 18);

	$i=1;
	CreateEvent($TourId, $i++, 0, 0, 16, $TargetR, 3, 6, 1, 5, 3, 1, 'ROM', 'Recurve Bow Open Men', 1, 240, 240, 0, 0, '', '', $TargetSizeR, $DistanceR);
	CreateEvent($TourId, $i++, 0, 0, 16, $TargetR, 3, 6, 1, 5, 3, 1, 'ROW', 'Recurve Bow Open Women', 1, 240, 240, 0, 0, '', '', $TargetSizeR, $DistanceR);
	CreateEvent($TourId, $i++, 0, 0,  8, $TargetC, 3, 6, 1, 5, 3, 1, 'C1M', 'Compound/Recurve Bow W1 Men', 0, 240, 240, 0, 0, '', '', $TargetSizeR, $DistanceC);
	CreateEvent($TourId, $i++, 0, 0,  8, $TargetC, 3, 6, 1, 5, 3, 1, 'C1W', 'Compound/Recurve Bow W1 Women', 0, 240, 240, 0, 0, '', '', $TargetSizeR, $DistanceC);
	CreateEvent($TourId, $i++, 0, 0, 32, $TargetC, 3, 6, 1, 5, 3, 1, 'COM', 'Compound Bow Open Men', 0, 240, 240, 0, 0, '', '', $TargetSizeR, $DistanceC);
	CreateEvent($TourId, $i++, 0, 0, 16, $TargetC, 3, 6, 1, 5, 3, 1, 'COW', 'Compound Bow Open Women', 0, 240, 240, 0, 0, '', '', $TargetSizeR, $DistanceC);
	CreateEvent($TourId, $i++, 0, 0,  2, $TargetR, 3, 6, 1, 5, 3, 1, 'VIM',  'Visually Impaired Class Open Men', 1, 240, 240, 0, 0, '', '', $TargetSizeV, $DistanceV);
	CreateEvent($TourId, $i++, 0, 0,  2, $TargetR, 3, 6, 1, 5, 3, 1, 'VIW',  'Visually Impaired Class Open Women', 1, 240, 240, 0, 0, '', '', $TargetSizeV, $DistanceV);
	$i=1;
	CreateEvent($TourId, $i++, 1, 0, 8, $TargetR, 4, 6, 9, 4, 6, 9, 'ROM', 'Recurve Men Open Team',1, 0, 0, 0, 0, '', '', $TargetSizeR, $DistanceR);
	CreateEvent($TourId, $i++, 1, 0, 4, $TargetR, 4, 6, 9, 4, 6, 9, 'ROW', 'Recurve Women Open Team',1, 0, 0, 0, 0, '', '', $TargetSizeR, $DistanceR);
	CreateEvent($TourId, $i++, 1, 0, 8, $TargetC, 4, 6, 9, 4, 6, 9, 'C1M', 'Compound/Recurve Men W1 Team',0, 0, 0, 0, 0, '', '', $TargetSizeC, $DistanceC);
	CreateEvent($TourId, $i++, 1, 0, 8, $TargetC, 4, 6, 9, 4, 6, 9, 'C1W', 'Compound/Recurve Women W1 Team',0, 0, 0, 0, 0, '', '', $TargetSizeC, $DistanceC);
	CreateEvent($TourId, $i++, 1, 0, 8, $TargetC, 4, 6, 9, 4, 6, 9, 'COM', 'Compound Men Open Team',0, 0, 0, 0, 0, '', '', $TargetSizeV, $DistanceV);
	CreateEvent($TourId, $i++, 1, 0, 8, $TargetC, 4, 6, 9, 4, 6, 9, 'COW', 'Compound Men Open Team',0, 0, 0, 0, 0, '', '', $TargetSizeV, $DistanceV);
}

function InsertStandardEvents($TourId, $SubRule) {
	InsertClassEvent($TourId, 0, 1, 'ROM', 'R2', 'M');
	InsertClassEvent($TourId, 0, 1, 'ROM', 'RS', 'M');
	InsertClassEvent($TourId, 0, 1, 'ROW', 'R2', 'W');
	InsertClassEvent($TourId, 0, 1, 'ROW', 'RS', 'W');
	InsertClassEvent($TourId, 0, 1, 'C1M', 'C1', 'M');
	InsertClassEvent($TourId, 0, 1, 'C1W', 'C1', 'W');
	InsertClassEvent($TourId, 0, 1, 'COM', 'CO', 'M');
	InsertClassEvent($TourId, 0, 1, 'COW', 'CO', 'W');
	InsertClassEvent($TourId, 0, 1, 'VIM',  'VI', 'M');
	InsertClassEvent($TourId, 0, 1, 'VIW',  'VI', 'W');

	InsertClassEvent($TourId, 1, 3, 'ROM', 'R2', 'M');
	InsertClassEvent($TourId, 1, 3, 'ROM', 'RS', 'M');
	InsertClassEvent($TourId, 1, 3, 'ROW', 'R2', 'W');
	InsertClassEvent($TourId, 1, 3, 'ROW', 'RS', 'W');
	InsertClassEvent($TourId, 1, 3, 'COM', 'CO', 'M');
	InsertClassEvent($TourId, 1, 3, 'COW', 'CO', 'W');
	InsertClassEvent($TourId, 1, 3, 'C1M', 'C1', 'M');
	InsertClassEvent($TourId, 1, 3, 'C1W', 'C1', 'W');
}

?>