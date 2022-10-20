@extends('layouts.panel')

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('warning'))
        <div class="alert alert-warning">
            {{ session('warning') }}
        </div>
    @endif

    <h3 class="mb-2 ml-3 font-weight-bold text-primary">{{ ucfirst($meet->name) }}</h3>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row ml-1 align-items-center">

                <button class="btn btn-primary mr-2" type="button" data-toggle="collapse" data-target="#form-horario"
                    aria-expanded="false" aria-controls="form-horario">
                    Novo Horario
                </button>

                <button class="btn btn-primary mr-2" type="button" data-toggle="collapse" data-target="#form-participant"
                    aria-expanded="false" aria-controls="form-participant">
                    Adicionar Particpante
                </button>

                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#form-topic"
                    aria-expanded="false" aria-controls="form-topic">
                    Adicionar Tópico
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center" colspan="{{ $tamanho + 1 }}">Horários</th>
                        </tr>
                        <tr>
                            <th scope="col" class="text-center align-middle">Participantes</th>

                            @for ($i = 0, $tamanho = count($horarios); $i < $tamanho; ++$i)
                                <th scope="col">

                                    <span>Data: </span>{{ $horarios[$i]->meet_date_formatted }} <span> | </span>
                                    {{ $horarios[$i]->meet_start_formatted }} <span> - </span>
                                    {{ $horarios[$i]->meet_end_formatted }}
                                </th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($participants as $participant)
                            <tr>
                                <th class="dark" scope="row">
                                    {{ $participant->name }}
                                </th>
                                @foreach ($horarios as $key => $h)
                                    <td scope="col" colspan="1" class="text-center align-middle">
                                        <button type="button" class="btn red btn-block btn-lg"></button>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <hr>

                <h3 class="ml-2 text-left font-weight-bold text-primary">Tópicos</h3>


                <ul class="list-group">
                    @foreach ($topics as $topic)
                        <li class="list-group-item"> - {{ $topic->topico }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="collapse" id="form-horario">
                <div class="mt-2 card card-body">
                    <h4 class="mb-0 font-weight-bold text-primary">Novo Horário</h4>
                    <hr>
                    <form class="form" action="{{ route('horario.meet.store', $meet->id) }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">Data</label>
                            <input type="text" name="meet_date"
                                class="form-control date {{ $errors->has('meet_date') ? ' is-invalid' : '' }}"
                                value="{{ old('meet_date') }}" data-mask="00/00/0000">
                            <div class="invalid-feedback">{{ $errors->first('meet_date') }}</div>
                        </div>
                        <div class="form-group">
                            <label for="name">Início</label>
                            <input type="text" name="meet_start"
                                class="form-control date     {{ $errors->has('meet_start') ? ' is-invalid' : '' }}"
                                value="{{ old('meet_start') }}" data-mask="00:00">
                            <div class="invalid-feedback">{{ $errors->first('meet_start') }}</div>
                        </div>
                        <div class="form-group">
                            <label for="name">Fim</label>
                            <input type="text" name="meet_end"
                                class="form-control date {{ $errors->has('meet_end') ? ' is-invalid' : '' }}"
                                value="{{ old('meet_end') }}" data-mask="00:00">
                            <div class="invalid-feedback">{{ $errors->first('meet_end') }}</div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-user btn-block">
                            Criar!
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="collapse multi-collapse" id="form-participant">
                <div class="mt-2 card card-body">
                    <h4 class="mb-0 font-weight-bold text-primary"> Novo Participante</h4>
                    <hr>
                    <form class="form" action="{{ route('participant.store', $meet->id) }}" method="post">
                        @csrf
                        <input type="text" name="email" class="form-control mb-2" placeholder="email">
                        <button class="btn btn-primary btn-user btn-block" type="submit">enviar convite</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="collapse multi-collapse" id="form-topic">
                <div class="mt-2 card card-body">
                    <h4 class="mb-0 font-weight-bold text-primary">Novo Tópico</h4>
                    <hr>
                    <form class="form" action="{{ route('topic.store', $meet->id) }}" method="post">
                        @csrf
                        <input type="text" name="topico" class="form-control mb-2" placeholder="Tópico">
                        <button class="btn btn-primary btn-user btn-block" type="submit">Adicionar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('.btn-lg').click(function() {
            console.log('achou')
            if($(this).hasClass('green')) {
                console.log('green')
                $(this).removeClass('green');
                $(this).addClass('red');
            } else if($(this).hasClass('red')){
                console.log('red')
                $(this).removeClass('red');
                $(this).addClass('green');
            }
        });

    </script>

    <style>
        .green {
            background-color: rgb(77, 184, 77);
        }

        .red{
            background-color: rgb(238, 33, 33);
        }
    </style>
@endsection
