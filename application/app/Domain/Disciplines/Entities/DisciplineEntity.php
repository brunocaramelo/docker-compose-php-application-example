<?php

namespace App\Domain\Disciplines\Entities;

use Illuminate\Database\Eloquent\Model;

class DisciplineEntity extends Model
{
    protected $table = 'disciplines';

    protected $fillable = [
                            'name'
                        ];

    public function books()
    {
        return $this->belongsToMany(
            \App\Domain\Books\Entities\BookEntity::class,
            'book_disciplines',
            'discipline_id',
            'book_id'
        );
    }

    public function scopeActive($query)
    {
        return $query->where('status', '=', '1');
    }
}
