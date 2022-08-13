// ignore_for_file: prefer_const_constructors, prefer_const_literals_to_create_immutables, unnecessary_new

import 'package:flutter/material.dart';
import 'package:hr_app/home.dart';

class Profil extends StatefulWidget {
  // const Profil({ Key? key }) : super(key: key);

  @override
  State<Profil> createState() => _ProfilState();
}

class _ProfilState extends State<Profil> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Profil'),
        leading: GestureDetector(
          onTap: () => Navigator.of(context).push(
            new MaterialPageRoute(
              builder: (BuildContext context) => new Home(),
            ),
          ),
          child: Icon(
            Icons.arrow_back_ios_rounded, // add custom icons also
          ),
        ),
        centerTitle: true,
      ),
      backgroundColor: Colors.white,
      body: ListView(
        children: [
          Container(
            child: Column(
              children: [
                Padding(
                  padding: const EdgeInsets.fromLTRB(34, 31, 8, 27),
                  child: Row(
                    children: [
                      Container(
                        child: Image.asset('assets/lgprofil.png'),
                      ),
                      Container(
                        alignment: Alignment.centerLeft,
                        padding: const EdgeInsets.only(
                            top: 16.0, bottom: 8, left: 17),
                        child: Text('Data Pribadi',
                            style: TextStyle(
                                fontWeight: FontWeight.bold, fontSize: 16)),
                      ),
                    ],
                  ),
                ),
                Padding(
                  padding: const EdgeInsets.fromLTRB(34, 2, 8, 20),
                  child: Column(
                    children: [
                      Container(
                        alignment: Alignment.centerLeft,
                        child: Text('Nama',
                            style: TextStyle(fontSize: 16, color: Colors.grey)),
                      ),
                      Container(
                        alignment: Alignment.centerLeft,
                        child: Text('Muhammad Fatih Darmawan',
                            style: TextStyle(
                                fontWeight: FontWeight.bold, fontSize: 16)),
                      ),
                    ],
                  ),
                ),
                Padding(
                  padding: const EdgeInsets.fromLTRB(34, 2, 8, 20),
                  child: Column(
                    children: [
                      Container(
                        alignment: Alignment.centerLeft,
                        child: Text('Tempat, Tanggal Lahir',
                            style: TextStyle(fontSize: 16, color: Colors.grey)),
                      ),
                      Container(
                        alignment: Alignment.centerLeft,
                        child: Text('Yogyakarta, 9 November 2201',
                            style: TextStyle(
                                fontWeight: FontWeight.bold, fontSize: 16)),
                      ),
                    ],
                  ),
                ),
                Padding(
                  padding: const EdgeInsets.fromLTRB(34, 2, 8, 20),
                  child: Column(
                    children: [
                      Container(
                        alignment: Alignment.centerLeft,
                        child: Text('NIK',
                            style: TextStyle(fontSize: 16, color: Colors.grey)),
                      ),
                      Row(
                        children: [
                          Container(
                            alignment: Alignment.centerLeft,
                            child: Text('3412356789014562',
                                style: TextStyle(
                                    fontWeight: FontWeight.bold, fontSize: 16)),
                          ),
                          Padding(
                            padding: const EdgeInsets.only(left: 119),
                            child: IconButton(
                              icon: Image.asset('assets/lgsalin.png'),
                              onPressed: () {},
                            ),
                          )
                        ],
                      ),
                    ],
                  ),
                ),
                Padding(
                  padding: const EdgeInsets.fromLTRB(34, 2, 8, 20),
                  child: Column(
                    children: [
                      Container(
                        alignment: Alignment.centerLeft,
                        child: Text('NPWP',
                            style: TextStyle(fontSize: 16, color: Colors.grey)),
                      ),
                      Row(
                        children: [
                          Container(
                            alignment: Alignment.centerLeft,
                            child: Text('2345698131',
                                style: TextStyle(
                                    fontWeight: FontWeight.bold, fontSize: 16)),
                          ),
                          Padding(
                            padding: const EdgeInsets.only(left: 179),
                            child: IconButton(
                              icon: Image.asset('assets/lgsalin.png'),
                              onPressed: () {},
                            ),
                          )
                        ],
                      ),
                    ],
                  ),
                ),
                Padding(
                  padding: const EdgeInsets.fromLTRB(34, 31, 8, 27),
                  child: Row(
                    children: [
                      Container(
                        child: Image.asset('assets/lgkerja.png'),
                      ),
                      Container(
                        alignment: Alignment.centerLeft,
                        padding: const EdgeInsets.only(
                            top: 16.0, bottom: 8, left: 17),
                        child: Text('Data Karyawan',
                            style: TextStyle(
                                fontWeight: FontWeight.bold, fontSize: 16)),
                      ),
                    ],
                  ),
                ),
                Padding(
                  padding: const EdgeInsets.fromLTRB(34, 2, 8, 20),
                  child: Column(
                    children: [
                      Container(
                        alignment: Alignment.centerLeft,
                        child: Text('ID Perusahaan',
                            style: TextStyle(fontSize: 16, color: Colors.grey)),
                      ),
                      Container(
                        alignment: Alignment.centerLeft,
                        child: Text('FL-345123',
                            style: TextStyle(
                                fontWeight: FontWeight.bold, fontSize: 16)),
                      ),
                    ],
                  ),
                ),
                Padding(
                  padding: const EdgeInsets.fromLTRB(34, 2, 8, 20),
                  child: Column(
                    children: [
                      Container(
                        alignment: Alignment.centerLeft,
                        child: Text('Jabatan',
                            style: TextStyle(fontSize: 16, color: Colors.grey)),
                      ),
                      Container(
                        alignment: Alignment.centerLeft,
                        child: Text('Mobile Developer',
                            style: TextStyle(
                                fontWeight: FontWeight.bold, fontSize: 16)),
                      ),
                    ],
                  ),
                ),
                Padding(
                  padding: const EdgeInsets.fromLTRB(34, 2, 8, 20),
                  child: Column(
                    children: [
                      Container(
                        alignment: Alignment.centerLeft,
                        child: Text('Masa Kerja',
                            style: TextStyle(fontSize: 16, color: Colors.grey)),
                      ),
                      Container(
                        alignment: Alignment.centerLeft,
                        child: Text('30 Juli 2022 - 30 Desember 2025',
                            style: TextStyle(
                                fontWeight: FontWeight.bold, fontSize: 16)),
                      ),
                    ],
                  ),
                ),
                Padding(
                  padding: const EdgeInsets.only(top: 24, bottom: 13),
                  child: SizedBox(
                    width: 342,
                    height: 46,
                    child: ElevatedButton(
                      child: const Text('Kembali'),
                      onPressed: () {},
                    ),
                  ),
                )
              ],
            ),
          ),
        ],
      ),
    );
  }
}
