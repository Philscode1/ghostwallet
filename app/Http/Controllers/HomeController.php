<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Asset;
use App\Models\Price;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    /**
     * It returns the view home.index and passes  userAssets and assets with prices to the view.
     * 
     * @return The user's assets an all assets with prices.
     */
    public function index()
    {
        $userAssets=auth()->user()->assets;
        $assets= Asset::with('prices')->orderBy('name')->get();
        $allNews = DB::table('news')->orderBy('id')->paginate(1);
        return view('home.index',compact('userAssets', 'assets', 'allNews' ));
    }

    
    /**
     * Return view home.create with assets and form
     */
    public function create(){
        $assets= Asset::select('name', 'symbol', 'id')->orderBy('name')->get();
        return view('home.create',compact('assets'));
    }

    /**
     * It takes the user_id and asset_id from the form, finds the user, detaches the asset from the
     * user, and then attaches the asset to 'asset_user' with the amount from the form.
     * 
     * @param Request The request object.
     */
    public function store(Request $request){
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'asset_id' => 'required',
            'user_id' => 'required'
        ]);
        $user = User::find($request->user_id);
        $user->assets()->detach($request->asset_id);
        $user->assets()->attach($request->asset_id, [
            'amount'=>$request->amount ,
        ]);
        return redirect()->route('home.index')->with('success','Asset added!');
    }

    /**
     * It takes an asset object, finds the user, finds the user's asset, finds the prices for the
     * asset, and then returns a view with the user's asset, the asset, and the prices.
     * 
     * @param Asset the asset that was clicked on
     */
    public function show(Asset $asset){
        $user=auth()->user();
        $userAsset= DB::table('asset_user')
            ->where('asset_id', $asset->id)
            ->where ('user_id', $user->id)->get();
        $prices = DB::table('prices')
            ->where('asset_id', $asset->id)->get();
        return view('home.show',compact('userAsset', 'asset', 'prices'));
    }

    /**
     * It takes an asset object and returns a view with the asset object and a userAsset object.
     * 
     * @param Asset asset The asset object that was passed to the edit method.
     * 
     * @return A collection of objects.
     */
    public function edit(Asset $asset){
        $user=auth()->user();
        $userAsset= DB::table('asset_user')
            ->where('asset_id', $asset->id)
            ->where ('user_id', $user->id)->get();
        $userAsset = $userAsset[0];
        return view('home.edit',compact('userAsset','asset'));
    }

    /**
     * It takes the user's input, finds the user, detaches the asset from the user, and then reattaches
     * the asset to the user with the new amount.
     * 
     * @param Request request The request object.
     * @param Asset asset The asset object that is being updated.
     * 
     * @return The user is being returned.
     */
    public function update(Request $request, Asset $asset){
        $request->validate([
            'amount'=>'required|numeric|min:0.01'
        ]);
        $user = User::where('id', '=', Auth::user()->id)->get();
        $user[0]->assets()->detach($asset->id);
        $user[0]->assets()->attach($asset->id,[
            'amount'=>$request->amount ,
        ]);
        return redirect()->route('home.index')->with('success','Your amount of '.$asset->name.' has been changed');
    /**
     * It takes an asset id, finds the user and detaches the asset from the 'asset_user' table.
     * 
     * @param asset The asset id
     * 
     * @return home.index is returned with status message
     */
    }
    public function destroy($asset){
        $user = User::where('id', '=', Auth::user()->id)->get();
        if( $asset ){
            $user[0]->assets()->detach($asset);
            $status = 200;
            $msg = 'Asset deleted!';
            session()->put('success',$msg);
        }
        else{
            $status = 404;
            $msg = 'Asset not fund!';
        }
        if( request()->ajax() ){
            return response()->json(compact('status','msg'),$status);
        }
        if( $status != 200){
            abort($status,$msg);
        }
        
        return redirect()->route('home.index')->with('success',$msg);
    }
}

