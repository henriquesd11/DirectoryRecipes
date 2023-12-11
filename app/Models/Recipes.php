<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipes extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'ingredients',
        'preparation',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'title' => 'string',
        'description' => 'string',
        'ingredients' => 'string',
        'preparation' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, fn($query, $search) =>
        $query->where(fn($query) =>
        $query->where('title', 'like', '%' . $search . '%')
            ->orWhere('description', 'like', '%' . $search . '%')
            ->orWhere('ingredients', 'like', '%' . $search . '%')
            ->orWhere('preparation', 'like', '%' . $search . '%')));
    }

    public function scopeSort($query, $sort)
    {
        $direction = 'asc';

        if (substr($sort, 0, 1) === '-') {
            $direction = 'desc';
            $sort = substr($sort, 1);
        }

        $query->when($sort ?? false, fn($query, $sort) =>
        $query->orderBy($sort, $direction));
    }

    public function scopePaginate($query, $paginate)
    {
        $query->when($paginate ?? false, fn($query, $paginate) =>
        $query->paginate($paginate));
    }
}
