<?php
    namespace Controller;
    class ViewController {
        static function main() {
            view('main');
        }
    
        static function sub() {
            view('sub');
        }
    
        static function stamp() {
            view('stamp');
        }

        static function login() {
            view('login');
        }
    }