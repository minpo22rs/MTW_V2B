<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'order_callback/*', 'backend/flash-hook-status', 'backend/flash-hook-courier',
        '/pay-via-ajax', '/success', '/cancel', '/fail', '/ipn', '/API/contestant-regions-member', '/API/regions-name', '/API/contestant-detail', '/API/product-in-category-product-page', '/API/product-detail-product-page', '/API/restaurant-detail', '/API/hotel-detail', '/API/login-mobile-mtwa', '/API/register-mobile-mtwa', '/API/vote-contestant', '/API/vote-contestant-free', '/API/account-detail', '/API/index-main', '/API/add-cart', '/API/otp-mobile-mtwa', '/API/account-list-payment', '/API/call-back', '/API/reset-mobile-mtwa', '/API/otp-mobile-mtwa-reset', '/API/add-wishlists', '/API/list-wishlists', '/API/qty-cart', '/API/list-cart', '/API/search-cart', '/API/attraction-detail-product-page', '/API/account-change', '/API/otp-phone-mtwa-reset', '/API/add-address', '/API/address-detail', '/API/vouchers-detail', '/API/carts-restaurant', '/API/carts-restaurant-list', '/API/carts-restaurant-delete', '/API/show-order', '/API/show-vouchers', '/API/room-detail', '/API/seacrh-hotel', '/API/search-rooms', '/API/check-rooms', '/API/hotel-order', '/API/show-vouchers-hotel', '/API/useless-vouchers-hotel', '/API/order-hotel-detail', '/API/restaurant-image', '/API/vouchers-show-detail', '/API/vouchers-order-detail', '/API/seller-images', '/API/room-images', '/API/product-by-cate', '/API/form-review', '/API/show-vouchers-useless', '/API/stardust', '/API/own-review', '/API/reviewlist', '/API/search-everything', '/API/check-wishlists', '/API/use-vouchers', '/API/attraction-member-detail', '/API/appleIdsign', 'API/getDistrict', 'API/getSubDistrict',
    ];
}
