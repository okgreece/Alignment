<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\LabelExtractor;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;

class LabelExtractorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        $labelextractor = LabelExtractor::paginate(15);

        return view('label-extractor.index', compact('labelextractor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        return view('label-extractor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return void
     */
    public function store(Request $request)
    {
        
        LabelExtractor::create($request->all());
   
        Session::flash('flash_message', 'LabelExtractor added!');

        return redirect('label-extractor');
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
        $labelextractor = LabelExtractor::findOrFail($id);

        return view('label-extractor.show', compact('labelextractor'));
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
        $labelextractor = LabelExtractor::findOrFail($id);

        return view('label-extractor.edit', compact('labelextractor'));
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
        
        $labelextractor = LabelExtractor::findOrFail($id);
        $labelextractor->update($request->all());

        Session::flash('flash_message', 'LabelExtractor updated!');

        return redirect('label-extractor');
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
        LabelExtractor::destroy($id);

        Session::flash('flash_message', 'LabelExtractor deleted!');

        return redirect('label-extractor');
    } 
    
}
