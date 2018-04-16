<?php

    namespace MySandbox\lib;

    class SandboxInitializer {
        public static function postUpdate(){
            echo 'composer post-update from package';
            exit;
        }

        public static function postInstall(){
            echo 'composer post-install from package';
            exit;
        }
    }
