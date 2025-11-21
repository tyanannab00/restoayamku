<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{

    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';


    const PRODUCT_UNAVAILABLE = 'Produk tidak tersedia';
    const STOCK_UNAVAILABLE = 'Stok produk tidak mencukupi';
    const SYSTEM_ERROR = 'Terjadi kesalahan sistem';

    public function index()
    {
        $products = Product::available()->latest()->get();
        return view('index', compact('products'));
    }

    public function form(Product $product)
    {
        try {
            $this->checkProductAvailability($product);
            
            Log::info("Order form accessed for product ID: {$product->id}");
            
            return view('formorder', [
                'product' => $product,
                'price' => $product->final_price 
            ]);

        } catch (ModelNotFoundException $e) {
            Log::error("Product not available: " . $e->getMessage());
            return redirect()->route('home')
                   ->withErrors(['error' => self::PRODUCT_UNAVAILABLE]);
        }
    }

    public function submit(Request $request)
    {
        DB::beginTransaction();

        try {
            $validated = $this->validateRequest($request);
            $product = $this->getAvailableProduct($validated['product_id']);

            $this->checkStock($product, $validated['quantity']);

            $order = $this->createOrder($product, $validated);

            DB::commit();

            return $this->buildSuccessResponse($request, $order, $product);

        } catch (ValidationException $e) {
            DB::rollBack();
            return $this->handleValidationError($request, $e);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Submit error: " . $e->getMessage());
            return $this->handleError($request, self::SYSTEM_ERROR);
        }
    }

    /**
     * Validate the incoming request
     */
    protected function validateRequest(Request $request)
    {
        return $request->validate([
            'product_id' => 'required|exists:products,id,is_available,1',
            'customer_name' => 'required|string|max:100',
            'email' => 'required|email:rfc,dns|max:100',
            'phone' => 'required|string|regex:/^[0-9+\-\s]+$/|min:10|max:15',
            'address' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1|max:20',
            'notes' => 'nullable|string|max:500',
        ]);
    }

    /**
     * Create order record
     */
    protected function createOrder(Product $product, array $validated)
    {
        return Order::create([
            'product_id' => $product->id,
            'customer_name' => $validated['customer_name'],
            'email' => $validated['email'],
            'phone' => $this->formatPhone($validated['phone']),
            'address' => $validated['address'],
            'quantity' => $validated['quantity'],
            'total_price' => $product->final_price * $validated['quantity'],
            'notes' => $validated['notes'] ?? null,
            'status' => Order::STATUS_PENDING
        ]);
    }

    /**
     * Check product availability
     */
    protected function checkProductAvailability(Product $product)
    {
        if (!$product->is_available) {
            throw new ModelNotFoundException(self::PRODUCT_UNAVAILABLE);
        }
    }

    /**
     * Check stock availability
     */
    protected function checkStock(Product $product, int $quantity)
    {
    
    
    
    
    
    }

    /**
     * Get available product
     */
    protected function getAvailableProduct($productId)
    {
        return Product::available()->findOrFail($productId);
    }

    /**
     * Format phone number
     */
    protected function formatPhone(string $phone): string
    {
        return preg_replace('/[^0-9+]/', '', $phone);
    }

    /**
     * Build success response
     */
    protected function buildSuccessResponse(Request $request, Order $order, Product $product)
    {
        $responseData = [
            'success' => true,
            'order_id' => $order->id,
            'product_name' => $product->name,
            'quantity' => $order->quantity,
            'total_price' => 'Rp ' . number_format($order->total_price, 0, ',', '.'),
            'img' => asset($product->image_path),
            'redirect_url' => route('order.confirmation', $order->id)
        ];

        if ($request->expectsJson()) {
            return response()->json($responseData);
        }

        return redirect()->route('order.confirmation', $order->id)
               ->with($responseData);
    }

    /**
     * Handle validation errors
     */
    protected function handleValidationError(Request $request, ValidationException $e)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        }

        return back()->withErrors($e->errors())->withInput();
    }

    /**
     * Handle general errors
     */
    protected function handleError(Request $request, string $message)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $message
            ], 422);
        }

        return back()->withInput()->withErrors(['error' => $message]);
    }

    public function suggestion(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:100',
            'message' => 'required|string|max:500'
        ]);
        
        Log::info('Suggestion received from: ' . $request->email);
        return back()->with('success', 'Terima kasih atas saran Anda!');
    }





    public function confirmation($orderId)
    {
        try {
            $order = Order::with(['product' => function($query) {
                $query->withTrashed();
            }])->findOrFail($orderId);

            return view('orders.confirmation', [
                'order' => $order,
                'product' => $order->product
            ]);

        } catch (ModelNotFoundException $e) {
            Log::error("Order confirmation error: " . $e->getMessage());
            return redirect()->route('home')->with('error', 'Pesanan tidak ditemukan');
        }
    }
    

}