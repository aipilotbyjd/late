<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Node extends Model
{
    use HasFactory;

    public function workflow()
    {
        return $this->belongsTo(Workflow::class);
    }

    public function integration()
    {
        return $this->belongsTo(Integration::class);
    }

    public function runs()
    {
        return $this->hasMany(NodeRun::class);
    }
}
