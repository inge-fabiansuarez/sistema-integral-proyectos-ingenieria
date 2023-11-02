<div>
    <div class="card">
        <div class="card-header pb-0 px-3">
            <h6 class="mb-0">Ingresar información Audiometria</h6>
        </div>
        <div class="card-body pt-4 p-3">
            <ul class="list-group">
                <li class="list-group-item border-0 p-4 mb-2 bg-gray-100 border-radius-lg">
                    <div class="d-flex flex-column">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Seleccionar empleado</label>
                            <select class="form-control" id="exampleFormControlSelect1">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>
                        <h6 class="mb-3 text-sm">Oliver Liam</h6>
                        <span class="mb-2 text-xs">Company Name: <span class="text-dark font-weight-bold ms-sm-2">Viking
                                Burrito</span></span>
                        <span class="mb-2 text-xs">Email Address: <span
                                class="text-dark ms-sm-2 font-weight-bold">oliver@burrito.com</span></span>
                        <span class="text-xs">VAT Number: <span
                                class="text-dark ms-sm-2 font-weight-bold">FRB1235476</span></span>
                        <br>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Fecha del examen</label>
                            <input type="date" class="form-control form-control-sm" id="exampleFormControlInput1">
                        </div>
                    </div>

                </li>

                <li class="list-group-item border-0 p-4 mb-2 bg-gray-100 border-radius-lg">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card mb-3">
                                <div class="card-body p-3">
                                    <div class="chart">
                                        <canvas wire:ignore id="myChart" wire:poll.500ms></canvas>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="table-responsive">

                                <table class="table table-striped table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th scope="col">Frecuencia</th>
                                            <th scope="col">Izquierdo</th>
                                            <th scope="col">Derecho</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($listEjeX as $index => $frecuency)
                                            <tr>
                                                <th scope="row">

                                                    <div class=" d-flex justify-content-between align-items-center">
                                                        {{ $frecuency }}
                                                        <a wire:click="$emitSelf('removeEjeX',{{ $index }})"
                                                            class="btn btn-icon btn-danger p-2 my-0">
                                                            <span class="btn-inner--icon"><i
                                                                    class="fas fa-trash"></i></span>
                                                        </a>
                                                    </div>

                                                </th>
                                                <td>
                                                    <input class="form-control form-control-sm" type="number"
                                                        placeholder="Hertz" wire:model="dataRigth.{{ $index }}">
                                                </td>
                                                <td>
                                                    <input class="form-control form-control-sm" type="number"
                                                        placeholder="Hertz" wire:model="dataLeft.{{ $index }}">
                                                </td>
                                            </tr>
                                        @endforeach


                                        <tr>
                                            <th scope="row">
                                                <input wire:model.defer="frequency" class="form-control form-control-sm"
                                                    type="text">
                                                @error('frequency')
                                                    <span class="text-danger text-xxs text-message-validation">
                                                        {{ $message }}
                                                    </span>
                                                    <br>
                                                @enderror
                                                <button wire:click="$emit('addOtherEjeX')" type="submit"
                                                    class="btn btn-success my-2">Agregar</button>

                                            </th>
                                            <td> </td>
                                            <td> </td>
                                        </tr>


                                    </tbody>
                                </table>


                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Diagnóstico oido Derecho:</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Diagnóstico oido Izquierdo:</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Observaciones:</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>
                </li>

            </ul>


        </div>
    </div>

    @json($listEjeX)
    @json($dataRigth)
    @json($dataLeft)

    @push('js')
        <script>
            document.addEventListener('livewire:load', function() {
                const ctx = document.getElementById('myChart').getContext('2d');

                let chart;

                // Define los datos que usarás en el gráfico (asegúrate de que 'data' esté definido)
                const data = {
                    labels: @json($listEjeX),
                    datasets: [{
                        label: 'DERECHA',
                        data: @json($dataRigth),
                        borderColor: '#FF0000',
                        backgroundColor: '#FF0000',
                        pointStyle: 'circle',
                        pointRadius: 10,
                        pointHoverRadius: 15
                    }, {
                        label: 'IZQUIERDA',
                        data: @json($dataLeft),
                        borderColor: '#0000FF',
                        backgroundColor: '#0000FF',
                        pointStyle: 'crossRot',
                        pointRadius: 20,
                        pointHoverRadius: 15
                    }]
                };

                const config = {
                    type: 'line',
                    data: data,
                    options: {
                        responsive: true,
                        plugins: {
                            title: {
                                display: true,
                                text: (ctx) => 'AUDIOMETRÍA',
                            }
                        }
                    }
                };

                chart = new Chart(ctx, config);

                Livewire.on('listEjeXUpdated', (updatedListEjeX, dataRigth, dataLeft) => {
                    chart.data.labels = updatedListEjeX;
                    chart.data.datasets[0].data = dataRigth;
                    chart.data.datasets[1].data = dataLeft;
                    chart.update();
                });

            });
        </script>
    @endpush
</div>