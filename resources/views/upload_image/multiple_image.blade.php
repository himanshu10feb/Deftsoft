<!DOCTYPE html>
<html lang="en">
<head>
<meta name="csrf-token" content="{!! csrf_token() !!}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
#choose_file {display: none;}
.selct_img{display: none;}

</style>
</head>
<body>
@if(session('flesh-message-success'))
                        <div class="alert alert-sm alert-success alert-block" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>{{ session('flesh-message-success') }}</strong>
                        </div>
                 @endif
                 @if(session('flesh-message-error'))
                        <div class="alert alert-sm alert-danger alert-block" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>{{ session('flesh-message-error') }}</strong>
                        </div>
                 @endif
<form method="post" action="{{url('upload-image')}}" enctype="multipart/form-data" id="img-upload-form">
          @csrf
          @if(count($images) < 10)
            <div id ="image_upload" >
              <img src="{{url('images/upload_button.png')}}" alt="" style="height:100px;" id ="image_upload">
            </div>
            <div class="row">
              <div class="col-md-4"></div>
              <div class="form-group col-md-4">
              <input required type="file" class="form-control" name="image[]" multiple id="choose_file">
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-4"></div>
              <div class="form-group col-md-4">
              <button type="submit" class="btn btn-success" style="margin-top:10px" id="upload-image-btn">Upload Image</button>
              </div>
            </div>    
          
          @endif
                      
       
               
</form>
<form action="{{url('delete-image/{id}')}}">

  @if(count($images)>0)
    @foreach($images as $image)

        <div style='float:left; padding:10px'; class="show-image">
              <div>
                <a href="{{url('/delete-singal-image/'.$image->image)}}" class="btn btn-close" name="image"  >
                     <span>&times;</span>
                </a>
            </div>
            <img class="card-img-top" src="{{URL('upload/'.$image->image)}}" alt="" style="height:100px; width:100px"/>
            <input type="file" name="singal_image" old_file="{{$image->image}}" class="selct_img">
            <input type="checkbox" name="images[]" class="custom-control-input" id="" value="{{$image->image}}">
            
        </div>
    @endforeach 
    <div>
      <button type = "submit" href="{{url('delete-image/'.$image->image)}}">Delete</button>
    </div>
  
  @endif
</form>   
</body>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<script>
$(document).ready(function(){
  $("#image_upload").click(function(){
    $("#choose_file").click()
    //alert("test");
  })
  $( "#img-upload-form" ).submit(function( event ) {
    // alert( "Handler for .submit() called." );
    var $totalCount=$(".show-image").length;
    //alert($totalCount);
    var $fileUpload = $("input[type='file']");
    if (parseInt($fileUpload.get(0).files.length)+$totalCount>10){
      alert("You can only upload a maximum of 10 files");
      event.preventDefault();
    } else {
      $( "#img-upload-form" ).submit();
    }
  });
 
 $("input[name=singal_image]").change(function(){
   
   var fd = new FormData();
   var files = $(this)[0].files;
   let old_image=$(this).attr('old_file');
   fd.append('newimage',files[0]);
   fd.append('oldimage',old_image);
  //  fd.append('_token',$('meta[name="csrf-token"]').attr('content'));
   $.ajax({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: 'singal-image',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                  console.log(response);
                  location.reload();
                }
    })
  });
    $('body').on('click', ".card-img-top", function(event){
      $(this).siblings().click();
    });
  })
</script>
</html>