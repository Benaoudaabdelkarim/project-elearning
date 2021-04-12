<?php

namespace App\Http\Controllers;

use App\Email;
use Illuminate\Http\Request;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Carbon::setlocale('fr');
        $emails = Email::all();
        foreach($emails as $email){
            $email->setAttribute('added', Carbon::parse($email->created_at)->diffForHumans());
            $email->setAttribute('path', '/email/'.$email->slug);
            
        }
        return response()->json($emails);
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
        Eamil::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'slug' => Str::slug($request->subject),
            'number' => $request->number,
            'message' => $request->message,
        ]);
        return response()->json(['message' => 'Email sended']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $email = Email::where('slug',$slug)->first();
        Carbon::setlocale('fr');
        return response()->json([
            'id' => $email->id,
            'name' => $email->name,
            'slug' => $email->slug,
            'email' => $email->email,
            'created_at' => $email->created_at->diffForHumans(),
            'subject' => $email->subject,
            'number' => $email->number,
            'message' => $email->message
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function edit(Email $email)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Email $email)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function destroy(Email $email)
    {
        $email->delete();
        return response()->json(['message' => 'email deleted']);
    }
}
