<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLocationRequest;
use App\Location;
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

        $faker = \Faker\Factory::create('it');

        Auth::user()->locations()->create([
            'path' => $path,
            'lat' => $faker->randomFloat(8, 90, 100),
            'lng' => $faker->randomFloat(8, 90, 100),
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
        //
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
        //
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

        return back();
    }
}
