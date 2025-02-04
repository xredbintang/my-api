<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ProductModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index () {
		try {
            $products =  Cache::remember('products',10, function(){
                return ProductModel::all();
            });
            // $products = ProductModel::all();
            $response = [
                'success' => true,
                'message' => 'Successfully get products data.',
                'data' => $products
            ];

            return response()->json($response, 200)->header('Cache-control','public, max-age=300');
        } catch (Exception $error) {
            $response = array(
                'success' => false,
                'message' => 'Sorry, there error in internal server',
                'data' => null,
                'errors' => $error->getMessage()
            );

            return response()->json($response, 500);
        }
	}
	
	public function show (int $product_id) {
		try {
            $products =  Cache::remember('productsid',10, function() use ($product_id){
                return ProductModel::find($product_id);
            });
            // $products = ProductModel::find($product_id);
            $response = array(
                'success' => true,
                'message' => 'Successfully get products data.',
                'data' => $products
            );

            return response()->json($response, 200);
        } catch (Exception $error) {
            $response = array(
                'success' => false,
                'message' => 'Sorry, there error in internal server',
                'data' => null,
                'errors' => $error->getMessage()
            );

            return response()->json($response, 500);
        }
	}
	
	public function store (Request $request) {
		try {
            Cache::forget('products');

            $validator = Validator::make($request->all(), [
                'product_name' => 'required|string|max:100',
                'product_category_id' => 'required|exists:categories,category_id',
                'product_stock' => 'required|numeric',
                'product_price' => 'required|numeric'
            ]);

            if ($validator->fails()) {
                $response = array(
                    'success' => false,
                    'message' => 'Failed to create data product. Data not completed, please check your data.',
                    'data' => null,
                    'errors' => $validator->errors()
                );

                return response()->json($response, 400);
            }

            $product = ProductModel::create($validator->validated());
            $response = array(
                'success' => true,
                'message' => 'Successfully create product data',
                'data' => $product,
            );

            return response()->json($response, 201);
        } catch (Exception $error) {
            $response = array(
                'success' => false,
                'message' => 'Sorry, there error in internal server',
                'data' => null,
                'errors' => $error->getMessage()
            );

            return response()->json($response, 500);
        }
	}
	
	public function update (Request $request, int $product_id) {
		try {
            Cache::forget('products');
            Cache::forget('productsid');

            $validator = Validator::make($request->all(), [
                'product_name' => 'required|string|max:100',
                'product_category_id' => 'required|exists:categories,category_id',
                'product_stock' => 'required|numeric',
                'product_price' => 'required|numeric'
            ]);

            if ($validator->fails()) {
                $response = array(
                    'success' => false,
                    'message' => 'Failed to create data product. Data not completed, please check your data.',
                    'data' => null,
                    'errors' => $validator->errors()
                );

                return response()->json($response, 400);
            }

            $product = ProductModel::find($product_id);

            if (!$product) {
                $response = [
                    'success' => false,
                    'message' => 'Product not found.',
                    'data' => null,
                    'errors' => 'Product with ID ' . $product_id . ' does not exist.'
                ];
    
                return response()->json($response, 404);
            }
    
            $product->update($validator->validated());

            $response = [
                'success' => true,
                'message' => 'Successfully update product data',
                'data' => $product,
        ];

            return response()->json($response, 200);
        } catch (Exception $error) {
            $response = array(
                'success' => false,
                'message' => 'Sorry, there error in internal server',
                'data' => null,
                'errors' => $error->getMessage()
            );

            return response()->json($response, 500);
        }
	}
	
	public function destroy (int $product_id) {
		try {
            $product = ProductModel::find($product_id);

            if($product){
                Cache::forget('products');
                Cache::forget('productsid');

                $product->delete();
                $response = [
                    'success' => 'true',
                    'message' => 'Successfully delete product data',
                    'data' => $product
                ];
            } else{
                $response = array(
                    'success' => true,
                    'message' => 'Product data not FOUND',
                    'data' => null
                );
            }
            

            return response()->json($response, $product ? 200 : 400 );
        } catch (Exception $error) {
            $response = array(
                'success' => false,
                'message' => 'Sorry, there error in internal server',
                'data' => null,
                'errors' => $error->getMessage()
            );

            return response()->json($response, 500);
        }
	}
}
