<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\CreateCommentRequest;
use App\Http\Requests\CreateLocationRequest;
use App\Location;
use App\Notification;
use App\Type;
use App\User;
use Auth;
use Illuminate\Http\Request;

use App\Http\Requests;
use Storage;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $view = view('locations.index');

        $view->locations = request()->user()->locations()->whereNotNull('type_id')->orderBy('id', 'desc')->paginate(9);

        return $view;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('locations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateLocationRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateLocationRequest $request)
    {
        $path = $request->file('file')->store('locations');

        $reader = \PHPExif\Reader\Reader::factory(\PHPExif\Reader\Reader::TYPE_NATIVE);

        $exif = $reader->read(storage_path('app/' . $path));

        $location = Auth::user()->locations()->create([
            'path' => $path,
            'lat' => ($exif && $exif->getGPS()) ? explode(',', $exif->getGPS())[0] : null,
            'lng' => ($exif && $exif->getGPS()) ? explode(',', $exif->getGPS())[1] : null
        ]);

        return redirect('/create/'.$location->id.'/next');
    }

    public function createNext(Location $location)
    {
        $view = view('locations.create-next');

        $view->types = Type::all();
        $view->location = $location;

        return $view;
    }

    public function storeNext($id, Requests\CreateNextLocationRequest $request)
    {
        $location = Location::find($id);

        $location->update([
            'description' => $request->get('description'),
            'type_id' => $request->get('type'),
            'lat' => $request->get('lat'),
            'lng' => $request->get('lng'),
            'disabled' => $request->get('disabled')
        ]);

        return redirect('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $view = view('locations.edit');

        $view->location = Location::with('user')->where('id', '=', $id)->first();

        $view->types = Type::all();

        return $view;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        dd('updating...');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $location = Location::find($id);

        Storage::delete($location->path);

        $location->delete();

        return back()->with('success', 'Foto eliminata con successo');
    }

    public function detail($id)
    {
        return view('locations.detail')->with('location', \App\Location::with('usersLike', 'comments')->where('id', '=', $id)->first());
    }

    public function like(\App\Location $location, Request $request)
    {
        $likes = \Auth::user()->likes->where('id', '=', $location->id);

        if($likes->count()) {
            $request->user()->likes()->detach($likes);
        } else {
            $request->user()->likes()->attach($location);

            if($request->user()->id!=$location->user_id) {
                Notification::create([
                    'user_id' => $location->user_id,
                    'from_user_id' => $request->user()->id,
                    'location_id' => $location->id,
                    'type' => 'like',
                    'notified' => false
                ]);
            }
        }

        return back();
    }

    public function comment($id, CreateCommentRequest $request)
    {
        Comment::create([
            'text' => $request->get('text'),
            'user_id' => $request->user()->id,
            'location_id' => $id
        ]);

        $location = Location::find($id);

        if($location->user_id!=$request->user()->id) {
            Notification::create([
                'user_id' => $location->user->id,
                'from_user_id' => $request->user()->id,
                'location_id' => $location->id,
                'type' => 'comment',
                'notified' => false
            ]);
        }

        return back();
    }

    public function deleteComment($id)
    {
        Comment::find($id)->delete();

        return back()->with('success', 'Commento eliminato con successo');
    }

    public function more($id)
    {
        $view = view('more');

        $user = User::find($id);

        $view->user = $user;
        $view->locations = Location::where('user_id', '=', $user->id)->whereNotNull('type_id')->paginate(9);

        return $view;
    }

    public function liked(\Illuminate\Http\Request $request)
    {
        $view = view('locations.liked');
        $view->locations = $request->user()->likes()->whereNotNull('type_id')->paginate(9);
        return $view;
    }
}
