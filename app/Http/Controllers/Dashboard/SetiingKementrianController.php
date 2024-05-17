<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\QueryService\Facades\QS;
use App\Services\QueryService\QueryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SetiingKementrianController extends Controller
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

        return view('pages.dashboard.settingkementrian.index', $user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $laporan = QS::call('MPN.GetKementrianSetting', array('a' => ''));
        if ($laporan->isSuccess()) {
            $result = $laporan->getData();
            return response()->json([
                $result, 200
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
    public function AddKementrianSetting(Request $request)
    {
        $kolom = $request->input('kolom', "");
        $id = $request->input('MPN_TRX_PNBP');
        $code = $request->input('KL_CODE');
        $name = $request->input('TRX_NAME');
        $eselon_code = $request->input('TRX_ESELON_CODE');
        $satker_code = $request->input('TRX_SATKER_CODE');
        $type = $request->input('TRX_MSG_TYPE');
        $status = $request->input('status');
        $chars = $request->input('FIRST_CHARS');
        $ip = $request->input('TRX_IP');
        $port = $request->input('TRX_PORT');
        $timeout = $request->input('TRX_TIMEOUT');

        $laporan = QS::call('MPN.AddKementrianSetting', [
            "a" => $code,
            "b" => $name,
            "c" => $id,
            "d" => $eselon_code,
            "e" => $satker_code,
            "f" => $type,
            "g" => $status,
            "h" => $kolom,
            "i" => $chars,
            "j" => $ip,
            "k" => $port,
            "l" => $timeout,

        ]);

        return response()->json([$laporan]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $laporan = QS::call('MPN.GetKementrianSettingByID', [
            "a" => $id
        ]);
        if ($laporan->isSuccess()) {
            $result = $laporan->getData();
            return response()->json([$result]);
        } else {
            return response()->json(['error' => 'Failed to update data'], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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


        $kolom = $request->input('kolom', "");
        $code = $request->input('KL_CODE');
        $name = $request->input('TRX_NAME');
        $eselon_code = $request->input('TRX_ESELON_CODE');
        $satker_code = $request->input('TRX_SATKER_CODE');
        $type = $request->input('TRX_MSG_TYPE');
        $status = $request->input('status');
        $chars = $request->input('FIRST_CHARS');
        $ip = $request->input('TRX_IP');
        $port = $request->input('TRX_PORT');
        $timeout = $request->input('TRX_TIMEOUT');

        $laporan = QS::call('MPN.EditKementrianSetting', [
            "a" => $code,
            "b" => $name,
            "c" => $id,
            "d" => $eselon_code,
            "e" => $satker_code,
            "f" => $type,
            "g" => $status,
            "h" => $kolom,
            "i" => $chars,
            "j" => $ip,
            "k" => $port,
            "l" => $timeout,

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
        $response = QS::call('MPN.deleteKementrian', [
            "a" => $id
        ]);
        if ($response->isSuccess()) {
            return response()->json(['message' => 'Data berhasil dihapus'], 200);
        } else {
            return response()->json(['error' => 'Gagal menghapus data'], 500);
        }
    }
}
