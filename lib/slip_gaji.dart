// ignore_for_file: prefer_const_constructors

import 'package:flutter/material.dart';
import 'package:hr_app/home.dart';

class SlipGaji extends StatefulWidget {
  const SlipGaji({Key? key}) : super(key: key);

  @override
  State<SlipGaji> createState() => _SlipGajiState();
}

class _SlipGajiState extends State<SlipGaji> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
        appBar: AppBar(
          actions: [
            Icon(Icons.share),
          ],
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
        body: Container(
          constraints: BoxConstraints.expand(),
          decoration: const BoxDecoration(
            image: DecorationImage(
                image: AssetImage("assets/bgview5.png"), fit: BoxFit.cover),
          ),
        ));
  }
}
