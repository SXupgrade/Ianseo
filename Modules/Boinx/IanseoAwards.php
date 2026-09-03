<?php
require_once('./config.php');
require_once('Common/Fun_FormatText.inc.php');
require_once('Common/Lib/ArrTargets.inc.php');
require_once('Common/Fun_Phases.inc.php');
//require_once('Common/Fun_Phases.inc.php');

// checks and creates the necessary flags/pictures
require_once('Common/CheckPictures.php');
CheckPictures($TourCodeSafe);


require_once('Common/Lib/Obj_RankFactory.php');

$Ind=array();
$Team=array();
$AbsInd=array();
$AbsTeam=array();

$Awards=array();

// finds out what is to be served!
$MyQuery="select * from BoinxSchedule where (BsType like 'Awa\\_%') and BsTournament=$TourId "
	. "ORDER BY"
	. " BsType";

$Rs=safe_r_sql($MyQuery);
while($MyRow=safe_fetch($Rs) ) {
	$tmp= explode('_', $MyRow->BsType);
	if($tmp[1]=='Ind') {
		$Ind[]=$tmp[2].$tmp[3];
	} elseif($tmp[1]=='Team') {
		$Team[]=$tmp[2].$tmp[3];
	} elseif($tmp[1]=='Abs') {
		$AbsInd[]=$tmp[2];
	} elseif($tmp[1]=='AbsTeam') {
		$AbsTeam[]=$tmp[2];
	}
}

if(!$Ind and !$Team and !$AbsInd and !$AbsTeam) {
	die("Nothing selected!");
}

$fotodir='http://' . $_SERVER['HTTP_HOST'] . $CFG->ROOT_DIR . 'TV/Photos/' . $TourCodeSafe . '-%s-%s.jpg';
$ranks=array('','g','s','b','w');

//Genero la query che mi ritorna i podi individuali di qualifica
if($Ind) {
	//Genero la query che mi ritorna tutti al max 10 righe dei podi qualificati
	$options=array('dist'=>0);
	$options['cutRank'] = 4;
	$family = 'DivClass';
	$options['arrNo'] = 0;
	$options['tournament']=$TourId;
	$options['events']=$Ind;

	$rank=Obj_RankFactory::create($family,$options);
	$rank->read();
	$rankData=$rank->getData();

	$Title=$rankData['meta']['title'];
	foreach($rankData['sections'] as $Event => $data) {
		$Awards['I-'.$Event]['header'] = $data['meta']['descr'];
		$txt=array();
		foreach($data['items'] as $item) {
			if(file_exists($CFG->DOCUMENT_PATH.'TV/Photos/'.$TourCodeSafe.'-Fl-'.$item['countryCode'].'.jpg')) {
				$Flag=sprintf($fotodir, 'Fl', $item['countryCode']);
			} elseif(file_exists($CFG->DOCUMENT_PATH.'TV/Photos/'.$TourCodeSafe.'-Fl-'.$item['countryIocCode'].'.jpg')) {
				$Flag=sprintf($fotodir, 'Fl', $item['countryIocCode']);
			} else {
				$Flag='';
			}
			$Awards['I-'.$Event]['items'][$ranks[$item['rank']]]=array(
				'flag'		=>$Flag,
				'name'	=>$item['athlete'],
				'country' => $item['countryCode']
				);
		}
	}
}

if($Team) {
	//Genero la query che mi ritorna tutti al max 10 righe dei podi qualificati
	$options=array('dist'=>0);
	$options['cutRank'] = 4;
	$family = 'DivClassTeam';
	$options['arrNo'] = 0;
	$options['tournament']=$TourId;
	$options['events']=$Team;

	$rank=Obj_RankFactory::create($family,$options);
	$rank->read();
	$rankData=$rank->getData();

	$Title=$rankData['meta']['title'];
	foreach($rankData['sections'] as $Event => $data) {
		$Awards['T-'.$Event]['header'] = $data['meta']['descr'];
		$txt=array();
		foreach($data['items'] as $item) {
			if(file_exists($CFG->DOCUMENT_PATH.'TV/Photos/'.$TourCodeSafe.'-Fl-'.$item['countryCode'].'.jpg')) {
				$Flag=sprintf($fotodir, 'Fl', $item['countryCode']);
			} elseif(file_exists($CFG->DOCUMENT_PATH.'TV/Photos/'.$TourCodeSafe.'-Fl-'.$item['countryIocCode'].'.jpg')) {
				$Flag=sprintf($fotodir, 'Fl', $item['countryIocCode']);
			} else {
				$Flag='';
			}
			$Awards['T-'.$Event]['items'][$ranks[$item['rank']]]=array(
				'flag'		=>$Flag,
				'name'	=>$item['countryName'],
				'country' => $item['countryCode']
				);
		}
	}
}

