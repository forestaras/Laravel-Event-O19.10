<!-- First, extends to the CRUDBooster Layout -->
@extends('crudbooster::admin_template')

@section('content')
  <style type="text/css">
.col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9 {
	position: relative;
	min-height: 1px;
	padding-right: 1px;
	padding-left: 1px;
}
  </style>

  <div class='panel panel-default'>
	<div class='panel-heading'>Реєстрація </div>    
  </div>

  <a href="/admin/event19/edit/{{$row->id}}">Редагувати</a> <br>

<p>
  <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
    РЕЄСТРАЦІЇ
  </a>
</p>
<div class="collapse" id="collapseExample">
  <div class="card card-body">
  <table class="table">
  <thead>
    <tr>
      <th scope="col">Назва</th>
      <th scope="col">Тренер</th>
      <th scope="col">Клуб</th>
      <th scope="col">Обл</th>
      <th scope="col">Розряд</th>
      <th scope="col">SI</th>
      <th scope="col">Рік</th>
      <th scope="col">Групи</th>
      <th scope="col">Дні</th>
      <th scope="col">Кінець реєстрації</th>
    </tr>
  </thead>
  <tbody>
  	@foreach($registersetings as $registerseting)
  	<tr>
      <th scope="row">{{$registerseting->title}}</th>
      <td>{{$registerseting->trener}}</td>
      <td>{{$registerseting->club}}</td>
      <td>{{$registerseting->obl}}</td>
      <td>{{$registerseting->roz}}</td>
      <td>{{$registerseting->si}}</td>
      <td>{{$registerseting->rik}}</td>
      <td>{{$registerseting->grup}}</td>
      <td>{{$registerseting->dni}}</td>
      <td>{{$registerseting->datestop}}</td>
      <td><a href="/admin/registerseting/delete/{{$registerseting->id}}">Видалити</a></td>
      <td><a href="/admin/registerseting/edit/{{$registerseting->id}}">Редагувати</a></td>
      
      
    </tr>
  	@endforeach 
  </tbody>
</table>
  </div>
   <a href="/admin/registerseting/add/?event={{$row->id}}">Додати реєстрацію</a>
</div>
<p>
  <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample">
    ПОСИЛАННЯ
  </a>
</p>
<div class="collapse" id="collapseExample2">
  <div class="card card-body">
  <table class="table">
  <thead>
    <tr>
      <th scope="col">Лінк</th>
      <th scope="col">URL</th>
    </tr>
  </thead>
  <tbody>
    @foreach($links as $link)
    <tr>
      <th scope="row"><a href="{{$link->text}}">{{$link->titlesilka}}</a></th>
      <td>{{$link->text}}</td>
      <td><a href="/admin/eventdop/delete/{{$link->id}}">Видалити</a></td>
      <td><a href="/admin/eventdop/edit/{{$link->id}}">Редагувати</a></td>
      
      
    </tr>
    @endforeach 
  </tbody>
</table>
  </div>
   <a href="/admin/eventdop/add/?event={{$row->id}}">Додати посилання</a>
</div>

<p>



  <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample3" role="button" aria-expanded="false" aria-controls="collapseExample">
    Онлайн
  </a>
</p>
<div class="collapse" id="collapseExample3">
  <div class="card card-body">
  <table class="table">
  <thead>
    <tr>
      <th scope="col">Назва онлайну</th>
      <th scope="col">Дата початку</th>
      <th scope="col">ID онлайну</th>
      <th scope="col">Пароль</th>
    </tr>
  </thead>
  <tbody>
    @foreach($onlines as $online)
    <tr>      
      <td>{{$online->name}}</td>
      <th>{{$online->datestart}}</th>
      <th>{{$online->id}}</th>
      <th>{{$online->cod}}</th>
      <td><a href="/admin/online/delete/{{$online->id}}">Видалити</a></td>
      <td><a href="/admin/online/edit/{{$online->id}}">Редагувати</a></td>
      
      
    </tr>
    @endforeach 
  </tbody>
</table>
  </div>
   <a href="/admin/online/add/?event={{$row->id}}">Додати ОНЛАЙН</a>
</div>
 
  
  @if($_GET['register']=='add')
  {{$register}}
  @endif

@endsection