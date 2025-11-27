@extends('adminlte::page')

@section('title', 'Eventos disponibles')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">Eventos disponibles</h1>

        <a href="{{ route('eventos.index') }}" class="btn btn-outline-dark">
            Volver a eventos
        </a>
    </div>
@stop

@section('content')

    {{-- filtro por fechas --}}
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('eventos.disponibles') }}">
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
                        <a href="{{ route('eventos.disponibles') }}" class="btn btn-outline-secondary">
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
            <h3 class="card-title">Eventos con boletos disponibles</h3>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <thead>
                    <tr>
                       
                        <th>Titulo</th>
                        <th>Descripcion</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Ubicacion</th>
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
                                {{-- editar en modal --}}
                                <button
                                    type="button"
                                    class="btn btn-sm btn-warning mb-1"
                                    data-toggle="modal"
                                    data-target="#modalEditarEventoDisponibles"
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

                                {{-- eliminar, regresando a esta vista --}}
                                <form action="{{ route('eventos.destroy', ['evento' => $evento->id, 'from' => 'disponibles']) }}"
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
                            <td colspan="10" class="text-center">No hay eventos disponibles</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL EDITAR: DISPONIBLES --}}
    <div class="modal fade" id="modalEditarEventoDisponibles" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Editar evento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="formEditarEventoDisponibles" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="from" value="disponibles">

                    <div class="modal-body">

                        <div class="form-group mb-3">
                            <label for="edit_titulo_disponibles">Titulo</label>
                            <input type="text" id="edit_titulo_disponibles" name="titulo" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="edit_descripcion_disponibles">Descripcion</label>
                            <textarea id="edit_descripcion_disponibles" name="descripcion" class="form-control" rows="3" required></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="edit_fecha_disponibles">Fecha</label>
                            <input type="date" id="edit_fecha_disponibles" name="fecha" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="edit_hora_disponibles">Hora</label>
                            <input type="time" id="edit_hora_disponibles" name="hora" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="edit_ubicacion_disponibles">Ubicacion</label>
                            <input type="text" id="edit_ubicacion_disponibles" name="ubicacion" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="edit_precio_disponibles">Precio</label>
                            <input type="number" step="0.01" id="edit_precio_disponibles" name="precio" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label>Imagen actual</label>
                            <div>
                                <img id="preview_imagen_disponibles" src="" alt="imagen evento"
                                     style="max-width: 120px; max-height: 120px;"
                                     class="d-none">
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="edit_imagen_disponibles">Nueva imagen (opcional)</label>
                            <input type="file" id="edit_imagen_disponibles" name="imagen" class="form-control-file">
                        </div>

                        <div class="form-group mb-3">
                            <div class="form-check">
                                <input type="checkbox" id="borrar_imagen_disponibles" name="borrar_imagen" class="form-check-input">
                                <label class="form-check-label" for="borrar_imagen_disponibles">
                                    Borrar imagen
                                </label>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
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
    $('#modalEditarEventoDisponibles').on('show.bs.modal', function (event) {
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

        modal.find('#edit_titulo_disponibles').val(titulo);
        modal.find('#edit_descripcion_disponibles').val(descripcion);
        modal.find('#edit_fecha_disponibles').val(fecha);
        modal.find('#edit_hora_disponibles').val(hora);
        modal.find('#edit_ubicacion_disponibles').val(ubicacion);
        modal.find('#edit_precio_disponibles').val(precio);

        var preview = modal.find('#preview_imagen_disponibles');
        if (urlImagen) {
            var fullUrl = "{{ asset('storage') }}/" + urlImagen.replace(/^storage\//, '');
            preview.attr('src', fullUrl);
            preview.removeClass('d-none');
        } else {
            preview.attr('src', '');
            preview.addClass('d-none');
        }

        modal.find('#borrar_imagen_disponibles').prop('checked', false);
        modal.find('#edit_imagen_disponibles').val('');

        var form = document.getElementById('formEditarEventoDisponibles');
        var baseUrl = "{{ url('eventos') }}";
        form.action = baseUrl + '/' + id;
    });
});
</script>
@stop
