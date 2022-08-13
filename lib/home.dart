// ignore_for_file: prefer_const_constructors, prefer_const_literals_to_create_immutables, unnecessary_new, unused_field

import 'dart:async';

import 'package:flutter/material.dart';
import 'package:hr_app/change_pass.dart';
import 'package:hr_app/izin_cuti.dart';
import 'package:hr_app/main.dart';
import 'package:hr_app/profil.dart';
import 'package:hr_app/slip_gaji.dart';
import 'package:intl/intl.dart';

class Home extends StatefulWidget {
  // const Home({ Key? key }) : super(key: key);

  @override
  State<Home> createState() => _HomeState();
}

class _HomeState extends State<Home> {
  var _timeString;
  bool isCheckIn;

  @override
  void initState() {
    _timeString = _formatDateTime(DateTime.now());
    Timer.periodic(Duration(seconds: 1), (Timer t) => _getTime());
    isCheckIn = false;
    super.initState();
  }

  void _getTime() {
    final DateTime now = DateTime.now();
    final String formattedDateTime = _formatDateTime(now);
    setState(() {
      _timeString = formattedDateTime;
    });
  }

  String _formatDateTime(DateTime dateTime) {
    return DateFormat('hh:mm:ss').format(dateTime);
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.teal.shade400,
      body: ListView(
        children: [
          DecoratedBox(
            decoration: BoxDecoration(
                image: DecorationImage(
                    image: AssetImage('assets/bgview3.png'),
                    fit: BoxFit.cover)),
            child: Container(
              child: Column(
                children: [
                  Container(
                      alignment: Alignment.center,
                      padding: const EdgeInsets.only(top: 36.0),
                      child: Image.asset('assets/lgmini.png')),
                  Container(
                      alignment: Alignment.center,
                      padding: const EdgeInsets.only(top: 16.0),
                      child: Image.asset('assets/profil.png')),
                  Container(
                      alignment: Alignment.center,
                      padding: const EdgeInsets.only(
                          top: 16, left: 10.0, bottom: 16.0),
                      child: Column(
                        // ignore: prefer_const_literals_to_create_immutables
                        children: [
                          const Text(
                            'Muhammad Fatih Darmawan',
                            style: TextStyle(
                                fontSize: 16,
                                fontWeight: FontWeight.bold,
                                color: Colors.white),
                          ),
                          Text('Mobile Developer',
                              style:
                                  TextStyle(fontSize: 16, color: Colors.white))
                        ],
                      )),
                  isCheckIn ?
                  Card( // Jika sudah check in muncul cart ini untuk warna merah
                    margin: EdgeInsets.symmetric(horizontal: 17),
                    clipBehavior: Clip.antiAlias,
                    child: Container(
                      color: Colors.red
                      padding: EdgeInsets.all(10),
                      child: Row(
                        children: [
                          Image.asset('assets/lgfinger.png'),
                          SizedBox(
                            width: 15,
                          ),
                          Column(
                            children: [
                              Text(
                                _timeString,
                                style: TextStyle(
                                    fontSize: 24, fontWeight: FontWeight.bold),
                              ),
                              Padding(
                                padding: const EdgeInsets.only(left: 12),
                                child: Text(
                                  DateFormat.yMMMEd().format(DateTime.now()),
                                  style: TextStyle(
                                      fontSize: 12, color: Colors.grey),
                                ),
                              ),
                            ],
                          ),
                          SizedBox(width: 72),
                          IconButton(
                            icon: Image.asset('assets/lgabsen.png'),
                            onPressed: () {},
                          ),
                          IconButton(
                            icon: Image.asset('assets/lghadir.png'),
                            onPressed: () {},
                          ),
                        ],
                      ),
                    ),
                  ) : Card( // jika belum muncul card yang ini default putih 
                    margin: EdgeInsets.symmetric(horizontal: 17),
                    clipBehavior: Clip.antiAlias,
                    child: Container(
                      padding: EdgeInsets.all(10),
                      child: Row(
                        children: [
                          Image.asset('assets/lgfinger.png'),
                          SizedBox(
                            width: 15,
                          ),
                          Column(
                            children: [
                              Text(
                                _timeString,
                                style: TextStyle(
                                    fontSize: 24, fontWeight: FontWeight.bold),
                              ),
                              Padding(
                                padding: const EdgeInsets.only(left: 12),
                                child: Text(
                                  DateFormat.yMMMEd().format(DateTime.now()),
                                  style: TextStyle(
                                      fontSize: 12, color: Colors.grey),
                                ),
                              ),
                            ],
                          ),
                          SizedBox(width: 72),
                          IconButton(
                            icon: Image.asset('assets/lgabsen.png'),
                            onPressed: () {},
                          ),
                          IconButton(
                            icon: Image.asset('assets/lghadir.png'),
                            onPressed: () {
                              setState((){
                                isCheckIn = true;
                              });
                            },
                          ),
                        ],
                      ),
                    ),
                  ),
                  Container(
                    alignment: Alignment.centerLeft,
                    padding:
                        const EdgeInsets.only(top: 16.0, bottom: 8, left: 15),
                    child: Text('Account Information',
                        style: TextStyle(
                            fontWeight: FontWeight.bold, fontSize: 16)),
                  ),
                  Column(
                    children: [
                      Row(
                        children: [
                          GestureDetector(
                            onTap: () {
                              Navigator.of(context).push(new MaterialPageRoute(
                                  builder: (BuildContext context) =>
                                      new Profil()));
                            },
                            child: Container(
                              alignment: Alignment.centerLeft,
                              padding: const EdgeInsets.only(left: 17),
                              child: Card(
                                  child: Column(
                                crossAxisAlignment: CrossAxisAlignment.start,
                                children: [
                                  Padding(
                                    padding: const EdgeInsets.only(
                                        top: 16.0, bottom: 8, left: 17),
                                    child: Image.asset('assets/lgprofil.png'),
                                  ),
                                  Padding(
                                    padding: const EdgeInsets.only(
                                        top: 4.0, bottom: 8, left: 17),
                                    child: Text('Profil',
                                        style: TextStyle(
                                            fontWeight: FontWeight.bold,
                                            fontSize: 14)),
                                  ),
                                  Padding(
                                    padding: const EdgeInsets.only(
                                        bottom: 8, left: 17),
                                    child: Text('Muhammad Fatih ',
                                        style: TextStyle(
                                            fontWeight: FontWeight.bold,
                                            fontSize: 12,
                                            color: Colors.grey)),
                                  ),
                                  Padding(
                                    padding: const EdgeInsets.only(
                                        bottom: 8, left: 17),
                                    child: Text('Mobile Developer',
                                        style: TextStyle(
                                            fontSize: 12, color: Colors.grey)),
                                  ),
                                  Padding(
                                    padding: const EdgeInsets.only(left: 10),
                                    child: SizedBox(
                                      width: 153,
                                    ),
                                  )
                                ],
                              )),
                            ),
                          ),
                          GestureDetector(
                            onTap: () {
                              Navigator.of(context).push(new MaterialPageRoute(
                                  builder: (BuildContext context) =>
                                      new SlipGaji()));
                            },
                            child: Container(
                              alignment: Alignment.centerLeft,
                              padding: const EdgeInsets.only(left: 1),
                              child: Card(
                                  child: Column(
                                crossAxisAlignment: CrossAxisAlignment.start,
                                children: [
                                  Padding(
                                    padding: const EdgeInsets.only(
                                        top: 16.0, bottom: 8, left: 17),
                                    child: Image.asset('assets/lggaji.png'),
                                  ),
                                  Padding(
                                    padding: const EdgeInsets.only(
                                        top: 4.0, bottom: 8, left: 17),
                                    child: Text('Slip Gaji',
                                        style: TextStyle(
                                            fontWeight: FontWeight.bold,
                                            fontSize: 14)),
                                  ),
                                  Padding(
                                    padding: const EdgeInsets.only(
                                        bottom: 8, left: 17),
                                    child: Text('Rp. 6.000.000',
                                        style: TextStyle(
                                            fontSize: 12, color: Colors.grey)),
                                  ),
                                  Padding(
                                    padding: const EdgeInsets.only(
                                        bottom: 8, left: 17),
                                    child: Text('Lihat slip gaji',
                                        style: TextStyle(
                                            fontSize: 12, color: Colors.grey)),
                                  ),
                                  Padding(
                                    padding: const EdgeInsets.only(left: 10),
                                    child: SizedBox(
                                      width: 153,
                                    ),
                                  )
                                ],
                              )),
                            ),
                          ),
                        ],
                      ),
                      Row(
                        children: [
                          GestureDetector(
                            onTap: () {
                              Navigator.of(context).push(new MaterialPageRoute(
                                  builder: (BuildContext context) =>
                                      new IzinCuti()));
                            },
                            child: Container(
                              alignment: Alignment.centerLeft,
                              padding: const EdgeInsets.only(left: 17),
                              child: Card(
                                  child: Column(
                                crossAxisAlignment: CrossAxisAlignment.start,
                                children: [
                                  Padding(
                                    padding: const EdgeInsets.only(
                                        top: 16.0, bottom: 8, left: 17),
                                    child: Image.asset('assets/lgcuti.png'),
                                  ),
                                  Padding(
                                    padding: const EdgeInsets.only(
                                        top: 4.0, bottom: 8, left: 17),
                                    child: Text('Pengajuan Cuti',
                                        style: TextStyle(
                                            fontWeight: FontWeight.bold,
                                            fontSize: 14)),
                                  ),
                                  Padding(
                                    padding: const EdgeInsets.only(
                                        bottom: 8, left: 17),
                                    child: Text('Cuti Anda Tersisa : ',
                                        style: TextStyle(
                                            fontSize: 12, color: Colors.grey)),
                                  ),
                                  Padding(
                                    padding: const EdgeInsets.only(
                                        bottom: 8, left: 17),
                                    child: Text('9 Hari',
                                        style: TextStyle(
                                            fontSize: 12, color: Colors.grey)),
                                  ),
                                  Padding(
                                    padding: const EdgeInsets.only(left: 10),
                                    child: SizedBox(
                                      width: 153,
                                    ),
                                  )
                                ],
                              )),
                            ),
                          ),
                          GestureDetector(
                            onTap: () {},
                            child: Container(
                              alignment: Alignment.centerLeft,
                              padding: const EdgeInsets.only(left: 1),
                              child: Card(
                                  child: Column(
                                crossAxisAlignment: CrossAxisAlignment.start,
                                children: [
                                  Padding(
                                    padding: const EdgeInsets.only(
                                        top: 16.0, bottom: 8, left: 17),
                                    child: Image.asset('assets/lgrei.png'),
                                  ),
                                  Padding(
                                    padding: const EdgeInsets.only(
                                        top: 4.0, bottom: 8, left: 17),
                                    child: Text('Reimbursement',
                                        style: TextStyle(
                                            fontWeight: FontWeight.bold,
                                            fontSize: 14)),
                                  ),
                                  Padding(
                                    padding: const EdgeInsets.only(
                                        bottom: 8, left: 17),
                                    child: Text('- Bpjs Kesehatan',
                                        style: TextStyle(
                                            fontSize: 12, color: Colors.grey)),
                                  ),
                                  Padding(
                                    padding: const EdgeInsets.only(
                                        bottom: 8, left: 17),
                                    child: Text('- Etc',
                                        style: TextStyle(
                                            fontSize: 12, color: Colors.grey)),
                                  ),
                                  Padding(
                                    padding: const EdgeInsets.only(left: 10),
                                    child: SizedBox(
                                      width: 153,
                                    ),
                                  )
                                ],
                              )),
                            ),
                          ),
                        ],
                      ),
                    ],
                  ),
                  Container(
                    alignment: Alignment.centerLeft,
                    padding:
                        const EdgeInsets.only(top: 16.0, bottom: 8, left: 17),
                    child: Text('Account Setting',
                        style: TextStyle(
                            fontWeight: FontWeight.bold, fontSize: 16)),
                  ),
                  GestureDetector(
                    onTap: () {
                      Navigator.of(context).push(new MaterialPageRoute(
                          builder: (BuildContext context) => new ChangePass()));
                    },
                    child: Card(
                      margin: EdgeInsets.only(left: 17, right: 17, bottom: 8),
                      child: ListTile(
                        leading: Image.asset('assets/lgpass.png'),
                        title: Text('ganti password'),
                        trailing: Icon(Icons.arrow_forward_ios_outlined),
                      ),
                    ),
                  ),
                  GestureDetector(
                    onTap: () {},
                    child: Card(
                      margin: EdgeInsets.only(left: 17, right: 17),
                      child: ListTile(
                        leading: Image.asset('assets/lgterm.png'),
                        title: Text('Terms and condition'),
                        trailing: Icon(Icons.arrow_forward_ios_outlined),
                      ),
                    ),
                  ),
                  Padding(
                    padding: const EdgeInsets.only(top: 24, bottom: 13),
                    child: SizedBox(
                      width: 342,
                      height: 46,
                      child: ElevatedButton(
                        child: const Text('Log Out'),
                        onPressed: () {
                          Navigator.of(context).push(new MaterialPageRoute(
                              builder: (BuildContext context) => new Login()));
                        },
                      ),
                    ),
                  )
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }
}
