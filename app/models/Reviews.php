<?php

class Reviews extends Eloquent {
    protected $fillable = array('user_id','food_id','rating'); // need to read up on mass assignment/ security issues

}