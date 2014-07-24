<?php
class Favorites extends Eloquent{
    protected $fillable = array('user_id','food_id','favorite'); // need to read up on mass assignment/ security issues

} 