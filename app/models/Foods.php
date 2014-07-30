<?php

class Foods extends Eloquent {
    protected $fillable = array('name','food_id'); // need to read up on mass assignment/ security issues
    protected  $primaryKey='food_id';

}