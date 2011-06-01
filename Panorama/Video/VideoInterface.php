<?php
/**
 *  Copyright (C) 2011 by OpenHost S.L.
 *
 *  Permission is hereby granted, free of charge, to any person obtaining a copy
 *  of this software and associated documentation files (the "Software"), to deal
 *  in the Software without restriction, including without limitation the rights
 *  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *  copies of the Software, and to permit persons to whom the Software is
 *  furnished to do so, subject to the following conditions:
 *
 *  The above copyright notice and this permission notice shall be included in
 *  all copies or substantial portions of the Software.
 *
 *  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 *  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 *  THE SOFTWARE.
 **/
/**
 * (c) Copyright Mér Xuñ 01 13:46:16 2011 Fran Diéguez. All Rights Reserved.
*/
namespace Panorama\Video;

interface VideoInterface {
    
    /**
     * Returns the download url for the video
    */
    public function getDownloadUrl();
    
    /**
     * Returns the video duration in secs
    */
    public function getDuration();
    
    /**
     * Returns the video embedHTML for put in a webpage
    */
    public function getEmbedHTML();
    
    /**
     * Returns the url of the video for embed in custom flash player 
    */
    public function getEmbedUrl();
    
    /**
     * Returns the url of the video in FLV format
    */
    public function getFLV();
    
    /**
     * Returns the service name of the video
    */
    public function getService();
    
    /**
     * Returns the default thumbnail of this video
    */
    public function getThumbnail();
    
    /**
     * Returns the title of this video 
    */
    public function getTitle();
    
    /**
     * Returns the internal video id in the particular service
    */
    public function getVideoId();


    
}