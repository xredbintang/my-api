<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CategoriesModel;
use Exception;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

class Categories extends Controller
{
    public function index () {
		try {
            $categories = CategoriesModel::getCategory();
            $response = [
                'success' => true,
                'message' => 'Successfully get categories data.',
                'data' => $categories
            ];

            return response()->json($response, 200);
        } catch (Exception $error) {
            $response = [
                'success' => false,
                'message' => 'Sorry, there error in internal server',
                'data' => null,
                'errors' => $error->getMessage()
            ];

            return response()->json($response, 500);
        }
	}

    public function show (int $category_id){
        try{
            $categories = CategoriesModel::getCategoryById($category_id);
            $response = [
                'succes' => true,
                'message' => 'Succesfully get category data',
                'data' => $categories
            ];
            return response()->json($response,200);
        } catch(Exception $error){
            $response = [
                'success' => false,
                'message' => 'Sorry, there error in internal server',
                'data' => null,
                'errors' => $error->getMessage()
            ];
            return response()->json($response, 500);
        }
    }

    public function store(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'category_name' => 'required|string|max:100'
            ]);

            if($validator->fails()){
                $response = [
                    'succes' => false,
                    'message' => 'Error cant get category data, data not completed',
                    'data' =>  null,
                    'error' => $validator->errors()
                ];
                
            return response()->json($response, 400);
            }

            $categories = CategoriesModel::createCategory($validator->validated());
            $response = [
                'succes' => true,
                'message' => 'succesfully created category data',
                'data' => $categories
            ];

            return response()->json($response,201);
        } catch(Exception $error){
            $response = [
                'succes' => false,
                'message' => 'Error in internal server',
                'data' => null,
                'errors' => $error->getMessage()
            ];

            return response()->json($response,500);
        }
    }

    public function update(Request $request,int $category_id){
        try{
            $validator = Validator::make($request->all(),[
                'category_name' => 'required|string|max:100'
            ]);
            if($validator->fails()){
                $response = [
                'succes' => false,
                'message' => 'Cannot update data, please check',
                'data' => null,
                'errors' => $validator->errors()
                ];
                
                return response()->json($response, 400);
            }

            $categories = CategoriesModel::updateCategory($category_id, $validator->validated());
            $response = [
                'succes' => true,
                'message' => 'succesfully update category data',
                'data' => $categories
            ];

            return response()->json($response,200);

        }catch(Exception $error){
            $response = [
                'succes' => false,
                'message' => 'Error internal server',
                'data' => null,
                'errors' => $error->getMessage()
            ];
            return response()->json($response,500);
        }
    }

    public function destroy(int $category_id){
        try{
            $categories = CategoriesModel::deletCategory($category_id);
            if($categories){
                $response = [
                    'success' => 'true',
                    'message' => 'Successfully delete category data',
                    'data' => $categories
                ];
            } else{
                $response = array(
                    'success' => true,
                    'message' => 'category data not FOUND',
                    'data' => null
                );
            }
            

            return response()->json($response, $categories ? 200 : 400 );
        } catch(Exception $error){
            $response = [
                'succes' => false,
                'message' => 'INternal server error',
                'data' => null,
                'errors' => $error->getMessage()
            ];

            return response()->json($response,500);
        }
    }
}
