
@foreach ($allIDS as $eachID)
 			@php 
 			 $shipChargeItems = \App\ShippingCharge::where('id', $eachID)->get();
 			@endphp 
          
           @if ($shipChargeItems) 
              @foreach ($shipChargeItems as $sCharge) 
                 <input type="hidden" name="id[]" value={{ $sCharge->id }}>

                  <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('Shipping Methods')}}</label>
                        <div class="col-lg-9">
                            <select name="shipping_method_id[]" id="shipping_method_id" class="form-control demo-select2"  required>
                                <option value="">Select One</option>
                                @foreach($sMethods as $sm)
                                    <option value="{{ $sm->id }}" @php if($sCharge->shipping_method_id==$sm->id){ echo 'selected';} @endphp   >{{  $sm->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('Price') }}</label>
                        <div class="col-lg-9">
                            <input type="text" name="price[]" class="form-control" value="{{ $sCharge->price}}">
                        </div>
                    </div>

                      <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('Status')}}</label>
                        <div class="col-lg-9">
                            <select name="status[]" id="status" class="form-control demo-select2"  required>
                                <option value="">Select One</option>
                               
                                    <option value="1" @php if($sCharge->status=="1"){ echo 'selected';} @endphp  >Active</option>
                                    <option value="0" @php if($sCharge->status=="0"){ echo 'selected';} @endphp  >Inactive</option>
                                
                            </select>
                        </div>
                    </div>
                    <hr>



              @endforeach
           @endif
        
@endforeach