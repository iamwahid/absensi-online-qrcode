<?php

use App\Models\Auth\User;
use App\Models\MataKuliah;
use Illuminate\Database\Seeder;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $matkuls = [
            ['nama' => 'Algoritma Struktur Data', 'sks' => 3, 'deskripsi' => 'ASD'],
            ['nama' => 'Pengantar Teknologi Informasi', 'sks' => 3, 'deskripsi' => 'PTI'],
            ['nama' => 'Logika Matematika', 'sks' => 2, 'deskripsi' => 'LM'],
            ['nama' => 'Agama Islam', 'sks' => 3, 'deskripsi' => 'Islam'],
            ['nama' => 'Kalkulus', 'sks' => 3, 'deskripsi' => 'clac'],
            ['nama' => 'Metode Penelitian', 'sks' => 3, 'deskripsi' => 'Metode'],
        ];

        foreach ($matkuls as $matkul) {
            MataKuliah::insert($matkul);
        }

        $faker = Faker\Factory::create('id_ID');

        
        for ($i=0; $i < 100; $i++) {
            $email = $faker->email;
            if (User::where('email', '=', $email)->first()) {
                continue;
            }

            $user = User::create([
                'email' => $email,
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'password' => bcrypt('secret'),
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'confirmed' => true,
            ]);

            $user->assignRole(config('access.users.default_role'));
            $user->mahasiswa()->create([
                'nim' => $faker->numberBetween($min = 100000, $max = 999999),
                'tahun' => $faker->randomElement($array = array (2020, 2019, 2018, 2017, 2016)),
                'kelas' => $faker->randomElement($array = array ('A', 'B', 'C', 'D', 'E')),
                'gender' => $faker->randomElement($array = array ('male', 'female')),
                'alamat' => 'Kab. '.$faker->randomElement($array = array ('Klaten','Jogja','Solo','Semarang','Jakarta', 'Ponorogo', 'Denpasar', 'Malang', 'Madiun'))
            ]);
        }

        for ($i=0; $i < 20; $i++) {
            $email = $faker->email;
            if (User::where('email', '=', $email)->first()) {
                continue;
            }

            $user = User::create([
                'email' => $email,
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'password' => bcrypt('secret'),
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'confirmed' => true,
            ]);

            $user->assignRole(config('access.users.executive_role'));
            $dosen = $user->dosen()->create([
                'nik' => $faker->numberBetween($min = 100000, $max = 999999),
                'no_hp' => $faker->numberBetween($min = 100000000, $max = 999999999),
                'gender' => $faker->randomElement($array = array ('male', 'female')),
                'alamat' => 'Kab. '.$faker->randomElement($array = array ('Klaten','Jogja','Solo','Semarang','Jakarta', 'Ponorogo', 'Denpasar', 'Malang', 'Madiun'))
            ]);
            $matkul = MataKuliah::find(rand(1, 6));
            $dosen->matkuls()->attach($matkul);
            
        }

        // $jadwals = [
        //     'matkul_id' => rand(1, 6),
        //     'dosen_id' => rand(1, 20),
        //     'start_at' => ,
        //     'finish_at',
        //     // 'room',
        //     'deskripsi',
        //     'kode_absen'
        // ]


    }
}
