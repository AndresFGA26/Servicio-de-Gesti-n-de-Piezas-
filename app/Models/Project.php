<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name'];

    public function blocks()
    {
        return $this->hasMany(Block::class);
    }

    public function pieces()
    {
        return $this->hasManyThrough(Piece::class, Block::class);
    }
}
