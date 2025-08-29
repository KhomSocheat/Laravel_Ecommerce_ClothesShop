@extends('layouts.admin')

@section('content')
      <div class="main-content-inner">
                            <div class="main-content-wrap">
                                <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                                    <h3>Brand infomation</h3>
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
                                            <a href="{{ route('admin.brands') }}">
                                                <div class="text-tiny">Brands</div>
                                            </a>
                                        </li>
                                        <li>
                                            <i class="icon-chevron-right"></i>
                                        </li>
                                        <li>
                                            <div class="text-tiny">Edit Brand</div>
                                        </li>
                                    </ul>
                                </div>
                                <!-- new-category -->
                                <div class="wg-box">
                                    <form class="form-new-product form-style-1" action="{{ route('admin.brand.update', $brand->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                          
                                        <fieldset class="name">
                                            <div class="body-title">Brand Name <span class="tf-color-1">*</span></div>
                                            <input class="flex-grow" type="text" placeholder="Brand name" name="name"
                                                tabindex="0" value="{{ $brand->name }}" aria-required="true" required="">
                                        </fieldset>
                                        @error('name')
                                            <span class="alert alert-danger text-center">{{ $message }}</span>
                                        @enderror
                                        <fieldset class="name">
                                            <div class="body-title">Brand Slug <span class="tf-color-1">*</span></div>
                                            <input class="flex-grow" type="text" placeholder="Brand Slug" name="slug"
                                                tabindex="0" value="{{ $brand->slug }}" aria-required="true" required="">
                                        </fieldset>
                                        @error('slug')
                                            <span class="alert alert-danger text-center">{{ $message }}</span>
                                        @enderror
                                        <fieldset>
                                            <div class="body-title">Upload images <span class="tf-color-1">*</span>
                                            </div>
                                            <div class="upload-image flex-grow">
                                                @if($brand->image)
                                                    <div class="item" id="imgpreview" >
                                                        <img src="{{ asset('uploads/brands') }}/{{ $brand->image }}" class="effect8" alt="" id="preview-img">
                                                        {{-- <div class="overlay">
                                                            <button type="button" class="btn-remove" id="remove-preview">×</button>
                                                        </div> --}}
                                                    </div>
                                                @endif
                                                <div id="upload-file" class="item up-load">
                                                    <label class="uploadfile" for="myFile">
                                                        <span class="icon">
                                                            <i class="icon-upload-cloud"></i>
                                                        </span>
                                                        <span class="body-text">Drop your images here or select <span
                                                                class="tf-color">click to browse</span></span>
                                                        <input type="file" id="myFile" name="image" accept="image/*">
                                                    </label>
                                                </div>
                                            </div>
                                        </fieldset>
                                        @error('image')
                                            <span class="alert alert-danger text-center">{{ $message }}</span>
                                        @enderror
                                        <div class="bot">
                                            <div></div>
                                            <button class="tf-button w208" type="submit">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function(){
            console.log('Document ready - jQuery loaded:', typeof $ !== 'undefined');

            $("#myFile").on("change",function(e){
                console.log('File input changed');
                const file = this.files[0];
                console.log('Selected file:', file);

                if(file){
                    // Check if file is an image
                    if (!file.type.startsWith('image/')) {
                        alert('Please select an image file');
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e){
                        console.log('File read successfully');
                        $("#preview-img").attr('src', e.target.result);
                        $("#imgpreview").show();
                        $("#upload-file").hide();
                    }
                    reader.onerror = function(e){
                        console.error('Error reading file:', e);
                    }
                    reader.readAsDataURL(file);
                } else {
                    console.log('No file selected');
                }
            });

            // Remove preview functionality
            $("#remove-preview").on("click", function(e){
                e.preventDefault();
                console.log('Remove preview clicked');
                $("#preview-img").attr('src', '');
                $("#imgpreview").hide();
                $("#upload-file").show();
                $("#myFile").val(''); // Clear the file input
            });

            $("input[name='name']").on("change keyup",function(){
                const slug = StringToSlug($(this).val());
                console.log('Generated slug:', slug);
                $("input[name='slug']").val(slug);
            });
        });

        function StringToSlug(Text){
            return Text.toLowerCase()
                .replace(/[^\w\s-]/g, '') // Remove special characters
                .replace(/[\s_-]+/g, '-') // Replace spaces and underscores with hyphens
                .replace(/^-+|-+$/g, ''); // Remove leading/trailing hyphens
        }
    </script>

    <style>
        .item {
            position: relative;
        }
        .overlay {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .btn-remove {
            background: rgba(255, 0, 0, 0.8);
            color: white;
            border: none;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            cursor: pointer;
            font-size: 16px;
            line-height: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .btn-remove:hover {
            background: rgba(255, 0, 0, 1);
        }
        #imgpreview img {
            max-width: 100%;
            max-height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }
        .upload-image .item {
            border: 2px dashed #ddd;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
        }
    </style>
@endpush
