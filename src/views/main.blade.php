{{--First we must check if we extending any view or not--}}
@extends((config('roleManager.extendedView')
AND !!config('roleManager.extendedView')
AND !!config('roleManager.extendedSection'))? config('roleManager.extendedView'):'RoleManager::blank')

@section(config('roleManager.extendedSection'))
    {{-- If isset load bootstrap externaly lets do it--}}

    @if(config('roleManager.externalBootstrap'))
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    @endif

    {{--Main section--}}
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-body">
                @include('RoleManager::_nav')

                @yield('roleManager-content')

            </div>
        </div>

    </div>

    {{-- If isset load bootstrap and jquery externaly lets do it--}}

    @if(config('roleManager.externalJquery'))
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"
                integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
                crossorigin="anonymous"></script>
    @endif
    @if(config('roleManager.externalBootstrap'))
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    @endif
@endsection

