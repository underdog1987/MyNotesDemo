<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Note;
use App\User;
use Auth;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request){
        $request->user()->authorizeRoles(['user', 'admin']);
        return view('home');
    }

    public function someAdminStuff(Request $request){
        $request->user()->authorizeRoles('admin');
        return view('admin');
    }

    public function userNotes(Request $request){
        $request->user()->authorizeRoles(['user', 'admin']);
        //$oUser=User::find(Auth::id());
        //$uNotes=$oUser->notes();
        $uNotes=Auth::User()->notes()->get();
        //dd($uNotes);
        return response(view('notes',array('notas'=>$uNotes)),200, ['Content-Type' => 'application/json']);
    }

    public function deleteNote(Request $request, $id){
        try{
            $id=(int)$id;
            $note = Note::find($id);
            $isNote = NULL !== $note;
            // Validar que exista la nota
            if($isNote){
                // Validar que sea una nota del usuario
                if(Auth::id() == $note->User->id){
                    $r = $note->delete();
                    $intResponse = 200;
                    $resp=array('success'=>TRUE, 'status' => $intResponse, 'message'=>'Se borró la nota');
                }else{
                    $intResponse = 401;
                    $resp=array('success'=>FALSE, 'status' => $intResponse, 'message'=>'No puedes borrar la nota de otro usuario');
                }
            }else{
                $intResponse = 404;
                $resp=array('success'=>FALSE, 'status' => $intResponse, 'message'=>'No encontramos la nota');
            }
        }catch(\Exception $e){ // Catch Laravel o PHP exceptions
            $intResponse = 500;
            $resp=array('success'=>FALSE, 'status' => $intResponse, 'message'=>$e->getMessage());
        }
        return response(view("note-deleted",array('resp'=>$resp)),$intResponse, ['Content-Type' =>"application/json"]);
    }

    public function updateNote(Request $request, $id){
        try{
            $id=(int)$id;
            $note = Note::find($id);
            $isNote = NULL !== $note;
            // Validar que exista la nota
            if($isNote){
                // Validar que sea una nota del usuario
                if(Auth::id() == $note->User->id){
                    
                    $rData=json_decode($request->getContent());
                    $note->name=$rData->name;
                    $note->txNote=$rData->txNote;
                    $note->update();
                    $intResponse = 200;
                    $resp=array('success'=>TRUE, 'status' => $intResponse, 'message'=>'Se actualizó la nota');
                }else{
                    $intResponse = 401;
                    $resp=array('success'=>FALSE, 'status' => $intResponse, 'message'=>'No puedes borrar la nota de otro usuario');
                }
            }else{
                $intResponse = 404;
                $resp=array('success'=>FALSE, 'status' => $intResponse, 'message'=>'No encontramos la nota');
            }
        }catch(\Exception $e){ // Catch Laravel o PHP exceptions
            $intResponse = 500;
            $resp=array('success'=>FALSE, 'status' => $intResponse, 'message'=>$e->getMessage());
        }
        return response(view("note-deleted",array('resp'=>$resp)),$intResponse, ['Content-Type' =>"application/json"]);
    }

    public function createNote(Request $request){
        try{
            $rData=json_decode($request->getContent());
            $note = new Note();
            $note->name=$rData->name;
            $note->txNote=$rData->txNote;
            $note->user_id=Auth::id();

            $note->save();

            $intResponse = 200;
            $resp=array('success'=>TRUE, 'status' => $intResponse, 'message'=>'Se agregó la nota');

        }catch(\Exception $e){ // Catch Laravel o PHP exceptions
            $intResponse = 500;
            $resp=array('success'=>FALSE, 'status' => $intResponse, 'message'=>$e->getMessage());
        }
        return response(view("note-created",array('resp'=>$resp)),$intResponse, ['Content-Type' =>"application/json"]);
    }


}
