<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
return [

    'jar'=> app_path().'/functions/silk/silk.jar',

    'config' => [
            '-d64',
            '-Xms2G',
            '-Xmx4G',
            '-Dreload=true',
            '-Dthreads=4',
        ],

];
