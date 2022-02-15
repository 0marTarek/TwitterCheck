<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Http;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'phone',
        'gender',
        'profile_image',
        'email',
        'password',
        'feedback',
        'rightFeedback',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function checkTwitter()
    {
        //$username = 'omartarek';
        $token = env('BEARER_TOKEN');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->get('https://api.twitter.com/2/users/by?usernames='. auth()->user()->username);
        

        $resultObj = new \stdClass;
        $resultObj->error = 0;

        $response_json = json_decode($response);
        if(isset($response_json->errors))
        {
            $resultObj->error = 1;
        }else{
            
            // user have twitter account

                //Getting the user information in json format (to get profile image). userId used to get the info.
                $userInfo = Http::withHeaders([
                    'Authorization' => 'Bearer '. $token,
                ])->get('https://api.twitter.com/1.1/users/show.json?id='. $response_json->data[0]->id);
                $userInfo_json = json_decode($userInfo);
                $resultObj->image = $userInfo_json->profile_image_url_https;

                //Getting the latest tweet by userId.
                $tweet = Http::withHeaders([
                    'Authorization' => 'Bearer '. $token,
                ])->get('https://api.twitter.com/2/users/'. $response_json->data[0]->id . '/tweets');
                $tweet_json = json_decode($tweet);
                $resultObj->tweets_count = count($tweet_json->data);
                if($resultObj->tweets_count > 0)
                {
                    $resultObj->tweet = $tweet_json->data[0]->text;
                }
                


        }
        //return json_decode($response)->errors[0]->detail;
        return json_encode($resultObj);
    }

}
