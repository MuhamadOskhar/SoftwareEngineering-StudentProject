<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BeratUmurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $umurBulan = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59];
        $BeratBadanTerlaluKurus = [2.1, 2.9, 3.8, 4.4, 4.9, 5.3, 5.7, 5.9, 6.2, 6.4, 6.6, 6.8, 6.9, 7.1, 7.2, 7.4, 7.5, 7.7, 7.8, 8, 8.1, 8.2, 8.4, 8.5, 8.6, 8.8, 8.9, 9, 9.1, 9.2, 9.4, 9.5, 9.6, 9.7, 9.8, 9.9, 10, 10.1, 10.2, 10.3, 10.4, 10.5, 10.6, 10.7, 10.8, 10.9, 11, 11.1, 11.2, 11.3, 11.4, 11.5, 11.6, 11.7, 11.8, 11.9, 12, 12.1, 12.2, 12.3];
        $BeratBadanKurus = [2.5, 3.4, 4.3, 5, 5.6, 6, 6.4, 6.7, 6.9, 7.1, 7.4, 7.6, 7.7, 7.9, 8.1, 8.3, 8.4, 8.6, 8.8, 8.9, 9.1, 9.2, 9.4, 9.5, 9.7, 9.8, 10, 10.1, 10.2, 10.4, 10.5, 10.7, 10.8, 10.9, 11, 11.2, 11.3, 11.4, 11.5, 11.6, 11.8, 11.9, 12, 12.1, 12.2, 12.4, 12.5, 12.6, 12.7, 12.8, 12.9, 13.1, 13.2, 13.3, 13.4, 13.5, 13.6, 13.7, 13.8, 14];
        $BeratBadanNormalKurus = [2.9, 3.9, 4.9, 5.7, 6.2, 6.7, 7.1, 7.4, 7.7, 8, 8.2, 8.4, 8.6, 8.8, 9, 9.2, 9.4, 9.6, 9.8, 10, 10.1, 10.3, 10.5, 10.7, 10.8, 11, 11.2, 11.3, 11.5, 11.7, 11.8, 12, 12.1, 12.3, 12.4, 12.6, 12.7, 12.9, 13, 13.1, 13.3, 13.4, 13.6, 13.7, 13.8, 14, 14.1, 14.3, 14.4, 14.5, 14.7, 14.8, 15, 15.1, 15.2, 15.4, 15.5, 15.6, 15.8, 15.9];
        $Median = [3.3, 4.5, 5.6, 6.4, 7, 7.5, 7.9, 8.3, 8.6, 8.9, 9.2, 9.4, 9.6, 9.9, 10.1, 10.3, 10.5, 10.7, 10.9, 11.1, 11.3, 11.5, 11.8, 12, 12.2, 12.4, 12.5, 12.7, 12.9, 13.1, 13.3, 13.5, 13.7, 13.8, 14, 14.2, 14.3, 14.5, 14.7, 14.8, 15, 15.2, 15.3, 15.5, 15.7, 15.8, 16, 16.2, 16.3, 16.5, 16.7, 16.8, 17, 17.2, 17.3, 17.5, 17.7, 17.8, 18, 18.2];
        $BeratBadanNormalGemuk = [3.9, 5.1, 6.3, 7.2, 7.8, 8.4, 8.8, 9.2, 9.6, 9.9, 10.2, 10.5, 10.8, 11, 11.3, 11.5, 11.7, 12, 12.2, 12.5, 12.7, 12.9, 13.2, 13.4, 13.6, 13.9, 14.1, 14.3, 14.5, 14.8, 15, 15.2, 15.4, 15.6, 15.8, 16, 16.2, 16.4, 16.6, 16.8, 17, 17.2, 17.4, 17.6, 17.8, 18, 18.2, 18.4, 18.6, 18.8, 19, 19.2, 19.4, 19.6, 19.8, 20, 20.2, 20.4, 20.6, 20.8];
        $BeratBadanGemuk = [4.4, 5.8, 7.1, 8, 8.7, 9.3, 9.8, 10.3, 10.7, 11, 11.4, 11.7, 12, 12.3, 12.6, 12.8, 13.1, 13.4, 13.7, 13.9, 14.2, 14.5, 14.7, 15, 15.3, 15.5, 15.8, 16.1, 16.3, 16.6, 16.9, 17.1, 17.4, 17.6, 17.8, 18.1, 18.3, 18.6, 18.8, 19, 19.3, 19.5, 19.7, 20, 20.2, 20.5, 20.7, 20.9, 21.2, 21.4, 21.7, 21.9, 22.2, 22.4, 22.7, 22.9, 23.2, 23.4, 23.7, 23.9];
        $BeratBadanTerlaluGemuk = [5, 6.6, 8, 9, 9.7, 10.4, 10.9, 11.4, 11.9, 12.3, 12.7, 13, 13.3, 13.7, 14, 14.3, 14.6, 14.9, 15.3, 15.6, 15.9, 16.2, 16.5, 16.8, 17.1, 17.5, 17.8, 18.1, 18.4, 18.7, 19, 19.3, 19.6, 19.9, 20.2, 20.4, 20.7, 21, 21.3, 21.6, 21.9, 22.1, 22.4, 22.7, 23, 23.3, 23.6, 23.9, 24.2, 24.5, 24.8, 25.1, 25.4, 25.7, 26, 26.3, 26.6, 26.9, 27.2, 27.6];

        $referensi = DB::table('berat_untuk_umur')->insert([
            'jenis_kelamin' => 'Laki Laki'
        ]);

        for ($i = 0; $i < count($umurBulan); $i++) {
            DB::table('standar_deviasi')->insert([
                'id_berat_untuk_umur' => 1,
                'umur_bulan' => $umurBulan[$i],
                'sangat_kurus' => $BeratBadanTerlaluKurus[$i],
                'kurus' => $BeratBadanKurus[$i],
                'normal_kurus' => $BeratBadanNormalKurus[$i],
                'baik' => $Median[$i],
                'normal_gemuk' => $BeratBadanNormalGemuk[$i],
                'gemuk' => $BeratBadanGemuk[$i],
                'sangat_gemuk' => $BeratBadanTerlaluGemuk[$i],
            ]);
        }

        $umurBulan = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59];
        $BeratBadanTerlaluKurus = [2, 2.7, 3.4, 4, 4.4, 4.8, 5.1, 5.3, 5.6, 5.8, 5.9, 6.1, 6.3, 6.4, 6.6, 6.7, 6.9, 7, 7.2, 7.3, 7.5, 7.6, 7.8, 7.9, 8.1, 8.2, 8.4, 8.5, 8.6, 8.8, 8.9, 9, 9.1, 9.3, 9.4, 9.5, 9.6, 9.7, 9.8, 9.9, 10.1, 10.2, 10.3, 10.4, 10.5, 10.6, 10.7, 10.8, 10.9, 11, 11.1, 11.2, 11.3, 11.4, 11.5, 11.6, 11.7, 11.8, 11.9, 12];
        $BeratBadanKurus = [2.4, 3.2, 3.9, 4.5, 5, 5.4, 5.7, 6, 6.3, 6.5, 6.7, 6.9, 7, 7.2, 7.4, 7.6, 7.7, 7.9, 8.1, 8.2, 8.4, 8.6, 8.7, 8.9, 9, 9.2, 9.4, 9.5, 9.7, 9.8, 10, 10.1, 10.3, 10.4, 10.5, 10.7, 10.8, 10.9, 11.1, 11.2, 11.3, 11.5, 11.6, 11.7, 11.8, 12, 12.1, 12.2, 12.3, 12.4, 12.6, 12.7, 12.8, 12.9, 13, 13.2, 13.3, 13.4, 13.5, 13.6];
        $BeratBadanNormalKurus = [2.8, 3.6, 4.5, 5.2, 5.7, 6.1, 6.5, 6.8, 7, 7.3, 7.5, 7.7, 7.9, 8.1, 8.3, 8.5, 8.7, 8.9, 9.1, 9.2, 9.4, 9.6, 9.8, 10, 10.2, 10.3, 10.5, 10.7, 10.9, 11.1, 11.2, 11.4, 11.6, 11.7, 11.9, 12, 12.2, 12.4, 12.5, 12.7, 12.8, 13, 13.1, 13.3, 13.4, 13.6, 13.7, 13.9, 14, 14.2, 14.3, 14.5, 14.6, 14.8, 14.9, 15.1, 15.2, 15.3, 15.5, 15.6];
        $Median = [3.2, 4.2, 5.1, 5.8, 6.4, 6.9, 7.3, 7.6, 7.9, 8.2, 8.5, 8.7, 8.9, 9.2, 9.4, 9.6, 9.8, 10, 10.2, 10.4, 10.6, 10.9, 11.1, 11.3, 11.5, 11.7, 11.9, 12.1, 12.3, 12.5, 12.7, 12.9, 13.1, 13.3, 13.5, 13.7, 13.9, 14, 14.2, 14.4, 14.6, 14.8, 15, 15.2, 15.3, 15.5, 15.7, 15.9, 16.1, 16.3, 16.4, 16.6, 16.8, 17, 17.2, 17.3, 17.5, 17.7, 17.9, 18];
        $BeratBadanNormalGemuk = [3.7, 4.8, 5.8, 6.6, 7.3, 7.8, 8.2, 8.6, 9, 9.3, 9.6, 9.9, 10.1, 10.4, 10.6, 10.9, 11.1, 11.4, 11.6, 11.8, 12.1, 12.3, 12.5, 12.8, 13, 13.3, 13.5, 13.7, 14, 14.2, 14.4, 14.7, 14.9, 15.1, 15.4, 15.6, 15.8, 16, 16.3, 16.5, 16.7, 16.9, 17.2, 17.4, 17.6, 17.8, 18.1, 18.3, 18.5, 18.8, 19, 19.2, 19.4, 19.7, 19.9, 20.1, 20.3, 20.6, 20.8, 21];
        $BeratBadanGemuk = [4.2, 5.5, 6.6, 7.5, 8.2, 8.8, 9.3, 9.8, 10.2, 10.5, 10.9, 11.2, 11.5, 11.8, 12.1, 12.4, 12.6, 12.9, 13.2, 13.5, 13.7, 14, 14.3, 14.6, 14.8, 15.1, 15.4, 15.7, 16, 16.2, 16.5, 16.8, 17.1, 17.3, 17.6, 17.9, 18.1, 18.4, 18.7, 19, 19.2, 19.5, 19.8, 20.1, 20.4, 20.7, 20.9, 21.2, 21.5, 21.8, 22.1, 22.4, 22.6, 22.9, 23.2, 23.5, 23.8, 24.1, 24.4, 24.6];
        $BeratBadanTerlaluGemuk = [4.8, 6.2, 7.5, 8.5, 9.3, 10, 10.6, 11.1, 11.6, 12, 12.4, 12.8, 13.1, 13.5, 13.8, 14.1, 14.5, 14.8, 15.1, 15.4, 15.7, 16, 16.4, 16.7, 17, 17.3, 17.7, 18, 18.3, 18.7, 19, 19.3, 19.6, 20, 20.3, 20.6, 20.9, 21.3, 21.6, 22, 22.3, 22.7, 23, 23.4, 23.7, 24.1, 24.5, 24.8, 25.2, 25.5, 25.9, 26.3, 26.6, 27, 27.4, 27.7, 28.1, 28.5, 28.8, 29.2];

        $referensi = DB::table('berat_untuk_umur')->insert([
            'jenis_kelamin' => 'Perempuan'
        ]);

        for ($i = 0; $i < count($umurBulan); $i++) {
            DB::table('standar_deviasi')->insert([
                'id_berat_untuk_umur' => 2,
                'umur_bulan' => $umurBulan[$i],
                'sangat_kurus' => $BeratBadanTerlaluKurus[$i],
                'kurus' => $BeratBadanKurus[$i],
                'normal_kurus' => $BeratBadanNormalKurus[$i],
                'baik' => $Median[$i],
                'normal_gemuk' => $BeratBadanNormalGemuk[$i],
                'gemuk' => $BeratBadanGemuk[$i],
                'sangat_gemuk' => $BeratBadanTerlaluGemuk[$i],
            ]);
        }
    }
}
