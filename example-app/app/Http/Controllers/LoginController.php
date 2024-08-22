<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Exception;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    //
    public function ajaxLogin(Request $request)
    {

        // $check = User::find($request->email);
        // if ($check) {
        //     dd($check);
        // }
        $data = User::select('id', 'name', 'email', 'phone')->get();
        return response()->json($data);
    }
    public function login(Request $request)
    {

        $validatedData = $request->validate([
            'email' => 'required',
            'password' => 'required|min:10',
        ]);

        $checkMail = User::where('email', $request->email)->first();

        if ($checkMail) {
            if ($checkMail->password === $request->password) {
                return redirect('user')->with('success', 'Logged In');
            }
        }
        return back()->with(['error' => 'Password not matched']);
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('forgetForm')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function passwordReset(Request $request)
    {

        try {
            $request->validate([
                'email' => 'required|email|exists:users,email',
            ]);

            $user = User::where('email', $request->email)->first();
            if ($user) {
                $token = Password::createToken($user);


                return back()->with('status', 'If an account with that email exists, a password reset link has been sent.');
            }

            return back()->with('status', 'If an account with that email exists, a password reset link has been sent.');
        } catch (Exception $e) {

            Log::error('Password reset email error: ' . $e->getMessage());
            return back()->with(['error' => 'An error occurred while sending the reset email.']);
        }
    }


    public function dataView()
    {
        return "From data view";
    }

    public function dataTable(Request $request)
    {
        if ($request->ajax()) {
            $data = User::latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $editUrl = route('users.edit', $row->id);
                    $deleteUrl = route('users.destroy', $row->id);
                    $actionBtn = '<a href="' . $editUrl . '" class="edit btn btn-success btn-sm">Edit</a>
                                  <form action="' . $deleteUrl . '" method="POST" style="display:inline;">
                                      ' . csrf_field() . '
                                      ' . method_field('DELETE') . '
                                      <button type="submit" class="delete btn btn-danger btn-sm">Delete</button>
                                  </form>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }


        return abort(404);
    }
}


// $request->validate([
    //     'email' => 'required|email',
    //     'password' => 'required',
    // ]);
    // $check = User::where('email', $request->email)->first();

    // if ($check) {
    //     if ($check->password === $request->password) {
    //         // dd(1);
    //         $data = User::select('id', 'name', 'email', 'phone')->get();
    //         return response()->json(['success' => true, 'message' => 'Logged In', 'data' => $data]);
    //     } else {
    //         return response()->json(['error' => true, 'message' => 'Incorrect Password']);
    //     }
    //     return response()->json(['error' => true, 'message' => 'User Not Found']);
    // }
    // return response()->json(['error' => true, 'message' => 'Username Password not Found']);