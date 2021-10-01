@extends('site.index')
@section('content')
 <section id="portfolio" class="portfolio">
      <div class="container" data-aos="fade-up">
      	   <div class="section-title">
             <h2>РЕЗУЛЬТАТИ</h2>
             <p>Сторінка перегляду результатів змагань. Ви можете відсортувати за групами  або командами, скориставшись фільтром.</p>
           </div>
           @foreach($peoples as $people)
           {{$people['name']}}
           {{$people['clas']}}
           {{$people['rezult']}}
       
           <br>
           @endforeach

        

        
      </div>      
  </section>
@endsection