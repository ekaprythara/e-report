@extends('/layouts/main')

@section('body')
    <div class="h1 fw-bold">Level</div>
    <div class="container-fluid rounded p-3 bg-white mb-3">
        <div class="table-responsive p-0 pt-3 pb-3">
            <table id="tb-level" class="table table-bordered table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Level</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($levels as $level)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $level->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
