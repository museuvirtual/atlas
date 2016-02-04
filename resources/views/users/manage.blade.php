@extends('app')

@section('content')


    <div class="col-md-12"><h2>Manage Users and Permissions</h2></div>


    <div class="container">
        <div class="row">
            <table class="table table-hover col-sm-12">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Nome</th>
                    <th>Apelidos</th>
                    <th>email</th>
                    <th>Criado em</th>
                    <th>Level</th>
                    <th>Mammal Expert</th>
                    <th>Accepted</th>
                    <th>Deleted</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)

                    <tr id='{{$user->id}}' onclick="selectRow({{$user->id}})">
                        <td>{{$user->id}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->surname}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->created_at->format('d-m-Y')}}</td>
                        <td>{{$user->level}}</td>
                        <td>{{$user->mammal_expert}}</td>
                        <td>{{$user->confirmed}}</td>
                        <td>{{$user->deleted}}</td>
                    </tr>

                @endforeach

                </tbody>
            </table>
        </div>
    </div>

    <script type="text/javascript">
        function selectRow(id){
            $('[class="success"]').attr("class","");
            $("#"+id).attr("class","success");
        };
    </script>
@endsection