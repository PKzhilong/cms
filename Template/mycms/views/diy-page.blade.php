@include("template::mycms.views._header")
<main class="main">

    <!-- Start Breadcrumb
    ============================================= -->
    <div class="site-breadcrumb" style="background: url(/mycms/cms/theme/mycms/assets/img/breadcrumb/breadcrumb.jpg)">
        <div class="container">
            <h1 class="breadcrumb-title">{{$diyPage->page_name}}</h1>
            <ul class="breadcrumb-menu clearfix">
                <li><a href="{{home_path()}}">网站首页</a></li>
                <li class="active">{{$diyPage->page_name}}</li>
            </ul>
        </div>
    </div>
    <!-- End Breadcrumb -->

    <!-- Start Blog Single
    ============================================= -->
    <div class="blog-single-area de-padding">
        <div class="container">
            <div class="blog-single-wpr">
                <div class="row ps g-xl-5">
                    {!! $diyPage->page_content !!}
                </div>
            </div>
        </div>
    </div>
    <!-- End Product -->

</main>

<div class="clearfix"></div>
@include("template::mycms.views._footer")
