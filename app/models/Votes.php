<?php

class Votes extends Eloquent {
    protected $fillable = array('user_id','comment_id','vote'); // need to read up on mass assignment/ security issues

}