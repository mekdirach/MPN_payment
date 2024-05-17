<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\app_role;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class roleManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$data  = app_role::select("*")->orderBy('created_at', 'DESC')->get(); //query get semua data ke model
        Auth::user();
        $post   = app_role::all();
        return view('pages.dashboard.rolemanagement.index')->with('data', $post);
    }
    /**
     * Show the form for creating a new resource.
     *
     * 
     *
     */

    //method untuk tampilkan data di tabel


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
    {
        $role = new app_role();
        $role->is_active = 1;
        $role->table_id = 1;
        $role->created_at = now();
        $role->created_by = 1;
        $role->name = $request->name;
        $role->code = $request->code;
        $role->description = $request->description;
        $role->save();

        return redirect('member/rolemanagement')->with('success', 'Data telah ditambahkan');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = app_role::where('nim', $id)->first();
        return view('pages.dashboard.rolemanagement.index')->with('edit', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * 
     * $update = app_role::find($id);
     *   $input = $request->all();
     *  $update->fill($input)->save();
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->input('id');
        $data = [
            'name' => $request->name,
            'code' => $request->code,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => 1,
            'description' => $request->description,
        ];

        // Update data dan periksa apakah berhasil
        $updated = app_role::where('id', $id)->update($data);

        if ($updated) {
            return redirect('member/rolemanagement')->with('success', 'Data telah diperbarui');
        } else {
            return redirect('member/rolemanagement')->with('error', 'Gagal memperbarui data');
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        app_role::where('id', $id)->delete();
        return redirect('member/rolemanagement')->with('success', 'Data telah dihapus');
    }
}
