@extends('layouts.default-guru')

@section('title')
    Data Admin - Lab Attendance
@endsection

@section('heading')
    Data Admin
@endsection

@section('custom-style')
    <!-- Custom styles for this page -->
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="rounded-1 p-3" style="background-color: white !important;">
                <form method="POST" action="{{ route('data-admin.update', $user->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama</label>
                        <input name="name" type="text" class="form-control @error('name')
                            is-invalid
                        @enderror" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ $user->name }}">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Email</label>
                        <input name="email" type="email" class="form-control @error('email')
                            is-invalid
                        @enderror" id="exampleInputPassword1" value="{{ $user->email }}">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Ganti Password</label>
                        <input name="new_password" type="password" class="form-control @error('new_password')
                            is-invalid
                        @enderror" id="exampleInputEmail1" aria-describedby="emailHelp" value="">
                        @error('new_password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Unit</label>
                        @foreach ($sections as $section)
                            <div class="form-check">
                                <input class="form-check-input" {{ in_array($section['id'], $userSections) ? 'checked' : '' }} name="section[]" type="checkbox" value="{{ $section['id'] }}" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                    {{ $section['name'] }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <a href="{{ route('data-admin.index') }}" class="btn btn-danger">Batal</a>
                    <button type="submit" class="btn btn-warning">Edit</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('modal')

@endsection

@section('custom-scripts')
@endsection
