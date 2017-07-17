<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport"/>
        <meta content="" name="description"/>
        <meta content="" name="author"/>
        <link href="../favicon.png" rel="icon"/>
        <title>
            consulting-mh
        </title>
        <!-- Bootstrap core CSS -->
        <!-- Latest compiled and minified CSS -->
        <link crossorigin="anonymous" href="/css/bootstrap.css" integrity="sha384-HuL8ZzStQK3/8pSKLj0lK43YwutcGS9zbMevycvDwl9QO4eGM5eQMRojPcVkEN4F" rel="stylesheet"/>
        <!-- Optional theme -->
        <link crossorigin="anonymous" href="/css/bootstrap-theme.css" integrity="sha384-87IgyAZ7ZPkMKNvliJR8lR09U+LMadREF430SkYRoNaFd+l2lhZnI1cXRdWnAZ+3" rel="stylesheet"/>
        {{-- Custom CSS --}}
        <link href="/css/custom.css" rel="stylesheet"/>
    </head>

    <body>
        <div class="container-fluid">
            <div class="row">
                @include('layouts/nav')
            </div>
            <div class="row keep_footer">
                <div class="col-md-12 col-lg-10 col-lg-offset-1 ">
                    <div class="panel panel-transparent ">
                        @yield('content')

                        @yield('form')
                    </div>
                </div>
            </div>
        <div class="row">
        	@include('layouts/footer')
        </div>
    </div>
</body>
</html>
