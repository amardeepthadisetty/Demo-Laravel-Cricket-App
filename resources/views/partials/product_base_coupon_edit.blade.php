<div class="panel-heading">
    <h3 class="panel-title">{{__('Add Your Product Base Coupon')}}</h3>
</div>
<div class="form-group">
   <label class="col-lg-3 control-label" for="coupon_name">{{__('Coupon Name')}}</label>
   <div class="col-lg-9">
       <input type="text" value="{{$coupon->name}}" id="coupon_name" name="coupon_name" class="form-control" required>
   </div>
</div>
<div class="form-group">
    <label class="col-lg-3 control-label" for="coupon_code">{{__('Coupon code')}}</label>
    <div class="col-lg-9">
        <input type="text" placeholder="{{__('Coupon code')}}" id="coupon_code" name="coupon_code" value="{{ $coupon->code }}" class="form-control" required>
    </div>
</div>
<div class="product-choose-list">
    @foreach (json_decode($coupon->details) as $key => $details)
        <div class="product-choose">
            <div class="form-group">
               <label class="col-lg-3 control-label">{{__('Products')}}</label>
               <div class="col-lg-9">
                  <select class="form-control  demo-select2" name="product_ids[]" required>
                     @foreach(\App\Product::all() as $key => $product)
                         <option value="{{$product->ref}}" @if ($details->product_id == $product->ref)
                             selected
                         @endif >{{$product->name}}</option>
                     @endforeach
                  </select>
               </div>
            </div>
            
          
           
            <hr>
        </div>
    @endforeach
</div>
<div class="more hide">
    <div class="product-choose">
        
        
        <div class="form-group">
            <label class="col-lg-3 control-label" for="name">{{__('Products')}}</label>
            <div class="col-lg-9">
                 <select class="form-control " name="product_ids[]" required>
                     @foreach(\App\Product::all() as $key => $product)
                         <option value="{{$product->ref}}" >{{$product->name}}</option>
                     @endforeach
                  </select>
            </div>
        </div>
        <hr>
    </div>
</div>
<div class="text-right">
    <button class="btn btn-primary" type="button" name="button" onclick="appendNewProductChoose()">{{ __('Add More') }}</button>
</div>
<div class="form-group">
    <label class="col-lg-3 control-label" for="start_date">{{__('Date')}}</label>
    <div class="col-lg-9">
        <div id="demo-dp-range">
            <div class="input-daterange input-group" id="datepicker">
                <input type="text" class="form-control" name="start_date" value="{{ date('m/d/Y', $coupon->start_date) }}" autocomplete="off">
                <span class="input-group-addon">{{__('to')}}</span>
                <input type="text" class="form-control" name="end_date" value="{{ date('m/d/Y', $coupon->end_date) }}" autocomplete="off">
            </div>
        </div>
    </div>
</div>

<div class="form-group">
   <label class="col-lg-3 control-label">{{__('Minimum Shopping')}}</label>
   <div class="col-lg-9">
      <input type="number" min="0" step="0.01" placeholder="{{__('Minimum Shopping')}}" name="min_buy" class="form-control" value={{ $coupon->min_discount }} required>
   </div>
</div> 

<div class="form-group">
   <label class="col-lg-3 control-label">{{__('Discount')}}</label>
   <div class="col-lg-8">
      <input type="number" min="0" step="0.01" placeholder="{{__('Discount')}}" value="{{ $coupon->discount }}" name="discount" class="form-control" required>
   </div>
   <div class="col-lg-1">
      <select class="demo-select2" name="discount_type">
         <option value="amount" @if ($coupon->discount_type == 'amount') selected  @endif>$</option>
         <option value="percent" @if ($coupon->discount_type == 'percent') selected  @endif>%</option>
      </select>
   </div>
</div>

<div class="form-group">
   <label class="col-lg-3 control-label">{{__('Maximum Discount Amount')}}</label>
   <div class="col-lg-9">
      <input type="number" min="0" step="0.01" placeholder="{{__('Maximum Discount Amount')}}" name="max_discount" class="form-control" value={{ $coupon->max_discount }} required>
   </div>
</div> 




<div id="extra_options" >

        <div class="form-group">
            <label class="col-lg-3 control-label" for="name">{{__('Repeat Type')}}</label>
            <div class="col-lg-9">
                <select name="repeat_type" id="repeat_type" class="form-control demo-select2" required>
                    <option value="">Select One</option>
                    <option value="unlimited" @if ($coupon->repeat_type == 'unlimited') selected  @endif >{{__('Unlimited')}}</option>
                    <option value="normal_limit" @if ($coupon->repeat_type == 'normal_limit') selected  @endif   >{{__('Normal Limit')}}</option>
                    <option value="user_limit" @if ($coupon->repeat_type == 'user_limit') selected  @endif    >{{__('User Limit')}}</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-lg-3 control-label" for="name">{{__('Limit')}}</label>
            <div class="col-lg-9">
                <input type="number" class="form-control" name="limit_number" value="{{ $coupon->limit_number }}">
                
            </div>
        </div>

    </div>


<script type="text/javascript">

    function appendNewProductChoose(){
        $('.product-choose-list').append($('.more').html());
        $('.product-choose-list').find('.product-choose').last().find('.category_id').select2();
    }

  

   

    $(document).ready(function(){
        $('.demo-select2').select2();
        //get_subcategories_by_category($('.category_id'));
    });

   

</script>
