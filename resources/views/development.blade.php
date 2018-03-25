@extends('layouts.development-single')

@section('title')
    {{$development->development_name}}
@endsection


@section('content')
    <div class="clearfix padding-top-40">
        <div class="col-md-10 single-property-content ">
            <div class="row">
                <div class="light-slide-item">
                    <div class="clearfix">
                        <div class="favorite-and-print">
                            <a class="printer-icon " href="javascript:window.print()">
                                <i class="fa fa-print"></i>
                            </a>
                        </div>

                        <ul id="image-gallery" class="gallery list-unstyled cS-hidden">
                            <li data-thumb="{{$development->photo->file}}">
                                <img src="{{$development->photo->file}}" />
                            </li>

                            @foreach($development->houseTypes as $houseType)
                                <li data-thumb="{{$houseType->house_photo->file}}">
                                    <img src="{{$houseType->house_photo->file}}" />
                                </li>
                                <li data-thumb="{{$houseType->photo->file}}">
                                    <img src="{{$houseType->photo->file}}" />
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="single-property-wrapper">
                <div class="section">
                    <h4 class="s-property-title">Development Description</h4>
                    <div class="s-property-content">
                        {{$development->development_description}}
                    </div>
                </div>
                <!-- End description area  -->

                <div class="section additional-details">

                    <h4 class="s-property-title">Development Plots</h4>

                    <table class="table" id="myTable">
                        <thead>
                            <tr>
                                <th>Development Name</th>
                                <th>Plot Name</th>
                                <th>House Type</th>
                                <th>SqFt</th>
                                <th>Phase</th>
                                <th>Status</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($plots as $plot)
                            <tr>
                                <td>{{$plot->development ? $plot->development->development_name : "Development Not Set" }}</td>
                                <td><a href="{{route('admin.plots.edit', $plot->id)}}">{{$plot->plot_name}}</a></td>
                                <td>{{$plot->houseTypes ? $plot->houseTypes->house_type_name : "NOT FOUND"}}</td>
                                <td>{{$plot->sqft}}</td>
                                <td>{{$plot->phases->phase_name}}</td>
                                <td>{{$plot->status}}</td>
                                <td>£{{number_format($plot->houseTypes->house_type_price, 2)}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="section property-video">
                    <h4 class="s-property-title">Example Property Tour</h4>
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="video-popup" src="https://my.matterport.com/show/?m=2UKkSrVmbNt&amp;play=1&amp;guides=0&amp;kb=0" frameborder="0" allowfullscreen="" allow="vr"></iframe>

                    </div>
                </div>
                <!-- End video area  -->
            </div>
        </div>

        <div class="col-md-2 p0">
            <aside class="sidebar-property blog-asside-right" style="margin-top: 0px !important;">
                <div class="dealer-widget">
                    <div class="dealer-content">
                        <div class="inner-wrapper">

                            <div class="clear">
                                <div class="col-xs-12 col-sm-12 ">
                                    <h3 class="dealer-name">
                                        <a href="">Nathan James</a><br>
                                    </h3>
                                    <div class="dealer-social-media">
                                        <a class="twitter" target="_blank" href="">
                                            <i class="fa fa-twitter"></i>
                                        </a>
                                        <a class="facebook" target="_blank" href="">
                                            <i class="fa fa-facebook"></i>
                                        </a>
                                        <a class="gplus" target="_blank" href="">
                                            <i class="fa fa-google-plus"></i>
                                        </a>
                                        <a class="linkedin" target="_blank" href="">
                                            <i class="fa fa-linkedin"></i>
                                        </a>
                                        <a class="instagram" target="_blank" href="">
                                            <i class="fa fa-instagram"></i>
                                        </a>
                                    </div>

                                </div>
                            </div>

                            <div class="clear">
                                <ul class="dealer-contacts">
                                    <li><i class="pe-7s-map-marker strong"> </i> 9089 your adress her</li>
                                    <li><i class="pe-7s-mail strong"> </i> email@yourcompany.com</li>
                                    <li><i class="pe-7s-call strong"> </i> +1 908 967 5906</li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>


                <div class="panel panel-default sidebar-menu similar-property-wdg wow fadeInRight animated">
                    <div class="panel-heading">
                        <h3 class="panel-title">House Types</h3>
                    </div>
                    <div class="panel-body recent-property-widget">
                        <ul>
                            @foreach($development->houseTypes as $type)
                                <li>
                                    <div class="col-xs-12 blg-thumb p0">
                                        <a href=""><img src="{{$type->house_photo->file}}" class="img-rounded"></a>
                                    </div>
                                    <div class="col-xs-12 blg-entry">
                                        <h6><a href="single.html">{{$type->house_type_name}} </a></h6>
                                        <span class="property-price">Price from: <b>£{{$type->house_type_price}}</b></span>
                                        <hr>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </aside>
        </div>
    </div>
@endsection