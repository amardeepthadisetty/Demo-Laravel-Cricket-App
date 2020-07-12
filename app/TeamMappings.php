<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamMappings extends Model
{
    // 
    protected $connection = 'mysql';
    protected $table = 'team_player_mappings';

    protected $guarded =[];
}
