<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Pricing;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Course $course)
    {
        $course = $course;
        $price = Pricing::where('courseId', $course->id)->first();

        return view('Teacher.Course.pricing', compact(['course', 'price']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Course $course)
    {
        $validated = $request->validate([
            'price' => 'required|numeric',
            'currency' => 'required|string',
            'currencySymbol' => 'required|string',
        ]);

        $validated['courseId'] = $course->id;
        
        Pricing::updateOrCreate(['courseId' => $course->id],[
            'price'=> $validated['price'],
            'currency'=> $validated['currency'],
            'currencySymbol'=> $validated['currencySymbol'],
        ]);
        return redirect()->back()->with('success', 'Pricing Saved Successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Pricing $pricing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pricing $pricing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pricing $pricing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pricing $pricing)
    {
        //
    }
}
