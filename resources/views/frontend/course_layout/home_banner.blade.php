<!-- Add this in your <head> section or main CSS file -->
    @push('styles')
<style>
    .breadcrumb-bg {
        background-image: url('frontend/assets/img/bg/bg-23.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        padding: 200px 0; 
        margin-top: 80px; /* Adjust this value as needed */
        
    }
</style>
@endpush
<!-- Breadcrumb Bar Section -->
<div class="breadcrumb-bar text-center breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title mb-2" style="color: white !important; ">Courses</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center mb-0">
                        <li class="breadcrumb-item" ><a href="{{ route('frontend.layout.index') }}" style="color: white;">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="color: white;">Courses</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
