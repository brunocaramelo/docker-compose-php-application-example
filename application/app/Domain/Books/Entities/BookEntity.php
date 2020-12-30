<?php

namespace App\Domain\Books\Entities;

use Illuminate\Database\Eloquent\Model;

class BookEntity extends Model
{
    protected $table = 'books';
    
    protected $fillable = [
                            'isbn',
                            'title',
                            'cover',
                            'level_name',
                            'price',
                        ];

    public function authors()
    {
        return $this->belongsToMany(
            \App\Domain\Authors\Entities\AuthorEntity::class,
            'book_authors',
            'book_id',
            'author_id'
        );
    }

    public function disciplines()
    {
        return $this->belongsToMany(
            \App\Domain\Disciplines\Entities\DisciplineEntity::class,
            'book_disciplines',
            'book_id',
            'discipline_id'
        );
    }
    
    public function scopeActive($query)
    {
        return $query->where('status', '=', '1');
    }
}
