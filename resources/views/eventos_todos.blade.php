@extends('adminlte::page')

@section('title', 'Todos los eventos')

@section('content_header')

<link rel="stylesheet" href="{{ asset('css/custom.css') }}">


    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">Todos los eventos</h1>

        <a href="{{ route('eventos.index') }}" class="btn btn-outline-secondary">
            Volver a eventos
        </a>
    </div>
@stop

@section('content')

    {{-- filtro por fechas --}}
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('eventos.todos') }}">
                <div class="form-row">
                    <div class="col-md-3 mb-2">
                        <label for="fecha_desde">Fecha desde</label>
                        <input type="date"
                               id="fecha_desde"
                               name="fecha_desde"
                               value="{{ request('fecha_desde') }}"
                               class="form-control">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="fecha_hasta">Fecha hasta</label>
                        <input type="date"
                               id="fecha_hasta"
                               name="fecha_hasta"
                               value="{{ request('fecha_hasta') }}"
                               class="form-control">
                    </div>
                    <div class="col-md-3 mb-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary mr-2">
                            Filtrar
                        </button>
                        <a href="{{ route('eventos.todos') }}" class="btn btn-outline-secondary">
                            Limpiar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- tabla --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Listado de todos los eventos</h3>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <thead>
                    <tr>
                       
                        <th>Título</th>
                        <th>Descripción</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Ubicación</th>
                        <th>Precio</th>
                        <th>Imagen</th>
                        <th>Boletos disponibles</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($eventos as $evento)
                        <tr>
                            
                            <td>{{ $evento->titulo }}</td>
                            <td>{{ $evento->descripcion }}</td>
                            <td>{{ $evento->fecha }}</td>
                            <td>{{ $evento->hora }}</td>
                            <td>{{ $evento->ubicacion }}</td>
                            <td>{{ $evento->precio }}</td>
                            <td>
                                @if($evento->urlImagen)
                                    <img src="{{ asset('storage/'.$evento->urlImagen) }}"
                                         alt="imagen evento"
                                         style="max-width: 80px; max-height: 80px;">
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $evento->boletosDisponibles }}</td>
                            <td>
                                <button
                                    type="button"
                                    class="btn btn-sm btn-warning mb-1"
                                    data-toggle="modal"
                                    data-target="#modalEditarEventoTodos"
                                    data-id="{{ $evento->id }}"
                                    data-titulo="{{ $evento->titulo }}"
                                    data-descripcion="{{ $evento->descripcion }}"
                                    data-fecha="{{ $evento->fecha }}"
                                    data-hora="{{ $evento->hora }}"
                                    data-ubicacion="{{ $evento->ubicacion }}"
                                    data-precio="{{ $evento->precio }}"
                                    data-urlimagen="{{ $evento->urlImagen }}"
                                >
                                    Editar
                                </button>

                                <form action="{{ route('eventos.destroy', ['evento' => $evento->id, 'from' => 'todos']) }}"
                                      method="POST"
                                      style="display:inline-block"
                                      onsubmit="return confirm('Seguro que deseas eliminar este evento?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center">No hay eventos registrados</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL EDITAR: TODOS --}}
    <div class="modal fade" id="modalEditarEventoTodos" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Editar evento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="formEditarEventoTodos" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="from" value="todos">

                    <div class="modal-body">

                        <div class="form-group mb-3">
                            <label for="edit_titulo_todos">Título</label>
                            <input type="text" id="edit_titulo_todos" name="titulo" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="edit_descripcion_todos">Descripción</label>
                            <textarea id="edit_descripcion_todos" name="descripcion" class="form-control" rows="3" required></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="edit_fecha_todos">Fecha</label>
                            <input type="date" id="edit_fecha_todos" name="fecha" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="edit_hora_todos">Hora</label>
                            <input type="time" id="edit_hora_todos" name="hora" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="edit_ubicacion_todos">Ubicación</label>
                            <input type="text" id="edit_ubicacion_todos" name="ubicacion" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="edit_precio_todos">Precio</label>
                            <input type="number" step="0.01" id="edit_precio_todos" name="precio" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label>Imagen actual</label>
                            <div>
                                <img id="preview_imagen_todos" src="" alt="imagen evento"
                                     style="max-width: 120px; max-height: 120px;"
                                     class="d-none">
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="edit_imagen_todos">Nueva imagen (opcional)</label>
                            <input type="file" id="edit_imagen_todos" name="imagen" class="form-control-file">
                        </div>

                        <div class="form-group mb-3">
                            <div class="form-check">
                                <input type="checkbox" id="borrar_imagen_todos" name="borrar_imagen" class="form-check-input">
                                <label class="form-check-label" for="borrar_imagen_todos">
                                    Borrar imagen
                                </label>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                            Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Guardar cambios
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@stop

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    $('#modalEditarEventoTodos').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);

        var id          = button.data('id');
        var titulo      = button.data('titulo');
        var descripcion = button.data('descripcion');
        var fecha       = button.data('fecha');
        var hora        = button.data('hora');
        var ubicacion   = button.data('ubicacion');
        var precio      = button.data('precio');
        var urlImagen   = button.data('urlimagen');

        var modal = $(this);

        modal.find('#edit_titulo_todos').val(titulo);
        modal.find('#edit_descripcion_todos').val(descripcion);
        modal.find('#edit_fecha_todos').val(fecha);
        modal.find('#edit_hora_todos').val(hora);
        modal.find('#edit_ubicacion_todos').val(ubicacion);
        modal.find('#edit_precio_todos').val(precio);

        var preview = modal.find('#preview_imagen_todos');
        if (urlImagen) {
            var fullUrl = "{{ asset('storage') }}/" + urlImagen.replace(/^storage\//, '');
            preview.attr('src', fullUrl);
            preview.removeClass('d-none');
        } else {
            preview.attr('src', '');
            preview.addClass('d-none');
        }

        modal.find('#borrar_imagen_todos').prop('checked', false);
        modal.find('#edit_imagen_todos').val('');

        var form = document.getElementById('formEditarEventoTodos');
        var baseUrl = "{{ url('eventos') }}";
        form.action = baseUrl + '/' + id;
    });
});
</script>
@stop
