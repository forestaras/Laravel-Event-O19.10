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
          <li data-filter=""  @if($_GET['sort']=='club' ) class="filter-active"@endif ><a href="?sort=club">Клуби</a></li>
           <li data-filter=""  @if($_GET['sort']=='tsah' ) class="filter-active"@endif ><a href="?sort=tsah">Шахматка</a></li>
          
        </ul>
        <div class="row content">
            <div class="col-md-6">



        	
            </div>
            <div class="col-md-6">
            	<a href="/event/{{$event->id}}">Сторінка змагань</a>
            </div>


        </div>
        <table class="table table-striped table-bordered">
          <tr>
            <td>Імя</td>
            @foreach($mopkp as $kp)<td>{{$kp->ctrl}}</td>@endforeach
            
            <td>Фініш</td>


          </tr>
           @foreach($people_rezult as $people)
          <tr>  
            <td>{{$people['name']}}</td>
            @foreach($people['split'] as $split)
            <td><abbsss title="{{$split['time_vidst_rt']}}">{{$split['time']}} ({{$split['count_all']}})</abbsss> <br>
            <abbsss title="{{$split['time_vidst_rt_peregon']}}">{{$split['time_peregon']}}({{$split['count_cp']}})</abbsss><br>
            
          </td>
            @endforeach
            <td>{{$people['finish']}}<br>
                {{$people['rt_peregon']}}
            </td>
          </tr>
          @endforeach
        </table>
        
       
        p
        <?php
        // print_r($peoples);
        // print_r($mopkp);
        ?>


        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div>
  <canvas id="myChart">
    <script>
// <block:setup:1>
const labels = [
'Старт',
@foreach($mopkp as $kp) 
  '{{$kp->ctrl}}', 
  @endforeach
  'Фініш',
];
const data = {
  labels: labels,
  datasets: [
  @foreach($people_rezult as $people) 
  {
    label: '{{$people['name']}}',
    backgroundColor: "{{$people['color']}}",
    borderColor: "{{$people['color']}}",
    data: [0,@foreach($people['split'] as $split) -{{$split['rttt']}},@endforeach],

  },
   @endforeach
   {
    label: 'СуперМен',
    backgroundColor: '#66ff33',
    borderColor: '#66ff33',
    data: [0,@foreach($mopkp as $kp) 0,@endforeach],
  },
]
};
// </block:setup>

// <block:config:0>
const config = {
  type: 'line',
  data,
  options: {
    plugins: {
      legend: {
        position: 'right',
      },
      title: {
        display: true,
        text: 'Chart.js Horizontal Bar Chart'
      }
    }
  }
  
};
// </block:config>

module.exports = {
  actions: [],
  config: config,
};
 </script>
 <script>
  // === include 'setup' then 'config' above ===

  var myChart = new Chart(
    document.getElementById('myChart'),
    config
  );
</script>
</canvas>
</div>
<!-- /.График -->



 









          </div>
      </div>      

  </section>
@endsection