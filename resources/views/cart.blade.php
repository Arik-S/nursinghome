<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            {{ __('Carrito de Donaciones') }}
        </h2>
    </x-slot>
    <main class="my-20">
        <div class="container-fluid">
            <div class="row mb-1">
                <div class="col-md-9">
                    <div class="card shadow">
                        <div class="cad-body p-2">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    @if ($message = Session::get('success'))
                                        <div class="p-4 mb-3 bg-green-400 rounded">
                                            <p class="text-green-800">{{ $message }}</p>
                                        </div>
                                    @endif
                                    <h3 class="text-3xl font-bold text-center">Productos para Donaciones</h3>
                                </div>

                                <div class="col-md-12">
                                    <!-- BOTONES PARA FINALIZAR DONACIÓN O LIMPIAR -->
                                    <div class="container h-10">
                                        <div class="row h-10">
                                            <div class="col-md-3"></div>
                                            <div class="text-right mr-2">
                                                <!--  CARGAR MÁS PRODUCTOS -->
                                                <form action="{{ route('products.list') }}" method="GET">
                                                    @csrf
                                                    <button class="btn btn-success" id="btnBuscarProducto">
                                                        <i class="fas fa-search"></i> Agregar Producto
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="text-right mr-2">
                                                <!--  LIMPIA LA LISTA -->
                                                <form action="{{ route('cart.clear') }}" method="POST">
                                                    @csrf
                                                    <button class="btn btn-danger" id="btnVaciarListado">
                                                        <i class="fas fa-trash"></i> Vaciar Listado
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="text-right mr-2">
                                                <!--  TERMINA EL PROCESO -->
                                                <form action="{{ route('cart.store') }}" method="POST">
                                                    @csrf
                                                    <button class="btn btn-primary" id="btnTerminarDonacion">
                                                        <i class="fas fa-shopping-bag"></i> Guardar Donacion
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <br>
                                        <br>
                                    </div>
                                    <!-- LISTADO QUE CONTIENE LOS PRODUCTOS QUE SE VAN AGREGANDO PARA LA DONACION -->
                                    <div class="col-md-12">
                                        <table id="lstProductosDonacion"
                                            class="display nowrap table-striped w-100 shadow table-flex">
                                            <thead class="bg-info text-left fs-3">
                                                <tr>
                                                    <th class="text-center">Imagen</th>
                                                    <th class="text-center">Nombre Producto</th>
                                                    <th class="text-center">Cantidad / Actualiza</th>
                                                    <th class="text-center">Eliminar</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-left fs-5">
                                                @foreach ($cartItems as $item)
                                                    <!--  $cartItems tiene toda la información optenida -->
                                                    <tr>
                                                      <td class="hidden pb-4 md:table-cell">
                                                        <a href="#">
                                                          <img src="{{ $item->attributes->image }}" class="w-20 rounded" alt="Thumbnail">
                                                        </a>
                                                      </td>
                                                        <td>
                                                            <a href="#">
                                                                <p class="mb-2 md:ml-4 text-purple-600 font-bold">
                                                                    {{ $item->name }}</p>

                                                            </a>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <div class="relative flex flex-row w-full h-8">
                                                                    <form action="{{ route('cart.update') }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="id"
                                                                            value="{{ $item->id }}">
                                                                        <input type="number" name="quantity"
                                                                            value="{{ $item->quantity }}"
                                                                            class="w-16 text-center h-6 text-gray-800 outline-none rounded border border-blue-600" />
                                                                        <button
                                                                            class="px-4 py-2 rounded-full shadow text-white bg-violet-500">Actualizar</button>
                                                                    </form>

                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <form action="{{ route('cart.remove') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" value="{{ $item->id }}"
                                                                    name="id">
                                                                <button
                                                                    class="px-4 py-2 text-white bg-red-600 shadow rounded-full">Eliminar</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <!-- / table -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow">
                        <h5 class="card-header py-1 bg-primary text-white text-center">
                            Datos Requeridos para la Donación <span id="totalVentaRegistrar"></span>
                        </h5>
                        <div class="card-body p-2">
                            <div class="form-group mb-2">

                                <label class="col-form-label" for="selCategoriaReg">
                                    <i class="fas fa-file-alt fs-6"></i>
                                    <span class="small">Entrega de Donación</span><span class="text-danger">*</span>
                                </label>

                                <select class="form-select form-select-sm" aria-label=".form-select-sm example"
                                    id="selDocumentoVenta" enable required>
                                    <option value="0" selected="true">Seleccione Forma de Entrega</option>
                                    <option value="1">Entrega a Local</option>
                                    <option value="2">Buscar Donación</option>
                                </select>

                                <span id="validate_categoria" class="text-danger small fst-italic" style="display:none">
                                    Debe Seleccionar tipo de Entrega
                                </span>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


</x-app-layout>


<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>


<script>
    var table;
    var items = []; // SE USA PARA EL INPUT DE AUTOCOMPLETE
    var itemProducto = 1;

    $(document).ready(function() {

        /* ======================================================================================
          INICIALIZAR LA TABLA DE VENTAS
          ======================================================================================*/
        table = $('#lstProductosDonacion').DataTable({
            "columns": [{
                    "data": "Item"
                },
                {
                    "data": "Nombre Producto"
                },
                {
                    "data": "Cantidad"
                },
                {
                    "data": "Eliminar"
                }
            ],
            /*columnDefs: [{
                //ocula la columna
                targets: 0,
                visible: false
            }],*/
            "order": [
                [0, 'desc']
            ],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            }
        });

    }) //FIN DOCUMENT READ
</script>
@include('footer')