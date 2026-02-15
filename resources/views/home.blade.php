<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $seo['title'] ? $seo['title'] : 'Tessart. Дизайн бюро.' }}</title>
    @foreach($metas as $meta => $params)
        @if ($seo[$meta])
            <meta {{ $params['name'] ? 'name='.$params['name'] : 'property='.$params['property'] }} content="{{ $seo[$meta] }}">
        @endif
    @endforeach

    <meta property="og:image:width" content="200" />
    <meta property="og:image:height" content="200" />

    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap-switch.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-toggle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/components.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('css/icons/icomoon/styles.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/icons/fontawesome/styles.min.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/text-block.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/nav_styles.css') }}" rel="stylesheet" type="text/css">

    <!-- Core JS files -->
    <script type="text/javascript" src="{{ asset('js/core/libraries/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/core/libraries/bootstrap.min.js') }}"></script>
    <!-- /core JS files -->

    <script type="text/javascript" src="{{ asset('js/plugins/forms/styling/uniform.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/forms/styling/bootstrap-switch.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/forms/styling/switchery.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('js/plugins/media/fancybox.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/ui/moment/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/pickers/daterangepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/pages/components_thumbnails.js') }}"></script>

    <script type="text/javascript" src="{{ asset('js/core/main.controls.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.maskedinput.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/feedback.js') }}"></script>

    {{--<script type="text/javascript" src="/js/jquery.stellar.min.js"></script>--}}
    <script src="{{ asset('js/jquery.easing.1.3.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/main.js') }}" type="text/javascript"></script>
</head>
<body>

@include('layouts._modal_block',['id' => 'message', 'message' => trans('content.thanks_for_your_message')])
@include('layouts._feedback_modal_block')
@include('layouts._nav_block')

<div id="on_top_button"><i class="glyphicon glyphicon-upload"></i></div>

<?php $slides = ''; ?>
@for ($i=0;$i<count($data);$i++)
    <style>
        @media screen and (min-width: 768px)
        {
            .slide.slide{{ $data[$i]->id }} > .image-block
            {
                width: {{ $data[$i]->image_part }}%;
            }

            .slide.slide{{ $data[$i]->id }} > .text-block
            {
                width: {{ 100 - $data[$i]->image_part }}%;
            }
        }
    </style>

    <?php ob_start(); ?>
    @include('_slide_block',['data' => $data[$i], 'next' => ($i != count($data)-1 ? str_slug($data[$i+1]->name) : null)])
    <?php $slides .= ob_get_clean(); ?>

    @if (!$i)
        <script>window.topSlide = "{{ str_slug($data[$i]->name) }}";</script>
    @endif
@endfor

{!! $slides !!}

<div class="soc-icons-container">
    <a href="https://www.facebook.com/groups/744986978859697/" target="_blank"><i class="fa fa-facebook-official"></i></a>
    <a href="https://vk.com/club65896194" target="_blank"><i class="fa fa-vk"></i></a>
    {{--<a href="" target="_blank"><i class="fa fa-instagram"></i></a>--}}
    {{--<a href="" target="_blank"><i class="fa fa-linkedin"></i></a>--}}
    {{--<a href="" target="_blank"><i class="fa fa-google-plus-square"></i></a>--}}

    <div class="copyright">© 2019 TessART</div>
</div>

</body>
</html>
