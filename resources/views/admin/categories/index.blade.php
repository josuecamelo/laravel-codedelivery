@extends('app')
@section('content')

    <div class="container">
        <h3>Categories</h3>
        <br />
        <a href="{{ route('admin.categories.create')  }}" class="btn btn-default">Nova Categoria</a>
        <br /><br />

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th>Ação</th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>
                        <a class="btn btn-default btn-sm" href="{{ route('admin.categories.edit', $category->id)  }}">Editar</a>
                    </td>
                </tr>
            </tbody>
            @endforeach
        </table>
        {!! $categories->render()  !!}
    </div>
@endsection