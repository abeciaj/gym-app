<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Gym;

class AllUsersController extends Controller
{
    #=======================================================================================#
    #			                           List Function                                	#
    #=======================================================================================#
    public function list(Request $request)
    {
        $query = User::role('user')->withoutBanned(); // Initialize the query for users

        // Apply search filter if provided
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%'); // Adjust fields as needed
            });
        }

        // Paginate results
        $users = $query->paginate(10); // Specify number of items per page

        // Show empty view if no results and no search applied
        if ($users->isEmpty() && !$request->has('search')) {
            return view('empty');
        }

        return view("allUsers.list", [
            'users' => $users,
            'search' => $request->input('search', ''), // Retain search input in the view
        ]);
    }
    #=======================================================================================#
    #			                           Show Function                                	#
    #=======================================================================================#
    public function show($id)
    {
        $singleUser = User::findorfail($id);
        return view("allUsers.show", ['singleUser' => $singleUser]);
    }
    #=======================================================================================#
    #			                           Delete Function                                	#
    #=======================================================================================#
    public function deleteUser($id)
    {
        $singleUser = User::findorfail($id);
        $singleUser->delete();
        return response()->json(['success' => 'Record deleted successfully!']);
    }


    #=======================================================================================#
    #			                        Assign Gym To User                              	#
    #=======================================================================================#
    public function addGym($id)
    {
        $singleUser = User::findorfail($id);
        return view('allUsers.addGym', [
            'user' => User::find($id),
            'gyms' => Gym::all(),
        ]);
    }

    public function submitGym(Request $request, $user_id)
    {
        $user = User::find($user_id);
        $request->validate([
            'gym_id' => 'required',
        ]);
        $user->gym_id = $request->gym_id;
        $user->update(['gym_id' => $request->gym_id]);
        $usersFromDB =  User::role('user')->withoutBanned()->get();
        return view("allUsers.list", ['users' => $usersFromDB]);
    }
}
