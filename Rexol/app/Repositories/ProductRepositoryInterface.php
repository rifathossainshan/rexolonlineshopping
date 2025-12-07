<?php

namespace App\Repositories;

use App\Models\Product;

interface ProductRepositoryInterface
{
    public function all();
    public function find($id);
    public function findBySlug($slug);
    public function getFeatured($limit = 6);
    public function getRecent($limit = 8);
    public function filter(array $filters);
}
