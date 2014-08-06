<?php

class NextDay extends Eloquent {
	protected $table = 'nextday';
    protected $fillable = array('food_id', 'food_name', 'hall', 'station'); // need to read up on mass assignment/ security issues
}