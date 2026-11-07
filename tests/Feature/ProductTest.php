<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    private function makeProduct(array $attributes = []): Product
    {
        return Product::create(array_merge([
            'name' => 'Chair',
            'price' => 100,
        ], $attributes));
    }

    private function validData(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Chair',
            'price' => 1200,
        ], $overrides);
    }

    public function test_index_lists_products_with_their_category(): void
    {
        $category = Category::create(['name' => 'Furniture']);
        $this->makeProduct(['name' => 'Wooden Stool', 'category_id' => $category->id]);

        $this->get(route('products.index'))
            ->assertOk()
            ->assertSee('Wooden Stool')
            ->assertSee('Furniture');
    }

    public function test_product_can_be_created(): void
    {
        $this->post(route('products.store'), $this->validData())
            ->assertRedirect(route('products.index'));

        $this->assertDatabaseHas('products', ['name' => 'Chair']);
    }

    public function test_product_can_be_created_with_a_category(): void
    {
        $category = Category::create(['name' => 'Furniture']);

        $this->post(route('products.store'), $this->validData(['category_id' => $category->id]))
            ->assertRedirect(route('products.index'));

        $this->assertDatabaseHas('products', [
            'name' => 'Chair',
            'category_id' => $category->id,
        ]);
    }

    public function test_name_is_required(): void
    {
        $this->post(route('products.store'), $this->validData(['name' => '']))
            ->assertSessionHasErrors('name');

        $this->assertDatabaseCount('products', 0);
    }

    public function test_price_must_be_a_non_negative_number(): void
    {
        foreach (['', 'abc', '-5'] as $badPrice) {
            $this->post(route('products.store'), $this->validData(['price' => $badPrice]))
                ->assertSessionHasErrors('price');
        }

        $this->assertDatabaseCount('products', 0);
    }

    public function test_category_must_exist(): void
    {
        $this->post(route('products.store'), $this->validData(['category_id' => 999]))
            ->assertSessionHasErrors('category_id');

        $this->assertDatabaseCount('products', 0);
    }

    public function test_product_can_be_updated(): void
    {
        $product = $this->makeProduct();

        $this->put(route('products.update', $product), $this->validData(['name' => 'Sofa', 'price' => 200]))
            ->assertRedirect(route('products.index'));

        $this->assertDatabaseHas('products', ['id' => $product->id, 'name' => 'Sofa']);
    }

    public function test_product_category_can_be_changed(): void
    {
        $old = Category::create(['name' => 'Chairs']);
        $new = Category::create(['name' => 'Tables']);
        $product = $this->makeProduct(['category_id' => $old->id]);

        $this->put(route('products.update', $product), $this->validData(['category_id' => $new->id]))
            ->assertRedirect(route('products.index'));

        $this->assertDatabaseHas('products', ['id' => $product->id, 'category_id' => $new->id]);
    }

    public function test_product_can_be_deleted(): void
    {
        $product = $this->makeProduct();

        $this->delete(route('products.destroy', $product))
            ->assertRedirect(route('products.index'));

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}