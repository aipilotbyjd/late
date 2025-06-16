<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Workflow extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function nodes()
    {
        return $this->hasMany(Node::class);
    }

    public function runs()
    {
        return $this->hasMany(WorkflowRun::class);
    }
}

