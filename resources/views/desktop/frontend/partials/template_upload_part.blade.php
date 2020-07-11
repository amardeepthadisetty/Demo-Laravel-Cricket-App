<style>
     .input_file, #progress{
        display:none;
    }
    
  
</style>
@php
 $product_upload = json_decode(json_encode($template->more_settings));  
@endphp

<div class="row pd-section">
@if($product_upload->upload_settings->is_upload=="1")
<div class="col-12">
    <label class="product-description-label">Upload Your Photo</label>
</div>
<div class="col-12 mt-1">
    @php
    $imagesHTML = '';
    $images = '';
        if( $sesArray ){
            if( count($sesArray['uploaded_images']) > 0 ){
                
                foreach( $sesArray['uploaded_images'] as $image ){
                    //echo '<br> image is: '.$image."<Br>";
                    $imagesHTML .= '<div class="upimg">';
                    $imagesHTML .= '<img src="'. asset( getImageURL( 'uploads/user_uploaded_images/new/'.$image, 'icon' ) ) .'" height="45px" width="45px">';
                    $imagesHTML .= '<span>File Name '.$image.'<br> </span>';
                    $imagesHTML .= '<button type="button"  onclick="resetImage()">Clear</button>'; 
                    $imagesHTML .= '</div>';

                    
                }
                $images  =  implode(",", $sesArray['uploaded_images'] );
            }
        }
        @endphp

     
    <button type="button" id="upload_button" class="upload-bt">Upload your favorite photo</button> 
    <span id="upload_error"></span>
    <span class="input_file">
        
        <input type="file" id="upload_file" name="upload[]" @php if($product_upload->upload_settings->upload_limit >= 2) { echo 'multiple'; }  @endphp  accept='image/*' >
        <input type="hidden" id="upload_limit" value="{{ $product_upload->upload_settings->upload_limit  }}" >
        <input type="hidden" id="photos" name="user_photos" value="{{ $images }}" >
    </span>
    <div id="for_images">
        {!! $imagesHTML  !!}
    </div>
    <div id="progress">
        <!-- <div id="progress-wrp"><div class="progress-bar"></div ><div class="status">0%</div></div> -->
        <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar"
            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                0% Complete
            </div>
        <div id="output"><!-- error or success results --></div>
    </div>
    
</div>
    </div>
    
@endif


<script>
    @php
    $images = '';
    if($images!=''){
        @endphp
        $('#upload_button').hide();
        @php
    }
    @endphp
$('#upload_button').on('click', function (){
    //alert("button clicked");
    $('#upload_file').trigger('click');
});

function resetImage(){
     //show the button
     $('#upload_button').show();
     $("#for_images").html('');
     $("#upload_file").val('');
     $("#photos").val('');
}



$("#upload_file").change(function(e) {

    $.ajaxSetup({
 
        headers: {
        
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        
        }
        
        });
    
    var upload_limit = $("#upload_limit").val();
    var numberOfImagesUploaded = $('#upload_file')[0].files.length;
    if (numberOfImagesUploaded > upload_limit) {
        alert("You can upload atmost "+upload_limit+" images");
        resetImage();
        return '';
    }
    var form_data = new FormData();
    var imagesHTML = '<div class="upimg">';
    console.log("length is: ",$('#upload_file')[0].files.length);
     $.each($('#upload_file')[0].files, function(i, file) {
        form_data.append('fileupload[]', file);
        var file_size_inMB = niceBytes(file.size);
        //console.log(file.name);
        imagesHTML += '<img src="'+URL.createObjectURL(file)+'" height="45px" width="45px" class="pull-left"><div class="pull-left pl-3 pr-3"><span>File Name '+file.name+'<br></span><span>Size '+file_size_inMB+'<br></span></div>';
    });
    imagesHTML += '<button type="button" onclick="resetImage()">Clear</button></div>';

    //console.log("imageshtml is:", imagesHTML);
    $('#for_images').html(imagesHTML);
   // form_data.append('fileupload[]', $('#upload_file')[0].files[0]);
    form_data.append('product_id', '{{ $product->id }}');
    $.ajax({
        url : '{{ route('upload.user_upload_file') }}',
        type: "POST",
        //enctype: 'multipart/form-data',
        data : form_data,
        contentType: false,
        processData: false,
        beforeSend: function(){
            $('#photos').val('');
            $('#progress').show();
            var percent = 0;
                 $(" .progress-bar").css("width", + percent +"%");
                    //$( " .status").text(percent +"%");
                    $( ".progress-bar").text(percent +"%");
             }, 
             complete: function(){
                 $('#progress').hide();
                 var percent = 0;
                 $(" .progress-bar").css("width", + percent +"%");
                 //$( " .status").text(percent +"%");
                  $( ".progress-bar").text(percent +"%");

                 //hide the button
                 $('#upload_button').hide();
                 $("#upload_file").val('');
             }, 
        xhr: function(){
            //upload Progress
            var xhr = $.ajaxSettings.xhr();
            if (xhr.upload) {
                xhr.upload.addEventListener('progress', function(event) {
                    var percent = 0;
                    var position = event.loaded || event.position;
                    var total = event.total;
                    if (event.lengthComputable) {
                        percent = Math.ceil(position / total * 100);
                    }
                    console.log("progress is:", percent);
                    //update progressbar
                    $(" .progress-bar").css("width", + percent +"%");
                    //$( " .status").text(percent +"%");
                     $( ".progress-bar").text(percent +"%");
                }, true);
            }
            return xhr;
        } ,
        success: function (result) {
            //
            if (result.status=="Success") {
                $('#photos').val(result.photos);
                $('#upload_error').text('').removeClass('error_span');
            }else if(result.status=="Failure"){
                $("#upload_error").html(result.messages.file[0]);
                setTimeout(() => {
                     $("#upload_error").html('');
                     resetImage();
                }, 9000);
               
            }else{
                console.log("success is:",result.status);
            }
        },
        error: function(result){
             console.log("error is:",result);
        }
       
    })
});
</script>