@extends('admin.master_layout')
@section('title')
    <title>{{ __('admin.Footer') }}</title>
@endsection
@section('admin-content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('admin.Footer') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a
                            href="{{ route('admin.dashboard') }}">{{ __('admin.Dashboard') }}</a></div>
                    <div class="breadcrumb-item">{{ __('admin.Footer') }}</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-end">
                                    <b>{{ __('admin.Translations') }}</b>
                                </div>
                                <div class="d-flex justify-content-end">
                                    @forelse($languages as $key => $language)
                                        <i
                                            class="fa {{ $footer->translation($language->code)?->first()?->address ? 'fa-check' : 'fa-edit' }}"></i>
                                        <a
                                            href="{{ route('admin.footer.translation', ['id' => $footer->id, 'code' => $language->code]) }}">{{ strtoupper($language->code) }}</a>
                                        @if (!$loop->last)
                                            ||
                                        @endif
                                    @empty
                                        <a
                                            href="{{ route('admin.footer.translation', ['id' => $footer->id, 'code' => $language->code]) }}">{{ strtoupper(config('app.locale')) }}</a>
                                    @endforelse
                                </div>
                                <form action="{{ route('admin.footer.update', $footer->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label>{{ __('admin.Email') }} <span class="text-danger">*</span></label>
                                            <input type="email" name="email" class="form-control"
                                                value="{{ $footer->email }}">
                                        </div>

                                        <div class="form-group col-12">
                                            <label>{{ __('admin.Phone') }} <span class="text-danger">*</span></label>
                                            <input type="text" name="phone" class="form-control"
                                                value="{{ $footer->phone }}">
                                        </div>

                                        <div class="form-group col-12">
                                            <label>{{ __('admin.Address') }} <span class="text-danger">*</span></label>
                                            <input type="text" name="address" class="form-control"
                                                value="{{ $footer->address }}">
                                        </div>

                                        <div class="form-group col-12">
                                            <label>{{ __('admin.First Column Title') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="first_column" class="form-control"
                                                value="{{ $footer->first_column }}">
                                        </div>

                                        <div class="form-group col-12">
                                            <label>{{ __('admin.Second Column Title') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="second_column" class="form-control"
                                                value="{{ $footer->second_column }}">
                                        </div>

                                        <div class="form-group col-12">
                                            <label>{{ __('admin.Third Column Title') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="third_column" class="form-control"
                                                value="{{ $footer->third_column }}">
                                        </div>





                                        <div class="form-group col-12">
                                            <label>{{ __('admin.Copyright') }} <span class="text-danger">*</span></label>
                                            <input type="text" name="copyright" class="form-control"
                                                value="{{ $footer->copyright }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <button class="btn btn-primary">{{ __('admin.Update') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
@endsection
