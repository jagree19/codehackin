@extends('layouts.blog-post')

@section('content')


    <!-- Blog Post -->

    <!-- Title -->
    <h1>{{$post->title}}</h1>

    <!-- Author -->
    <p class="lead">
        by <a href="#">{{$post->user->name}}</a>
    </p>

    <hr>

    <!-- Date/Time -->
    <p><span class="glyphicon glyphicon-time"></span> Posted {{$post->created_at->diffForHumans()}}</p>

    <hr>

    <!-- Preview Image -->
    <img class="img-responsive" src="{{$post->photo->path}}" alt="">

    <hr>

    <!-- Post Content -->
    <p>{{$post->body}}</p>

    <hr>

    @if(Session::has('commentFlash'))

        <p class="{{session('classFlash')}}">{{session('commentFlash')}}</p>

    @endif

    <!-- Blog Comments -->

    @if(Auth::check())

    <!-- Comments Form -->
    <div class="well">
        <h4>Leave a Comment:</h4>


        {!! Form::open(['method'=>'POST', 'action'=>'PostCommentsController@store']) !!}

        <input type="hidden" name="post_id" value="{{$post->id}}">

            <div class="form-group">

                {!! Form::textarea('body', null, ['class'=>'form-control', 'rows'=>3]) !!}
            </div>

            <div class="form-group">
                {!! Form::submit('Create Post', ['class'=>'btn btn-primary']) !!}
            </div>

        {!! Form::close() !!}


    </div>

    @endif

    <hr>

    <!-- Posted Comments -->

    @if(count($post->comments) > 0)

        @foreach($post->comments as $comment)

            @if($comment->is_active == 1)

    <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img  height="64" class="media-object" src="{{Auth::user()->gravatar}}" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">{{$comment->author}}
                            <small>{{$comment->created_at->diffForHumans()}}</small>
                        </h4>
                        {{$comment->body}}

                        <div class="comment-reply-container">

                            <button id="toggle-reply" class="toggle-reply btn btn-primary pull-right">Reply</button>

                            <div class="comment-reply">

                                {!! Form::open(['method'=>'POST', 'action'=>'CommentRepliesController@createReply']) !!}

                                <input type="hidden" name="comment_id" value="{{$comment->id}}">

                                <div class="form-group">
                                    {!! Form::textarea('body', null, ['class'=>'form-control','rows'=>1]) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::submit('Reply', ['class'=>'btn btn-primary']) !!}
                                </div>

                                {!! Form::close() !!}

                            </div>

                        </div>

                    <!-- Nested Comment -->
                        @if(Session::has('replyFlash'))

                            <p class="{{session('classFlash')}}">{{session('replyFlash')}}</p>

                        @endif

                        @if(count($comment->replies) > 0)

                            @foreach($comment->replies as $reply)

                                @if($reply->is_active == 1)


                                    <div id="nested-comment" class="media">
                                        <a class="pull-left" href="#">
                                            <img height="64" class="media-object" src="{{$reply->photo}}" alt="">
                                        </a>
                                        <div class="media-body">
                                            <h4 class="media-heading">{{$reply->author}}
                                                <small>{{$reply->created_at->diffForHumans()}}</small>
                                            </h4>
                                            {{$reply->body}}
                                        </div>


                                        <div class="comment-reply-container">

                                            <button id="toggle-reply" class="toggle-reply btn btn-primary pull-right">Reply</button>

                                            <div class="comment-reply">

                                                {!! Form::open(['method'=>'POST', 'action'=>'CommentRepliesController@createReply']) !!}

                                                    <input type="hidden" name="comment_id" value="{{$comment->id}}">

                                                    <div class="form-group">
                                                        {!! Form::textarea('body', null, ['class'=>'form-control','rows'=>1]) !!}
                                                    </div>

                                                    <div class="form-group">
                                                        {!! Form::submit('Reply', ['class'=>'btn btn-primary']) !!}
                                                    </div>

                                                {!! Form::close() !!}

                                            </div>

                                        </div>

                                    </div>

                                @endif

                            @endforeach

                        @endif
                        <!-- End Nested Comment -->

                    </div>
                </div>


            @endif

        @endforeach

    @endif


@endsection

@section('scripts')

    <script>
        $(".comment-reply-container .toggle-reply").click(function() {

            $(this).next().slideToggle('slow');

        });
    </script>


@endsection