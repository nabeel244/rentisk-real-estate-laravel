@extends('tenant.layout')
@section('title')
    <title>{{__('tenant.Dashboard')}}</title>
@endsection
@section('tenant-dashboard')
<div class="row">

    <div class="col-12 col-xl-9 ms-auto">
        <div class="wsus__dashboard_main_content">
            <div class="wsus__manage_dashboard">
                <h4 class="heading">{{__('user.Dashboard')}}</h4>
                <div class="row">
                    <div class="col-xl-4 col-sm-6 col-md-4">
                        <div class="wsus__manage_single">
                            <i class="far fa-list"></i>
                            {{-- <span>{{ $publishProperty }}</span> --}}
                            <p>{{__('user.Published Property')}}</p>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6 col-md-4">
                        <div class="wsus__manage_single green">
                          <i class="fab fa-buromobelexperte"></i>
                            {{-- <span>{{ $expiredProperty }}</span> --}}
                            <p>{{__('user.Expired Property')}}</p>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6 col-md-4">
                        <div class="wsus__manage_single sky">
                            <i class="far fa-list"></i>
                            {{-- <span>{{ $myReviews }}</span> --}}
                            <p>{{__('user.My Reviews')}}</p>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6 col-md-4">
                      <div class="wsus__manage_single blue">
                          <i class="far fa-list"></i>
                          {{-- <span>{{ $clientReviews }}</span> --}}
                          <p>{{__('user.Client Reviews')}}</p>
                      </div>
                    </div>
                    <div class="col-xl-4 col-sm-6 col-md-4">
                        <div class="wsus__manage_single orange">
                            <i class="far fa-list"></i>
                            {{-- <span>{{ $wishlists->count() }}</span> --}}
                            <p>{{__('user.Wishlists')}}</p>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6 col-md-4">
                        <div class="wsus__manage_single purple">
                            <i class="far fa-list"></i>
                            {{-- <span>{{ $orders->count() }}</span> --}}
                            <p>{{__('user.Orders')}}</p>
                        </div>
                    </div>
                    {{-- @if ($activeOrder) --}}

                    {{-- @endif --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
