<?php

namespace App\Http\Controllers\Admin\Data\Items;

use App\Models\Data\Unit;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UnitsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $units = Unit::paginate(5);

        if ($request->search) {
            $units = Unit::where(
                'name',
                'LIKE',
                "%$request->search%"
            )->paginate(5);
        }

        return view('admin.item-mgmt.units.index', compact('units'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $unit = Unit::findOrFail($id);
        return response()->json($unit);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
        ]);
        $unit = $request->only('name', 'description');
        $action = Unit::create($unit);
        if (!$action) {
            return redirect()->back()->with('error','Failed add new Unit');
        }
        return redirect()->back()->with('success','Unit created successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $unit = Unit::findOrFail($request->id);
        $unit->name = $request->name;
        $unit->description = $request->description;
        $unit->save();
        return redirect()->back()->with('success','Unit updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Unit::findOrFail($id)->delete();
        return redirect()
                ->route('admin.items.units.index')
                ->with('success', 'Units delete successfully');
    }
}