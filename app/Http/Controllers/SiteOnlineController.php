<?php namespace App\Http\Controllers;

use CRUDBooster;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class SiteOnlineController extends \crocodicstudio\crudbooster\controllers\CBController
{
   function grupsearh($grups,$people){//Шукає рупу в базі даних з групами
         foreach ($grups as $grupa) {
   			 if($grupa->id==$people->cls)$grup=$grupa->name;
   		 }
       return $grup;
   }

   function clubsearh($clubs,$people){ //Шукає клуб в базі даних з групами
         foreach ($clubs as $cluba) {
   			 if($cluba->id==$people->org)$club=$cluba->name;
   		 }
       return $club;
   }

   function statussearh($people) { //Шукає Статус 
	$status=$people->stat;
    switch($status) {
     case 0: 
      return " "; //Unknown, running?
    case 1:
      return "OK";
    case 20:
      return "DNS"; // Did not start;
    case 21:
      return "CANCEL"; // Cancelled entry;
    case 3:
      return "MP"; // Missing punch
    case 4:
      return "DNF"; //Did not finish
    case 5:
      return "DQ"; // Disqualified
    case 6:      
      return "OT"; // Overtime
    case 99:
      return "NP"; //Not participating;
  }
  }

  function plases($status,$mistse) {// місце для правильного сортувння
  switch($status) {
    case 0: 
      return 99999999; //Unknown, running?
    case 1:
      return $mistse;
    case 20:
      return 99999992; // Did not start;
    case 21:
      return 99999995; // Cancelled entry;
    case 3:
      return 99999994; // Missing punch
    case 4:
      return 99999991; //Did not finish
    case 5:
      return 99999993; // Disqualified
    case 6:      
      return 99999997; // Overtime
    case 99:
      return 99999996; //Not participating;
  }
}

   function formatTime($time) { //формат часу
    $time = $time / 10;
    if ($time > 3600)
        return sprintf("%d:%02d:%02d", $time/3600, ($time/60)%60, $time%60);
    elseif ($time > 0)
        return sprintf("%2d:%02d", ($time/60)%60, $time%60);
    else
        return '0:00';
   }


    function formatVids($time,$stat) { //формат часу відставання
    $time = $time / 10;
    if ($time > 3600 and $stat==1)
        return sprintf("+%d:%02d:%02d", $time/3600, ($time/60)%60, $time%60);
    elseif ($time > 0  and $stat==1)
        return sprintf("+%2d:%02d", ($time/60)%60, $time%60);
    else
        return 'ЛІДЕР';
   }


   function rez_stat($people){//зєднрує статус та результат
   	if($people->stat!=1)
   		return SiteOnlineController::statussearh($people);
   	else
   		return SiteOnlineController::formatTime($people->rt);
   }




   function mistse($people,$peopless){//визначає просто місуце
   	foreach ($peopless as $peoples) {
   		if ($peoples->cls==$people->cls and $people->stat==1 and $peoples->stat==1 and $peoples->rt<$people->rt) {
   			$x=$x+1;
   		}
   	}
   	if ($people->stat!=1) {
   		 return $x=' ';
   	}
   	else return $x+1;
 	
   }

   function count_people($peoples){

   }

   function count_club($clubs){
   	foreach ($clubs as $ckub) {
   		$x=$x+1;
   	}
   	return $x;

   }








   public function showrezult($id){
   	$seting=SetingController::seting();
   	$event = DB::table('mopcompetition')->where('cid',$id)->first();  
   	$peopless = DB::table('mopcompetitor')->where('cid',$id)->get();  
   	$grups = DB::table('mopclass')->where('cid',$id)->get();    
   	$clubs = DB::table('moporganization')->where('cid',$id)->get(); 
   	foreach ($peopless as $people) {
   		$mistse=SiteOnlineController::mistse($people,$peopless);
     		$peoplesa[]=['name'=>$people->name,
     		                 'cls'=>SiteOnlineController::grupsearh($grups,$people),
     		                 'org'=>SiteOnlineController::clubsearh($clubs,$people),
     		                 'status'=>SiteOnlineController::statussearh($people),
     		                 'stat'=>$people->stat,
     		                 'rt'=>$people->rt,
     		                 'start'=>SiteOnlineController::formatTime($people->st),
     		                 'rezult'=>SiteOnlineController::formatTime($people->rt),
     		                 'rez_stat'=>SiteOnlineController::rez_stat($people),
     		                 'mistse'=>$mistse,
     		                 'plases'=>SiteOnlineController::plases($people->stat,$mistse),
     		                 
     		                 ];

   	}


   	
    $cls = array_column($peoplesa, 'cls');
    $st = array_column($peoplesa, 'plases');
    array_multisort($cls, SORT_ASC, $st, SORT_ASC, $peoplesa);

$x=0;
    foreach ($peoplesa as $people) {
    	if ($people['plases']==1) $x=$people['rt'];
    	$vids=$people['rt']-$x;
    	$people['vids']=SiteOnlineController::formatVids($vids,$people['stat']);
    	$peoples[]=$people;
    	$count_people=$count_people+1;

    }
    $event->count_people=$count_people;
    $event->count_club=SiteOnlineController::count_club($clubs);




   return view('site.online.rezult', compact('event','seting','peoples','grups','clubs'));
   }








   public function showstartlist($id){
   	$seting=SetingController::seting();
   	$event = DB::table('mopcompetition')->where('cid',$id)->first();  
   	$peopless = DB::table('mopcompetitor')->where('cid',$id)->get();  
   	$grups = DB::table('mopclass')->where('cid',$id)->get();    
   	$clubs = DB::table('moporganization')->where('cid',$id)->get(); 
   	foreach ($peopless as $people) {
   		
     		$peoples[]=['name'=>$people->name,
     		                 'cls'=>SiteOnlineController::grupsearh($grups,$people),
     		                 'org'=>SiteOnlineController::clubsearh($clubs,$people),
     		                 
     		                 
     		                 'start'=>SiteOnlineController::formatTime($people->st),
     		                 
     		                 
     		                 
     		                 'si'=>$people->si,
     		                 
     		                 
     		                 ];
						
        $count_people=$count_people+1;

   	}


   	
    $cls = array_column($peoples, 'start');
    $st = array_column($peoples, 'org');
    array_multisort($cls, SORT_ASC, $st, SORT_ASC, $peoples);

 
    $event->count_people=$count_people;
    $event->count_club=SiteOnlineController::count_club($clubs);




   return view('site.online.startlist', compact('event','seting','peoples','grups','clubs'));
   }



    public function showpeople($name){
	$seting=SetingController::seting();
	$peopless = DB::table('mopcompetitor')->where('name',$name)->get(); 
	 
	foreach ($peopless as $people) {
		
		$event = DB::table('mopcompetition')->where('cid',$people->cid)->first();
		$clas=DB::table('mopclass')->where('cid',$people->cid)->where('id',$people->cls)->first();//групи
		$peopleses = DB::table('mopcompetitor')->where('cid',$people->cid)->where('cls',$people->cls)->get();//для ппрорахунку місця
		$mistse=SiteOnlineController::mistse($people,$peopleses);//місце в старті
		//
		$pipl['name']=$people->name;
		$club=DB::table('moporganization')->where('id',$people->org)->where('cid',$people->cid)->first();
		if ($club->name) {
			$pipl['club']=$club;
		}
		//дані про спортсмена

		   	
		


		//Змагання спортсмена
		$events[]=
		['title'=>$event->name,
		'name'=>$people->name,
		'club'=>$club->name,
		'data'=>$event->date,
		'rezult'=>SiteOnlineController::rez_stat($people),
		'mistse'=>$mistse,
		'clas'=>$clas->name];
		//Змагання спортсмена

	}
	
    return view('site.online.people', compact('seting','events','pipl'));
    }
































































































public function showsplit($id,$grup){
	$colors=['#66ff33','#3333ff','#ffff00','#ff5050','#ff9900','#9966ff','#00ffcc','#003399','#009933','#cc9900','#66ff33','#3333ff','#ffff00','#ff5050','#ff9900','#9966ff','#00ffcc','#003399','#009933','#cc9900'];
   	$seting=SetingController::seting();
   	$event = DB::table('mopcompetition')->where('cid',$id)->first(); 
   	$grups = DB::table('mopclass')->where('cid',$id)->where('name',$grup)->first();// виймаємо группу     
   	$peopless = DB::table('mopcompetitor')->where('cid',$id)->where('cls',$grups->id)->get()->sortBy('rt')->sortBy('stat'); // виймаємо учасників
   	// $kp=DB::table('mopcompetitor')->where('cid',$id)->where('cls',$grups->id)->get();
   	$mopkp=DB::table('mopclasscontrol')->where('cid',$id)->where('id',$grups->id)->get()->sortBy('ord');// виймаєкомо КП для групи

   	$mopradio=DB::table('mopradio')->where('cid',$id)->get();// виймаємо всі результати групи на кп


  
    foreach ($peopless as $p) {
    	$split=$mopradio->where('id',$p->id);
    	$popsplit=0;
    	foreach ($split as $s) {
        $splitperegon=$s->rt-$popsplit;
    	$allsplit[]=['ctrl'=>$s->ctrl,//записує в масив номер КП
   		                    'rt'=>$s->rt,
   		                    'id'=>$s->id,
   		                    'rt_peregon'=>$splitperegon];
    	$popsplit=$s->rt;
   		
   		}	
   	
    }

function min_rt($allsplit,$ctrl,$rt){
    foreach($allsplit as $sp){
    	if ($sp['ctrl']==$ctrl and $sp['rt']>0 ) {
    		$allctrl[]=[$sp['rt']];
    	}
    }
    $min=min($allctrl);
    $vist=$rt-$min['0'];

    return$vist;
}

function min_rt_peregon($allsplit,$ctrl,$rt_peregon){
    foreach($allsplit as $sp){
    	if ($sp['ctrl']==$ctrl and $sp['rt_peregon']>0 ) {
    		$allctrl[]=[$sp['rt_peregon']];
    	}
    }
    $min=min($allctrl);
    $vist=$rt_peregon-$min['0'];
    return$vist;
}

function min_rt_peregon2($allsplit,$ctrl,$rt_peregon){
    foreach($allsplit as $sp){
    	if ($sp['ctrl']==$ctrl and $sp['rt_peregon']>0 ) {
    		$allctrl[]=[$sp['rt_peregon']];
    	}
    }
    $min=min($allctrl);
    $vist=$rt_peregon-$min['0'];
    return$vist;
}



    



	# code...


   	// $people_rezult=app()->make('stdClass');
   	// $split = app()->make('stdClass');

   	function count_kp($allsplit,$mopsplit,$splitperegon){
   		$count=1;
   		foreach ($allsplit as $all) {
   			if ($all['ctrl']==$mopsplit->ctrl and $all['rt_peregon']<$splitperegon) {
   				$count=$count+1;
   			}
   		}
   		return $count;
   	}



   	function count_all($allsplit,$mopsplit){
   		$count=1;
   		foreach ($allsplit as $all) {
   			if ($all['ctrl']==$mopsplit->ctrl and $all['rt']<$mopsplit->rt) {
   				$count=$count+1;
   			}
   		}
   		return $count;
   	}

   

$color=0;
   	foreach ($peopless as $people) { //цей фурич робить масив з даних всіх сплітів групи;
   		$splitpeople=array();   // очищає спліти попереднього учасниак
   		$splitradio=$mopradio->where('id',$people->id); //вибирає всі спліти учасника
   		$popsplit=0;
   		$x=0;
   		$z=0;
   		$rttt=0;
 
   		foreach ($splitradio as $mopsplit) {//форичитьть всі спліти	
   			$ctrl=0;
   		foreach ($mopkp as $kp) {
   			if ($kp->ord==$x) {
   				$ctrl=$kp->ctrl;
   			}
   		}



   		if ($ctrl!=$mopsplit->ctrl) {	
   			$splitpeople[]=['ctrl'=>0,//записує в масив номер КП
   		                    'rt'=>0,
   		                    'id'=>0,
   		                    'count_all'=>0,
   		                    'rt_peregon'=>0,
   		                    'count_cp'=>0,
   		                    'time'=>0,
   		                    'time_peregon'=>0];
   		                     $x=$x+1;
   		                     $ctrl=0;
   		}



   		                 
   			$splitperegon=$mopsplit->rt-$popsplit;
   			$z=min_rt_peregon($allsplit,$mopsplit->ctrl,$splitperegon)+$z;
   			$rttt=$rttt+$z;
   			$splitpeople[]=['ctrl'=>$mopsplit->ctrl,//записує в масив номер КП
   		                    'rt'=>$mopsplit->rt,
   		                    'rttt'=>$rttt/10,

   		                    'id'=>$mopsplit->id,
   		                    'count_all'=>count_all($allsplit,$mopsplit),
   		                    'rt_peregon'=>$splitperegon,
   		                    'count_cp'=>count_kp($allsplit,$mopsplit,$splitperegon),
   		                    'time'=>SiteOnlineController::formatTime($mopsplit->rt),
   		                    'time_peregon'=>SiteOnlineController::formatTime($splitperegon),
   		                    'vidst_rt'=>min_rt($allsplit,$mopsplit->ctrl,$mopsplit->rt),
   		                    'vidst_rt_peregon'=>min_rt_peregon($allsplit,$mopsplit->ctrl,$splitperegon),
   		                    'time_vidst_rt_peregon'=>SiteOnlineController::formatVids(min_rt_peregon($allsplit,$mopsplit->ctrl,$splitperegon),1),
   		                    'time_vidst_rt'=>SiteOnlineController::formatVids(min_rt($allsplit,$mopsplit->ctrl,$mopsplit->rt),1)];//записує в масив результат на КП
   		   $popsplit=$mopsplit->rt;
   		   $z=min_rt_peregon($allsplit,$mopsplit->ctrl,$splitperegon);
   		

   		   $x=$x+1;
 

   		}
   		
   		

   		
   		$people_rezult[]=['name'=>$people->name,
   		                  'id'=>$people->id,
   	                      'split'=>$splitpeople,
   	                      'rt'=>$people->rt,
   	                      'color'=>	$colors[$color],

   	                      'rt_peregon'=>SiteOnlineController::formatTime($people->rt-$mopsplit->rt),
   	                      'finish'=>SiteOnlineController::formatTime($people->rt),
   	                  ];
   	                  $color=$color+1;
   	}



   


    // $laravel_object = app()->make('stdClass');
    // $object = app()->make('stdClass');
    // $object->scss='hgysg';
    // $laravel_object->foo=$object;
    // print_r($people_rezult);  
    // print_r($peopless);  
   	// $kp=$mopkp->where('ord',4);
   	// echo $kp;
   	// $num2=$mopkp->where('ord',5);
   	// print_r($num2->ctrl);
   	// echo $min;
   	// var_dump($people_rezult);
   	// var_dump($keys);
   




 




   return view('site.online.split', compact('event','seting','people_rezult','mopkp'));
   }


}



