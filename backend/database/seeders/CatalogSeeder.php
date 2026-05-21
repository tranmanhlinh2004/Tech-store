<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $this->upsert('brands', array_map(fn (array $brand): array => $brand + [
            'logo' => null,
            'description' => null,
            'status' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ], [
            ['id' => 1, 'name' => 'Apple', 'slug' => 'apple', 'logo' => 'template/images/brand/b1.png', 'description' => 'iPhone, MacBook, iPad va phu kien Apple.'],
            ['id' => 2, 'name' => 'Samsung', 'slug' => 'samsung', 'logo' => 'template/images/brand/b2.png', 'description' => 'Dien thoai, tablet, man hinh va thiet bi thong minh.'],
            ['id' => 3, 'name' => 'Dell', 'slug' => 'dell', 'logo' => 'template/images/brand/b3.png', 'description' => 'Laptop doanh nhan, ultrabook va man hinh.'],
            ['id' => 4, 'name' => 'Asus', 'slug' => 'asus', 'logo' => 'template/images/brand/b4.png', 'description' => 'Laptop gaming, mainboard va phu kien.'],
            ['id' => 5, 'name' => 'Acer', 'slug' => 'acer', 'logo' => 'template/images/brand/b5.png'],
            ['id' => 6, 'name' => 'HP', 'slug' => 'hp', 'logo' => 'template/images/brand/b6.png'],
            ['id' => 7, 'name' => 'Lenovo', 'slug' => 'lenovo', 'logo' => 'template/images/brand/b1.png'],
            ['id' => 8, 'name' => 'MSI', 'slug' => 'msi', 'logo' => 'template/images/brand/b2.png'],
            ['id' => 9, 'name' => 'LG', 'slug' => 'lg', 'logo' => 'template/images/brand/b3.png'],
            ['id' => 10, 'name' => 'Sony', 'slug' => 'sony', 'logo' => 'template/images/brand/b4.png'],
            ['id' => 11, 'name' => 'Logitech', 'slug' => 'logitech', 'logo' => 'template/images/brand/b5.png'],
            ['id' => 12, 'name' => 'Razer', 'slug' => 'razer', 'logo' => 'template/images/brand/b6.png'],
            ['id' => 13, 'name' => 'Kingston', 'slug' => 'kingston', 'logo' => 'template/images/brand/b1.png'],
            ['id' => 14, 'name' => 'Corsair', 'slug' => 'corsair', 'logo' => 'template/images/brand/b2.png'],
            ['id' => 15, 'name' => 'Xiaomi', 'slug' => 'xiaomi', 'logo' => 'template/images/brand/b3.png'],
            ['id' => 16, 'name' => 'Oppo', 'slug' => 'oppo', 'logo' => 'template/images/brand/b4.png'],
            ['id' => 17, 'name' => 'Anker', 'slug' => 'anker', 'logo' => 'template/images/brand/b5.png'],
            ['id' => 18, 'name' => 'JBL', 'slug' => 'jbl', 'logo' => 'template/images/brand/b6.png'],
            ['id' => 19, 'name' => 'TP-Link', 'slug' => 'tp-link', 'logo' => 'template/images/brand/b1.png'],
            ['id' => 20, 'name' => 'Gigabyte', 'slug' => 'gigabyte', 'logo' => 'template/images/brand/b2.png'],
        ]));

        $categories = array_map(fn (array $category): array => $category + [
            'parent_id' => null,
            'description' => null,
            'image' => null,
            'status' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ], [
            ['id' => 1, 'name' => 'Laptop', 'slug' => 'laptop', 'description' => 'Laptop hoc tap, van phong va gaming.', 'image' => 'template/images/product/ultrabook/macbook-air-m3-13-inch.jpg'],
            ['id' => 2, 'name' => 'Smartphone', 'slug' => 'smartphone', 'description' => 'Dien thoai iPhone va Android.', 'image' => 'template/images/product/android-phone/samsung-galaxy-s24-ultra.jpg'],
            ['id' => 3, 'name' => 'Tablet', 'slug' => 'tablet', 'description' => 'May tinh bang cho hoc tap va sang tao.', 'image' => 'template/images/product/tablet/ipad-air-m2-11-inch.jpg'],
            ['id' => 4, 'name' => 'Audio', 'slug' => 'audio', 'description' => 'Tai nghe, loa va micro.', 'image' => 'template/images/product/bluetooth-headphone/sony-wh-1000xm5.jpg'],
            ['id' => 5, 'name' => 'Keyboard', 'slug' => 'keyboard', 'description' => 'Ban phim van phong va ban phim co.', 'image' => 'template/images/product/mechanical-keyboard/logitech-mx-keys-s.webp'],
            ['id' => 6, 'name' => 'Mouse', 'slug' => 'mouse', 'description' => 'Chuot van phong va chuot gaming.', 'image' => 'template/images/product/gaming-mouse/logitech-g-pro-x-superlight.webp'],
            ['id' => 7, 'name' => 'Monitor', 'slug' => 'monitor', 'description' => 'Man hinh lam viec va giai tri.', 'image' => 'template/images/product/monitor/lg-ultragear-27gp850.jpg'],
            ['id' => 8, 'name' => 'PC Components', 'slug' => 'pc-components', 'description' => 'SSD, RAM, VGA, mainboard va nguon.', 'image' => 'template/images/product/pc-components/gigabyte-rtx-4060-eagle-oc.png'],
            ['id' => 9, 'name' => 'Network', 'slug' => 'network', 'description' => 'Router va mesh Wi-Fi.', 'image' => 'template/images/product/router/tp-link-archer-ax55.jpg'],
            ['id' => 10, 'name' => 'Smart Home', 'slug' => 'smart-home', 'description' => 'Camera, sac, pin du phong va nha thong minh.', 'image' => 'template/images/product/smart-home/anker-737-power-bank.jpg'],
            ['id' => 11, 'parent_id' => 1, 'name' => 'Gaming Laptop', 'slug' => 'gaming-laptop', 'description' => 'Laptop hieu nang cao cho game va do hoa.', 'image' => 'template/images/product/gaming-laptop/asus-rog-strix-g16.jpg'],
            ['id' => 12, 'parent_id' => 1, 'name' => 'Ultrabook', 'slug' => 'ultrabook', 'description' => 'Laptop mong nhe pin lau.', 'image' => 'template/images/product/ultrabook/dell-xps-13-plus.jpg'],
            ['id' => 13, 'parent_id' => 2, 'name' => 'Android Phone', 'slug' => 'android-phone', 'description' => 'Dien thoai Android.', 'image' => 'template/images/product/android-phone/xiaomi-14-5g.jpg'],
            ['id' => 14, 'parent_id' => 2, 'name' => 'iPhone', 'slug' => 'iphone', 'description' => 'Cac dong Apple iPhone.', 'image' => 'template/images/product/iphone/iphone-15-pro-256gb.webp'],
            ['id' => 15, 'parent_id' => 4, 'name' => 'Bluetooth Headphone', 'slug' => 'bluetooth-headphone', 'description' => 'Tai nghe khong day va chong on.', 'image' => 'template/images/product/bluetooth-headphone/airpods-pro-2-usb-c.jpg'],
            ['id' => 16, 'parent_id' => 4, 'name' => 'Speaker', 'slug' => 'speaker', 'description' => 'Loa di dong va loa de ban.', 'image' => 'template/images/product/speaker/jbl-charge-5.jpg'],
            ['id' => 17, 'parent_id' => 5, 'name' => 'Mechanical Keyboard', 'slug' => 'mechanical-keyboard', 'description' => 'Ban phim co cho gaming va lam viec.', 'image' => 'template/images/product/mechanical-keyboard/razer-blackwidow-v4.jpg'],
            ['id' => 18, 'parent_id' => 6, 'name' => 'Gaming Mouse', 'slug' => 'gaming-mouse', 'description' => 'Chuot gaming DPI cao.', 'image' => 'template/images/product/gaming-mouse/razer-deathadder-v3.jpg'],
            ['id' => 19, 'parent_id' => 8, 'name' => 'SSD and RAM', 'slug' => 'ssd-and-ram', 'description' => 'Nang cap luu tru va bo nho.', 'image' => 'template/images/product/ssd-and-ram/kingston-nv2-1tb.png'],
            ['id' => 20, 'parent_id' => 9, 'name' => 'Router', 'slug' => 'router', 'description' => 'Router Wi-Fi va he thong mesh.', 'image' => 'template/images/product/router/tp-link-deco-x20-2-pack.jpg'],
        ]);

        $this->upsert('categories', array_values(array_filter($categories, fn (array $category): bool => $category['parent_id'] === null)));
        $this->upsert('categories', array_values(array_filter($categories, fn (array $category): bool => $category['parent_id'] !== null)));

        $products = $this->products($now);

        $this->upsert('products', $products);
        $this->upsert('product_images', $this->productImages($products, $now));
        $this->upsert('product_specifications', $this->productSpecifications());

        if (Schema::hasTable('banners')) {
            $this->upsert('banners', [
                [
                    'id' => 1,
                    'title' => 'Laptop gaming dang giam gia',
                    'image' => 'template/images/product/gaming-laptop/asus-rog-strix-g16.jpg',
                    'link' => '/shop?category=laptop',
                    'position' => 'home_deal',
                    'sort_order' => 1,
                    'status' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'id' => 2,
                    'title' => 'Phu kien lam viec moi',
                    'image' => 'template/images/product/mechanical-keyboard/logitech-mx-keys-s.webp',
                    'link' => '/shop?category=keyboard',
                    'position' => 'home_deal',
                    'sort_order' => 2,
                    'status' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ]);
        }
    }

    private function products($now): array
    {
        $products = [
            ['id' => 1, 'category_id' => 14, 'brand_id' => 1, 'name' => 'iPhone 15 Pro 256GB', 'slug' => 'iphone-15-pro-256gb', 'sku' => 'IP15P-256', 'short_description' => 'A17 Pro, 256GB, khung titanium.', 'description' => 'iPhone cao cap voi camera 48MP, hieu nang manh va thiet ke ben nhe cho cong viec hang ngay.', 'import_price' => 22000000, 'price' => 28990000, 'sale_price' => 27490000, 'quantity' => 45, 'warranty_months' => 12, 'thumbnail' => 'template/images/product/iphone/iphone-15-pro-256gb.webp', 'is_featured' => true],
            ['id' => 2, 'category_id' => 14, 'brand_id' => 1, 'name' => 'iPhone 15 128GB', 'slug' => 'iphone-15-128gb', 'sku' => 'IP15-128', 'short_description' => 'Dynamic Island va camera 48MP.', 'description' => 'Mau iPhone can bang cho nguoi dung can camera tot, hieu nang on dinh va thiet ke gon.', 'import_price' => 16500000, 'price' => 21990000, 'sale_price' => 20990000, 'quantity' => 60, 'warranty_months' => 12, 'thumbnail' => 'template/images/product/iphone/iphone-15-128gb.jpg', 'is_featured' => true],
            ['id' => 3, 'category_id' => 13, 'brand_id' => 2, 'name' => 'Samsung Galaxy S24 Ultra', 'slug' => 'samsung-galaxy-s24-ultra', 'sku' => 'SGS24U-256', 'short_description' => 'Flagship Android kem S Pen.', 'description' => 'Man hinh lon, camera zoom xa, S Pen va hieu nang flagship cho cong viec lan giai tri.', 'import_price' => 21000000, 'price' => 27990000, 'sale_price' => 26490000, 'quantity' => 36, 'warranty_months' => 12, 'thumbnail' => 'template/images/product/android-phone/samsung-galaxy-s24-ultra.jpg', 'is_featured' => true],
            ['id' => 4, 'category_id' => 13, 'brand_id' => 15, 'name' => 'Xiaomi 14 5G', 'slug' => 'xiaomi-14-5g', 'sku' => 'XM14-256', 'short_description' => 'Flagship nho gon, sac nhanh.', 'description' => 'Dien thoai Android hieu nang cao, phu hop cho choi game, chup anh va su dung hang ngay.', 'import_price' => 12500000, 'price' => 16990000, 'sale_price' => 15990000, 'quantity' => 52, 'warranty_months' => 12, 'thumbnail' => 'template/images/product/android-phone/xiaomi-14-5g.jpg', 'is_featured' => true],
            ['id' => 6, 'category_id' => 12, 'brand_id' => 1, 'name' => 'MacBook Air M3 13 inch', 'slug' => 'macbook-air-m3-13-inch', 'sku' => 'MBA-M3-13', 'short_description' => 'Chip M3, 8GB RAM, 256GB SSD.', 'description' => 'Laptop mong nhe, pin lau, phu hop hoc tap, van phong va sang tao noi dung co ban.', 'import_price' => 22500000, 'price' => 28990000, 'sale_price' => 27990000, 'quantity' => 28, 'warranty_months' => 12, 'thumbnail' => 'template/images/product/ultrabook/macbook-air-m3-13-inch.jpg', 'is_featured' => true],
            ['id' => 7, 'category_id' => 11, 'brand_id' => 4, 'name' => 'Asus ROG Strix G16', 'slug' => 'asus-rog-strix-g16', 'sku' => 'ROG-G16-I7', 'short_description' => 'Core i7, RTX 4060, 16GB RAM.', 'description' => 'Laptop gaming co man hinh tan so quet cao, GPU RTX 4060 va tan nhiet tot cho game, do hoa va hoc ky thuat.', 'import_price' => 26500000, 'price' => 34990000, 'sale_price' => 32990000, 'quantity' => 18, 'warranty_months' => 24, 'thumbnail' => 'template/images/product/gaming-laptop/asus-rog-strix-g16.jpg', 'is_featured' => true],
            ['id' => 8, 'category_id' => 11, 'brand_id' => 8, 'name' => 'MSI Katana 15 B13V', 'slug' => 'msi-katana-15-b13v', 'sku' => 'MSI-K15-B13V', 'short_description' => 'Core i7, RTX 4050, man 144Hz.', 'description' => 'Laptop gaming cho esports, hoc do hoa va cac tac vu can GPU rieng.', 'import_price' => 20500000, 'price' => 27990000, 'sale_price' => 25990000, 'quantity' => 22, 'warranty_months' => 24, 'thumbnail' => 'template/images/product/gaming-laptop/msi-katana-15-b13v.png', 'is_featured' => true],
            ['id' => 9, 'category_id' => 12, 'brand_id' => 3, 'name' => 'Dell XPS 13 Plus', 'slug' => 'dell-xps-13-plus', 'sku' => 'DXPS13P-512', 'short_description' => 'Ultrabook cao cap, SSD 512GB.', 'description' => 'Laptop gon, thiet ke hien dai, man hinh dep va ban phim thoai mai cho cong viec di dong.', 'import_price' => 26000000, 'price' => 33990000, 'sale_price' => 31990000, 'quantity' => 14, 'warranty_months' => 12, 'thumbnail' => 'template/images/product/ultrabook/dell-xps-13-plus.jpg', 'is_featured' => true],
            ['id' => 13, 'category_id' => 3, 'brand_id' => 1, 'name' => 'iPad Air M2 11 inch', 'slug' => 'ipad-air-m2-11-inch', 'sku' => 'IPAD-AIR-M2', 'short_description' => 'Chip M2, man Liquid Retina.', 'description' => 'May tinh bang manh cho ghi chu, ve, hoc tap va giai tri.', 'import_price' => 14500000, 'price' => 18990000, 'sale_price' => 17990000, 'quantity' => 34, 'warranty_months' => 12, 'thumbnail' => 'template/images/product/tablet/ipad-air-m2-11-inch.jpg', 'is_featured' => true],
            ['id' => 15, 'category_id' => 15, 'brand_id' => 1, 'name' => 'AirPods Pro 2 USB-C', 'slug' => 'airpods-pro-2-usb-c', 'sku' => 'APP2-USBC', 'short_description' => 'Tai nghe chong on chu dong.', 'description' => 'Tai nghe nho gon voi chong on chu dong, am thanh khong gian va hop sac USB-C.', 'import_price' => 4200000, 'price' => 6490000, 'sale_price' => 5890000, 'quantity' => 80, 'warranty_months' => 12, 'thumbnail' => 'template/images/product/bluetooth-headphone/airpods-pro-2-usb-c.jpg', 'is_featured' => true],
            ['id' => 16, 'category_id' => 15, 'brand_id' => 10, 'name' => 'Sony WH-1000XM5', 'slug' => 'sony-wh-1000xm5', 'sku' => 'SONY-XM5', 'short_description' => 'Tai nghe over-ear ANC cao cap.', 'description' => 'Tai nghe thoai mai cho di chuyen, lam viec va nghe nhac voi kha nang chong on manh.', 'import_price' => 6200000, 'price' => 8990000, 'sale_price' => 7990000, 'quantity' => 42, 'warranty_months' => 12, 'thumbnail' => 'template/images/product/bluetooth-headphone/sony-wh-1000xm5.jpg', 'is_featured' => true],
            ['id' => 17, 'category_id' => 16, 'brand_id' => 18, 'name' => 'JBL Charge 5', 'slug' => 'jbl-charge-5', 'sku' => 'JBL-CHG5', 'short_description' => 'Loa di dong chong nuoc.', 'description' => 'Loa pin lau, am luong lon va chong nuoc cho ngoai troi.', 'import_price' => 2100000, 'price' => 3490000, 'sale_price' => 2990000, 'quantity' => 55, 'warranty_months' => 12, 'thumbnail' => 'template/images/product/speaker/jbl-charge-5.jpg', 'is_featured' => false],
            ['id' => 19, 'category_id' => 17, 'brand_id' => 11, 'name' => 'Logitech MX Keys S', 'slug' => 'logitech-mx-keys-s', 'sku' => 'LOG-MXKS', 'short_description' => 'Ban phim khong day cho van phong.', 'description' => 'Ban phim go em, den nen thong minh, ket noi nhieu thiet bi cho cong viec hang ngay.', 'import_price' => 1900000, 'price' => 2990000, 'sale_price' => 2590000, 'quantity' => 44, 'warranty_months' => 12, 'thumbnail' => 'template/images/product/mechanical-keyboard/logitech-mx-keys-s.webp', 'is_featured' => true],
            ['id' => 20, 'category_id' => 17, 'brand_id' => 12, 'name' => 'Razer BlackWidow V4', 'slug' => 'razer-blackwidow-v4', 'sku' => 'RZ-BWV4', 'short_description' => 'Ban phim co gaming RGB.', 'description' => 'Ban phim co switch nhanh, den RGB va thiet ke toi uu cho game thu.', 'import_price' => 2500000, 'price' => 3990000, 'sale_price' => 3490000, 'quantity' => 25, 'warranty_months' => 12, 'thumbnail' => 'template/images/product/mechanical-keyboard/razer-blackwidow-v4.jpg', 'is_featured' => true],
            ['id' => 21, 'category_id' => 18, 'brand_id' => 11, 'name' => 'Logitech G Pro X Superlight', 'slug' => 'logitech-g-pro-x-superlight', 'sku' => 'LOG-GPX-SL', 'short_description' => 'Chuot gaming khong day sieu nhe.', 'description' => 'Chuot hieu nang cao voi trong luong nhe va cam bien HERO cho FPS.', 'import_price' => 2200000, 'price' => 3490000, 'sale_price' => 3190000, 'quantity' => 38, 'warranty_months' => 12, 'thumbnail' => 'template/images/product/gaming-mouse/logitech-g-pro-x-superlight.webp', 'is_featured' => true],
            ['id' => 23, 'category_id' => 7, 'brand_id' => 9, 'name' => 'LG UltraGear 27GP850', 'slug' => 'lg-ultragear-27gp850', 'sku' => 'LG-27GP850', 'short_description' => 'Man QHD 27 inch 165Hz.', 'description' => 'Man hinh Fast IPS mau sac dep, tan so quet cao cho gaming va lam viec da nhiem.', 'import_price' => 5200000, 'price' => 7990000, 'sale_price' => 6990000, 'quantity' => 20, 'warranty_months' => 24, 'thumbnail' => 'template/images/product/monitor/lg-ultragear-27gp850.jpg', 'is_featured' => true],
            ['id' => 25, 'category_id' => 7, 'brand_id' => 3, 'name' => 'Dell UltraSharp U2723QE', 'slug' => 'dell-ultrasharp-u2723qe', 'sku' => 'DL-U2723QE', 'short_description' => 'Man 4K USB-C cho do hoa.', 'description' => 'Man hinh chuyen nghiep mau sac chuan, do phan giai 4K va hub USB-C.', 'import_price' => 9500000, 'price' => 13490000, 'sale_price' => 12490000, 'quantity' => 12, 'warranty_months' => 36, 'thumbnail' => 'template/images/product/monitor/dell-ultrasharp-u2723qe.jpg', 'is_featured' => true],
            ['id' => 26, 'category_id' => 19, 'brand_id' => 13, 'name' => 'Kingston NV2 1TB', 'slug' => 'kingston-nv2-1tb', 'sku' => 'KS-NV2-1TB', 'short_description' => 'SSD NVMe PCIe 4.0 1TB.', 'description' => 'SSD toc do cao de nang cap laptop va desktop.', 'import_price' => 950000, 'price' => 1590000, 'sale_price' => 1390000, 'quantity' => 120, 'warranty_months' => 36, 'thumbnail' => 'template/images/product/ssd-and-ram/kingston-nv2-1tb.png', 'is_featured' => false],
            ['id' => 28, 'category_id' => 8, 'brand_id' => 20, 'name' => 'Gigabyte RTX 4060 Eagle OC', 'slug' => 'gigabyte-rtx-4060-eagle-oc', 'sku' => 'GB-RTX4060-EOC', 'short_description' => 'Card do hoa 8GB GDDR6.', 'description' => 'GPU tiet kiem dien cho gaming 1080p va 1440p.', 'import_price' => 6300000, 'price' => 8990000, 'sale_price' => 8490000, 'quantity' => 16, 'warranty_months' => 36, 'thumbnail' => 'template/images/product/pc-components/gigabyte-rtx-4060-eagle-oc.png', 'is_featured' => true],
            ['id' => 30, 'category_id' => 20, 'brand_id' => 19, 'name' => 'TP-Link Archer AX55', 'slug' => 'tp-link-archer-ax55', 'sku' => 'TPL-AX55', 'short_description' => 'Router Wi-Fi 6 AX3000.', 'description' => 'Router gia dinh toc do cao, phu song on dinh va nhieu cong LAN.', 'import_price' => 1400000, 'price' => 2390000, 'sale_price' => 1990000, 'quantity' => 64, 'warranty_months' => 24, 'thumbnail' => 'template/images/product/router/tp-link-archer-ax55.jpg', 'is_featured' => true],
            ['id' => 33, 'category_id' => 10, 'brand_id' => 17, 'name' => 'Anker 737 Power Bank', 'slug' => 'anker-737-power-bank', 'sku' => 'ANK-737-PB', 'short_description' => 'Pin du phong 24.000mAh sac nhanh.', 'description' => 'Pin du phong dung luong cao, sac nhanh cho laptop, tablet va dien thoai.', 'import_price' => 2300000, 'price' => 3690000, 'sale_price' => 3290000, 'quantity' => 33, 'warranty_months' => 18, 'thumbnail' => 'template/images/product/smart-home/anker-737-power-bank.jpg', 'is_featured' => true],
            ['id' => 34, 'category_id' => 10, 'brand_id' => 17, 'name' => 'Anker Nano 65W Charger', 'slug' => 'anker-nano-65w-charger', 'sku' => 'ANK-NANO-65W', 'short_description' => 'Cu sac GaN USB-C 65W.', 'description' => 'Cu sac nho gon cho dien thoai, tablet va laptop mong nhe.', 'import_price' => 520000, 'price' => 890000, 'sale_price' => 790000, 'quantity' => 95, 'warranty_months' => 18, 'thumbnail' => 'template/images/product/smart-home/anker-nano-65w-charger.jpg', 'is_featured' => false],
        ];

        return array_map(function (array $product) use ($now): array {
            $effectivePrice = (float) ($product['sale_price'] ?? $product['price']);

            return $product + [
                'status' => 'active',
                'is_free_shipping' => $effectivePrice >= 2000000,
                'sold_count' => $product['id'] * 2,
                'view_count' => 100 + ($product['id'] * 7),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }, $products);
    }

    private function productImages(array $products, $now): array
    {
        $images = [];

        foreach (array_values($products) as $index => $product) {
            $images[] = [
                'id' => $index + 1,
                'product_id' => $product['id'],
                'image_path' => $product['thumbnail'],
                'is_main' => true,
                'sort_order' => 1,
                'created_at' => $now,
            ];
        }

        return $images;
    }

    private function productSpecifications(): array
    {
        $specs = [
            [1, 'Storage', '256GB'], [1, 'Warranty', '12 thang'],
            [2, 'Storage', '128GB'], [2, 'Camera', '48MP'],
            [3, 'Display', '6.8 inch AMOLED'], [3, 'Feature', 'S Pen'],
            [4, 'Chipset', 'Snapdragon 8 Gen 3'], [4, 'Charging', '90W'],
            [6, 'Chip', 'Apple M3'], [6, 'Weight', '1.24kg'],
            [7, 'GPU', 'NVIDIA RTX 4060'], [7, 'Refresh Rate', '165Hz'],
            [8, 'GPU', 'NVIDIA RTX 4050'], [8, 'RAM', '16GB DDR5'],
            [9, 'Display', '13.4 inch'], [9, 'Storage', '512GB SSD'],
            [13, 'Chip', 'Apple M2'], [13, 'Screen', '11 inch'],
            [15, 'Connection', 'Bluetooth'], [15, 'Feature', 'Active noise cancellation'],
            [16, 'Battery', 'Toi da 30 gio'], [16, 'Feature', 'Adaptive noise canceling'],
            [17, 'Battery', 'Toi da 20 gio'], [17, 'Waterproof', 'IP67'],
            [19, 'Layout', 'Full size'], [19, 'Connection', 'Bluetooth va USB receiver'],
            [20, 'Switch', 'Mechanical green switch'], [20, 'Lighting', 'RGB'],
            [21, 'Weight', '63g'], [21, 'Sensor', 'HERO sensor'],
            [23, 'Resolution', 'QHD 2560x1440'], [23, 'Refresh Rate', '165Hz'],
            [25, 'Resolution', '4K UHD'], [25, 'Port', 'USB-C hub'],
            [26, 'Capacity', '1TB'], [26, 'Interface', 'NVMe PCIe 4.0'],
            [28, 'VRAM', '8GB GDDR6'], [28, 'Output', 'HDMI va DisplayPort'],
            [30, 'Wi-Fi', 'Wi-Fi 6 AX3000'], [30, 'Ports', 'Gigabit LAN'],
            [33, 'Capacity', '24000mAh'], [33, 'Power', '140W output'],
            [34, 'Power', '65W'], [34, 'Port', 'USB-C'],
        ];

        $rows = [];

        foreach ($specs as $index => [$productId, $name, $value]) {
            $rows[] = [
                'id' => $index + 1,
                'product_id' => $productId,
                'spec_name' => $name,
                'spec_value' => $value,
                'sort_order' => ($index % 2) + 1,
            ];
        }

        return $rows;
    }

    private function upsert(string $table, array $rows): void
    {
        if ($rows === []) {
            return;
        }

        $updateColumns = array_values(array_diff(array_keys($rows[0]), ['id']));

        DB::table($table)->upsert($rows, ['id'], $updateColumns);
    }
}
