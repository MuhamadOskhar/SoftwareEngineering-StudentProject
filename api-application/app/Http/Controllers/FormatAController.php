<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormatARequest;
use App\Models\BayiModel;
use App\Models\FormatAModel;
use App\Models\OrangTuaModel;
use App\Models\PosyanduModel;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class FormatAController extends Controller
{
    protected $judulFormat = 'Catatan ibu hamil, kelahiran, kematian bayi dan kematian ibu hamil, melahirkan atau nifas Januari - Desember';
    public function get(FormatARequest $request): JsonResponse
    {
        /**
         * Melakukan validasi data request
         * 
         */
        $data = $request->validated();

        /**
         * Membuat query utama
         * 
         */
        $query = FormatAModel::select(
            'format_a.id as id_format_a',
            'orang_tua.id as id_orang_tua',
            'orang_tua.nama_ayah',
            'orang_tua.nama_ibu',
            'orang_tua.nik_ayah',
            'orang_tua.nik_ibu',
            'orang_tua.tanggal_meninggal_ibu',
            'orang_tua.no_telp',
            'orang_tua.rt_rw',
            'orang_tua.tempat_tinggal',
            'bayi.nama as nama_bayi',
            'bayi.nik as nik_bayi',
            'bayi.anak_ke',
            'bayi.jenis_kelamin',
            'bayi.tanggal_lahir',
            'bayi.tanggal_meninggal as tanggal_meninggal_bayi',
            'bayi.berat_lahir',
            'bayi.tinggi_lahir',
            'bayi.memiliki_kia',
            'bayi.imd',
            'bayi.memiliki_kms',
            'format_a.keterangan',
        )
            ->join('bayi', 'bayi.id', 'format_a.id_bayi')
            ->join('orang_tua', 'orang_tua.id', 'bayi.id_orang_tua')
            ->orderBy('bayi.tanggal_lahir', 'DESC');

        /**
         * Membuat query untuk perhitungan
         * 
         */
        $queryMenghitung = BayiModel::select(
            'bayi.id'
        )->join('orang_tua', 'orang_tua.id', 'bayi.id_orang_tua');


        /**
         * Memfilter data berdasarkan tahun
         * 
         */
        if (!empty($data['tahun'])) {

            /**
             * Melakukan filtering pada query
             * 
             */
            $query = $query->whereRaw('YEAR(bayi.tanggal_lahir) = ' . $data['tahun']);
            $queryMenghitung = $queryMenghitung->whereRaw('YEAR(bayi.tanggal_lahir) = ' . $data['tahun']);

            /**
             * Mendapatkan data jumlah kematian
             * dan jumlah kelahiran bayi
             * 
             */
            $jumlahBayiMeninggal = $queryMenghitung->whereRaw('bayi.tanggal_meninggal IS NOT NULL')->count();
            $jumlahLahir = $query->count();

        }

        /**
         * Melakukan filtering atau penyaringan
         * data pada kondisi tertentu
         * 
         */
        if (!empty($data['search'])) {

            /**
             * Memfilter data sesuai request search
             * 
             */
            $query = $query->whereRaw('bayi.nama LIKE "%' . $data['search'] . '%" OR orang_tua.nama_ibu LIKE "%' . $data['search'] . '%" OR orang_tua.nama_ayah LIKE "%' . $data['search'] . '%"');


        }

        /**
         * Mengambil banyaknya data yang diambil
         * 
         */
        $count = $query->count();
        $jumlahMeninggal = $jumlahBayiMeninggal;
        $jumlahLahir -= $jumlahBayiMeninggal;

        /**
         * Memeriksa apakah data ingin difilter
         * 
         */
        if (isset($data['start']) && isset($data['length'])) {

            /**
             * Mengambil data gambar dari
             * query yang sudah difilter
             * 
             */
            $query = $query
                ->offset(($data['start'] - 1) * $data['length'])
                ->limit($data['length']);

        }

        /**
         * Mengambil data dari query dan
         * akan dijadikan response
         * 
         */
        $formatA = $query->get();

        /**
         * Memeriksa apakah id_format_a ada
         * 
         */
        if (!empty($data['id_format_a'])) {

            /**
             * Mengambil query data sesuai id
             * 
             */
            $query = $query->where('format_a.id', $data['id_format_a']);

            /**
             * Mengambil data dari query dan
             * akan dijadikan response
             * 
             */
            $count = 1;
            $formatA = $query->first();

        }

        $formatA = $formatA->map(function ($item) {
            $tanggalLahir = Carbon::parse($item->tanggal_lahir);
            $item->tanggal_lahir_format = $tanggalLahir->format("d M Y");
            return $item;
        });

        /**
         * Mengambil data posyandu
         * 
         */
        $posyandu = PosyanduModel::select(
            'nama_posyandu',
            'kota'
        )->first();

        /**
         * Mendapatkan seluruh tahun lahir yang bisa dipilih
         * 
         */
        $listTahunLahir = BayiModel::selectRaw('YEAR(tanggal_lahir) as tahun_lahir')
            ->orderByDesc('tanggal_lahir')
            ->distinct()
            ->pluck('tahun_lahir');

        $listTahunLahir = $listTahunLahir->toArray();

        /**
         * Mengembalikan response sesuai request
         * 
         */
        return response()->json([
            'nama_posyandu' => $posyandu->nama_posyandu,
            'kota' => $posyandu->kota,
            'list_tahun_lahir' => $listTahunLahir,
            'judul_format' => $this->judulFormat,
            'jumlah_lahir' => $jumlahLahir,
            'jumlah_meninggal' => $jumlahMeninggal,
            'jumlah_bayi_meninggal' => $jumlahBayiMeninggal,
            'jumlah_data' => $count,
            'format_a' => $formatA,
        ])->setStatusCode(200);
    }
    public function post(FormatARequest $request): JsonResponse
    {

        /**
         * Memeriksa apakah request sesuai
         * dengan ketentuan berlaku
         * 
         */
        $data = $request->validated();

        if (empty($data['id_bayi'])) {

            /**
             * Memeriksa apakah data yang
             * dibutuhkan sudah tersedia
             * 
             */
            if ((empty($data['nama_ibu']) && empty($data['id_orang_tua'])) || empty($data['nama_bayi'])) {
                throw new HttpResponseException(response()->json([
                    'errors' => [
                        'message' => 'Data nama_ibu atau nama_bayi tidak boleh kosong'
                    ]
                ])->setStatusCode(400));
            }

            if (empty($data['id_orang_tua'])) {

                /**
                 * Melakukan penambahan data orang_tua
                 * 
                 */
                $orangTua = OrangTuaModel::create([
                    'nama_ayah' => $data['nama_ayah'],
                    'nik_ayah' => $data['nik_ayah'],
                    'nama_ibu' => $data['nama_ibu'],
                    'nik_ibu' => $data['nik_ibu'],
                    'tanggal_meninggal_ibu' => $data['tanggal_meninggal_ibu'],
                    'no_telp' => $data['no_telp'],
                    'rt_rw' => $data['rt_rw'],
                    'tempat_tinggal' => $data['tempat_tinggal'],
                ]);

            }

            /**
             * Inisiasi id data orang tua
             * 
             */
            $idOrangTua = empty($data['id_orang_tua']) ? $orangTua->id : $data['id_orang_tua'];

            /**
             * Melakukan penambahan data bayi
             * 
             */
            $bayi = BayiModel::create([
                'id_orang_tua' => $idOrangTua,
                'nama' => $data['nama_bayi'],
                'nik' => $data['nik_bayi'],
                'anak_ke' => $data['anak_ke'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'tanggal_lahir' => $data['tanggal_lahir'],
                'tanggal_meninggal' => $data['tanggal_meninggal_bayi'],
                'berat_lahir' => $data['berat_lahir'],
                'tinggi_lahir' => $data['tinggi_lahir'],
                'memiliki_kms' => $data['memiliki_kms'],
                'memiliki_kia' => $data['memiliki_kia'],
                'imd' => $data['imd'],
            ]);
        }

        /**
         * Melakukan penambahan data format_a
         * 
         */
        FormatAModel::create([
            'id_bayi' => $data['id_bayi'] ?? $bayi->id,
            'id_admin' => Auth::user()->id,
            'keterangan' => $data['keterangan'],
        ]);

        /**
         * Mengembalikan response setelah
         * melakukan penambahan data
         * 
         */
        return response()->json([
            'success' => [
                'message' => "Data berhasil ditambahkan"
            ]
        ])->setStatusCode(201);
    }
    public function put(FormatARequest $request): JsonResponse
    {

        /**
         * Memeriksa apakah request sesuai
         * dengan ketentuan berlaku
         * 
         */
        $data = $request->validated();

        /**
         * Membuat query utama
         * 
         */
        $formatA = FormatAModel::select(
            'format_a.id as id_format_a',
            'format_a.id_bayi',
            'orang_tua.id as id_orang_tua',
            'orang_tua.nama_ayah',
            'orang_tua.nama_ibu',
            'orang_tua.nik_ayah',
            'orang_tua.nik_ibu',
            'orang_tua.tanggal_meninggal_ibu',
            'orang_tua.no_telp',
            'orang_tua.rt_rw',
            'orang_tua.tempat_tinggal',
            'bayi.nama as nama_bayi',
            'bayi.nik as nik_bayi',
            'bayi.anak_ke',
            'bayi.jenis_kelamin',
            'bayi.tanggal_lahir',
            'bayi.tanggal_meninggal as tanggal_meninggal_bayi',
            'bayi.berat_lahir',
            'bayi.tinggi_lahir',
            'bayi.memiliki_kia',
            'bayi.imd',
            'bayi.memiliki_kms',
            'format_a.keterangan',
        )
            ->join('bayi', 'bayi.id', 'format_a.id_bayi')
            ->join('orang_tua', 'orang_tua.id', 'bayi.id_orang_tua')
            ->where('format_a.id', $data['id_format_a'])
            ->first();

        /**
         * Melakukan pengubahan data format_a
         * 
         */
        FormatAModel::where('id', $data['id_format_a'])->update([
            'keterangan' => $data['keterangan'] ?? $formatA->keterangan,
        ]);

        /**
         * Melakukan pengubahan data bayi
         * 
         */
        $bayi = BayiModel::where('id', $formatA->id_bayi);
        $bayi->update([
            'id_orang_tua' => $data['ganti_id_ortu'] ?? $formatA->id_orang_tua,
            'nama' => $data['nama_bayi'] ?? $formatA->nama_bayi,
            'nik' => $data['nik_bayi'] ?? $formatA->nik_bayi,
            'jenis_kelamin' => $data['jenis_kelamin'] ?? $formatA->jenis_kelamin,
            'tanggal_lahir' => $data['tanggal_lahir'] ?? $formatA->tanggal_lahir,
            'tanggal_meninggal' => $data['tanggal_meninggal_bayi'] ?? $formatA->tanggal_meninggal_bayi,
            'berat_lahir' => $data['berat_lahir'] ?? $formatA->berat_lahir,
            'tinggi_lahir' => $data['tinggi_lahir'] ?? $formatA->tinggi_lahir,
            'memiliki_kia' => $data['memiliki_kia'] ?? $formatA->memiliki_kia,
            'imd' => $data['imd'] ?? $formatA->imd,
            'memiliki_kms' => $data['memiliki_kms'] ?? $formatA->memiliki_kms,
        ]);

        $bayi = $bayi->select('id_orang_tua')->first();

        if (empty($data['ganti_id_ortu'])) {

            /**
             * Melakukan pengubahan data orang_tua
             * 
             */
            OrangTuaModel::where('id', $bayi->id_orang_tua)->update([
                'nama_ayah' => $data['nama_ayah'] ?? $formatA->nama_ayah,
                'nama_ibu' => $data['nama_ibu'] ?? $formatA->nama_ibu,
                'nik_ayah' => $data['nik_ayah'] ?? $formatA->nik_ayah,
                'nik_ibu' => $data['nik_ibu'] ?? $formatA->nik_ibu,
                'tanggal_meninggal_ibu' => $data['tanggal_meninggal_ibu'] ?? $formatA->tanggal_meninggal_ibu,
                'no_telp' => $data['no_telp'] ?? $formatA->no_telp,
                'tempat_tinggal' => $data['tempat_tinggal'] ?? $formatA->tempat_tinggal,
                'rt_rw' => $data['rt_rw'] ?? $formatA->rt_rw,
            ]);

        }

        /**
         * Mengembalikan response setelah
         * melakukan pengubahan data
         * 
         */
        return response()->json([
            'success' => [
                'message' => "Data berhasil diubah"
            ]
        ])->setStatusCode(201);
    }
    public function delete(FormatARequest $request): JsonResponse
    {
        /**
         * Memeriksa apakah request
         * yang diberikan sesuai
         * 
         */
        $data = $request->validated();

        /**
         * Mendapatkan id_orang tua
         * 
         */
        $idOrangTua = FormatAModel::select('bayi.id_orang_tua')
            ->where('format_a.id', $data['id_format_a'])
            ->join('bayi', 'bayi.id', 'format_a.id_bayi')
            ->value('id_orang_tua');

        /**
         * Menghapus data orang tua berdasarkan id_format_a
         */
        OrangTuaModel::where('id', $idOrangTua)
            ->delete();

        /**
         * Mengembalikan response setelah
         * melakukan delete data
         * 
         */
        return response()->json([
            'success' => [
                'message' => "Data edukasi berhasil dihapus"
            ]
        ])->setStatusCode(200);
    }
    public function jumlah_bayi(Request $request): JsonResponse
    {
        $jumlahBayi = BayiModel::count();

        /**
         * Mengembalikan response
         * 
         */
        return response()->json(
            $jumlahBayi
        )->setStatusCode(200);
    }
    public function listOrangTua(): JsonResponse
    {
        $query = OrangTuaModel::select('id as value')
            ->selectRaw('CONCAT(nama_ayah, " & ", nama_ibu) as title');
        $listOrangTua = $query->get();
        return response()->json(
            $listOrangTua
        )->setStatusCode(200);
    }
}
