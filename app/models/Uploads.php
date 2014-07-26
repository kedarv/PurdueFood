<?php

class Uploads extends Eloquent {
    protected $fillable = array('food_id','filename','email','shortcode'); // need to read up on mass assignment/ security issues

}