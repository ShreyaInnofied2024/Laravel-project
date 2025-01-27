<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order; // Assuming you have an Order model
use App\Models\User;  // Assuming you have a User model
use App\Models\Product;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Data for the dashboard
        $data = [
            'totalOrders' => Order::count(),
            'totalRevenue' => Order::where('status', 'Completed')->sum('total_amount'),
            'orderStatusCounts' => [
                'Pending' => Order::where('status', 'Pending')->count(),
                'Paid'=>Order::where('status','Paid')->count(),
                'Processing' => Order::where('status', 'Processing')->count(),
                'Out For Delivery' => Order::where('status', 'Out For Delivery')->count(),
                'Completed' => Order::where('status', 'Completed')->count(),
                'Cancelled' => Order::where('status', 'Canceled')->count(),
            ],
            'customer' => User::where('user_role', 'Customer')->count(),
            'revenueByDate' => Order::selectRaw('DATE(created_at) as order_date, SUM(total_amount) as total_revenue')
                ->where('status', 'Completed')
                ->groupBy('order_date')
                ->orderBy('order_date', 'asc')
                ->get(),
            'revenueByPaymentMethod' => Order::selectRaw('shipping_method, SUM(total_amount) as total_revenue')
                ->groupBy('shipping_method')
                ->get(),
            'productsSoldByDate' => Order::join('order_items', 'orders.id', '=', 'order_items.order_id')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->selectRaw('DATE(orders.created_at) as sale_date, products.name as product_name, SUM(order_items.quantity) as total_quantity, SUM(order_items.price * order_items.quantity) as total_revenue')
                ->where('orders.status', 'Completed')
                ->groupBy('sale_date', 'product_name')
                ->orderBy('sale_date', 'asc')
                ->get(),
        ];

        return view('admin.dashboard', compact('data'));
    }

    public function indexseller()
    {
        // Data for the dashboard
        $data = [
            'totalOrders' => Order::count(),
            'totalRevenue' => Order::where('status', 'Completed')->sum('total_amount'),
            'orderStatusCounts' => [
                'Pending' => Order::where('status', 'Pending')->count(),
                'Paid'=>Order::where('status','Paid')->count(),
                'Processing' => Order::where('status', 'Processing')->count(),
                'Out For Delivery' => Order::where('status', 'Out For Delivery')->count(),
                'Completed' => Order::where('status', 'Completed')->count(),
                'Cancelled' => Order::where('status', 'Canceled')->count(),
            ],
            'customer' => User::where('user_role', 'Customer')->count(),
            'revenueByDate' => Order::selectRaw('DATE(created_at) as order_date, SUM(total_amount) as total_revenue')
                ->where('status', 'Completed')
                ->groupBy('order_date')
                ->orderBy('order_date', 'asc')
                ->get(),
            'revenueByPaymentMethod' => Order::selectRaw('shipping_method, SUM(total_amount) as total_revenue')
                ->groupBy('shipping_method')
                ->get(),
            'productsSoldByDate' => Order::join('order_items', 'orders.id', '=', 'order_items.order_id')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->selectRaw('DATE(orders.created_at) as sale_date, products.name as product_name, SUM(order_items.quantity) as total_quantity, SUM(order_items.price * order_items.quantity) as total_revenue')
                ->where('orders.status', 'Completed')
                ->groupBy('sale_date', 'product_name')
                ->orderBy('sale_date', 'asc')
                ->get(),
        ];

        return view('seller.dashboard', compact('data'));
    }
}
