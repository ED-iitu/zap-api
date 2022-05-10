@extends('layouts.app')
@section('content')

    <div class="container">
        <h1>Импорт товаров</h1>
        <div class="mb-4 d-flex justify-content-between">
            <div>
                <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="importFile" id="importFile" class="@error('importFile') is-invalid @enderror">
                    <button class="btn btn-outline-secondary">Import</button>
                    @error('importFile')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </form>
            </div>
        </div>
    </div>

@endsection