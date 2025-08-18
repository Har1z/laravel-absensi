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
        <div class="col-12 mb-4">
            <div class="rounded-1 p-3" style="background-color: white !important;">
                <a href="{{ route('data-admin.create') }}" class="btn btn-success">
                    Tambah Admin
                </a>
            </div>
        </div>
        <div class="col-12">
            <div class="rounded-1 p-3" style="background-color: white !important;">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Nama</th>
                            <th scope="col">Email</th>
                            <th scope="col" class="text-center">Unit</th>
                            <th scope="col" class="text-center">#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($userHash as $userId => $item)
                            <tr onclick="window.location.href = '{{ route('data-admin.show', $userId) }}'" style="cursor: pointer">
                                <td>{{ $item['name'] }}</td>
                                <td>{{ $item['email'] }}</td>
                                <td class="text-center">
                                    @foreach ($item['sections'] as $userSection)
                                        {{ $userSection }}
                                    @endforeach
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('data-admin.destroy', $userId) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('modal')

@endsection

@section('custom-scripts')
@endsection
