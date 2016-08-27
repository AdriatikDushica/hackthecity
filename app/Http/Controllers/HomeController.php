<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLocationRequest;
use App\Location;
use App\Type;
use Auth;
use Illuminate\Http\Request;

use App\Http\Requests;
use Storage;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $view = view('locations.index');

        $view->locations = request()->user()->locations()->orderBy('id', 'desc')->paginate(9);

        return $view;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $view = view('locations.create');

        $view->types = Type::all();

        return $view;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateLocationRequest $request)
    {
        $path = $request->file('file')->store('locations');

        Auth::user()->locations()->create([
            'path' => $path,
            'lat' => $request->get('lat'),
            'lng' => $request->get('lng'),
            'description' => $request->get('description'),
            'type_id' => $request->get('type'),
            'disabled' => $request->has('disabled')
        ]);

        return redirect('/home');
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

        $view->location = \App\Location::with('user')->where('id', '=', $id)->first();

        $view->types = \App\Type::all();

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
}
