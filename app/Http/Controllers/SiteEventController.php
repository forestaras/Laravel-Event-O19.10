<?php namespace App\Http\Controllers;

use CRUDBooster;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class SiteEventController extends \crocodicstudio\crudbooster\controllers\CBController
{
    public function dataua($dataevent)
    {
        $m=date_format(date_create($dataevent), 'm');
        $d=date_format(date_create($dataevent), 'd');
     switch ($m) {
         case '01':$x='січ';break;
         case '02':$x='лют';break;
         case '03':$x= 'бер';break;
         case '04':$x= 'кві';break;
         case '05':$x= 'тра';break;
         case '06':$x= 'чер';break;
         case '07':$x= 'лип';break;
         case '08':$x= 'сер';break;
         case '09':$x= 'вер';break;
         case '10':$x= 'жов';break;
         case '11':$x= 'лис';break;
         case '12':$x= 'гру';break;
        }
        $data=$d.' '.$x;
        return $data;

    }



	public function index()
    {
    	$seting=SetingController::seting();
        $yerstart=$_GET['yerastart'];
        $mountstart=$_GET['datastart'];


    	$events = DB::table('event')->where('activ',1)->where('datastart', 'like', $yerstart.'%'.$mountstart.'%')->orderBy('datastart', 'DESC')->get(); // Дані змагання

    	foreach ($events as $event) { 
            $event->registersetings=DB::table('registerseting')->where('eventid',$event->id)->get();         
    		$obl=DB::table('obl')->where('id',$event->oblid)->first();
            $event->datastart=SiteEventController::dataua($event->datastart);
            if ($event->datafinish!=0) { $event->datafinish=SiteEventController::dataua($event->datafinish);} 

             
    		$event->obltitle=$obl->title; //Міняємо ід на область
    	}
        return view('site.tableevent', compact('events','seting'));
    }






    	public function show($id)
    {
    	$seting=SetingController::seting();                    // Настройки меню і назва сайту
    	$event = DB::table('event')->where('id',$id)->first();  
        // $user=DB::table('cms_users')->where('id',CRUDBooster::myId())->first();	
    	$event->datastart=date_format(date_create($event->datastart), 'd-m-Y');   // Дані
    	$event->obl=DB::table('obl')->where('id',$event->oblid)->first();
    	$event->club=DB::table('club')->where('id',$event->clubid)->first();
        $event->registersetings = DB::table('registerseting')->where('eventid',$id)->get();//Дані про реєстрацію      
        return view('site.showevent', compact('event','seting'));
    }






       public function registerevent($registerid)
    {   $seting=SetingController::seting(); 
        $registerseting=DB::table('registerseting')->where('id',$registerid)->first();

        $event = DB::table('register')->where('eventid',$registerid)->get();   
        foreach ($event as $ev) {
            $x=$x+1;
            $grup[]=$ev->grup;
            $obl[]=$ev->obl;
            $club[]=$ev->club;
        }  
            
       
        if ($obl) {
            sort($obl);
            $event->obl=array_unique($obl);
        }
        if ($club) {
            sort($club);
            $event->club=array_unique($club);
        }

         $event->grup=explode(' ',$registerseting->grup);


        
        
        

        $event->countreg = $x;// кількість зареєстрованих

        return view('site.show_register', compact('seting','event','registerseting'));
    }






        public function register($id,$regid)
    {
    	$seting=SetingController::seting();                    // Настройки меню і назва сайту
    	$event = DB::table('registerseting')->where('id',$regid)->first();
        return view('site.registreevent', compact('seting','event'));
    }
        public function getLogout()
    {

        $me = CRUDBooster::me();
        CRUDBooster::insertLog(trans("crudbooster.log_logout", ['email' => $me->email]));

        Session::flush();

        return redirect()->route('getLogin')->with('message', trans("crudbooster.message_after_logout"));
    }
}