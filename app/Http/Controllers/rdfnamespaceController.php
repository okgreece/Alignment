<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\rdfnamespace;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;

class rdfnamespaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        $rdfnamespace = rdfnamespace::paginate(15);

        return view('rdfnamespace.index', compact('rdfnamespace'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        return view('rdfnamespace.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return void
     */
    public function store(Request $request)
    {
        
        rdfnamespace::create($request->all());

        Session::flash('flash_message', 'rdfnamespace added!');

        return redirect('rdfnamespace');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function show($id)
    {
        $rdfnamespace = rdfnamespace::findOrFail($id);

        return view('rdfnamespace.show', compact('rdfnamespace'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function edit($id)
    {
        $rdfnamespace = rdfnamespace::findOrFail($id);

        return view('rdfnamespace.edit', compact('rdfnamespace'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function update($id, Request $request)
    {
        
        $rdfnamespace = rdfnamespace::findOrFail($id);
        $rdfnamespace->update($request->all());

        Session::flash('flash_message', 'rdfnamespace updated!');

        return redirect('rdfnamespace');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function destroy($id)
    {
        rdfnamespace::destroy($id);

        Session::flash('flash_message', 'rdfnamespace deleted!');

        return redirect('rdfnamespace');
    }
}
