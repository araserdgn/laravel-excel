<!DOCTYPE html>
<html>

<head>
    <title>Laravel 9 Import Export Excel & CSV File to Database Example - LaravelTuts.com</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container">
        <div class="card mt-3 mb-3">
            <div class="card-header text-center">
                <h4>Laravel Excell Deneme</h4>
            </div>
            <div class="card-body">


                @if (isset($errors) && $errors->any())
                    <div class="alert alert-danger text-center">
                        @foreach ($errors->all() as $error)
                            {{ $error }}<br>
                        @endforeach
                    </div>
                @endif


                <form action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" class="form-control">

                    <br>
                    <button class="btn btn-primary">Import User Data</button>
                </form>

                <table class="table table-bordered mt-3 text-center">
                    <tr>
                        <th colspan="3">
                            Kişi Listeleri
                            <a class="btn btn-danger float-end" href="{{ route('users.export') }}">Export User Data</a>
                        </th>
                    </tr>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                    </tr>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone_no }}</td>
                    </tr>
                    @endforeach
                </table>

            </div>
        </div>
    </div>

</body>

</html>