if($AbsInd) {
	require_once('Common/Lib/Obj_RankFactory.php');

	//Genero la query che mi ritorna tutti al max 10 righe dei podi qualificati
	$options=array('dist'=>0);
	$family = 'FinalInd';
	$options['tournament']=$TourId;
	$options['eventsR']=$AbsInd;

	$rank=Obj_RankFactory::create($family,$options);
	$rank->read();
	$rankData=$rank->getData();

	$Title=$rankData['meta']['title'];
	foreach($rankData['sections'] as $Event => $data) {
		$Awards['AI-'.$Event]['header'] = $data['meta']['descr'];
		$Awards['AI-'.$Event]['items'][$ranks[1]]=array('flag' => '', 'name' =>'');
		$Awards['AI-'.$Event]['items'][$ranks[2]]=array('flag' => '', 'name' =>'');
		$Awards['AI-'.$Event]['items'][$ranks[3]]=array('flag' => '', 'name' =>'');
		$Awards['AI-'.$Event]['items'][$ranks[4]]=array('flag' => '', 'name' =>'');
		$txt=array();
		foreach($data['items'] as $item) {
			if($item['rank'] > 4) break;
			if(file_exists($CFG->DOCUMENT_PATH.'TV/Photos/'.$TourCodeSafe.'-Fl-'.$item['countryCode'].'.jpg')) {
				$Flag=sprintf($fotodir, 'Fl', $item['countryCode']);
			} elseif(file_exists($CFG->DOCUMENT_PATH.'TV/Photos/'.$TourCodeSafe.'-Fl-'.$item['countryIocCode'].'.jpg')) {
				$Flag=sprintf($fotodir, 'Fl', $item['countryIocCode']);
			} else {
				$Flag='';
			}
			$Awards['AI-'.$Event]['items'][$ranks[$item['rank']]]=array(
				'flag'		=>$Flag,
				'name'	=>$item['athlete'],
				'country' => $item['countryCode']
				);
		}
	}
}

if($AbsTeam) {
	$family = 'FinalTeam';
	$options['tournament']=$TourId;
	$options['eventsR']=$AbsTeam;

	$rank=Obj_RankFactory::create($family,$options);
	$rank->read();
	$rankData=$rank->getData();


	$Title=$rankData['meta']['title'];
	foreach($rankData['sections'] as $Event => $data) {
		$Awards['AT-'.$Event]['header'] = $data['meta']['descr'];
		$txt=array();
		foreach($data['items'] as $item) {
			if($item['rank']>4) break;
			if(file_exists($CFG->DOCUMENT_PATH.'TV/Photos/'.$TourCodeSafe.'-Fl-'.$item['countryCode'].'.jpg')) {
				$Flag=sprintf($fotodir, 'Fl', $item['countryCode']);
//			} elseif(file_exists($CFG->DOCUMENT_PATH.'TV/Photos/'.$TourCodeSafe.'-Fl-'.$item['countryIocCode'].'.jpg')) {
//				$Flag=sprintf($fotodir, 'Fl', $item['countryIocCode']);
			} else {
				$Flag='';
			}
			$Awards['AT-'.$Event]['items'][$ranks[$item['rank']]]=array(
				'flag'		=>$Flag,
				'name'	=>$item['countryName'],
				'country' => $item['countryCode']
				);
		}
	}
}

$XmlDoc = new DOMDocument('1.0', 'UTF-8');
$XmlRoot = $XmlDoc->createElement('Ianseoaward');
$XmlDoc->appendChild($XmlRoot);

$StartEvent='a';
$OldEvent='';

foreach($Awards as $Event => $Data) {
	$XmlRoot->appendChild($Item = $XmlDoc->createElement($StartEvent));
	$Item->appendChild($XmlDoc->createElement('header', $Data['header']));
	foreach($Data['items'] as $k => $v) {
		$element = $XmlDoc->createElement($k.'name');
		$element->appendChild($XmlDoc->createCDATASection($v['name']));
		$Item->appendChild($element);

		$element = $XmlDoc->createElement($k.'flag');
		$element->appendChild($XmlDoc->createCDATASection($v['flag']));
		$Item->appendChild($element);

		$element = $XmlDoc->createElement($k.'country');
		$element->appendChild($XmlDoc->createCDATASection($v['country']));
		$Item->appendChild($element);
	}
	$StartEvent++;
}

header('Cache-Control: no-store, no-cache, must-revalidate');
header('Content-type: text/xml; charset=' . PageEncode);
echo $XmlDoc->SaveXML();

/*

<?xml version="1.0"?>
 <Ianseoaward>

            <a> evento (progressivo a,b,c,d,e,f,ecc)
                <header>Recurve Men</header> Titolo evento
                <gname>Scarzella</gname> nome gold
                <sname>Pisani</sname> nome silver
                <bname>Deligant</bname> nome bronze
                <gflag>http://localhost:8888/ianseo/Boinx/flag1.jpg</gflag> bandiera gold
                <sflag>http://localhost:8888/ianseo/Boinx/flag3.gif</sflag> bandiera silver
                <bflag>http://localhost:8888/ianseo/Boinx/flag2.gif</bflag> bandiera bronze
            </a>
            <b>
                <header>Recurve Women</header>
                 <gname>Scarzella</gname>
                <sname>Pisani</sname>
                <bname>Deligant</bname>
                <gflag>http://localhost:8888/ianseo/Boinx/flag1.jpg</gflag>
                <sflag>http://localhost:8888/ianseo/Boinx/flag3.gif</sflag>
                <bflag>http://localhost:8888/ianseo/Boinx/flag2.gif</bflag>
            </b>
            <c>
                <header>Compound Men</header>
                  <gname>Scarzella</gname>
                <sname>Pisani</sname>
                <bname>Deligant</bname>
                <gflag>http://localhost:8888/ianseo/Boinx/flag1.jpg</gflag>
                <sflag>http://localhost:8888/ianseo/Boinx/flag3.gif</sflag>
                <bflag>http://localhost:8888/ianseo/Boinx/flag2.gif</bflag>
            </c>
            <d>
                <header>Compound Women</header>
                  <gname>Scarzella</gname>
                <sname>Pisani</sname>
                <bname>Deligant</bname>
                <gflag>http://localhost:8888/ianseo/Boinx/flag1.jpg</gflag>
                <sflag>http://localhost:8888/ianseo/Boinx/flag3.gif</sflag>
                <bflag>http://localhost:8888/ianseo/Boinx/flag2.gif</bflag>
            </d>



  </Ianseoaward>

*/
?>