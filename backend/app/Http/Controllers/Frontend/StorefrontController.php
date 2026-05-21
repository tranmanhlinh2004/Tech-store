<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class StorefrontController extends Controller
{
    public function home()
    {
        try {
            $featuredProducts = $this->decorateProducts(
                $this->productQuery()
                    ->where('products.is_featured', true)
                    ->orderByDesc('products.created_at')
                    ->limit(8)
                    ->get()
            );

            $dealProducts = $this->decorateProducts(
                $this->productQuery()
                    ->whereNotNull('products.sale_price')
                    ->whereColumn('products.sale_price', '<', 'products.price')
                    ->orderByRaw('(products.price - products.sale_price) DESC')
                    ->limit(3)
                    ->get()
            );

            return view('frontend.index', [
                'featuredProducts' => $featuredProducts,
                'dealProducts' => $dealProducts,
                'categoryTiles' => $this->categoryTiles(),
                'brandNames' => DB::table('brands')
                    ->where('status', true)
                    ->orderBy('name')
                    ->limit(6)
                    ->pluck('name'),
                'stats' => [
                    'products' => DB::table('products')->where('status', 'active')->count(),
                    'brands' => DB::table('brands')->where('status', true)->count(),
                ],
            ]);
        } catch (Throwable) {
            return view('frontend.index', [
                'featuredProducts' => collect(),
                'dealProducts' => collect(),
                'categoryTiles' => collect(),
                'brandNames' => collect(),
                'stats' => ['products' => 0, 'brands' => 0],
            ]);
        }
    }

    public function shop(Request $request)
    {
        try {
            $query = $this->productQuery();
            $filters = [
                'q' => trim((string) $request->query('q', '')),
                'category' => (string) $request->query('category', ''),
                'brand' => (string) $request->query('brand', ''),
                'price' => (string) $request->query('price', ''),
                'sort' => (string) $request->query('sort', 'featured'),
            ];

            if ($filters['q'] !== '') {
                $keyword = '%'.$filters['q'].'%';
                $query->where(function ($query) use ($keyword): void {
                    $query->where('products.name', 'like', $keyword)
                        ->orWhere('products.sku', 'like', $keyword)
                        ->orWhere('brands.name', 'like', $keyword)
                        ->orWhere('categories.name', 'like', $keyword);
                });
            }

            if ($filters['category'] !== '') {
                $categoryIds = $this->categoryIdsForSlug($filters['category']);
                $categoryIds === []
                    ? $query->whereRaw('1 = 0')
                    : $query->whereIn('products.category_id', $categoryIds);
            }

            if ($filters['brand'] !== '') {
                $query->where('brands.slug', $filters['brand']);
            }

            $this->applyPriceFilter($query, $filters['price']);
            $this->applySort($query, $filters['sort']);

            $products = $this->decorateProducts($query->limit(24)->get());

            return view('frontend.shop-side-version-2', [
                'products' => $products,
                'categories' => $this->rootCategories(),
                'brands' => DB::table('brands')->where('status', true)->orderBy('name')->get(),
                'filters' => $filters,
            ]);
        } catch (Throwable) {
            return view('frontend.shop-side-version-2', [
                'products' => collect(),
                'categories' => collect(),
                'brands' => collect(),
                'filters' => ['q' => '', 'category' => '', 'brand' => '', 'price' => '', 'sort' => 'featured'],
            ]);
        }
    }

    public function product(?string $slug = null)
    {
        try {
            $query = $this->productQuery();

            if ($slug !== null) {
                $query->where('products.slug', $slug);
            } else {
                $query->orderByDesc('products.is_featured')->orderByDesc('products.created_at');
            }

            $product = $query->first();

            if (! $product) {
                abort(404);
            }

            $product = $this->decorateProduct($product);

            $images = DB::table('product_images')
                ->where('product_id', $product->id)
                ->orderByDesc('is_main')
                ->orderBy('sort_order')
                ->pluck('image_path')
                ->filter()
                ->values();

            if ($images->isEmpty() && $product->thumbnail) {
                $images = collect([$product->thumbnail]);
            }

            $specifications = DB::table('product_specifications')
                ->where('product_id', $product->id)
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get();

            $relatedProducts = $this->relatedProducts($product);

            return view('frontend.product-detail', [
                'product' => $product,
                'productImages' => $images,
                'specifications' => $specifications,
                'relatedProducts' => $relatedProducts,
            ]);
        } catch (Throwable) {
            abort(404);
        }
    }

    private function productQuery()
    {
        return DB::table('products')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->where('products.status', 'active')
            ->select([
                'products.*',
                'brands.name as brand_name',
                'brands.slug as brand_slug',
                'categories.name as category_name',
                'categories.slug as category_slug',
            ]);
    }

    private function categoryTiles(): Collection
    {
        $prioritySlugs = ['laptop', 'smartphone', 'monitor', 'audio', 'keyboard', 'pc-components'];
        $priorityOrder = collect($prioritySlugs)
            ->map(fn (string $slug, int $index): string => "WHEN '{$slug}' THEN {$index}")
            ->implode(' ');

        $tiles = DB::table('categories')
            ->whereNull('parent_id')
            ->where('status', true)
            ->whereIn('slug', $prioritySlugs)
            ->orderByRaw("CASE slug {$priorityOrder} ELSE 99 END")
            ->get();

        if ($tiles->count() < 6) {
            $tiles = $tiles->concat(
                $this->rootCategories()
                    ->whereNotIn('slug', $tiles->pluck('slug')->all())
                    ->take(6 - $tiles->count())
            );
        }

        return $tiles
            ->map(function ($category) {
                $meta = $this->categoryMeta($category->slug);
                $category->icon = $meta['icon'];
                $category->subtitle = $meta['subtitle'];

                return $category;
            });
    }

    private function rootCategories(): Collection
    {
        return DB::table('categories')
            ->whereNull('parent_id')
            ->where('status', true)
            ->orderBy('name')
            ->get();
    }

    private function categoryIdsForSlug(string $slug): array
    {
        $category = DB::table('categories')
            ->select('id')
            ->where('slug', $slug)
            ->where('status', true)
            ->first();

        if (! $category) {
            return [];
        }

        $childIds = DB::table('categories')
            ->where('parent_id', $category->id)
            ->where('status', true)
            ->pluck('id')
            ->all();

        return array_merge([$category->id], $childIds);
    }

    private function applyPriceFilter($query, string $price): void
    {
        $currentPrice = 'COALESCE(products.sale_price, products.price)';

        match ($price) {
            'under_5' => $query->whereRaw($currentPrice.' < ?', [5000000]),
            '5_15' => $query->whereRaw($currentPrice.' BETWEEN ? AND ?', [5000000, 15000000]),
            'over_15' => $query->whereRaw($currentPrice.' > ?', [15000000]),
            default => null,
        };
    }

    private function applySort($query, string $sort): void
    {
        match ($sort) {
            'price_asc' => $query->orderByRaw('COALESCE(products.sale_price, products.price) ASC'),
            'price_desc' => $query->orderByRaw('COALESCE(products.sale_price, products.price) DESC'),
            'newest' => $query->orderByDesc('products.created_at'),
            'best_selling' => $query->orderByDesc('products.sold_count'),
            default => $query->orderByDesc('products.is_featured')->orderByDesc('products.sold_count')->orderBy('products.name'),
        };
    }

    private function relatedProducts(object $product): Collection
    {
        $related = $this->decorateProducts(
            $this->productQuery()
                ->where('products.category_id', $product->category_id)
                ->where('products.id', '<>', $product->id)
                ->limit(4)
                ->get()
        );

        if ($related->count() >= 4) {
            return $related;
        }

        $moreProducts = $this->decorateProducts(
            $this->productQuery()
                ->where('products.id', '<>', $product->id)
                ->whereNotIn('products.id', $related->pluck('id')->all())
                ->orderByDesc('products.is_featured')
                ->limit(4 - $related->count())
                ->get()
        );

        return $related->concat($moreProducts)->values();
    }

    private function decorateProducts(Collection $products): Collection
    {
        return $products->map(fn ($product) => $this->decorateProduct($product));
    }

    private function decorateProduct(object $product): object
    {
        $regularPrice = (float) $product->price;
        $salePrice = $product->sale_price !== null ? (float) $product->sale_price : null;
        $hasDiscount = $salePrice !== null && $salePrice > 0 && $salePrice < $regularPrice;
        $currentPrice = $hasDiscount ? $salePrice : $regularPrice;

        $product->current_price = $currentPrice;
        $product->has_discount = $hasDiscount;
        $product->display_price = $this->formatCurrency($currentPrice);
        $product->display_original_price = $hasDiscount ? $this->formatCurrency($regularPrice) : null;
        $product->discount_label = $hasDiscount
            ? '-'.max(1, (int) round((($regularPrice - $salePrice) / $regularPrice) * 100)).'%'
            : ((bool) $product->is_featured ? 'Hot' : 'Mới');
        $product->stock_label = ((int) $product->quantity > 0)
            ? 'Còn '.(int) $product->quantity.' sản phẩm'
            : 'Hết hàng';
        $product->teaser = Str::limit($product->short_description ?: strip_tags((string) $product->description), 86);

        return $product;
    }

    private function formatCurrency(float $value): string
    {
        return number_format($value, 0, ',', '.').'đ';
    }

    private function categoryMeta(string $slug): array
    {
        return [
            'laptop' => ['icon' => 'fas fa-laptop', 'subtitle' => 'Văn phòng, học tập, gaming'],
            'smartphone' => ['icon' => 'fas fa-mobile-alt', 'subtitle' => 'iPhone và Android'],
            'monitor' => ['icon' => 'fas fa-desktop', 'subtitle' => 'Làm việc và giải trí'],
            'audio' => ['icon' => 'fas fa-headphones-alt', 'subtitle' => 'Tai nghe, loa, micro'],
            'keyboard' => ['icon' => 'fas fa-keyboard', 'subtitle' => 'Bàn phím văn phòng và cơ'],
            'pc-components' => ['icon' => 'fas fa-memory', 'subtitle' => 'SSD, RAM, VGA, mainboard'],
            'network' => ['icon' => 'fas fa-wifi', 'subtitle' => 'Router và mesh Wi-Fi'],
            'smart-home' => ['icon' => 'fas fa-plug', 'subtitle' => 'Sạc, camera, pin dự phòng'],
        ][$slug] ?? ['icon' => 'fas fa-microchip', 'subtitle' => 'Thiết bị công nghệ'];
    }
}
