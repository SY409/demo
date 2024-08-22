<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\Contracts\DataTable;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::select('id', 'name', 'email')->get();
        return view('index', [
            'user' => $users,
        ])->with('success', 'Data Inserted');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('registration');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:30',
            'phone' => 'required|digits:10',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);
        $insert = User::insert([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $request->password,
        ]);
        if ($insert) {
            return back()->with('success', 'Data Inserted');
        } else {
            return back()->with('error', 'Data not inserted');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $editData = User::find($id);
        return view('editForm', ['data' => $editData]);


        // return response()->json([
        //     'success' => true,
        //     'html' => $viewContent
        // ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd("from update");
        $updated = User::where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);
        // if ($updated) {
        //     return response()->json(['success' => true, 'message' => 'User updated successfully.']);
        // } else {
        //     return response()->json(['success' => false, 'message' => 'User not found or no changes made.'], 404);
        // }
        if ($updated) {
            return redirect('user')->with('success', 'Data Updated Successfully');
        } else {
            return back()->with('error', 'Data cannot be Update');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // dd($id);
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return redirect('user')->with('success', 'Data Deleted Successfully');
        } else {
            return back()->with('error', 'Data cannot be deleted');
        }
    }
    public function delete(string $id)
    {
        $user = User::find($id);
        // dd($user);
        if ($user) {
            $user->delete();
            return response()->json(['success' => true], 200);
        } else {

            return response()->json(['success' => false], 404);
        }
    }
}
