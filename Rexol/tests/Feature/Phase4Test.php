<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Phase4Test extends TestCase
{
    use RefreshDatabase;

    public function test_product_page_has_dynamic_seo_tags()
    {
        // 1. Create Data
        $category = Category::create(['name' => 'SEO Test', 'slug' => 'seo-test']);
        $product = Product::create([
            'title' => 'SEO Product',
            'slug' => 'seo-product',
            'category_id' => $category->id,
            'price' => 100,
            'stock' => 10,
            'meta_title' => 'Custom Meta Title',
            'meta_description' => 'Custom Meta Description',
            'meta_keywords' => 'keyword1, keyword2'
        ]);

        // 2. Visit Product Page
        $response = $this->get(route('products.show', $product->slug));

        // 3. Assert SEO Tags Present
        $response->assertStatus(200);
        $response->assertSee('<title>Custom Meta Title</title>', false);
        $response->assertSee('name="description" content="Custom Meta Description"', false);
        $response->assertSee('name="keywords" content="keyword1, keyword2"', false);

        // Assert Open Graph
        $response->assertSee('property="og:title" content="Custom Meta Title"', false);
    }

    public function test_sitemap_generation_command_works()
    {
        // Run command
        $this->artisan('sitemap:generate')->assertExitCode(0);

        // Assert file exists
        $this->assertTrue(file_exists(public_path('sitemap.xml')));

        // Assert content
        $content = file_get_contents(public_path('sitemap.xml'));
        $this->assertStringContainsString('<urlset', $content);
        $this->assertStringContainsString(route('home'), $content);
    }
}
