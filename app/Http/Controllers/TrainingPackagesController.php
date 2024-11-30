<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrainingPackage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class TrainingPackagesController extends Controller
{
    #=======================================================================================#
    #			                             index                                         	#
    #=======================================================================================#
    public function index(Request $request)
    {
        $query = TrainingPackage::query(); // Initialize the query for training packages

        // Apply search filter if provided
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Paginate results
        $packages = $query->paginate(10); // Specify number of items per page

        // Show empty view if no results and no search applied
        if ($packages->isEmpty() && !$request->has('search')) {
            return view('empty');
        }

        return view('trainingPackages.listPackages', [
            'packages' => $packages,
            'search' => $request->input('search', ''), // Retain search input in the view
        ]);
    }
    #=======================================================================================#
    #			                             create                                        	#
    #=======================================================================================#
    public function create()
    {
        $packages = TrainingPackage::all();


        return view('trainingPackages.creatPackage', [
            'packages' => $packages,

        ]);
    }
    #=======================================================================================#
    #			                             store                                         	#
    #=======================================================================================#
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'price' => ['required', 'numeric', 'min:10', 'max:90'],
            'sessions_number' => ['required', 'numeric', 'min:1', 'max:40'],
        ]);

        $requestData = request()->all();
        $package = TrainingPackage::create($requestData);

        $id = $package->id;


        $data = array('gym_id' => $request->gym_id, "training_package_id" => $id);
        DB::table('gyms_training_packages')->insert($data);



        return redirect()->route('trainingPackages.listPackages');
    }
    #=======================================================================================#
    #			                             show                                         	#
    #=======================================================================================#
    public function show($id)
    {
        $package = TrainingPackage::findorfail($id);
        return view('trainingPackages.show_training_package', ['package' => $package]);
    }
    #=======================================================================================#
    #			                             edit                                         	#
    #=======================================================================================#
    public function edit($id)
    {
        $packages = TrainingPackage::all();

        $package = TrainingPackage::find($id);

        return view('trainingPackages.editPackage', ['package' => $package, 'packages' => $packages]);
    }
    #=======================================================================================#
    #			                             update                                         #
    #=======================================================================================#
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required'],
            'price' => ['required', 'numeric', 'min:10', 'max:4000'],
            'sessions_number' => ['required', 'numeric', 'min:1', 'max:60']
        ]);


        TrainingPackage::where('id', $id)->update([

            'name' => $request->all()['name'],
            'price' => $request->price * 100,
            'sessions_number' => $request->sessions_number,




        ]);
        return redirect()->route('trainingPackages.listPackages');
    }
    #=======================================================================================#
    #			                             destroy                                       	#
    #=======================================================================================#
    public function deletePackage($id)
    {
        $package = TrainingPackage::findorfail($id);
        $package->delete();
        return response()->json(['success' => 'Record deleted successfully!']);
    }
}
