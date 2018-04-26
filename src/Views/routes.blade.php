<!doctype html>
<html lang="{{ App::getLocale() }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>@lang('laravel-routes::routes.title')</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/3.13.3/swagger-ui.css">
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $(document).on('click', '.opblock-summary', function(){
                    $(this).closest('.opblock').find('.opblock-body').slideToggle("slow");
                });
            });
        </script>

    </head>
    <body>
        <section id="routes" class="doc-section swagger-ui">
            <h2 class="section-title">@lang('laravel-routes::routes.header')</h2>
            <div class="section-block">
                @foreach($routes as $route)
                    <div class="opblock opblock-{{ $route->getMethodClass() }}">
                        <div class="opblock-summary opblock-summary-{{ $route->getMethodClass() }}">
                            <span class="opblock-summary-method">{{ $route->method }}</span>
                            <span class="opblock-summary-path">
                                                            <a class="nostyle">
                                                                <span>{{ $route->uri }}</span>
                                                            </a>
                                                            <img src="data:image/svg+xml;base64,PHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJMYXllcl8xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDI0IDI0IiBlbmFibGUtYmFja2dyb3VuZD0ibmV3IDAgMCAyNCAyNCIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+CjxwYXRoIGQ9Ik0xOSA3djRINS44M2wzLjU4LTMuNTlMOCA2bC02IDYgNiA2IDEuNDEtMS40MUw1LjgzIDEzSDIxVjd6Ii8+Cjwvc3ZnPgo=" class="view-line-link">
                                                        </span> <!-- opblock-summary-path -->
                            <div class="opblock-summary-description">{{ $route -> comment }}</div>
                            <button class="authorization__btn unlocked" aria-label="authorization button unlocked">
                                <svg width="20" height="20">
                                    <use href="#unlocked" xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#unlocked"></use>
                                </svg>
                            </button>
                        </div> <!-- opblock-summary -->
                        <div class="opblock-body" style="display: none;"><!-- react-text: 1914 --><!-- /react-text -->
                            <div class="opblock-section">
                                <div class="opblock-section-header">
                                    <div class="tab-header">
                                        <h4 class="opblock-title">@lang('laravel-routes::routes.section')</h4>
                                    </div>
                                </div> <!-- opblock-section-header -->
                                <div class="table-container">
                                    <table class="parameters">
                                        <thead>
                                        <tr>
                                            <th class="col col_header parameters-col_name">@lang('laravel-routes::routes.route-name')</th>
                                            <th class="col col_header parameters-col_controller">@lang('laravel-routes::routes.controller')</th>
                                            <th class="col col_header parameters-col_middleware">@lang('laravel-routes::routes.middleware')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td class="col parameters-col_name">
                                                <div class="markdown">{{ $route -> name != null ? $route -> name : __('laravel-routes::routes.route-nameless') }}</div>
                                            </td>
                                            <td class="col parameters-col_controller">
                                                <div class="markdown"> {{ $route -> action }}</div>
                                            </td>
                                            <td class="col parameters-col_middleware">
                                                <div class="markdown"> {{ $route -> middleware }} </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div> <!-- table-container -->
                            </div> <!-- opblock-section -->

                            <div class="opblock-section">
                                <div class="opblock-section-header">
                                    <div class="tab-header">
                                        <h4 class="opblock-title">@lang('laravel-routes::routes.params')</h4>
                                    </div>
                                </div> <!-- opblock-section-header -->
                                @if($route->params->isEmpty())
                                    <div class="opblock-description-wrapper"><p>@lang('laravel-routes::routes.no-params')</p></div>
                                @else
                                    <div class="table-container">
                                        <table class="parameters">
                                            <thead>
                                            <tr>
                                                <th class="col col_header parameters-col_name">@lang('laravel-routes::routes.param-name')</th>
                                                <th class="col col_header parameters-col_controller">@lang('laravel-routes::routes.description')</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($route -> params as $param)
                                                    <tr>
                                                        <td class="col parameters-col_name">
                                                            <div class="markdown">{{ $param -> name }}</div>
                                                        </td>
                                                        <td class="col parameters-col_controller">
                                                            <div class="markdown"> {{ $param -> description }}</div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div> <!-- opblock-section -->
                        </div> <!-- opblock-body -->
                    </div> <!-- opblock -->
                @endforeach
            </div> <!-- opblock -->
        </section><!--//doc-section-->
    </body>
</html>

