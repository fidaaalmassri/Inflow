@extends('layouts.dashboard')
@section('socialMedia','active')
@section("title", "حسابات التواصل الإجتماعي")
@section("css")


<style>

.social .profile-header {
    box-shadow: inset 0 0 0 2000px rgb(158 46 150 / 82%) !important ;
}


</style>
@endsection

@section("content")

    @if(session('message_flash'))
        <div class="alert alert-success">
            {{session('message_flash')}}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{session('error')}}
        </div>
    @endif
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="card social">
                <div class="profile-header d-flex justify-content-between justify-content-center">
                    <div class="d-flex">
                        <div class="mr-3">
                            <img src="{{asset('assets/images/user-small.png') }}" class="rounded" alt="">
    
    
                            </div>
                        
                       <strong>{{$user->name }} 
                    
                        <div class="details">
                            <h5 class="mb-2"></h5>
                     @if($user->role_id == 1)
                            <span class="text-light">مؤثر </span>
                            @else
                            <span class="text-light"> شركة</span>
@endif
                   
                        </div>
                    </strong>


                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-lg-8 col-md-7">
           
            <div class="card">
                <div class="header">
                    <h2>ملفات التعريف على مواقع التواصل الإجتماعي </h2>
                </div>
                <div class="row clearfix">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-hover table-custom spacing8">
                                <thead>
                                <tr>
                                    <th>البرنامج</th>
                                    <th>الحساب</th>
                                    <th>الإجراء</th>
                                    
    
                                </tr>
                                </thead>
                                <tbody id="quali">
                                    <tr>
                                        <td> تويتر</td>
                                        <td>تويتر</td>
                                        <td> تويتر</td>
                                    </tr>
                                    <tr>
                                        <td> يوتيوب</td>
                                        <td>يوتيوب</td>
                                        <td> يوتيوب</td>
                                    </tr>
                                    <tr>
                                        <td> إنستجرام</td>
                                        <td>إنستجرام</td>
                                        <td> إنستجرام</td>
                                    </tr>
                                    <tr>
                                        <td> تيك توك</td>
                                        <td> تيك توك</td>
                                        <td> تيك توك</td>
                                    </tr>
                                    
                                    <tr>
                                        <td>سناب شات</td>
                                        <td>سناب شات</td>
                                        <td>سناب شات</td>

    
                                    </tr>
                                 </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{-- end section qualification    --}}
    

        </div>    
      
    </div>
@endsection


@section("js")
<script src="{{asset('assets/vendor/jquery-validation/jquery.validate.js')}}"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.0.6/parsley.min.js"></script>

<!-- Jquery Validation Plugin Css -->
<!-- data table js -->
<script src="{{ asset('assets/bundles/datatablescripts.bundle.js') }}"></script>
<script src="{{asset('assets/vendor/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('assets/js/pages/ui/dialogs.js')}}"></script>


<script>

    
    $(function () {
        $('#basic-form').parsley();
    });
    
      $(function () {
        $('#basic-form-pass').parsley();
    });
</script>

@endsection
