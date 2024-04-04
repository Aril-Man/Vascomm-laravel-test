<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Product;
use App\Models\quota;
use App\Models\Receiver;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use stdClass;

class AdminController extends Controller
{
    public function index() {

        $data = new stdClass();
        $data->sum_user = User::count();
        $data->sum_user_active = User::where('status', 'active')->count();
        $data->sum_product = Product::count();
        $data->sum_product_active = Product::where('status', 'active')->count();

        $data->products = Product::orderBy('id', 'DESC')->get();

        return view('admin.index', compact('data'));
    }

    public function userIndex() {
        $data = new stdClass();
        $data->users = User::where('role', 'customer')->get();

        return view('admin.user.index', compact('data'));
    }

    public function storeUser(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);

        if ($validator->fails()) return redirect()->route('admin.user.index')->with('error', $validator->errors()->first());

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->status = 'active';
        $user->role = 'customer';
        $user->password = Hash::make("user123");
        $user->save();

        return redirect()->route('admin.user.index')->with('success', 'success create user');
    }

    public function getUserById($id) {

        $data = new stdClass();
        $data->user = User::where('id', $id)->first();

        if ($data->user == null) {
            return response()->json(['status' => false, 'message' => 'Data not found']);
        }

        return response()->json(['status' => true, 'message' => 'Get data success', 'data' => $data]);
    }

    public function updateUser(Request $req) {
        try {

            $validator = Validator::make($req->all(), [
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'status' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors()->first(), 400);
            }

            $user_id = $req->user_id;
            $email = $req->email;
            $name = $req->name;
            $phone = $req->phone;
            $isEmail = $req->isEmail;
            $status = $req->status;

            if ($isEmail == "true") {
                $validate = User::where('email', $email)->first();
                if ($validate != null) {
                    return response()->json("This email is already registered", 400);
                }
            }

            $updated = User::where('id', $user_id)
                ->update([
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'status' => $status
                ]);

            return response()->json($updated);
        } catch (\Throwable $th) {
            return response()->json($th);
        }
    }

    public function deleteUser($id) {
        $user = User::where('id', $id)->first();
        if ($user == null) {
            return response()->json(['status' => false, 'message' => 'User not found']);
        }

        $delete = $user->delete();

        if ($delete) {
            return response()->json(['status' => true, 'message' => 'User deleted']);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed deleted']);
        }
    }

    public function productIndex() {
        $data = new stdClass();
        $data->products = Product::all();

        return view('admin.product.index', compact('data'));
    }

    public function storeProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required|numeric|min:1',
            'img' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        if ($validator->fails()) return redirect()->route('admin.product.index')->with('error', $validator->errors()->first());

        $imagePath = Str::random(16) . '.' . $request->file('img')->extension();
        $request->file('img')->move(public_path('product_images'), $imagePath);

        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->img_url = $imagePath;
        $product->status = 'active';
        $product->save();

        return redirect()->route('admin.product.index')->with('success', 'Product created successfully.');
    }

    public function deleteProduct($id) {
        $product = Product::where('id', $id)->first();
        if ($product == null) {
            return response()->json(['status' => false, 'message' => 'product not found']);
        }

        $delete = $product->delete();

        if ($delete) {
            return response()->json(['status' => true, 'message' => 'Product deleted']);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed deleted']);
        }
    }

    public function getProductById($id) {

        $data = new stdClass();
        $data->product = Product::where('id', $id)->first();

        if ($data->product == null) {
            return response()->json(['status' => false, 'message' => 'Data not found']);
        }

        return response()->json(['status' => true, 'message' => 'Get data success', 'data' => $data]);
    }

    public function updateProduct(Request $req) {
        try {

            $validator = Validator::make($req->all(), [
                'name' => 'required',
                'price' => 'required',
                'img' => 'image|mimes:jpeg,png,jpg',
                'status' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors()->first(), 400);
            }

            $product = Product::findOrFail($req->product_id);

            $product_id = $req->product_id;
            $name = $req->name;
            $price = $req->price;
            $status = $req->status;

            if ($req->hasFile('img')) {
                if ($product->img_url) {
                    Storage::delete($product->img_url);
                }
                $imagePath = Str::random(16) . '.' . $req->file('img')->extension();
                $req->file('img')->move(public_path('product_images'), $imagePath);
            } else {
                $imagePath = $product->img_url;
            }

            Product::where('id', $product_id)
                ->update([
                    'name' => $name,
                    'price' => $price,
                    'img_url' => $imagePath,
                    'status' => $status
                ]);

            return redirect()->route('admin.product.index')->with('success', 'Product created successfully.');
        } catch (\Throwable $th) {
            return redirect()->route('admin.product.index')->with('success', 'Product created failed.');
        }
    }
}
