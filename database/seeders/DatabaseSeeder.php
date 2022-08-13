<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Discount;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // CUSTOMER
        $customer = Customer::create([
            "code" => "NUMBER1",
            "name" => "I am number 1",
            "address" => "yogyakarta",
            "phone_num" => "62812341234",
        ]);
        for($i = 2; $i <= 10; ++$i) {
            Customer::create([
                "code" => "NUMBER" . $i,
                "name" => "I am number " . $i,
                "address" => "dimana mana hatiku senang",
                "phone_num" => "62812341234",
            ]);
        }

        // DISCOUNT
        $discount1 = Discount::create([
            "name" => "Promo Merdeka 5%",
            "discount_percent" => 5,
            "type" => "percent",
            "is_active" => true,
        ]);
        $discount2 = Discount::create([
            "name" => "Promo 17 Agustus",
            "discount_amount" => 17000,
            "type" => "amount",
            "is_active" => true,
        ]);

        // PRODUCT
        $product1 = Product::create([
            "sku_code" => "SKH-121",
            "product_name" => "Sun Kacang Hijau 100gr",
            "description" => "description sun kacang hijau",
            "unit_price" => 100000,
            "discount_id" => $discount1->id,
        ]);
        $product2 = Product::create([
            "sku_code" => "ZWS-543",
            "product_name" => "Zwitsal Soap Classic 100gr",
            "description" => "description zwitsal soap classic",
            "unit_price" => 20000,
            "discount_id" => $discount2->id
        ]);

        // CARTS
        $cart = Cart::create([
            "customer_id" => $customer->id,
            "subtotal" => 120000,
            "discount" => 0,
            "tax" => 12000,
            "total_price" => 132000,
            "notes" => "notes",
        ]);
        // CARTS ITEM
        CartItem::create([
            "cart_id" => $cart->id,
            "product_id" => $product1->id,
            "quantity" => 2,
            "subtotal" => 95000,
        ]);
        CartItem::create([
            "cart_id" => $cart->id,
            "product_id" => $product2->id,
            "quantity" => 2,
            "subtotal" => 15000,
        ]);
        CartItem::create([
            "cart_id" => $cart->id,
            "product_id" => $product1->id,
            "quantity" => 2,
            "subtotal" => 95000,
        ]);
        CartItem::create([
            "cart_id" => $cart->id,
            "product_id" => $product2->id,
            "quantity" => 2,
            "subtotal" => 15000,
        ]);
        CartItem::create([
            "cart_id" => $cart->id,
            "product_id" => $product1->id,
            "quantity" => 2,
            "subtotal" => 95000,
        ]);
        CartItem::create([
            "cart_id" => $cart->id,
            "product_id" => $product2->id,
            "quantity" => 2,
            "subtotal" => 15000,
        ]);
        CartItem::create([
            "cart_id" => $cart->id,
            "product_id" => $product1->id,
            "quantity" => 2,
            "subtotal" => 95000,
        ]);
        CartItem::create([
            "cart_id" => $cart->id,
            "product_id" => $product2->id,
            "quantity" => 2,
            "subtotal" => 15000,
        ]);
        CartItem::create([
            "cart_id" => $cart->id,
            "product_id" => $product1->id,
            "quantity" => 2,
            "subtotal" => 95000,
        ]);
        CartItem::create([
            "cart_id" => $cart->id,
            "product_id" => $product2->id,
            "quantity" => 2,
            "subtotal" => 15000,
        ]);
        CartItem::create([
            "cart_id" => $cart->id,
            "product_id" => $product1->id,
            "quantity" => 2,
            "subtotal" => 95000,
        ]);
        CartItem::create([
            "cart_id" => $cart->id,
            "product_id" => $product2->id,
            "quantity" => 2,
            "subtotal" => 15000,
        ]);

        // INVOICES
        $invoice = Invoice::create([
            "customer_id" => $customer->id,
            "subtotal" => 120000,
            "discount" => 20000,
            "tax" => 12000,
            "total_price" => 112000,
            "notes" => "notes"
        ]);
        // INVOICE ITEMS
        InvoiceItem::create([
            "invoice_id" => $invoice->id,
            "product_id" => $product1->id,
            "quantity" => 2,
            "subtotal" => 95000,
        ]);
        User::create([
            "name"=> "Admin",
            "email"=> "admin@gmail.com",
            "password"=> bcrypt("12345678"),
        ]);
    }
}
