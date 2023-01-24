<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Response;
use Agent;
use General;
use Auth;

class fileController extends Controller
{
    public function show($path,$name='')
    {
        $filePath = 'storage/app/public/image';
        if($path == 'noimg') { //Noimg
            $filePath .= '/noimg.jpg';
            return response()->file($filePath);
        } else {
            $name = General::decode($name,env('CODE'));
            $ex = explode('/',$name);
            $name = @$ex[0];//1.jpg
            $tmp = @$ex[1];//tmp?t=xxx
    
            if($tmp) { $temp = 'tmp/'; } else { $temp = ''; }

            if($path == 'banner-top') {
                $path = '/banner_top/';
            } else if($path == 'banner-slide') {
                $path = '/banner_slide/';
            } else if($path == 'banner-promotion') {
                $path = '/banner_promotion/';
            } else if($path == 'news') {
                $path = '/news/';
            } else if($path == 'publisher') {
                $path = '/publisher/';
            } else if($path == 'e-book') {
                $path = '/e-book/';
            } else if($path == 'bank_acc') {
                $path = '/bank_acc/';
            } else if($path == 'read-corner') {
                $path = '/read_corner/';
            } else if($path == 'medias') {
                $path = '/medias/';
            } else if($path == 'avatar') {
                $path = '/avatar/';
            } else if($path == 'citizen') {
                $path = '/citizen/';
            } else if($path == 'review') {
                $path = '/review/';
            } else if($path == 'product') {
                $path = '/product/';
            } else if($path == 'product-sample') {
                $path = '/product/file/';
            } else if($path == 'slip') {
                $path = '/slip/';
            } 

            if(!$name) {
                $filePath .= '/noimg.jpg';
            } else {
                $filePath .=  $path.$temp.$name;
            }

            return response()->file($filePath);
        } 

    }

}
