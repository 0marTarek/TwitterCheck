@extends('layouts.app')

@section('content')
<style>
    .im{
        border-radius: 50%;
        width:100px;
        height:100px;
        margin-bottom:15px;
        
        
    }
</style>
<?php 
    $twitter_result = json_decode(auth()->user()->checkTwitter());
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header text-center">Welcome,    <b> {{Auth::user()->first_name . ' ' . Auth::user()->first_name }}</b></div>

                <div class="card-body text-center">
                    
                        <br>
                    <img class="im" src="{{asset(Auth::user()->profile_image)}}" alt="" srcset=""> <br>

                    <span><b>@</b>{{Auth::user()->username}}</span> <br>
                    <span><b> {{Auth::user()->email}}</b></span>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <h2>Welcome, {{auth()->user()->first_name . ' ' . auth()->user()->last_name }}</h2>
        </div>
        <div class="col-md-3"></div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header text-center">Twitter Account</div>

                <div class="card-body text-center">
                    @if($twitter_result->error == 0)
                    <img class="im" src="{{$twitter_result->image}}" alt="" srcset=""> <br>
                    <span><b>@</b>{{Auth::user()->username}}</span> <br> <br>
                        @if($twitter_result->tweets_count > 0)
                            <span><b> Last Tweet</b></span> <br>
                            
                            <p>{{$twitter_result->tweet}}</p>
                        @endif
                    @else
                    <span>Username not found on twitter</span> <br>
                    @endif
                </div>
            </div>


        </div>
        <div class="card mt-5">
            <div class="card-header">Feedback</div>

            <div class="card-body ">
                @if(Auth::user()->feedback == NULL)
                <form action="{{route('saveFeedback')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="feedback">Feedback.</label>
                        <textarea class="form-control" id="feedback" name="feedback" rows="3"></textarea>
                    </div>

                    <div class="form-check form-check-inline mt-2">
                        <input class="form-check-input" type="radio" name="right" id='yes' value="yes" >
                        <label for='yes'>
                            Yes, the result right 
                        </label>
                    </div>
                    <div class="form-check form-check-inline ">
                        <input class="form-check-input" type="radio" name="right" id="no" value="no" >
                        <label for="no">
                            No, it's NOT ..! 
                        </label>
                    </div><br>
                    <button class="btn btn-primary mt-2">Send</button>
                </form>
                @else
                <h3>Your feedback: </h3>
                <p>{{Auth::user()->feedback}}</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
