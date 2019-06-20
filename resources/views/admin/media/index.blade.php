@extends('layouts.admin')

@section('content')

    @if(Session::has('mediaFlash'))

        <p class="{{session('classFlash')}}">{{session('mediaFlash')}}</p>

    @endif

    <h1>Media</h1>

    @if($photos)

    <table class="table">
        <thead>
          <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Photo</th>
            <th>Created</th>
          </tr>
        </thead>
        <tbody>

        @foreach($photos as $photo)

          <tr>
            <td>{{$photo->id}}</td>
            <td>{{$photo->path}}</td>
            <td><img height="80" src="{{$photo->path}}" alt=""></td>
            <td>{{$photo->created_at}}</td>
            <td>

                {!! Form::open(['method'=>'DELETE', 'action'=>['AdminMediaController@destroy', $photo->id]]) !!}

                    <div class="form-group">
                        {!! Form::submit('Delete', ['class'=>'btn btn-danger']) !!}
                    </div>

                {!! Form::close() !!}

            </td>
          </tr>

        @endforeach


        </tbody>
      </table>

    @endif

@endsection