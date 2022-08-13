// ignore_for_file: prefer_const_constructors

import 'package:flutter/material.dart';
import 'package:hr_app/home.dart';

class ChangePass extends StatefulWidget {
  // const ChangePass({ Key? key }) : super(key: key);

  @override
  State<ChangePass> createState() => _ChangePassState();
}

class _ChangePassState extends State<ChangePass> {
  bool _isObscureNow = true;
  bool _isObscureNew = true;
  bool _isObscureFix = true;
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Ganti Password'),
        leading: GestureDetector(
          onTap: () => Navigator.of(context).push(
            MaterialPageRoute(
              builder: (BuildContext context) => Home(),
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
          Padding(
            padding: const EdgeInsets.symmetric(horizontal: 16),
            child: Column(
              children: [
                Container(
                  alignment: Alignment.centerLeft,
                  padding: const EdgeInsets.only(top: 16.0, bottom: 24),
                  child: Text('Amankan Akun Anda Dengan Sandi Baru',
                      style:
                          TextStyle(fontWeight: FontWeight.bold, fontSize: 16)),
                ),
                Container(
                  padding: const EdgeInsets.only(bottom: 16),
                  child: TextField(
                    obscureText: _isObscureNow,
                    decoration: InputDecoration(
                        fillColor: Colors.white,
                        filled: true,
                        labelText: 'Password saat Ini',
                        border: InputBorder.none,
                        suffixIcon: IconButton(
                            icon: Icon(_isObscureNow
                                ? Icons.visibility
                                : Icons.visibility_off),
                            onPressed: () {
                              setState(() {
                                _isObscureNow = !_isObscureNow;
                              });
                            })),
                  ),
                  decoration: BoxDecoration(
                    boxShadow: [
                      BoxShadow(
                        color: Colors.grey.shade200,
                        blurRadius: 25,
                        offset: const Offset(0, 1),
                      ),
                    ],
                  ),
                ),
                Container(
                  padding: const EdgeInsets.only(bottom: 16),
                  child: TextField(
                    obscureText: _isObscureNew,
                    decoration: InputDecoration(
                        fillColor: Colors.white,
                        filled: true,
                        labelText: 'Password Baru',
                        border: InputBorder.none,
                        suffixIcon: IconButton(
                            icon: Icon(_isObscureNew
                                ? Icons.visibility
                                : Icons.visibility_off),
                            onPressed: () {
                              setState(() {
                                _isObscureNew = !_isObscureNew;
                              });
                            })),
                  ),
                  decoration: BoxDecoration(
                    boxShadow: [
                      BoxShadow(
                        color: Colors.grey.shade200,
                        blurRadius: 25,
                        offset: const Offset(0, 1),
                      ),
                    ],
                  ),
                ),
                Container(
                  padding: const EdgeInsets.only(bottom: 16),
                  child: TextField(
                    obscureText: _isObscureFix,
                    decoration: InputDecoration(
                        fillColor: Colors.white,
                        filled: true,
                        labelText: 'Konfirmasi Password',
                        border: InputBorder.none,
                        suffixIcon: IconButton(
                            icon: Icon(_isObscureFix
                                ? Icons.visibility
                                : Icons.visibility_off),
                            onPressed: () {
                              setState(() {
                                _isObscureFix = !_isObscureFix;
                              });
                            })),
                  ),
                  decoration: BoxDecoration(
                    boxShadow: [
                      BoxShadow(
                        color: Colors.grey.shade200,
                        blurRadius: 25,
                        offset: const Offset(0, 1),
                      ),
                    ],
                  ),
                ),
                Container(
                  padding: const EdgeInsets.only(top: 24, bottom: 13),
                  child: SizedBox(
                    width: 342,
                    height: 46,
                    child: ElevatedButton(
                      child: const Text('Simpan'),
                      onPressed: () {},
                    ),
                  ),
                )
              ],
            ),
          )
        ],
      ),
    );
  }
}
