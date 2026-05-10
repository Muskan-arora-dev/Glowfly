<?Php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryController extends Controller
{
    // APPLY FORM
    public function applyForm()
    {
        return view('delivery.apply');
    }

    // APPLY SUBMIT
    public function applySubmit(Request $request)
    {
        $user = Auth::user();

        $user->role = 'delivery';
        $user->delivery_status = 'pending';
        $user->save();

        return redirect()->back()->with('success','Request sent to admin for approval');
    }
}
