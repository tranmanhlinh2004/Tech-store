<?php

namespace App\Support;

class AdminPermission
{
    public static function groups(): array
    {
        return [
            'Tổng quan' => [
                'dashboard.view' => 'Xem dashboard',
                'reports.view' => 'Xem báo cáo',
            ],
            'Sản phẩm' => [
                'products.view' => 'Xem sản phẩm',
                'products.create' => 'Thêm sản phẩm',
                'products.update' => 'Sửa sản phẩm',
                'products.delete' => 'Xóa sản phẩm',
                'inventory.update' => 'Cập nhật tồn kho',
                'categories.manage' => 'Quản lý danh mục',
                'brands.manage' => 'Quản lý thương hiệu',
            ],
            'Đơn hàng' => [
                'orders.view' => 'Xem đơn hàng',
                'orders.update' => 'Cập nhật đơn hàng',
                'payments.view' => 'Xem thanh toán',
            ],
            'Marketing & nội dung' => [
                'coupons.manage' => 'Quản lý mã giảm giá',
                'banners.manage' => 'Quản lý banner',
                'reviews.manage' => 'Quản lý đánh giá',
                'news.manage' => 'Quản lý bài viết',
                'contacts.view' => 'Xem liên hệ khách hàng',
            ],
            'Tài khoản & quyền' => [
                'users.view' => 'Xem tài khoản user',
                'users.create' => 'Tạo tài khoản user',
                'users.update' => 'Cập nhật tài khoản user',
                'users.delete' => 'Xóa tài khoản user',
                'roles.manage' => 'Quản lý vai trò và phân quyền',
            ],
            'Tài khoản cá nhân' => [
                'profile.update' => 'Cập nhật hồ sơ cá nhân',
                'cart.checkout' => 'Thanh toán giỏ hàng',
            ],
        ];
    }

    public static function descriptions(): array
    {
        return collect(self::groups())->flatMap(fn (array $permissions) => $permissions)->all();
    }

    public static function names(): array
    {
        return array_keys(self::descriptions());
    }

    public static function adminNames(): array
    {
        return collect(self::names())
            ->reject(fn (string $permission): bool => in_array($permission, ['profile.update', 'cart.checkout'], true))
            ->values()
            ->all();
    }

    public static function defaultRoleDescriptions(): array
    {
        return [
            'admin' => 'Full system administrator',
            'manager' => 'Store manager with sales and product access',
            'manage' => 'Legacy manager role alias',
            'staff' => 'General shop staff',
            'customer' => 'Registered customer account',
            'warehouse' => 'Warehouse and inventory staff',
            'content' => 'Content and product description editor',
            'support' => 'Customer support staff',
            'accountant' => 'Payment and revenue accountant',
            'marketer' => 'Marketing and campaign staff',
            'seller' => 'Sales consultant',
            'shipper' => 'Delivery staff',
            'product_manager' => 'Product catalog manager',
            'order_manager' => 'Order processing manager',
            'review_moderator' => 'Review moderation staff',
            'analyst' => 'Revenue and inventory analyst',
            'inventory_auditor' => 'Inventory audit staff',
            'coupon_manager' => 'Coupon and promotion manager',
            'banner_manager' => 'Homepage banner manager',
            'news_editor' => 'Technology news editor',
            'guest_member' => 'Limited member role for testing',
        ];
    }

    public static function defaultRolePermissions(): array
    {
        return [
            'admin' => self::names(),
            'manager' => [
                'dashboard.view',
                'reports.view',
                'products.view',
                'products.create',
                'products.update',
                'categories.manage',
                'brands.manage',
                'orders.view',
                'orders.update',
                'coupons.manage',
                'reviews.manage',
            ],
            'manage' => [
                'dashboard.view',
                'reports.view',
                'products.view',
                'products.create',
                'products.update',
                'categories.manage',
                'brands.manage',
                'orders.view',
                'orders.update',
                'coupons.manage',
                'reviews.manage',
            ],
            'staff' => [
                'dashboard.view',
                'products.view',
                'orders.view',
                'orders.update',
                'reviews.manage',
                'contacts.view',
            ],
            'customer' => [
                'profile.update',
                'cart.checkout',
            ],
            'warehouse' => [
                'dashboard.view',
                'products.view',
                'inventory.update',
            ],
            'content' => [
                'dashboard.view',
                'products.view',
                'products.update',
                'categories.manage',
                'brands.manage',
                'banners.manage',
                'news.manage',
                'reviews.manage',
            ],
            'support' => [
                'dashboard.view',
                'orders.view',
                'orders.update',
                'contacts.view',
                'reviews.manage',
            ],
            'accountant' => [
                'dashboard.view',
                'orders.view',
                'payments.view',
                'reports.view',
            ],
            'marketer' => [
                'dashboard.view',
                'coupons.manage',
                'banners.manage',
                'reports.view',
            ],
            'seller' => [
                'dashboard.view',
                'products.view',
                'orders.view',
                'orders.update',
            ],
            'shipper' => [
                'dashboard.view',
                'orders.view',
                'orders.update',
            ],
            'product_manager' => [
                'dashboard.view',
                'products.view',
                'products.create',
                'products.update',
                'products.delete',
                'inventory.update',
                'categories.manage',
                'brands.manage',
            ],
            'order_manager' => [
                'dashboard.view',
                'orders.view',
                'orders.update',
                'payments.view',
            ],
            'review_moderator' => [
                'dashboard.view',
                'reviews.manage',
            ],
            'analyst' => [
                'dashboard.view',
                'reports.view',
            ],
            'inventory_auditor' => [
                'dashboard.view',
                'products.view',
                'inventory.update',
            ],
            'coupon_manager' => [
                'dashboard.view',
                'coupons.manage',
            ],
            'banner_manager' => [
                'dashboard.view',
                'banners.manage',
            ],
            'news_editor' => [
                'dashboard.view',
                'news.manage',
            ],
            'guest_member' => [],
        ];
    }
}
