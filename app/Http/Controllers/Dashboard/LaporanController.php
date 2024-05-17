<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\QueryService\QueryService;
use App\Traits\Connection\Services_JSON;
use Illuminate\Support\Facades\File;
use Facade\FlareClient\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
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

        return view('pages.dashboard.Laporan.index', $user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function detectUtfEncoding($filename)
    {
        $text = file_get_contents($filename);
        $first2 = substr($text, 0, 2);
        $first3 = substr($text, 0, 3);
        $first4 = substr($text, 0, 4);

        if ($first3 === UTF8_BOM) {
            return 'UTF-8';
        } elseif ($first4 === UTF32_BIG_ENDIAN_BOM) {
            return 'UTF-32BE';
        } elseif ($first4 === UTF32_LITTLE_ENDIAN_BOM) {
            return 'UTF-32LE';
        } elseif ($first2 === UTF16_BIG_ENDIAN_BOM) {
            return 'UTF-16BE';
        } elseif ($first2 === UTF16_LITTLE_ENDIAN_BOM) {
            return 'UTF-16LE';
        }

        return 'NONE';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$path = storage_path('/var/www/html/upload/');
        $path = '/var/www/html/upload/';
        $file = $request->file('fileToUpload');
        $todayDate = date('dmY'); // Format tanggal hari ini (misalnya, "18082023")
        $uploadDir = $path . $todayDate . '/';
        if (!file_exists($uploadDir)) {
            // Jika direktori belum ada, maka buat direktori
            mkdir($uploadDir, 0777, true);
        }
        define('UTF32_BIG_ENDIAN_BOM', chr(0x00) . chr(0x00) . chr(0xFE) . chr(0xFF));
        define('UTF32_LITTLE_ENDIAN_BOM', chr(0xFF) . chr(0xFE) . chr(0x00) . chr(0x00));
        define('UTF16_BIG_ENDIAN_BOM', chr(0xFE) . chr(0xFF));
        define('UTF16_LITTLE_ENDIAN_BOM', chr(0xFF) . chr(0xFE));
        define('UTF8_BOM', chr(0xEF) . chr(0xBB) . chr(0xBF));

        $bom = $this->detectUtfEncoding($file->getRealPath());
        if ($bom === 'NONE') {
            $fullpath = $path . $file->getClientOriginalName();
            if ($file->move($path, $file->getClientOriginalName())) {
                date_default_timezone_set('Asia/Jakarta'); // Atur zona waktu sesuai dengan zona waktu yang diharapkan
                $datetime = date('YmdHis');
                $JSONMPI = new Services_JSON(SERVICES_JSON_SUPPRESS_ERRORS);
                $MPI = array('BSCORE' => $fullpath);
                $JMPI = $JSONMPI->encode($MPI);
                $aReq = array(
                    'MT' => '2200',
                    'PC' => '15300',
                    'ST' => '01000',
                    'DT' => $datetime,
                    'MPI' => $JMPI
                );

                $Json = new QueryService();
                $bOK = $Json->JsonExec($aOutput, $aReq);
                //var_dump($bOK, $aOutput);

                if ($bOK) {
                    if ($aOutput->RC == '0000') {
                        $links = array();

                        if (isset($aOutput->DT)) {
                            $datetime = $aOutput->DT;
                        } else {
                            $datetime = ''; // Atur nilai default jika properti DT tidak ada
                        }

                        // Loop untuk tautan Bank Statement
                        foreach ($aOutput->MPO->BS as $bs) {
                            $bs_parts = explode('/', $bs);
                            $bs_link = 'http://192.168.229.164:8081/' . $bs_parts[count($bs_parts) - 2] . '/' . $bs_parts[count($bs_parts) - 1];
                            $links[] = array('type' => 'Bank Statement', 'url' => $bs_link);
                        }

                        $lhp_parts = explode('/', $aOutput->MPO->LHP);
                        $lhp_filename = $lhp_parts[count($lhp_parts) - 1];
                        $lhp_link = 'http://192.168.229.164:8081/' . $lhp_parts[count($lhp_parts) - 2] . '/' . $lhp_filename;
                        $links[] = array('type' => 'Laporan Harian Penerimaan', 'url' => $lhp_link);

                        $dnp_parts = explode('/', $aOutput->MPO->DNP);
                        $dnp_link = 'http://192.168.229.164:8081/' . $dnp_parts[count($dnp_parts) - 2] . '/' . $dnp_parts[count($dnp_parts) - 1];
                        $links[] = array('type' => 'Daftar Nominatif Pembayaran', 'url' => $dnp_link);

                        if (isset($aOutput->MPO->BSSelisih)) {
                            $slsh_parts = explode('/', $aOutput->MPO->BSSelisih);
                            $slsh_link = 'http://192.168.229.164:8081/' . $slsh_parts[count($slsh_parts) - 2] . '/' . $slsh_parts[count($slsh_parts) - 1];
                            $links[] = array('type' => 'Data Selisih antara Bank Statement dan Transaksi MPN', 'url' => $slsh_link);
                        }
                        $response = [
                            'success' => true,
                            'message' => 'Upload File Laporan berhasil',
                            'tanggal' => $datetime,
                            'links' => $links,
                        ];
                    } else {
                        $response = [
                            'success' => false,
                            'message' => '[' . $aOutput->RC . '] ' . '[' . $aOutput->RCMSG . '] ',
                        ];
                    }
                } else {
                    $response = [
                        'success' => false,
                        'message' => 'Tidak ada respon dari sistem.',
                    ];
                }
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Tidak berhasil mengunggah file.',
                ];
            }
        } else {
            $response = [
                'success' => false,
                'message' => 'File tidak dapat diproses, silahkan download file Rekening Koran menggunakan menu Export dari IBM I-Series Navigator.<br> <i>(File Mengandung Byte Order Mark ' . $bom . ')</i>',
            ];
        }

        return response()->json($response)->setStatusCode(200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $data = [];

        $directories = File::directories('/var/www/html/upload');

        foreach ($directories as $directory) {
            $dirReport = basename($directory);
            $files = File::files($directory);

            $dirData = [
                'Tanggal' => substr($dirReport, 0, 2) . '-' . substr($dirReport, 2, 2) . '-' . substr($dirReport, 4, 4),
                'FILE' => []
            ];

            foreach ($files as $file) {
                $fileReport = basename($file);

                $dirData['FILE'][] = [
                    'url' => 'http://192.168.229.164:8081/' . $dirReport . '/' . $fileReport,
                    'name' => $fileReport
                ];
            }

            $data[] = $dirData;
        }
        // Anda dapat mengirimkan data ini sebagai respons JSON
        return response()->json($data)->setStatusCode(200);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $data = [];

        $directories = File::directories(base_path('../upload'));

        foreach ($directories as $directory) {
            $dirReport = basename($directory);
            $files = File::files($directory);

            $dirData = [
                'Tanggal' => substr($dirReport, 0, 2) . '-' . substr($dirReport, 2, 2) . '-' . substr($dirReport, 4, 4),
                'FILE-FILE' => []
            ];

            foreach ($files as $file) {
                $fileReport = basename($file);

                $dirData['FILE-FILE'][] = [
                    'title' => 'View ' . $fileReport,
                    'url' => base64_encode($dirReport . '/' . $fileReport),
                    'name' => $fileReport
                ];
            }

            $data[] = $dirData;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getUrl($url)
    {
        return view('pages.dashboard.Laporan.content.detail', ['url' => $url]);
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
