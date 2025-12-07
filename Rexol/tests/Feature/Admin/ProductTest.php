<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\Product;
use App\Models\Size;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    private $admin;
    private $category;
    private $sizes;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->category = Category::create(['name' => 'Test Cat', 'slug' => 'test-cat', 'status' => 1]);

        $this->sizes = collect([
            Size::create(['name' => 'S', 'slug' => 's']),
            Size::create(['name' => 'M', 'slug' => 'm']),
        ]);
    }

    public function test_admin_can_view_products_index()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.products.index'));
        $response->assertStatus(200);
    }

    public function test_admin_can_create_product_with_sizes_and_images()
    {
        // Mock storage
        Storage::fake('public');

        $file = UploadedFile::fake()->image('product.jpg');

        $response = $this->actingAs($this->admin)->post(route('admin.products.store'), [
            'title' => 'New Product',
            'category_id' => $this->category->id,
            'price' => 100,
            'stock' => 10,
            'status' => 'on',
            'featured' => 'on',
            'sizes' => $this->sizes->pluck('id')->toArray(),
            'images' => [$file]
        ]);

        $response->assertRedirect(route('admin.products.index'));

        $this->assertDatabaseHas('products', ['title' => 'New Product']);

        $product = Product::where('title', 'New Product')->first();

        // Check sizes
        $this->assertEquals(2, $product->sizes()->count());
        $this->assertTrue($product->sizes->contains($this->sizes->first()));

        // Check images
        $this->assertEquals(1, $product->images()->count());

        // Verify storage
        // Image path is stored relative to public disk root in DB logic, but usually we store relative path
        // Controller: $image->store('products', 'public') returns 'products/hash.jpg'
        // DB: '/storage/' . $path

        $dbImage = $product->images->first()->image;
        $storagePath = str_replace('/storage/', '', $dbImage);

        Storage::disk('public')->assertExists($storagePath);
    }

    public function test_admin_can_update_product()
    {
        $product = Product::create([
            'title' => 'Old Product',
            'slug' => 'old-product',
            'category_id' => $this->category->id,
            'price' => 50
        ]);

        // Attach initial size
        $product->sizes()->attach($this->sizes->first());

        $response = $this->actingAs($this->admin)->put(route('admin.products.update', $product), [
            'title' => 'Updated Product',
            'category_id' => $this->category->id,
            'price' => 75,
            // Omitting sizes means detach all in my reading of controller logic?
            // Controller: if has('sizes') sync, else detach().
            // If I send empty array or nothing, it should detach.
            // Wait, HTML form verification: if no checkbox checked, 'sizes' is not sent.
            // So omit 'sizes' key.
        ]);

        $response->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', ['title' => 'Updated Product', 'price' => 75]);

        $this->assertEquals(0, $product->fresh()->sizes()->count());
    }

    public function test_admin_can_delete_product()
    {
        $product = Product::create([
            'title' => 'Delete Me',
            'slug' => 'delete-me',
            'category_id' => $this->category->id,
            'price' => 50
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.products.destroy', $product));

        $response->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
