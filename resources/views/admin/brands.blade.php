@extends('layouts.admin')
@section('content')
       <div class="main-content-inner">
                            <div class="main-content-wrap">
                                <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                                    <h3>Brands</h3>
                                    <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                                        <li>
                                            <a href="{{ route('admin.index') }}">
                                                <div class="text-tiny">Dashboard</div>
                                            </a>
                                        </li>
                                        <li>
                                            <i class="icon-chevron-right"></i>
                                        </li>
                                        <li>
                                            <div class="text-tiny">Brands</div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="wg-box">
                                    <div class="flex items-center justify-between gap10 flex-wrap">
                                        <div class="wg-filter flex-grow">
                                            <form class="form-search">
                                                <fieldset class="name">
                                                    <input type="text" placeholder="Search here..." class="" name="name"
                                                        tabindex="2" value="" aria-required="true" required="">
                                                </fieldset>
                                                <div class="button-submit">
                                                    <button class="" type="submit"><i class="icon-search"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                        <a class="tf-button style-1 w208" href="{{ route('admin.add.brand') }}"><i
                                                class="icon-plus"></i>Add new</a>
                                    </div>
                                    <div class="wg-table table-all-user">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Name</th>
                                                        <th>Slug</th>
                                                        <th>Products</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($brands as $brand)
                                                    <tr>
                                                        <td>{{ $brand->id }}</td>
                                                        <td class="pname">
                                                            <div class="image">
                                                                @if($brand->image && file_exists(public_path('uploads/brands/' . $brand->image)))
                                                                    <img src="{{ asset('uploads/brands/' . $brand->image) }}" alt="{{ $brand->name }}" class="image">
                                                                @else
                                                                    <div class="no-image-placeholder">
                                                                        <i class="icon-image"></i>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="name">
                                                                <a href="#" class="body-title-2">{{ $brand->name }}</a>
                                                            </div>
                                                        </td>
                                                        <td>{{ $brand->slug }}</td>
                                                        <td><a href="#" target="_blank">0</a></td>
                                                        <td>
                                                            <div class="list-icon-function">
                                                                <a href="{{ route('admin.brand.edit', $brand->id) }}">
                                                                    <div class="item edit">
                                                                        <i class="icon-edit-3"></i>
                                                                    </div>
                                                                </a>
                                                                <form action="#" method="POST">
                                                                    <div class="item text-danger delete">
                                                                        <i class="icon-trash-2"></i>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="divider"></div>
                                        <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                                            {{ $brands->links('pagination::bootstrap-5') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
@endsection

@push('styles')
<style>
    .no-image-placeholder {
        width: 50px;
        height: 50px;
        background-color: #f8f9fa;
        border: 2px dashed #dee2e6;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
        color: #6c757d;
        font-size: 20px;
    }
    .image img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 4px;
    }
</style>
@endpush
