@extends('layouts.app')

@section('content')
<div class="main-todo">
    <h1 class="title-todo">TODO APP </h1>
    <div class="layout-main">
        <form class="form-input" method="POST">
            <input class="input-main" name="message" type="text" placeholder="Enter the to-do list">
        </form>
        <div id="works">
            @foreach ($works as $work)
            <div class="d-flex" class="work" id="work{{$work->id}}">
                <p id="work{{$work->id}}" class="@if($work->status == "0") text-light @else text-success @endif">{{$work->message}}  |  <p>
                <p style="color: white" class="ml-3">{{$work->created_at}}<p>
                @if($work->status == '0')
                    <button class="done ml-3 btn btn-primary button{{$work->id}}" id="{{$work->id}}">Click to Done</button>
                @else
                    <button class="done ml-3 btn btn-success button{{$work->id}}" id="{{$work->id}}">Click to UnDone</button>   
                @endif
                <button class="ml-3 btn btn-danger delete" data-id="{{$work->id}}">Delete</button>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection