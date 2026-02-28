<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;



class vueController extends Controller
{
    //
    // Get All Users
    public function index()
    {
        $users = DB::table('vue_store')->get();
        return response()->json($users);
    }

    // Insert User
    public function store(Request $request)
    {
        $qualification = implode(',', $request->qualification);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'place' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'qualification' => 'required|array',
            
            


        ]);
        DB::table('vue_store')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'place' => $request->place,
            'state' => $request->state,
            'qualification' => $qualification,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json(['status' => true,
        'message' => 'New user added successfully 🤙']);
    }

    // Update User
    public function update(Request $request, $id)
    {
        $qualification = implode(',', $request->qualification);
        DB::table('vue_store')
            ->where('id', $id)
            ->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'place' => $request->place,
                'state' => $request->state,
                'qualification' => $qualification,
                'updated_at' => now()
            ]);

        return response()->json(['status' => true,
        'message' => 'Data updated successfully 🤙']);
    }

    // Delete User
    public function destroy($id)
    {
        DB::table('vue_store')->where('id', $id)->delete();

        return response()->json(['status' => true,
        'message' => 'Data deleted successfully 🤙']);
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->ids; // Array of IDs to delete
        DB::table('vue_store')->whereIn('id', $ids)->delete();

        return response()->json(['status' => true,
        'message' => 'Selected data deleted successfully 🤙']);
    }
}
