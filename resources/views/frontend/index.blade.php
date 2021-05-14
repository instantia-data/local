@extends(config('view.themes.frontend'))

@section('title')
{{$infos->title}}
@endsection

@section('meta-description')
{{$infos->short_description}}
@endsection

@section('header')
<div class="first-top hidding-sync" id="row-logo">
    <div class="row p-3 px-4">
        <div class="col-2 mx-auto px-5">
            <img class="img-fluid" src="/logos/incluirmais.png" alt="{{env('APP_NAME')}} {{env('APP_DESCRIPTION')}}" title="{{env('APP_DESCRIPTION')}}" />
        </div>
    </div>
</div>
@endsection

@section('css')
<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
<link href="/css/instantia/local/local.css?v=@version()" rel="stylesheet" />
<style>

</style>
<!-- ================== END PAGE LEVEL STYLE ================== -->
@endsection

@section('content')


<section class="page-section mb-0 pt-4" id="page">
    <div class="container">
        <!-- About Section Heading-->
        <h2 class="page-section-heading text-center text-uppercase"></h2>
        <!-- Icon Divider-->
        <div class="divider-custom">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-plus"></i></div>
            <div class="divider-custom-line"></div>
        </div>
        
        
        <!-- About Section Content-->
        <div class="row">
            
        </div>
        <!-- About Section Button-->
        <div class="text-center mt-4">
            
        </div>
    </div>
</section>



@endsection

@section('scripts')
<script src="/js/instantia/local/local.js?v=@version()"></script>
<script>
    

</script>
@endsection
