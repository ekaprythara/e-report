<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Level;
use App\Models\Logistic;
use App\Models\Receiver;
use App\Models\Supplier;
use App\Models\LogisticType;
use App\Models\ReceiverUnit;
use App\Models\StandardUnit;
use App\Models\InboundLogistic;
use Illuminate\Database\Seeder;
use App\Models\LogisticProcurement;
use App\Models\OutboundLogistic;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Level::create([
            'name' => 'Kepala Bidang'
        ]);
        Level::create([
            'name' => 'Kepala Sub Bidang'
        ]);
        Level::create([
            'name' => 'Pegawai'
        ]);

        User::create([
            'username' => 'swanjaya',
            'password' => bcrypt('password'),
            'name' => 'I Nyoman Swanjaya, S.E., M.Si',
            'address' => 'Jalan Kertajaya',
            'email' => 'nyomanswanjaya@gmail.com',
            'phone' => '085700000001',
            'level_id' => '1'
        ]);
        User::create([
            'username' => 'ekasaputra',
            'password' => bcrypt('password'),
            'name' => 'I Wayan Gede Eka Saputra, S.Kom, M.Si',
            'address' => 'Jalan Kertasoma',
            'email' => 'ekasaputra@gmail.com',
            'phone' => '085700000002',
            'level_id' => '2'
        ]);
        User::create([
            'username' => 'ekapriyanthara',
            'password' => bcrypt('password'),
            'name' => 'I Putu Eka Priyanthara',
            'address' => 'Jalan Nangka Selatan',
            'email' => 'ekapriyanthara@gmail.com',
            'phone' => '085700000003',
            'level_id' => '3'
        ]);


        ReceiverUnit::create([
            'name' => 'Personal',
            'address' => null,
            'email' => null,
            'telephone' => null
        ]);
        ReceiverUnit::create([
            'name' => 'Desa Mawar',
            'address' => 'Jembrana',
            'email' => 'desamawar@gmail.com',
            'telephone' => '0361000001'
        ]);
        ReceiverUnit::create([
            'name' => 'Desa Melati',
            'address' => 'Buleleng',
            'email' => 'desamelati@gmail.com',
            'telephone' => '0361000002'
        ]);
        ReceiverUnit::create([
            'name' => 'Desa Sandat',
            'address' => 'Denpasar',
            'email' => 'desasandat@gmail.com',
            'telephone' => '0361000003'
        ]);
        ReceiverUnit::create([
            'name' => 'Desa Kamboja',
            'address' => 'Bangli',
            'email' => 'desakamboja@gmail.com',
            'telephone' => '0361000004'
        ]);
        ReceiverUnit::create([
            'name' => 'Desa Teratai',
            'address' => 'Karangasem',
            'email' => 'desateratai@gmail.com',
            'telephone' => '0361000005'
        ]);

        Receiver::create([
            'name' => 'Arimbawa',
            'phone' => '081200000001',
            'receiverUnit_id' => 5,
            'description' => ''
        ]);
        Receiver::create([
            'name' => 'Putu Mahendra',
            'phone' => '081200000002',
            'receiverUnit_id' => 2,
            'description' => 'Supir'
        ]);
        Receiver::create([
            'name' => 'Made Sekarnawa',
            'phone' => '081200000003',
            'receiverUnit_id' => 3,
            'description' => 'Staff'
        ]);
        Receiver::create([
            'name' => 'Gede Bayu',
            'phone' => '081200000004',
            'receiverUnit_id' => 4,
            'description' => 'Supir'
        ]);
        Receiver::create([
            'name' => 'Yogi Hermawan',
            'phone' => '081200000005',
            'receiverUnit_id' => 6,
            'description' => ''
        ]);
        Receiver::create([
            'name' => 'Ariesta Yana',
            'phone' => '081200000006',
            'receiverUnit_id' => 4,
            'description' => 'Staff'
        ]);
        Receiver::create([
            'name' => 'Gede Suwandi',
            'phone' => '081200000007',
            'receiverUnit_id' => 1,
            'description' => ''
        ]);
        Receiver::create([
            'name' => 'Indra Mahesa',
            'phone' => '081200000008',
            'receiverUnit_id' => 3,
            'description' => 'Supir'
        ]);
        Receiver::create([
            'name' => 'Angga Pramesta',
            'phone' => '081200000009',
            'receiverUnit_id' => 2,
            'description' => 'Staff'
        ]);
        Receiver::create([
            'name' => 'Anggi Jayanthi',
            'phone' => '081200000010',
            'receiverUnit_id' => 6,
            'description' => ''
        ]);


        LogisticProcurement::create([
            'name' => 'Bantuan'
        ]);
        LogisticProcurement::create([
            'name' => 'Sendiri'
        ]);

        LogisticType::create([
            'name' => 'Sandang',
            'expiredDate' => '0'
        ]);
        LogisticType::create([
            'name' => 'Pangan',
            'expiredDate' => '1'
        ]);
        LogisticType::create([
            'name' => 'Paket Kematian',
            'expiredDate' => '0'
        ]);
        LogisticType::create([
            'name' => 'Lain-lain',
            'expiredDate' => '0'
        ]);

        StandardUnit::create([
            'name' => 'Unit'
        ]);
        StandardUnit::create([
            'name' => 'Buah'
        ]);
        StandardUnit::create([
            'name' => 'Pasang'
        ]);
        StandardUnit::create([
            'name' => 'Lembar'
        ]);
        StandardUnit::create([
            'name' => 'Karung'
        ]);
        StandardUnit::create([
            'name' => 'Batang'
        ]);
        StandardUnit::create([
            'name' => 'Bungkus'
        ]);
        StandardUnit::create([
            'name' => 'Paket'
        ]);
        StandardUnit::create([
            'name' => 'Botol'
        ]);
        StandardUnit::create([
            'name' => 'Butir'
        ]);
        StandardUnit::create([
            'name' => 'Gulung'
        ]);
        StandardUnit::create([
            'name' => 'Dus'
        ]);
        StandardUnit::create([
            'name' => 'Kaleng'
        ]);
        StandardUnit::create([
            'name' => 'Setel'
        ]);
        StandardUnit::create([
            'name' => 'Box'
        ]);

        Logistic::create([
            'name' => 'Lauk Pauk',
            'logisticType_id' => 2,
            'standardUnit_id' => 8,
            'stock' => '0',
        ]);
        Logistic::create([
            'name' => 'Makanan Siap Saji',
            'logisticType_id' => 2,
            'standardUnit_id' => 8,
            'stock' => '0',
        ]);
        Logistic::create([
            'name' => 'Air Mineral',
            'logisticType_id' => 2,
            'standardUnit_id' => 12,
            'stock' => '0',
        ]);
        Logistic::create([
            'name' => 'Paket Perlengkapan Keluarga',
            'logisticType_id' => 1,
            'standardUnit_id' => 8,
            'stock' => '0',
        ]);
        Logistic::create([
            'name' => 'Paket Kebersihan Keluarga',
            'logisticType_id' => 1,
            'standardUnit_id' => 8,
            'stock' => '0',
        ]);
        Logistic::create([
            'name' => 'Paket Kesehatan Keluarga',
            'logisticType_id' => 1,
            'standardUnit_id' => 8,
            'stock' => '0',
        ]);
        Logistic::create([
            'name' => 'Paket Perlengkapan Bayi',
            'logisticType_id' => 1,
            'standardUnit_id' => 8,
            'stock' => '0',
        ]);
        Logistic::create([
            'name' => 'Kantong Mayat',
            'logisticType_id' => 3,
            'standardUnit_id' => 4,
            'stock' => '0',
        ]);
        Logistic::create([
            'name' => 'Masker N95',
            'logisticType_id' => 1,
            'standardUnit_id' => 4,
            'stock' => '0',
        ]);
        Logistic::create([
            'name' => 'Matras',
            'logisticType_id' => 1,
            'standardUnit_id' => 4,
            'stock' => '0',
        ]);
        Logistic::create([
            'name' => 'Selimut',
            'logisticType_id' => 1,
            'standardUnit_id' => 4,
            'stock' => '0',
        ]);
        Logistic::create([
            'name' => 'Perlengkapan Makan',
            'logisticType_id' => 1,
            'standardUnit_id' => 8,
            'stock' => '0',
        ]);
        Logistic::create([
            'name' => 'Sarden',
            'logisticType_id' => 2,
            'standardUnit_id' => 13,
            'stock' => '0',
        ]);
        Logistic::create([
            'name' => 'Mie Instan',
            'logisticType_id' => 2,
            'standardUnit_id' => 12,
            'stock' => '0',
        ]);
        Logistic::create([
            'name' => 'Peralatan Dapur Keluarga',
            'logisticType_id' => 1,
            'standardUnit_id' => 8,
            'stock' => '0',
        ]);

        Supplier::create([
            'name' => 'PT. Cakra Nusantara',
            'address' => 'Jalan Tukad Batanghari',
            'contactPerson' => 'Gusta',
            'telephone' => '087500000001'
        ]);
        Supplier::create([
            'name' => 'PT. Agung Sentosa',
            'address' => 'Jalan Antasura',
            'contactPerson' => 'Flaviarus Erwin Putranto',
            'telephone' => '087500000002'
        ]);
        Supplier::create([
            'name' => 'PT. Bintang Sejahtera',
            'address' => 'Jalan Merpati',
            'contactPerson' => 'Jonathan Liem',
            'telephone' => '087500000003'
        ]);
        Supplier::create([
            'name' => 'PT. Cahaya Perkasa',
            'address' => 'Jalan Merak',
            'contactPerson' => 'Putu Wanaraya',
            'telephone' => '087500000004'
        ]);
        Supplier::create([
            'name' => 'PT. Purnama',
            'address' => 'Jalan Gunung Agung',
            'contactPerson' => 'Indah Jayanthi Putri',
            'telephone' => '087500000005'
        ]);
    }
}
