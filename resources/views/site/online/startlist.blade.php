@extends('site.index')
@section('content')
 <section id="portfolio" class="portfolio">
      <div class="container" data-aos="fade-up">
      	 <div class="section-title">
          <h2>Стартові:{{$event->name}}</h2>
          <p>Сторінка перегляду результатів змагань. Ви можете відсортувати за групами  або командами, скориставшись фільтром.</p>
        </div>

        <ul id="portfolio-flters" class="d-flex justify-content-center" data-aos="fade-up" data-aos-delay="100">
          <li data-filter=""  @if($_GET['sort']=='grup'  or !$_GET) class="filter-active"@endif ><a href="?sort=grup">Групи</a></li>
          <li data-filter=""  @if($_GET['sort']=='club'  or !$_GET) class="filter-active"@endif ><a href="?sort=club">Клуби</a></li>
           <li data-filter=""  @if($_GET['sort']=='tsah'  or !$_GET) class="filter-active"@endif ><a href="?sort=tsah">Шахматка</a></li>
          
        </ul>
        <div class="row content">
            <div class="col-md-6">


        	СТАРТОВІ:{{$event->name}}  <br>
        	Дата змагань: {{date_format(date_create($event->date), 'd.m.Y')}}<br>
        	Учасників: {{$event->count_people}}<br>
        	Команд: {{ $event->count_club}}
        	
            </div>
            <div class="col-md-6">
            	<a href="/event/{{$event->id}}">Сторінка змагань</a>
            </div>


        </div>

      	 <div class="table-responsive">
      	 	@if($_GET['sort']=='grup')
      	 	   	@foreach($grups as $grup)
      	 	   	<p id="{{$grup->name}}">
            	<br>
            	<br>
            	<br>
            	<br>	
                </p>

      	 	   	@foreach($grups as $grupa)
        	   <a href="#{{$grupa->name}}">{{$grupa->name}}</a>|
        	    @endforeach
        	   <h3>{{$grup->name}}</h3>
        	    
            <table id="my" style="width:99%" class="table table-striped table-bordered">
              <thead>
              	<!-- {{$events}} -->
                <tr>
                  <th>#п.п</th>
                  <th>SI</th>
                  <th>Імя</th>
                  <th>Команда,клуб</th>
                      
                  <th>Старт</th>
                </tr>
              </thead>
              <tbody> 
                <?php  $x=0; ?>
      	      @foreach($peoples as $people)
      	      @if($grup->name==$people['cls']) 
              <?php  $x=$x+1; ?>
      <tr>
        
        <td> {{$x}}</td>       
      	<td> {{$people['si']}}</td>     	
      	<td>{{$people['name']}}</td>
      	<th><a href="?sort=club#{{$people['org']}}">{{$people['org']}}</a></th>
      
      	<td>{{$people['start']}}</td>
      </tr>  
              @endif
      	      @endforeach
       
             
                                
              </tbody>
            </table>
     @endforeach
     @endif



     @if($_GET['sort']=='club')
           	 @foreach($clubs as $club)
      	 	   	<p id="{{$club->name}}">
            	<br>
            	<br>
            	<br>
            	<br>	
                </p>

      	 	   	@foreach($clubs as $cluba)
        	   <a href="#{{$cluba->name}}">{{$cluba->name}}</a>|
        	    @endforeach
        	   <h3>{{$club->name}}</h3>
        	    
            <table id="my" style="width:99%" class="table table-striped table-bordered">
              <thead>
              	<!-- {{$events}} -->
               <tr>
                  <th>#п.п</th>
                  <th>SI</th>
                  <th>Імя</th>
                  <th>Група</th>                      
                  <th>Старт</th>
                </tr>
              </thead>
              <tbody> 
                 <?php  $x=0; ?>
      	      @foreach($peoples as $people)
      	      @if($club->name==$people['org']) 
               <?php  $x=$x+1; ?>
      <tr>
        <td> {{$x}}</td>       
        <td> {{$people['si']}}</td>       
        <td>{{$people['name']}}</td>
      	<th><a href="?sort=grup#{{$people['cls']}}">{{$people['cls']}}</a></th>
        <td>{{$people['start']}}</td>
      </tr>  
              @endif
      	      @endforeach
       
             
                                
              </tbody>
            </table>
     @endforeach
     @endif



     @if($_GET['sort']=='tsah')
            <table id="my" style="width:99%" class="table table-striped table-bordered">
              <thead>
                <!-- {{$events}} -->
               <tr>
                  <th>#п.п</th>
                  <th>SI</th>
                  <th>Імя</th>
                  <th>Група</th>                      
                  <th>Клуб</th>                      
                  <th>Старт</th>
                </tr>
              </thead>
              <tbody> 
                 <?php  $x=0; ?>
              @foreach($peoples as $people)
               
               <?php  $x=$x+1; ?>
      <tr>
        <td> {{$x}}</td>       
        <td> {{$people['si']}}</td>       
        <td>{{$people['name']}}</td>
        <th><a href="?sort=grup#{{$people['cls']}}">{{$people['cls']}}</a></th>
        <th><a href="?sort=club#{{$people['org']}}">{{$people['org']}}</a></th>
        
        <td>{{$people['start']}}</td>
      </tr>  
             
              @endforeach
       
             
                                
              </tbody>
            </table>
     @endif

          </div>
      </div>      

  </section>
@endsection