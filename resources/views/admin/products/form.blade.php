@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading mb-3">{{$title}}</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ $action }}" enctype="multipart/form-data">
                            @if (isset($product->id))
                                {{ method_field('PUT') }}
                            @endif
                            @csrf

                            <div class="form-group">
                                <select class="custom-select" id="inputGroupSelect01" name="company_id">
                                    <option selected>Выберите поставщика</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" name="name" value="{{ $product->name ?? '' }}" placeholder="Название">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" aria-label="With textarea" name="description" placeholder="Описание">{{$product->description ?? ''}}</textarea>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="article" value="{{ $product->article ?? '' }}" placeholder="Артикул">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="brand" value="{{ $product->brand ?? '' }}" placeholder="Бренд">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="price" value="{{ $product->price ?? '' }}" placeholder="Цена">
                            </div>
                            <div class="form-group">
                                <input type="file" class="form-control" name="image">
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    Сохранить
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection