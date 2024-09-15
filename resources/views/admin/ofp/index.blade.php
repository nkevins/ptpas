<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('css/adminlte.min.css')}}" />

    <title>GIA OFP</title>
</head>
<body>
<h3 class="text-center">GIA OFP</h3>
<hr />

<div class="container">
    <div class="row">
        <div class="col-md">
            @include('flash::message')
            <form action="{{action('GiaOfpController@generate')}}" method="POST" class="mt-3">
                @csrf
                <div class="form-row">
                    <div class="col">
                        <input type="text" class="form-control" name="simbriefPilotId" placeholder="Simbrief Pilot ID" required />
                    </div>
                </div>
                <div class="form-row mt-1">
                    <div class="col">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-print"></i> Print</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

</body>
</html>
