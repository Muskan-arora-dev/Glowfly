<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;


class WishlistController extends Controller
{
    
    public function add($product_id)
    {
        
        if (!auth()->check()) {
            return redirect()->route('login');
        }

       
        $already = Wishlist::where('user_id', auth()->id())
                           ->where('product_id', $product_id)
                           ->first();

        if (!$already) {
            Wishlist::create([
                'user_id' => auth()->id(),
                'product_id' => $product_id,
            ]);
        }

        return back()->with('success', 'Added to wishlist!');
    }

    
    public function show()
    {
        if (!auth()->check()) {
            return redirect()->route('login.page');
        }

        $items = Wishlist::where('user_id', auth()->id())
                        ->with('product') 
                        ->get();

        return view('wishlist.show', compact('items'));
    }

    
   
    public function remove($id)
    {
        Wishlist::where('id', $id)
                ->where('user_id', auth()->id())
                ->delete();

        return back()->with('success', 'Removed from wishlist!');
    }

    public function toggle(Product $product)
    {
        $user = Auth::user();

        $wishlistItem = Wishlist::where('user_id', $user->id)
                                ->where('product_id', $product->id)
                                ->first();

        if ($wishlistItem) {
           
            $wishlistItem->delete();
        } else {
          
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
        }

        return back();
    }
}