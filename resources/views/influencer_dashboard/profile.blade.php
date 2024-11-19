@extends('layouts.dashboard')
@section('profile_influencer','active')
@section("title", "صفحتي الشخصية")
@section("css")
<link rel="stylesheet" href="{{asset('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}">


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
                    <h2>المعلومات الأساسية</h2>
                </div>
                <div class="body">
                    <form method="POST" action="{{route('updateOrCreate')}}" id="basic-form"
                          novalidate enctype="multipart/form-data">
                        {{-- @method('PUT') --}}
                        @csrf
                        <div class="row clearfix">
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label class="control-label">الاسم الأول</label>
                                    <input type="text" value="{{ $influence->fname ?? '' }}"  name="fname" required
                                           class="form-control" placeholder="الاسم الأول">
                                    @if ($errors->has('fname'))
                                        <p class="text-danger">{{$errors->first('fname')}}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label class="control-label">الاسم الأخير</label>
                                    <input type="text" value="{{ $influence->lname ?? ''}}" name="lname" required
                                           class="form-control" placeholder="الاسم الأخير">
                                    @if ($errors->has('lname'))
                                        <p class="text-danger">{{$errors->first('lname')}}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label class="control-label">تاريخ الميلاد</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="icon-clock"></i></span>
                                        </div>
                                        {{-- {{ $user->getUserInfo->birthday }} --}}
                                        {{-- {{ \Carbon\Carbon::parse($user->from_date)->format('d/m/Y')}} --}}
                                        {{-- {{   date('dd/mm/YYYY', strtotime($influence->birthday)) }} --}}
                                                <?php
                                                // $birthday=\Carbon\Carbon::parse($influence->birthday )->format('d/m/Y');
                                                 ?>


                                        <input data-provide="datepicker"  name="birthday" value="{{ !empty($influence->birthday) ? $influence->birthday:'' }}" data-date-autoclose="true" class="form-control">


                                        <!--<input value="  {{ !empty($influence->birthday) ? $influence->birthday:'' }}" type="date" name="birthday"-->
                                        <!--       class="form-control"   required="">-->
                                        @if ($errors->has('birthday'))
                                            <p class="text-danger">{{$errors->first('birthday')}}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label class="control-label">الجنس</label>
                                    <select class="form-control" class="form-control" name="gender">
                                        
                                        <option  {{ !empty($influence->gender) &&$influence->gender == 'female' ? 'selected':'' }}  


                                            value="female" >
                                            أنثى
                                        </option>
                                        <option value="male" {{ !empty($influence->gender) &&$influence->gender == 'male' ? 'selected':'' }}
                                       >
                                            ذكر
                                        </option>
                                    </select>
                                    @if ($errors->has('gender'))
                                        <p class="text-danger">{{$errors->first('gender')}}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <label class="control-label"> الوصف</label>
                                    <textarea  cols="12" rows="6" class="form-control"  
                                           name="description" placeholder=" الوصف">
                                           {{ $influence->description ?? ' '  }}    
                                </textarea>
                                    @if ($errors->has('description'))
                                        <p class="text-danger">{{$errors->first('description')}}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <label class="control-label">الموقع/البلد</label>
                                    {{-- {{ $user->getUserInfo->location }} --}}
                                    <input value=" {{ $influence->location ?? ' ' }}" type="text" name="location"
                                           class="form-control" placeholder="الموقع/البلد" required="">
                                    @if ($errors->has('location'))
                                        <p class="text-danger">{{$errors->first('location')}}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <label class="control-label col-lg-12">  
                                    الإهتمامات 
                               </label>

                                <div class="row form-group">
                                     {{-- {{ in_array($task->id,$userTask)? ' checked' : '' }}                      
                                                  <input value="" type="text" name="location" --}}
                                    <label class="col-lg-2"><input type="checkbox" name="Interests[]"
                                        value="fashion" ><span> موضة</span></label>                               
                                            
                                        <label class="col-lg-2"><input type="checkbox" name="Interests[]"
                                            value="fashion" ><span> رياضة</span></label>                            
                                            <label class="col-lg-2"><input type="checkbox" name="Interests[]"
                                                value="fashion" ><span> موسيقى</span></label>                            
                                                <label class="col-lg-2"><input type="checkbox" name="Interests[]"
                                                    value="fashion" ><span> سفر</span></label>                            
                                                                
                                                    <label class="col-lg-2"><input type="checkbox" name="Interests[]"
                                                value="fashion" ><span> ترفيه</span></label>                        
                                                      
                                                <label class="col-lg-2"><input type="checkbox" name="Interests[]"
                                                    value="fashion" ><span> صحة</span></label>            
                                                                          
                                                    <label class="col-lg-2"><input type="checkbox" name="Interests[]"
                                                        value="fashion" ><span> جمال</span></label>   
                                                        @if ($errors->has('location'))
                                                        <p class="text-danger">{{$errors->first('Interests')}}</p>                           
                                                        @endif

                                </div>
                            </div>
                           
            
                            <div class="col-lg-12 col-md-12 text-right">
                                <button type="submit" class="btn btn-primary">تعديل</button> &nbsp;&nbsp;
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        
            {{-- end section qualification    --}}
    

        </div>    
       
        <div class="col-xl-4 col-lg-4 col-md-5">
            <div class="card">
                <div class="header">
                    <h2>تعديل كلمة المرور</h2>
                </div>
                <div class="body">
                    <form method="POST" action="" id="basic-form-pass" novalidate
                          enctype="multipart/form-data">
                        @csrf
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <input type="email" value="" class="form-control" disabled>
                                </div>

                                <div class="form-group">
                                    <input type="password" name="current-password"
                                           class="form-control @error('current-password') is-invalid @enderror" required
                                           placeholder="كلمة السر الحالية">
                                    @error('current-password')
                                    <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="password" name="new-password"
                                           class="form-control @error('new-password') is-invalid @enderror" required
                                           placeholder="كلمة السر الجديدة">
                                    @error('new-password')
                                    <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="password" name="new-password_confirmation" class="form-control"
                                           placeholder="تأكيد كلمة السر الجديدة">
                                </div>
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-primary">تفيير كلمة المرور</button> &nbsp;&nbsp;
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
            </div>

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

<script src="{{asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>

<script>

    
    $(function () {
        $('#basic-form').parsley();
    });
    
      $(function () {
        $('#basic-form-pass').parsley();
    });
</script>

@endsection
