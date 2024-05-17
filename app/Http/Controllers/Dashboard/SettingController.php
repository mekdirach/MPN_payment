<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\QueryService\Facades\QS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
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
        $user = Auth::user();

        return view('pages.dashboard.pengaturan.index', $user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $laporan = QS::call('MPN.GetMPNSetting', [
            "a" => '',
        ]);

        if ($laporan->isSuccess()) {
            $result = $laporan->getData();
            return response()->json([
                $result
            ]);
        } else {
            return response()->json(['error' => 'Failed to retrieve data'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        date_default_timezone_set('Asia/Jakarta'); // Atur zona waktu sesuai dengan zona waktu yang diharapkan
        $datetime = date('YmdHis');

        $key = $request->input('key');
        $value = $request->input('value');
        $deskripsi = $request->input('deskripsi');
        $laporan = QS::call('MPN.EditMPNSetting', [
            "a" => $id,
            "b" => $key,
            "c" => $value,
            "d" => $deskripsi,
            "e" => $datetime,
            "f" => auth()->user()->name,

        ]);
        if ($laporan->isSuccess()) {
            $result = $laporan->getData();
            return response()->json([$result]);
        } else {
            return response()->json(['error' => 'Failed to update data'], 500);
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
        //
    }
}
