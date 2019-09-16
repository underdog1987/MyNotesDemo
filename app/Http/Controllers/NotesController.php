<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Note;
use App\User;


class NotesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /*
     * Obtiene nota por ID
     */
    public function getNote(Request $request, $id, $format){

        $id=(int)$id;
        $format = strtolower($format);

        $note = Note::find($id);

        $intResponse = NULL===$note?404:200;
        switch($format){
            case 'xml':{
                $view = 'noteXML';
                $contentType = 'application/xml';
                break;
            }
            case 'csv':{
                $view = 'noteCSV';
                $contentType = 'text/csv';
                break;
            }
            default:{ // json
                $view = 'note';
                $contentType = 'application/json';
                break;
            }
        }
        return response(view($view,array('nota'=>$note)),$intResponse, ['Content-Type' => $contentType]);
    }

    /*
     * Obtiene todas las notas
     * GET /notes/{format}
     *      {format} es uno de los soguientes:
     *          * json
     *          * csv
     *          * xml
     */
    public function getNotes(Request $request, $format)
    {
        $notes = Note::All();
        switch($format){
            case 'xml':{
                $view = 'notesXML';
                $contentType = 'application/xml';
                break;
            }
            case 'csv':{
                $view = 'notesCSV';
                $contentType = 'text/csv';
                break;
            }
            default:{ // json
                $view = 'notes';
                $contentType = 'application/json';
                break;
            }
        }
        return response(view($view,array('notas'=>$notes)),200, ['Content-Type' => $contentType]);
    }

}
