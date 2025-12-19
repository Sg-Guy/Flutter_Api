<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Exception;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function store (Request $request){
        $role = new Role() ;
        $request->validate(['nom'=>"required|string"] , ['nom.required'=>'le nom du rôle est requis !']) ;

        $role->nom = $request->nom ;
        try {
            $role->save() ;
            return response()-> json(
                [
                    'message'=>'rôle créeé avec succès',
                ] ,200
            ) ;
        } catch (Exception $e) {
            return response()->json( 
                [
                    'message'=>'Une erreur est survenue lors de la création. Veuillez réessayer'  ,
                    'error'=>$e
                ] , 500
            ) ;
        }
    }
}
