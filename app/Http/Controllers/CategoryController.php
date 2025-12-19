<?php

namespace App\Http\Controllers;

use App\Http\Requests\categorieRequest;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store (categorieRequest $request) {
        $category_exist  = Category::where('name' , '=' , $request->name)->get() ;

        if(count($category_exist) > 0)  {
            return response()->json([
                'message'=>"Cette catégorie existe déjà"
            ]) ;
        }

        $categorie = new Category() ;
        $categorie->name = $request->name ;

        try {
            
            $categorie->save() ;
            return response()->json([
                'status'=>201 ,
                'message'=>"La categorie a bien été créée " , 
                'data'=>$categorie 
            ]);
        } catch (Exception $e) {
    
            return response()->json([
                'status' =>400 ,
                'message'=>'Une erreur est survenue lors de la création. Veuillez réessayer'  ,
                'error'=>$e 
            ]) ;
        }
    }

    public function index () {
        $categories = Category::all('id' ,'name') ;
        return response()->json([
            'message'=>"Requête traitée avec succes" ,
            'data' =>$categories
            ] , 200) ;
    }

    public function update (categorieRequest $request , Category $categorie) {

        //$category_id_exist  = Category::where('id' , '=' , $categorie->id);//->get() ;
        $category_exist  = Category::where('name' , '=' , $request->name)->get() ;

        if(/*count($category_id_exist) > 0 &&*/ count($category_exist) > 0)  {
            return response()->json([
                'message'=>"Cette catégorie existe déjà"
            ]) ;
        }

        $categorie->name = $request->name ;

        try {
            
            $categorie->update() ;
            return response()->json([
                'message'=>"La categorie a bien été mise à jour " , 
                'data'=>$categorie 
            ],200);
        } catch (Exception $e) {
    
            return response()->json([
                'message'=>'Une erreur est survenue lors de la création. Veuillez réessayer'  ,
                'error'=>$e 
            ] , 400) ;
        }
    }

    public function destroy (Category $categorie) {
        if ($categorie) {
            try {
                $categorie->delete() ;
                return response()->json([
                    'message'=>"Catégorie supprimé avec succès" ,
                    ] , 200) ;
            } catch (Exception $e){
                return response()->json([
                    'message'=>"Erreur lors de la suppression" ,
                    ] , 500) ;
            }
        } else {
            return response()->json([
                    'message'=>"Cette catégorie n'existe pas" ,
                    ] , 404) ;
        }

    }
}
