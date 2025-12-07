<?php

namespace App\Services;

use App\Repositories\ProductRepositoryInterface;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAllProducts()
    {
        return $this->productRepository->all();
    }

    public function getProductBySlug($slug)
    {
        return $this->productRepository->findBySlug($slug);
    }

    public function getFeaturedProducts()
    {
        return $this->productRepository->getFeatured();
    }

    public function getRecentProducts()
    {
        return $this->productRepository->getRecent();
    }

    public function filterProducts(array $filters)
    {
        return $this->productRepository->filter($filters);
    }
}
