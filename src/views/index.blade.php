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
    <div class="row justify-content-md-center">
        <div class="card col-md-8 col-lg-8">
            <div class="card-body">
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
                            @foreach($packages as $package)
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
                            </tbody>
                        </table>
                    </div>
                </main>
            </div>
        </div>
        <div class="card col-md-3 col-lg-3">
            <div class="card-body">
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


</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://unpkg.com/popper.js@1.12.6/dist/umd/popper.js" integrity="sha384-fA23ZRQ3G/J53mElWqVJEGJzU0sTs+SvzG8fXVWP+kJQ1lwFAOkcUOysnlKJC33U" crossorigin="anonymous"></script>
<script src="https://unpkg.com/bootstrap-material-design@4.1.1/dist/js/bootstrap-material-design.js" integrity="sha384-CauSuKpEqAFajSpkdjv3z9t8E7RlpJ1UP0lKM/+NdtSarroVKu069AlsRPKkFBz9" crossorigin="anonymous"></script>


<script>$(document).ready(function() { $('body').bootstrapMaterialDesign(); });</script>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
</html>
