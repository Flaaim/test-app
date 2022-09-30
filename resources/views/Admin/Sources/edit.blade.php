<!-- Page header -->
<section class="content-header">
    <h1>{{$title}}</h1>
</section>
<!-- /page header -->


<!-- Content area -->
<div class="content">
    <!-- Input group addons -->
    <div class="box card">
        <form action="{{route('sources.update',[$source->id])}}" method="POST">
            @if($errors->any())
            <ul>
                @foreach($errors->all() as $error)
                    <li>
                        {{$error}}
                    </li>
                @endforeach
            </ul> 
            @endif
            @method('PUT')
            @csrf
        <fieldset class="mb-3">
                    <legend class="">{{__('Common info')}}</legend>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">{{__('Title')}}<span
                                    class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <div class="input-group">
                                <input type="text" name="title" required class="form-control"
                                       value="{{$source->title}}"
                                       placeholder="{{__('Title')}}">
                            </div>
                        </div>
                    </div>
                </fieldset>
                <button type="submit" class="btn btn-success">{{__('Submit')}}</button>
        </form>
    </div>
</div>