<?php
class Followers extends Eloquent{
    protected $fillable = array('follower_user_id','target_user_id','following');
} 