// ignore_for_file: prefer_const_constructors, prefer_const_literals_to_create_immutables, unnecessary_new

import 'package:animated_splash_screen/animated_splash_screen.dart';
import 'package:flutter/material.dart';
import 'package:hr_app/home.dart';
import 'package:page_transition/page_transition.dart';
import 'package:intl/intl.dart';

void main() => runApp(Login());

class Login extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      home: AnimatedSplashScreen(
        duration: 3000,
        splash: Center(
          child: Image.asset('assets/lgsplash.png'),
        ),
        nextScreen: LoginPage(),
        splashTransition: SplashTransition.scaleTransition,
        pageTransitionType: PageTransitionType.leftToRight,
        backgroundColor: Colors.teal.shade400,
      ),
    );
  }
}

class LoginPage extends StatefulWidget {
  @override
  _LoginPageState createState() => _LoginPageState();
}

class _LoginPageState extends State<LoginPage> {
  TextEditingController nameController = TextEditingController();
  TextEditingController passwordController = TextEditingController();

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Padding(
          padding: const EdgeInsets.all(10),
          child: ListView(
            children: <Widget>[
              Container(
                  alignment: Alignment.center,
                  padding: const EdgeInsets.only(top: 90.0),
                  child: Image.asset('assets/lgfloo.png')),
              Container(
                  alignment: Alignment.centerLeft,
                  padding:
                      const EdgeInsets.only(top: 48, left: 10.0, bottom: 13.0),
                  child: const Text(
                    'Login your Account',
                    style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold),
                  )),
              Container(
                padding: const EdgeInsets.all(10),
                child: TextField(
                  controller: nameController,
                  decoration: const InputDecoration(
                    border: OutlineInputBorder(),
                    labelText: 'Floo email',
                  ),
                ),
              ),
              Container(
                padding: const EdgeInsets.fromLTRB(10, 10, 10, 16),
                child: TextField(
                  obscureText: true,
                  controller: passwordController,
                  decoration: const InputDecoration(
                    border: OutlineInputBorder(),
                    labelText: 'Password',
                  ),
                ),
              ),
              Container(
                  height: 50,
                  padding: const EdgeInsets.fromLTRB(10, 0, 10, 0),
                  child: ElevatedButton(
                    child: const Text('Login'),
                    onPressed: () {
                      Navigator.of(context).push(new MaterialPageRoute(
                          builder: (BuildContext context) => new Home()));
                    },
                  )),

              // Container(
              //   child: Text('PT FLoo Integra Digital'),
              // )
            ],
          )),
    );
  }
}
