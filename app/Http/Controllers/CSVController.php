<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CSVController extends Controller
{



	function getForm()
	{
		return view('upload_result_orienteering');
	}

	function upload(Request $request)
	{   

		foreach ($request->file() as $file) {
			foreach ($file as $f) {
				$f->move(storage_path('images'), time().'_'.$f->getClientOriginalName());
				$file_name=time().'_'.$f->getClientOriginalName();
			}
		}
		$inform=['nazva_file'=>$file_name,
		'r1'=>$request['r1'],
		'r2'=>$request['r2'],
		'r3'=>$request['r3'],
		'n1'=>$request['n1'],
		'n2'=>$request['n2'],
		'n3'=>$request['n3'],
		'nd'=>$request['nd'],
		'i1'=>$request['i1'],
		'i2'=>$request['i2'],
		'kd1'=>$request['kd1'],
		'kd2'=>$request['kd2'],
		'i3'=>$request['i3'],
		's1'=>$request['s1'],
		's2'=>$request['s2'],
		's3'=>$request['s3']];


		return CSVController::csv($inform);
	}





	function second($time){                                         //Робить з ГГ:хв:сек просто секунди
		return $time = strtotime($time);
	}

	function ckasdist($cd1,$cd2,$grup){
		$ckasgrup=preg_replace("/[^0-9]/", "", $grup);
		if($ckasgrup<16) return $cd1;
		elseif($ckasgrup>=16 and $ckasgrup<=21) return $cd2;
		else return 0;

	}

	function undor($grup,$vr){
		if (preg_replace("/[^0-9]/", "", $grup)<16){
			if($vr=='III'){
				return '2-ю';	
			}
			if($vr=='II'){
				return '1-ю';	
			}

			if($vr=='I'){
				return '1-ю';	
			}
			if($vr=='KMS'){
				return '1-ю';	
			}
			if($vr=='MS'){
				return '1-ю';	
			}
			else return $vr;
		}
		if(preg_replace("/[^0-9]/", "", $grup)>=16 and preg_replace("/[^0-9]/", "", $grup)<=21){
			if($vr!='3-ю'){
				return $vr;
			}
			else return '';

		}
		else return '';


	}

	function tab_vidsik($grup,$roz_tab){
		if(preg_replace("/[^0-9]/", "", $grup)>=16 and preg_replace("/[^0-9]/", "", $grup)<=21 and $roz_tab[roz_name]!='3-ю'){

		}

	}


	function rozryad($rang,$time_best,$grup){
		$rozz=[['rang'=>1200,'MS'=>0,'KMS'=>131,'I'=>147,'II'=>174,'III'=>209,'3-ю'=>0],
		['rang'=>1100,'MS'=>0,'KMS'=>129,'I'=>144,'II'=>170,'III'=>204,'3-ю'=>0],
		['rang'=>1000,'MS'=>0,'KMS'=>126,'I'=>141,'II'=>166,'III'=>199,'3-ю'=>0],
		['rang'=>800,'MS'=>0,'KMS'=>123,'I'=>138,'II'=>162,'III'=>194,'3-ю'=>0],
		['rang'=>630,'MS'=>0,'KMS'=>120,'I'=>135,'II'=>158,'III'=>189,'3-ю'=>0],
		['rang'=>500,'MS'=>0,'KMS'=>117,'I'=>132,'II'=>154,'III'=>184,'3-ю'=>224],
		['rang'=>400,'MS'=>0,'KMS'=>114,'I'=>129,'II'=>150,'III'=>179,'3-ю'=>219],
		['rang'=>320,'MS'=>0,'KMS'=>111,'I'=>126,'II'=>146,'III'=>174,'3-ю'=>214],
		['rang'=>250,'MS'=>0,'KMS'=>108,'I'=>123,'II'=>142,'III'=>170,'3-ю'=>209],
		['rang'=>200,'MS'=>0,'KMS'=>105,'I'=>120,'II'=>138,'III'=>166,'3-ю'=>204],
		['rang'=>160,'MS'=>0,'KMS'=>102,'I'=>117,'II'=>135,'III'=>162,'3-ю'=>199],
		['rang'=>120,'MS'=>0,'KMS'=>100,'I'=>114,'II'=>132,'III'=>158,'3-ю'=>194],
		['rang'=>100,'MS'=>0,'KMS'=>0,'I'=>111,'II'=>129,'III'=>154,'3-ю'=>189],
		['rang'=>80,'MS'=>0,'KMS'=>0,'I'=>108,'II'=>126,'III'=>150,'3-ю'=>184],
		['rang'=>63,'MS'=>0,'KMS'=>0,'I'=>105,'II'=>123,'III'=>146,'3-ю'=>179],
		['rang'=>50,'MS'=>0,'KMS'=>0,'I'=>102,'II'=>120,'III'=>142,'3-ю'=>174],
		['rang'=>36,'MS'=>0,'KMS'=>0,'I'=>0,'II'=>117,'III'=>138,'3-ю'=>170],
		['rang'=>32,'MS'=>0,'KMS'=>0,'I'=>0,'II'=>114,'III'=>135,'3-ю'=>166],
		['rang'=>25,'MS'=>0,'KMS'=>0,'I'=>0,'II'=>111,'III'=>132,'3-ю'=>162],
		['rang'=>20,'MS'=>0,'KMS'=>0,'I'=>0,'II'=>108,'III'=>129,'3-ю'=>158],
		['rang'=>16,'MS'=>0,'KMS'=>0,'I'=>0,'II'=>105,'III'=>126,'3-ю'=>154],
		['rang'=>13,'MS'=>0,'KMS'=>0,'I'=>0,'II'=>102,'III'=>123,'3-ю'=>150],
		['rang'=>10,'MS'=>0,'KMS'=>0,'I'=>0,'II'=>100,'III'=>120,'3-ю'=>146],
		['rang'=>8,'MS'=>0,'KMS'=>0,'I'=>0,'II'=>0,'III'=>117,'3-ю'=>142],
		['rang'=>6,'MS'=>0,'KMS'=>0,'I'=>0,'II'=>0,'III'=>114,'3-ю'=>138],
		['rang'=>5,'MS'=>0,'KMS'=>0,'I'=>0,'II'=>0,'III'=>111,'3-ю'=>135],
		['rang'=>4,'MS'=>0,'KMS'=>0,'I'=>0,'II'=>0,'III'=>108,'3-ю'=>132],
		['rang'=>3,'MS'=>0,'KMS'=>0,'I'=>0,'II'=>0,'III'=>105,'3-ю'=>129],
		['rang'=>2,'MS'=>0,'KMS'=>0,'I'=>0,'II'=>0,'III'=>0,'3-ю'=>123],
		['rang'=>1,'MS'=>0,'KMS'=>0,'I'=>0,'II'=>0,'III'=>0,'3-ю'=>114]];

		foreach ($rozz as $roz) {
			if($rang>=$roz['rang']){
				break;
			}
		}

		// if(preg_replace("/[^0-9]/", "", $grup)>=16)unset($roz['3-ю']);
		foreach ($roz as $ii) {
			if($ii!=0 and array_search($ii,$roz)!='rang'){
				$z=array_search($ii,$roz);
				$u=CSVController::undor($grup,$z);
				$timevik=$time_best/100*$ii;
				$ekran[]=['roz_name'=>$u,'roz_proz'=>$ii,'timeo'=>date('H:i:s',intval($timevik))];
			}
			

		}
		return $ekran;

	}
	


	function klasifik($rang,$time_best,$time,$grup){
         

		$rozz=[['rang'=>1200,'MS'=>0,'KMS'=>131,'I'=>147,'II'=>174,'III'=>209,'3-ю'=>0],
		['rang'=>1100,'MS'=>0,'KMS'=>129,'I'=>144,'II'=>170,'III'=>204,'3-ю'=>0],
		['rang'=>1000,'MS'=>0,'KMS'=>126,'I'=>141,'II'=>166,'III'=>199,'3-ю'=>0],
		['rang'=>800,'MS'=>0,'KMS'=>123,'I'=>138,'II'=>162,'III'=>194,'3-ю'=>0],
		['rang'=>630,'MS'=>0,'KMS'=>120,'I'=>135,'II'=>158,'III'=>189,'3-ю'=>0],
		['rang'=>500,'MS'=>0,'KMS'=>117,'I'=>132,'II'=>154,'III'=>184,'3-ю'=>224],
		['rang'=>400,'MS'=>0,'KMS'=>114,'I'=>129,'II'=>150,'III'=>179,'3-ю'=>219],
		['rang'=>320,'MS'=>0,'KMS'=>111,'I'=>126,'II'=>146,'III'=>174,'3-ю'=>214],
		['rang'=>250,'MS'=>0,'KMS'=>108,'I'=>123,'II'=>142,'III'=>170,'3-ю'=>209],
		['rang'=>200,'MS'=>0,'KMS'=>105,'I'=>120,'II'=>138,'III'=>166,'3-ю'=>204],
		['rang'=>160,'MS'=>0,'KMS'=>102,'I'=>117,'II'=>135,'III'=>162,'3-ю'=>199],
		['rang'=>120,'MS'=>0,'KMS'=>100,'I'=>114,'II'=>132,'III'=>158,'3-ю'=>194],
		['rang'=>100,'MS'=>0,'KMS'=>0,'I'=>111,'II'=>129,'III'=>154,'3-ю'=>189],
		['rang'=>80,'MS'=>0,'KMS'=>0,'I'=>108,'II'=>126,'III'=>150,'3-ю'=>184],
		['rang'=>63,'MS'=>0,'KMS'=>0,'I'=>105,'II'=>123,'III'=>146,'3-ю'=>179],
		['rang'=>50,'MS'=>0,'KMS'=>0,'I'=>102,'II'=>120,'III'=>142,'3-ю'=>174],
		['rang'=>36,'MS'=>0,'KMS'=>0,'I'=>0,'II'=>117,'III'=>138,'3-ю'=>170],
		['rang'=>32,'MS'=>0,'KMS'=>0,'I'=>0,'II'=>114,'III'=>135,'3-ю'=>166],
		['rang'=>25,'MS'=>0,'KMS'=>0,'I'=>0,'II'=>111,'III'=>132,'3-ю'=>162],
		['rang'=>20,'MS'=>0,'KMS'=>0,'I'=>0,'II'=>108,'III'=>129,'3-ю'=>158],
		['rang'=>16,'MS'=>0,'KMS'=>0,'I'=>0,'II'=>105,'III'=>126,'3-ю'=>154],
		['rang'=>13,'MS'=>0,'KMS'=>0,'I'=>0,'II'=>102,'III'=>123,'3-ю'=>150],
		['rang'=>10,'MS'=>0,'KMS'=>0,'I'=>0,'II'=>100,'III'=>120,'3-ю'=>146],
		['rang'=>8,'MS'=>0,'KMS'=>0,'I'=>0,'II'=>0,'III'=>117,'3-ю'=>142],
		['rang'=>6,'MS'=>0,'KMS'=>0,'I'=>0,'II'=>0,'III'=>114,'3-ю'=>138],
		['rang'=>5,'MS'=>0,'KMS'=>0,'I'=>0,'II'=>0,'III'=>111,'3-ю'=>135],
		['rang'=>4,'MS'=>0,'KMS'=>0,'I'=>0,'II'=>0,'III'=>108,'3-ю'=>132],
		['rang'=>3,'MS'=>0,'KMS'=>0,'I'=>0,'II'=>0,'III'=>105,'3-ю'=>129],
		['rang'=>2,'MS'=>0,'KMS'=>0,'I'=>0,'II'=>0,'III'=>0,'3-ю'=>123],
		['rang'=>1,'MS'=>0,'KMS'=>0,'I'=>0,'II'=>0,'III'=>0,'3-ю'=>114]];


		foreach ($rozz as $roz) {
			if($rang>=$roz['rang']){
				break;
			}
		}
		unset($roz['rang']);
		foreach ($roz as $ta) {
			$timevik=$time_best/100*$ta;
			if($time<=$timevik){
				$u=array_search($ta,$roz);	 
				return $u;
			}

		}   
		


	}




	function status($status,$rezult){
		if ($status=='DNS'||$status=='DSQ'||$status=='пп.2.6.10'||$status=='DNF'){
			if($status=='пп.2.6.10')return'DSQ';
			return $status;
		}
		else return date('H:i:s',intval($rezult));

	}

	function statusroz($status,$vr){
		if ($status=='DNS'||$status=='DSQ'||$status=='пп.2.6.10'){
			return '';
		}
		else return $vr;
	}



	function rang_people($i){
		if ($i == 'б/р'||$i == '-'||$i == ''||$i == 'бр'||$i == 'б-р'||$i == 'б/р'||$i == 'б/р'||$i == 'б/р') {
			return $rang=0.1;
		} elseif ($i == '3-ю'||$i == '3-Ю' ||$i == '3-ю' ||$i == 'ІІІ-Ю'||$i == '3Ю'||$i == '3ю'||$i == '3-ю') {
			return $rang=0.3;
		} elseif ($i == '2-ю'||$i == 'III' ||$i == 'ІІІ' ||$i == '2ю'||$i == 'III'||$i == '2-ю') {
			return $rang=1;
		} elseif ($i == '1-ю'||$i == 'ІІ'||$i == '1ю'||$i == '2'||$i == 'II') {
			return $rang=3;
		} elseif ($i == 'І'||$i == 'І'||$i == '1') {
			return $rang=10;
		} elseif ($i == 'КМСУ') {
			return $rang=30;
		} elseif ($i == 'МСУ') {
			return $rang=100;
		}

	}


	public function csv($inform){
//     $a = array();
// $fp = fopen("1488.csv", "r");
// while (!feof($fp)) {
//      $a[] = fgetcsv($fp,1000, ";");
// }
//  $suma_rang=0;



// $x=0;
// $rang=0;
// $gr=0;
//  foreach ($a as $grup) {
//  	$rang_people=CSVController::rang_people($grup['4']);

//  	if($grup['0']=='﻿1.'||$grup['0']==2.||$grup['0']==3||$grup['0']==4||$grup['0']==5||$grup['0']==6||$grup['0']==7||$grup['0']==8||$grup['0']==9||$grup['0']==10||$grup['0']==11||$grup['0']==12){
//      $x=$rang_people+$x;
//  }
// if($gr!=$grup['3']){
// 	$x=0;
// 	// $t[$gr]=$rang;
// 	 // $t[]=['grup'=>$gr,'rang'=>$rang];
// 	 $t[]=[$gr=>$rang];

// }
// if ($grup['0']<=1){
// 	$rez=CSVController::second($grup['9'])-CSVController::second($grup['8']);
// 	$d[]=[$gr=>$rez];
// }

// $rang=$x;
//  $gr=$grup['3'];
//  }        






// foreach ($a as $result) {
// 	$rang_people=CSVController::rang_people($result['4']);
//     $rezult=CSVController::second($result['9'])-CSVController::second($result['8']);
//     $grup=$result['3'];
//     $best_result=array_column($d, $grup);
//     $rang=array_column($t, $grup);
// 	$ar[]=['mistse'=>(float)$result['0'],
//             'name'=>$result['1'],
//             'rik'=>$result['2'],
//             'grupa'=>$result['3'],
//             'rozryad'=>$result['4'],
//             'trener'=>$result['5'],
//             'comanda'=>$result['6'],
//             'status'=>$result['7'],
//             'result'=>$rezult,
//             'rang_people'=>$rang_people,
//             'suma_rang'=>$rang['0'],
//             'best'=>$best_result['0']

//         ];
// 	# code...
// }







// $f = Storage::disk('images');
		$array = $fields = array(); $i = 0;
		$nazva_file=$inform['nazva_file'];
		$patsh=storage_path('images/'.$nazva_file);
		$handle = @fopen($patsh, "r");
		if ($handle) {
			while (($row = fgetcsv($handle, 4096, ';')) !== false) {
				if (empty($fields)) {
					$fields = $row;
					continue;
				}
				foreach ($row as $k=>$value) {
					$array[$i][$fields[$k]] = $value;
				}
				$i++;
			}
			if (!feof($handle)) {
				echo "Error: unexpected fgets() fail\n";
			}
			fclose($handle);
		}
		function ToObject($Array) {
     
			// Create new stdClass object
			$object = app()->make('stdClass');
			 
			// Use loop to convert array into
			// stdClass object
			foreach ($Array as $key => $value) {
				if (is_array($value)) {
					$value = ToObject($value);
				}
				$object->$key = $value;
			}
			return $object;
		}

		$xx=ToObject($array);
		print_r($xx);


		foreach ($array as $res) {
			$x=0;
			$oo=array();
			if($res['﻿mistse']=='1'){	
				$best_rezult=CSVController::second($res['finish'])-CSVController::second($res['start']);
				$grup=$res['grup'];
				foreach ($array as $re) {

					if($grup==$re['grup']){
						if($re['roz']=='') $novroz='б/р';
							else $novroz=$re['roz'];
						if($re['﻿mistse']>=1 and $re['﻿mistse']<=12){
							if($re['roz']=='б/р'||$re['roz']==''and $grup==preg_replace("/[^0-9]/", "", $grup)>=16){
								$rang_people=0.3;
							}
							else $rang_people=CSVController::rang_people($re['roz']);
							
							$x=$rang_people+$x;
							

						}
						$rezult=CSVController::second($re['finish'])-CSVController::second($re['start']);
						$b=CSVController::klasifik($x,$best_rezult,$rezult,$grup);
						$oo[]=['name'=>$re['name'],
						'mistse'=>$re['﻿mistse'],
						'vik'=>$b,
						'comanda'=>$re['comanda'],
						'trener'=>$re['trener'],
						'rik'=>$re['rik'],
						'status'=>$re['status'],
						'legts'=>$re['legts'],
						'roz'=>$novroz,
						'rezult'=>$rezult];


					}
				}

	// $best_rezult=CSVController::second($res['finish'])-CSVController::second($res['start']);

				$rezi[]=['r'=>$best_rezult,
				'g'=>$res['grup'],
				'x'=>$x,
				'm'=>$oo];
			}



	 // $rezultat[]=['grup'=>$rezi,
	 //              ];

		}
		foreach ($rezi as $grupa) {
			$rezult_people=array();
			$grup=$grupa['g'];
			$rang_grup=$grupa['x'];
			$beat_time_grupa=$grupa['r'];
			$npp=0;
			$klasdist=CSVController::ckasdist($inform['kd1'],$inform['kd2'],$grup);
			$tabl_roz=CSVController::rozryad($rang_grup,$beat_time_grupa,$grup);
			// $tabl_roz=CSVController::undor($grup,$tabl);
			

			foreach ($grupa['m'] as $people) {
				$v=CSVController::klasifik($rang_grup,$beat_time_grupa,$people['rezult'],$grup);
				$vv=CSVController::undor($grup,$v);
				$vr=CSVController::statusroz($people['status'],$vv);
				$npp=$npp+1;
				$rezult=CSVController::status($people['status'],$people['rezult']);
				$legs=$people['legts'];

				$rezult_people[]=['name'=>$people['name'],
				'nam'=>$npp,
				'rezult'=>$rezult,
				'rik'=>$people['rik'],
				'﻿mistse'=>$people['mistse'],
				'comanda'=>$people['comanda'],
				'trener'=>$people['trener'],
				'roz'=>$people['roz'],	 		                 
				'vik'=>$vr];
			}
			$ri[]=['grup'=>$grup,
			'legts'=>$legs,
			'rang_grup'=>$rang_grup,
			'klasdist'=>$klasdist,
			'roz_tab'=>$tabl_roz,
			'rezult_people'=>$rezult_people];
		}



// dd($ri);


		return view('csv',compact('ri','inform'));
	}

}