<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel Composer</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css" integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous">
    <style>
        body {
            font-size: .875rem;
        }

        .navbar .form-control {
            padding: .75rem 1rem;
            border-width: 0;
            border-radius: 0;
        }

        .form-control-dark {
            color: #fff;
            background-color: rgba(255, 255, 255, .1);
            border-color: rgba(255, 255, 255, .1);
        }

        .form-control-dark:focus {
            border-color: transparent;
            box-shadow: 0 0 0 3px rgba(255, 255, 255, .25);
        }

        /*
         * Utilities
         */

        .border-top { border-top: 1px solid #e5e5e5; }
        .border-bottom { border-bottom: 1px solid #e5e5e5; }
    </style>
</head>
<body>

<div class="container-fluid pt-3">

        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs bg-primary" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link @if($tab == 'home') active @endif" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="@if($tab == 'home') true @else false @endif">Installed Packages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if($tab == 'search') active @endif" id="search-tab" data-toggle="tab" href="#search" role="tab" aria-controls="profile" aria-selected="@if($tab == 'search') true @else false @endif">Search</a>
                    </li>
                </ul>

                <div class="tab-content">

                    <div class="tab-pane fade @if($tab == 'home') show active @endif" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="row ">
                            <div class="col-md-8 col-lg-8">
                                <div>
                                    <main role="main">
                                        <h2>Packages</h2>
                                        <div class="table-responsive table-bordered">
                                            <table class="table table-hover">
                                                <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Version</th>
                                                    <th>Latest</th>
                                                    <th>Description</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if(isset($data['packages']))
                                                    @foreach($data['packages'] as $package)
                                                        <tr>
                                                            <td style="width: 50%">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <strong>

                                                                            <a href="{{ route('laravel-composer.package-details', [
                                                                        'name' => str_replace("/", "_",$package['name'])
                                                                     ]) }}">{{ $package['name'] }}</a>
                                                                        </strong>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <a href="{{ route('laravel-composer.package-download', [
                                                                        'name' => str_replace("/", "_",$package['name']),
                                                                        'version' => $package['version']
                                                                     ]) }}" target="_blank">Download</a> |
                                                                        <a href="{{ route('laravel-composer.package-remove', [
                                                                        'name' => str_replace("/", "_",$package['name'])
                                                                     ]) }}" target="_blank">Remove</a> |

                                                                    </div>
                                                                </div>

                                                            </td>
                                                            <td>{{ $package['version'] }}</td>
                                                            <td @if($package['latest'] != $package['version']) style="color: red" @endif>{{ $package['latest'] }}</td>
                                                            <td style="width: 50%">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        {{ $package['description'] }}
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        @if($package['latest-status'] == 'up-to-date')
                                                                            <span class="badge badge-success">
                                                                       Up to date
                                                                </span>
                                                                        @elseif($package['latest-status'] == 'update-possible')
                                                                            <span class="badge badge-warning"
                                                                                  data-toggle="tooltip"
                                                                                  data-placement="right"
                                                                                  title="From {{ $package['version'] }} to {{ $package['latest'] }}"
                                                                            >Update available</span>
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </main>
                                </div>
                            </div>
                            <div class="col-md-3 col-lg-3">
                                <div>
                                    <main role="main">
                                        <h2>Output</h2>
                                        <div>
                                            <small><code style="color: #1b1e21">{!! Session::has('result') ? nl2br(Session::get("result")) : '' !!}</code></small>
                                        </div>
                                    </main>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="tab-pane fade @if($tab == 'search') show active @endif" id="search" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <br>
                                Get package list
                                <hr>
                                <form class="form-inline" action="{{ route('laravel-composer.package-list') }}" method="get">
                                    <div class="form-group">
                                        <label for="organization" >Organization</label>
                                        <input type="text" class="form-control" id="organization" name="vendor" placeholder="Ex. Composer" value="{{ request('vendor') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="list_type" >Type</label>
                                        <input type="text" class="form-control" id="list_type" name="list_type" placeholder="Ex. composer-plugin" value="{{ request('list_type') }}">
                                    </div>

                                    <span class="form-group bmd-form-group">
                                <button type="submit" class="btn btn-raised btn-primary">Search</button>
                            </span>
                                </form>

                                Search package
                                <hr>
                                <form class="form-inline" action="{{ route('laravel-composer.package-search') }}" method="get">
                                    <div class="form-group">
                                        <label for="q" >Query</label>
                                        <input type="text" class="form-control" id="q" name="q" placeholder="search by query" value="{{ request('q') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="tags" >Tags</label>
                                        <input type="text" class="form-control" id="tags" name="tags" placeholder="Ex. psr-3" value="{{ request('tags') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="search_type" >Type</label>
                                        <input type="text" class="form-control" id="search_type" name="search_type" placeholder="Ex. symfony-bundle" value="{{ request('search_type') }}">
                                    </div>

                                    <span class="form-group bmd-form-group">
                                <button type="submit" class="btn btn-raised btn-primary">Search</button>
                            </span>
                                </form>
                                <table class="table">
                                    @if(isset($result_type) && $result_type == 'list')
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Package</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(isset($packages))
                                            @foreach($packages as $package)
                                                <tr>
                                                    <th scope="row">{{ $loop->iteration }}</th>
                                                    <td>{{ $package }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    @else
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Downloads</th>
                                            <th scope="col">Favers</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(isset($output))
                                            @foreach($output['results'] as $package)
                                                <tr>
                                                    <th scope="row">{{ $loop->iteration }}</th>
                                                    <td>
                                                        {{ $package['name'] }} <br>
                                                        <a href="{{ $package['url'] }}">Packagist</a> |
                                                        <a href="{{ $package['repository'] }}">GitHub</a> |
                                                        <a href="#" data-name="{{ $package['name'] }}" class="detailsView">Details</a>
                                                    </td>
                                                    <td>{{ $package['description'] }}</td>
                                                    <td>{{ $package['downloads'] }}</td>
                                                    <td>{{ $package['favers'] }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    @endif
                                </table>
                            </div>
                            <div class="col-md-6">
                                <div id="log">

                                </div>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
        </div>
</div>


</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://unpkg.com/popper.js@1.12.6/dist/umd/popper.js" integrity="sha384-fA23ZRQ3G/J53mElWqVJEGJzU0sTs+SvzG8fXVWP+kJQ1lwFAOkcUOysnlKJC33U" crossorigin="anonymous"></script>
<script src="https://unpkg.com/bootstrap-material-design@4.1.1/dist/js/bootstrap-material-design.js" integrity="sha384-CauSuKpEqAFajSpkdjv3z9t8E7RlpJ1UP0lKM/+NdtSarroVKu069AlsRPKkFBz9" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() { $('body').bootstrapMaterialDesign(); });
</script>

<script>
    $(document).on('click', '.detailsView', function (event) {
        var request = $.ajax({
            url: '{{ route('laravel-composer.package-readme-view') }}',
            type: "get",
            data: {name :  $(this).data("name")},
            dataType: "html"
        });

        request.done(function(msg) {
            $("#log").html( msg );
        });

        request.fail(function(jqXHR, textStatus) {
            alert( "Request failed: " + textStatus );
        });
    });


</script>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
</html>
