@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Mis notas
                    <a href="#" data-toggle="modal" data-target="#detalleModal" style="float:right" class="btn btn-sm btn-secondary"><i class="fa fa-plus"></i> Añadir nota</a>
                    <a href="{{url('/')}}" target="_blank" style="float:right;margin-right:10px;color:#FFF" class="btn btn-sm btn-success"><i class="fa fa-globe"></i> Visitar Sitio</a>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <!--
                    @if(Auth::user()->hasRole('admin'))
                        <div>Acceso como administrador</div>
                    @else
                        <div class="alert alert-success" role="alert">Acceso usuario</div>
                    @endif
                    -->
                    <hr />
                    <ul class="list-group" id="myNotes"></ul>
                    <div id="no-notes">
                        <h3>Esto está muy vacío</h3>
                        <p>Haz clic en el boton "Añadir nota" para agregar tu primera nota</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detalleModal" tabindex="-1" role="dialog" aria-labelledby="exampleDetalleLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleDetalleLabel">Añadir o editar nota</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="txTitulo" class="control-label">Título de la nota:</label>
                <input type="text" class="form-control" id="txTitulo">
            </div>
            <div class="form-group">
                <label for="txNota" class="control-label">Contenido de la nota:</label>
                <input type="text" class="form-control" id="txNota">
            </div>
            <div>
                <input type="hidden" id="iNote" value="0">
            </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
          <button class="btn btn-success" type="button" id="btnGuardar" >Guardar</button>
        </div>
      </div>
    </div>
  </div>

<script>

    $( document ).ready(function() {
        loadNotes();

        $('.btnEdita').click( function(e){
            // Get selected note
            _id=parseInt($(this).attr('note-id'));
            $.ajax({
                url: "{{url('note')}}/"+_id+"/json",
                dataType: 'json',
                type: 'GET',
                success: function(data) {
                    $('#txTitulo').val(data.name);
                    $('#txNota').val(data.txNote);
                    $('#iNote').val(_id);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert("No pudimos obtener los detalles de la nota\n" + "HTTP Status: " + jqXHR.status + " " + textStatus);
                    $('#detalleModal').modal('hide');
                    
                }
            });
        });

        $('.btnElimina').on('click', function(){
            if(window.confirm("¿Deseas eliminar la nota?")){
                // Obtener id de la nota
                _id=parseInt($(this).attr('note-id'));
                j = { "id": _id, "_token": "{{ csrf_token() }}" };
                $.ajax({
                    url: "{{url('note')}}/"+_id,
                    dataType: 'json',
                    type: 'DELETE',
                    data: j,
                    success: function(data) {
                        loadNotes();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert("No pudimos eliminar la nota\n" + "HTTP Status: " + jqXHR.status + " " + textStatus);
                        
                    }
                });
            }
        });

        $('#btnGuardar').click( function(e){
            // Save note
            _id=parseInt($('#iNote').val());
            j = { "id": _id, "_token": "{{ csrf_token() }}", "name": $('#txTitulo').val(), "txNote": $("#txNota").val() };
            method=_id==0?"POST":"PUT";
            uri=_id==0?"{{url('note/add')}}":"{{url('note')}}/"+_id;
            $.ajax({
                url: uri,
                dataType: 'json',
                contentType: 'application/json; charset=UTF-8',
                type: method,
                data: JSON.stringify(j),
                success: function(data) {
                    loadNotes();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert("Ocurrió un error al guardar la nota\n" + "HTTP Status: " + jqXHR.status + " " + textStatus);
                }
            });
            $('#detalleModal').modal('hide');
            $('#txTitulo').val('');
            $('#txNota').val('');
            $('#iNote').val(0);
        });

        $('#detalleModal').on('hidden.bs.modal', function (e) {
            $('#detalleModal').modal('hide');
            $('#txTitulo').val('');
            $('#txNota').val('');
            $('#iNote').val(0);
        });

    });

    function loadNotes(){
        $.ajaxSetup({async: false});
        $.getJSON( "{{url('user-notes')}}/", function( data ) {
            $('#myNotes').html('');
            if(data.length > 0){
                $('#no-notes').hide();
                for(c=0;c<data.length;c++){
                    oNote=data[c];
                    note='<li class="list-group-item" id="note-'+oNote.id+'"><div class="row"><div class="col-md-8"><h4>#'+oNote.id+' '+oNote.name+'</h4><p>'+oNote.txNote+'</p></div><div class="col-md-4"><button class="btn btn-danger btnElimina" note-id="'+oNote.id+'"><i class="fa fa-close"></i> Eliminar</button><a class="btn btn-info btnEdita" style="color:#FFF;margin-left:15px;" href="#" data-toggle="modal" data-target="#detalleModal" note-id="'+oNote.id+'"><i class="fa fa-pencil"></i> Editar</a></div></div></li>';
                    $(note).appendTo('#myNotes');
                }
            }else{
                $('#no-notes').show('slow');
            }
        }).fail(function(e){
            alert("Un error impidió que obtuvieramos las notas");
            console.log(e.responseText)
        });
        $.ajaxSetup({async: true});
    }
</script>
@endsection
