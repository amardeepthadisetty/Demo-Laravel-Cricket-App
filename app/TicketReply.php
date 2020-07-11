<?php

namespace App;

use App\User;
use App\Ticket;
use Illuminate\Database\Eloquent\Model;

class TicketReply extends Model
{
    protected $connection = 'mysql';
    protected $table = 'ticket_replies';
    public function ticket(){
    	return $this->belongsTo(Ticket::class);
    }
    public function user(){
    	return $this->belongsTo(User::class);
    }
}
