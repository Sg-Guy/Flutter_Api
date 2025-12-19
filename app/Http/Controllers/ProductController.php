<?php

namespace App\Http\Controllers;

use App\Http\Requests\productRequest;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Ramsey\Uuid\Type\Integer;

class ProductController extends Controller
{

    public function  index () {
        $all_product = Product::with('category:id,name')->orderBy('created_at' , 'desc')->get() ;
        
        $products = $all_product-> map(function($product){
            $item = $product->toArray() ;
            $item[
                    'category_name' 
                ] = $product->category->name ?? null ;
                unset($item['category']);
                return $item ;
        }) ;

        return response()->json([
            'data'=>$products
            
        ] , 200);
    }
    public function  vedette () {
        $all_product = Product::with('category:id,name')->where('vedette' , true)->get() ;
        
        $products = $all_product-> map(function($product){
            $item = $product->toArray() ;
            $item[
                    'category_name' 
                ] = $product->category->name ?? null ;
                unset($item['category']);
                return $item ;
        }) ;

        return response()->json([
            'data'=>$products
            
        ] , 200);
    }
    public function  nouveau () {
        $all_product = Product::with('category:id,name')->orderBy('created_at' , 'desc')->limit(5)->get() ;
        
        $products = $all_product-> map(function($product){
            $item = $product->toArray() ;
            $item[
                    'category_name' 
                ] = $product->category->name ?? null ;
                unset($item['category']);
                return $item ;
        }) ;

        return response()->json([
            'data'=>$products
            
        ] , 200);
    }

    public function store (productRequest $request) {
        $product = new Product() ;
        $product->nom = $request->nom ;
        $product->category_id = $request->category_id ;
        $product->description = $request->description ;
        $product->stock = $request->stock ;
        $product->prix_unitaire = $request->prix_unitaire ;
        $product->prix_promo = $request->prix_promo ;
       // $product->image = $request->image ; //revoire la methode de stockage
        if ($request->hasFile('image')) {
            $chemin_image = $request->file('image')->store('images', 'public');
            //dd($chemin_image);
            
        }
//dd($product) ;
       $product->image = $chemin_image ; //revoire la methode de stockage
       $product->vedette = $request->vedette ;
       

        try {
            $product->save() ;

            return response()->json([
                'message' =>"Création effectuée",
                'data'=>$product ,
                ]) ;
        } catch (Exception $e) {
            return response()->json([
                'status' => 400 ,
                'message'=> "Requête erronnée".$e
                ] , 201) ;

        }
    }
    public function update (productRequest $request/*Product $product*/) {
        $product = Product::where('id', '=' ,1) ;
        dd($product);
        $product->nom = $request->nom ;
        $product->category_id = $request->category_id ;
        $product->description = $request->description ;
        $product->stock = $request->stock ;
        $product->prix_unitaire = $request->prix_unitaire ;
        $product->prix_promo = $request->prix_promo ;
        $product->image = $request->image ; //revoire la methode de stockage

//dd($product) ;
        try {
            $product->update() ;

            return response()->json([
                'message' =>"mise à jour effectuée",
                //'data'=>$product ,
                ] ,201) ;
        } catch (Exception $e) {
            return response()->json([
                'message'=> "Requête erronnée".$e
                ] ,404) ;

        }
    }

    public function destroy (Product $product) {

        //$product = Product::find($product);
        try {
            if ($product) {
            //dd($product);
            //$product = $product;
            $product->delete();
            return  response()->json(
                [
                    'message'=>'produit supprimé avec succès'
                ], 200
            ) ;
        } else {
            return response()->json(
                [
                    'message'=>"Le produit n'existe pas",
                ] , 400
            ) ;
        }
        } catch (Exception $e) {
            return response()->json(
                [
                    'message'=>"Erreur: ".$e ,
                ] , 500
            ) ;
        }
        }

}
    

