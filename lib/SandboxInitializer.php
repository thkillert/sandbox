<?php

    namespace MySandbox\lib;

    class SandboxInitializer {
        public static function postUpdate(){
            echo 'composer post-update from package';
            echo "\n";
            exit;
        }

        public static function postInstall(){
            echo 'composer post-install from package';
            echo "\n";
            exit;
        }
    }
