<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class TweetController extends Controller
{
    public function index()
    {
        $tweets = Tweet::orderBy('created_at', 'DESC')
        ->with(['user' => function ($q) {
            return $q->withCount([
            'followers as isFollowing' => function ($q) {
                return $q
                ->where('follower_id', auth()->user()->id);}])
                ->withCasts(['isFollowing' => 'boolean']);}
        ])->get();

        return Inertia::render('Tweets/Index', [
            'tweets' => $tweets
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => ['required', 'max: 280'],
            'user_id' => ['exists:users,id']
        ]);

        Tweet::create([
            'content' => $request->input('content'),
            'user_id' => auth()->user()->id
        ]);

        return Redirect::route('tweets.index');
    }

    public function profile(User $user)
    {
        $profileUser = $user->loadCount([
            'followings as isFollowingYou' =>
                function ($q) { return $q->where('following_id', auth()->user()->id)->withCasts(['is_following_you' => 'boolean']); },
            'followers as isFollowed' =>
                function ($q) { return $q->where('follower_id', auth()->user()->id)->withCasts(['is_followed' => 'boolean']); }
        ]);

        $tweets = $user->tweets;

        return Inertia::render('Tweets/Profile', [
            'profileUser' => $profileUser,
            'tweets' => $tweets
        ]);
    }

    public function follows(User $user)
    {
        auth()->user()->followings()->attach($user->id);
        return Redirect::route('tweets.index');
    }

    public function unfollows(User $user)
    {
        auth()->user()->followings()->detach($user->id);
        return redirect()->back();
    }

    public function followings()
    {
        $followings = Tweet::with('user')
        ->whereIn('user_id', auth()->user()->followings->pluck('id')->toArray())
        ->orderBy('created_at', 'DESC')->get();
        
        return Inertia::render('Tweets/Followings', ['followings' => $followings]);
    }

    public function shag($shag)
    {
        $tweets = Tweet::with('user')->where('content', 'LIKE', '%#' . $shag . '%')->get();
        return Inertia::render('Tweets/Index', ['tweets' => $tweets, 'shag' => $shag]);
    }

    public function destroy(Tweet $tweet)
    {
        $this->authorize('destroy', $tweet);
        $tweet->delete();
        
        return redirect()->back();
    }

    public function update(Tweet $tweet, Request $request)
    {
        $this->authorize('update', $tweet);
        $request->validate([
            'tweetContent' => ['required', 'max: 280']
        ]);
        $tweet->content = $request->input('tweetContent');
        $tweet->save();
        
        return redirect()->back();
    }
}