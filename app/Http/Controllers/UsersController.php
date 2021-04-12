<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    public function register(Request $request){
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'slug' => Str::slug($request->name),
        ]);

        return response()->json([
            'logged' => true,
            'name' => $user->name,
            'email' => $user->email,
            'id' => $user->id,
            'admin' => $user->admin,
            'slug' => $user->slug,
        ]);
    }

    public function login(Request $request){
        if(auth()->attempt(
            ['email' => $request->email,'password' => $request->password]
        )){
            return response()->json([
                'logged' => true,
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
                'id' => auth()->user()->id,
                'admin' => auth()->user()->admin,
            ]);
        }else{
            return response()->json([
                'error' => 'Email ou mot de passe est incorrect'
            ]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Carbon::setlocale('fr');
        $users = User::all();
        foreach($users as $user){
            $user->setAttribute('added', Carbon::parse($user->created_at)->diffForHumans());
            $user->setAttribute('path', '/user/'.$user->slug);
            
        }
        return response()->json($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $user = User::where('slug',$slug)->first();
        return response()->json(['user' =>[
            'id' => $user->id,
            'name' => $user->name,
            'slug' => $user->slug,
            'email' => $user->email,
            //'comments_count' => $post->comments->count(),
            'posts' => $this->postsArray($user->posts)
        ]]);
    }
    public function postsArray($posts){
        $jsonposts = [];
        foreach($posts as $post){
            array_push($jsonposts,[
                'id' => $post->id,
                'title' => $post->title,
                'category' => $post->category->name,
                'photo' => $post->photo,
                'body' => $post->body,
                'slug' => $post->slug,
                'created_at' => $post->created_at->diffForHumans(),
                'user' => $post->user->name,
                'path' => 'post/'.$post->slug
            ]);
        }
        return $jsonposts;
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
