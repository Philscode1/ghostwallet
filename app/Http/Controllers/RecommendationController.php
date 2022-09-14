<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recommendation;

class RecommendationController extends Controller
{
    /**
     * The index function returns the view recommendationForm
     * 
     * @return The view recommendation.recommendationForm
     */
    public function index()
    {
        return view('recommendation.recommendationForm');
    }
  
    /**
     * The store function stores the data from the recommendation form in the database
     * 
     * @param Request $request The request object
     * 
     * @return The view recommendation.recommendationForm
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'asset_name' => 'required',
            'asset_symbol' => 'required',
        ]);
  
        Recommendation::create($request->all());
  
        return redirect()->back()
            ->with(['success' => 'Thank you for your asset recommendation. We will add it as soon as possible.']);
    }
}
