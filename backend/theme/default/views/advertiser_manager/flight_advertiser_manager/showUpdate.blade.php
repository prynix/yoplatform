{{ HTML::script("{$assetURL}js/dual-list-box.js") }}
{{ HTML::script("{$assetURL}js/wizard/jquery.bootstrap.wizard.js") }}
{{ HTML::script("{$assetURL}js/wizard/bootstrap/js/bootstrap.min.js") }}
{{ HTML::style("{$assetURL}css/flight_advertiser_manager.css") }}
{{ HTML::style("{$assetURL}css/checkbox.css") }}
<div class="part">
{{ Form::open(array('role'=>'form','class'=>'form-horizontal form-cms')) }}
    <div class="row">
        <div class="col-md-12">
			<div id="rootwizard">
    			<div class="navbar">
    				<div class="navbar-inner">
    			  		<div class="">
                			<ul class="nav nav-pills">
                				<li class="active"><a href="#tab1" data-toggle="tab" aria-expanded="true"><span class="number">1.</span>General Info</a></li>
                				<!-- <li class=""><a href="#tab2" data-toggle="tab" aria-expanded="false"><span class="number">2.</span>Retargeting</a></li> -->
                				<li class=""><a href="#tab3" data-toggle="tab" aria-expanded="false"><span class="number">2.</span>Inventory</a></li>
                				<li class=""><a href="#tab4" data-toggle="tab" aria-expanded="false"><span class="number">3.</span>Region</a></li>
                				<!-- <li class=""><a href="#tab5" data-toggle="tab" aria-expanded="false"><span class="number">5.</span>Audience</a></li> -->
                				<li class=""><a href="#tab5" data-toggle="tab" aria-expanded="false"><span class="number">4.</span>Tag</a></li>
                				<li class=""><a href="#tab6" data-toggle="tab" aria-expanded="false"><span class="number">5.</span>Cost</a></li>
                                <li id="audience_tab" class=""><a href="#tab2" data-toggle="tab" aria-expanded="false" onclick="showAudience();"><span class="number">6.</span>Audience</a></li>
                			</ul>
    			 		</div>
    			  	</div>
				</div>
				@include("partials.show_messages") 
        		<div class="tab-content">
        			<div class="tab-pane active" id="tab1">
        				<div class="form-group form-group-sm">
                            <label class="col-xs-2">{{trans('text.status')}}</label>
                            <div class="col-xs-4">
                                <select class="form-control" id="status" name="status">
                                    <option value="1" <?php if( isset($item->status) &&  $item->status == 1 ){ echo "selected='selected'"; }?> >{{trans('text.active')}}</option>
                                    <option value="0" <?php if( isset($item->status) &&  $item->status == 0 ){ echo "selected='selected'"; }?>>{{trans('text.unactive')}}</option>
                                </select>
                            </div>
                        </div>
            
                        <!-- NAME -->
                        <div class="form-group form-group-sm">
                            <label class="col-md-2">{{trans('text.name')}}</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="name" value="{{{ $item->name or Input::get('name') }}}" name="name">
                            </div>
                        </div>                        
            
                        <!-- CAMPAIGN -->
                        <div class="form-group">
                            <label class="col-md-2">{{trans('text.campaign')}}</label>
                            <div class="col-md-4">
                                <input type="hidden" id="campaign_id" value="{{{ $item->campaign_id or Input::get('campaign_id') }}}" name="campaign_id">
                                <input type="text" class="form-control input-sm" id="campaign" value="{{{ $item->campaign->name or Input::get('campaign') }}}" name="campaign" readonly onclick="Select.openModal('campaignR2')" placeholder="Click here to select campaign">
                            </div>
                            <!-- <div class="col-md-3 text-select">
                                <a href="javascript:;" onclick="Select.openModal('campaignR2')" class="btn btn-default btn-block btn-sm">{{trans('text.select_campaign')}}</a>
                            </div> -->
                        </div>
            
                        <!-- Ad -->
                        <div class="form-group">
                            <label class="col-md-2">{{trans('text.ad')}}</label>
                            <div class="col-md-4">
                                <input type="hidden" id="ad_id" value="{{{ $item->ad_id or Input::get('ad_id') }}}" name="ad_id">
                                <input type="text" class="form-control input-sm" id="ad" value="{{{ $item->ad->name or Input::get('ad') }}}" name="ad" readonly  onclick="Select.openModal('ad')" placeholder="Click here to select ad">
                                <input type="hidden" id="ad_parent_id" value="campaign_id">
                            </div>
                            <!-- <div class="col-md-3 text-select">
                                <a href="javascript:;" onclick="Select.openModal('ad')" class="btn btn-default btn-block btn-sm">{{trans('text.select_ad')}}</a>
                            </div> -->
                        </div>
            
                        <!-- CHANNEL ( CATEGORY ) -->
                        <div class="form-group">
                            <label class="col-md-2">{{trans('text.channel')}}</label>
                            <div class="col-md-4">
                            <?php
                                $categoryValue = ( isset($item->category_id) ) ? $item->category_id : Input::get('category_id');
                            ?>
                            {{ 
                                Form::select(
                                    'category_id', 
                                    $listCategory,
                                    $categoryValue, 
                                    array('class'=>'form-control input-sm','id'=>'category_id')
                                ) 
                            }}
                            </div>
                        </div>      
                                  
                        <!-- REMARK -->
                        <!-- <div class="form-group form-group-sm">
                            <label class="col-md-2">{{trans('text.remark')}}</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="remark" value="{{{ $item->remark or Input::get('remark') }}}" name="remark">
                            </div>
                        </div>     -->                    
                         
                        <!-- SELECT CAMPAIGN RETARGETING -->
                        <!-- <div class="form-group form-group-sm">
                            <label class="col-md-2">{{trans('text.campaign_retargeting')}}</label>
                            <div class="col-md-4 text-select">
                                <a href="javascript:;" onclick="Select.openModal('campaign_retargeting')" class="btn btn-default btn-block btn-sm">{{trans('text.select_campaign')}}</a>
                                <div id="list-campaign-retargeting">
                                    @if( !empty($campaignRetargetingSelected) )
                                        @foreach( $campaignRetargetingSelected as $id => $name )
                                            <div class="campaign-retargeting-item-{{$id}}">
                                                <span class="label label-info"><a onclick="removeCampaignRetargeting('{{$id}}')" href="javascript:;"><i class="fa fa-times"></i></a>{{$name}}</span>
                                                <input type="hidden" class="campaign-retargeting-selected" name="campaign-retargeting-selected[]" value="{{$id}}">
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div> -->                      
                        <!-- COST TYPE -->
                        <div class="form-group form-group-sm">
                            <label class="col-md-2">{{trans('text.cost_type')}}</label>
                            <div class="col-md-10">
                                <div class="radio radio-info radio-inline">
                                    {{ Form::radio('cost_type', 'cpm', 'cpm' == Input::get('cost_type') || ( !empty($item->cost_type) && 'cpm' == $item->cost_type), array('id'=>'cpm') )}}
                                    <label for="cpm"> CPM </label>
                                </div>
                                <div class="radio radio-info radio-inline">
                                    {{ Form::radio('cost_type', 'cpc', 'cpc' == Input::get('cost_type') || ( !empty($item->cost_type) && 'cpc' == $item->cost_type), array('id'=>'cpc') )}}
                                    <label for="cpc"> CPC </label>
                                </div>
                                <div class="radio radio-info radio-inline">
                                    {{ Form::radio('cost_type', 'cpv', 'cpv' == Input::get('cost_type') || ( !empty($item->cost_type) && 'cpv' == $item->cost_type), array('id'=>'cpv') )}}
                                    <label for="cpv"> CPV </label>
                                </div>
                                <div class="radio radio-info radio-inline">
                                    {{ Form::radio('cost_type', 'cpe', 'cpe' == Input::get('cost_type') || ( !empty($item->cost_type) && 'cpe' == $item->cost_type), array('id'=>'cpe') )}}
                                    <label for="cpe"> CPE </label>
                                </div>
                                <div class="radio radio-info radio-inline">
                                    {{ Form::radio('cost_type', 'cpa', 'cpa' == Input::get('cost_type') || ( !empty($item->cost_type) && 'cpa' == $item->cost_type), array('id'=>'cpa') )}}
                                    <label for="cpa"> CPA </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(true)
                    <div class="tab-pane" id="tab2">
        				<!-- RETARGETING -->
                        <div class="form-group form-group-sm">
                            <label class="col-md-2"> {{trans('text.use_retargeting')}} </label>
                            <div class="col-md-4">
                                <div class="radio radio-info radio-inline">
                                    <input type="radio" id="retargeting_1" class="use_retargeting" @if(isset($item) && $item->use_retargeting == "1") checked="checked" @endif value="1" name="use_retargeting">
                                    <label for="retargeting_1"> Yes </label>
                                </div>
                                <div class="radio radio-info radio-inline">
                                    <input type="radio" id="retargeting_2" class="use_retargeting" @if(!isset($item)) checked="checked" @elseif(isset($item) && $item->use_retargeting == "2") checked="checked" @endif value="2" name="use_retargeting">
                                    <label for="retargeting_2"> No </label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- RETARGETING URL -->
                        <div class="form-group form-group-sm retargeting" id="audience">
                           
                        </div>
                    </div>
                    @endif
        			<div class="tab-pane" id="tab3">
        				<!-- CAMPAIGN DATE -->
                        <div class="form-group form-group-sm">
                            <label class="col-md-2">{{trans('text.campaign_date')}}</label>
                            <div class="col-md-4">
                                <input type="text" class="no-border" id="campaign_date" style="width: 100%" value="{{{ $item->campaign->dateRange or Input::get('campaign_date') }}}" name="campaign_date" readonly>
                            </div>
                        </div> 
                        <!-- EVENT -->
                        <div class="form-group">
                            <label class="col-md-2">{{trans('text.select_event')}}</label>
                            <div class="col-md-4">
                            <?php
                                $eventValue = ( isset($item->event) ) ? $item->event : Input::get('event');
                            ?>
                            {{ 
                                Form::select(
                                    'event', 
                                    $listEvent,
                                    $eventValue, 
                                    array('class'=>'form-control input-sm','id'=>'event')
                                ) 
                            }}
                            </div>
                        </div>
                        <!-- VALUE ADDED -->
                        <div class="form-group form-group-sm">
                            <label class="col-md-2">{{trans('text.value_added')}}</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="value_added" value="{{{ $item->value_added or Input::get('value_added') }}}" name="value_added">
                            </div>
                        </div>
        			    <!-- TOTAL INVENTORY -->
                        <div class="form-group form-group-sm">
                            <label class="col-md-2">{{trans('text.total_inventory')}}</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="total_inventory" value="{{{ $item->total_inventory or Input::get('total_inventory') }}}" name="total_inventory">
                            </div>
                        </div>
        			    <!-- DATE -->
                        <?php
                           $stt = 0;
                        ?>
                        <div class="form-group form-group-sm">
                            <label class="col-md-2">{{trans('text.date')}} <i class="fa fa-calendar"></i>
                            </label>
                            <div class="col-md-4">
                                <div class="input-daterange input-group" id="datepicker">
                                    <input type="text" class="form-control" name="start_date_range" id="start_date_range" />
                                    <span class="input-group-addon">to</span>
                                    <input type="text" class="form-control" name="end_date_range" id="end_date_range" />
                                </div>
                                                    
                            </div>
                            <div class="col-md-6">
                            	<div class="col-md-4">
                                	<a href="javascript:;" onclick="addDate()" class="btn btn-default btn-block btn-sm">{{trans('text.add_date')}}</a>
                                </div>
                                <div class="col-md-6">
                                	<a href="javascript:;" onclick="reCalculateInventory()" class="btn btn-default btn-block btn-sm">Recalculate Inventory</a>
                                </div>
                            </div>
                            <label class="col-md-2"></label>
                            <div class="col-md-8">
                            <div id="list-date-range">
                                    <?php 
                                       if(!empty($getdate) && count($getdate) > 0) {
                                       foreach($getdate as $key => $value ){ 
                                    ?>
                                            <div class="date-range">
                                                <span class="label label-info">
                                                	<a onclick="removeDate('{{$stt}}','{{$value['id'] or 0 }}')" href="javascript:;" title="Delete"><i class="fa fa-times"></i></a>
                                                	<a onclick="Flight.getAddDateInfo('edit','{{$stt}}')" href="javascript:;" title="Edit"><i class="fa fa-pencil-square-o"></i></a>
                                                	<a onclick="Flight.getAddDateInfo('copy','{{$stt}}')" href="javascript:;" title="Copy"><i class="fa fa-clipboard"></i></a>
                                                	<?= date('d-m-Y',  strtotime($value['start']))?> -> <?= date('d-m-Y',  strtotime($value['end']))?>
                                                	
                                                </span>
                                                <input type="hidden" id="date-start-{{$stt}}" name="date[{{$key}}][start]" value="<?= date('d-m-Y',  strtotime($value['start']))?>">
                                                <input type="hidden" id="end-start-{{$stt}}" name="date[{{$key}}][end]" value="<?= date('d-m-Y',  strtotime($value['end']))?>">
                                                <input type="hidden" id="diff-{{$stt}}" name="date[{{$key}}][diff]" value="{{$value['diff']}}">
                                                <input type="hidden" id="diffid-{{$stt}}" name="date[{{$key}}][id]" value="{{$value['id'] or 0 }}">
                                                
                                                <input type="hidden" id="frequency-cap-{{$stt}}" name="date[{{$key}}][frequency_cap]" value="{{$value['frequency_cap']}}">
                                                <input type="hidden" id="frequency-cap-time-{{$stt}}" name="date[{{$key}}][frequency_cap_time]" value="{{$value['frequency_cap_time']}}">
                                                <input type="hidden" id="daily-inventory-{{$stt}}" name="date[{{$key}}][daily_inventory]" value="{{$value['daily_inventory']}}">
                                                <div class="sub_form">
                                                	<div class="form-group">
                                                		<label class="col-xs-4 fw_normal">Hour will run flight</label>
                                    					<?php 
                                    					    $isObject = true;
                                    					    if (isset($value['hour'])) {
                                    					        $hours =  json_decode($value['hour']);
                                    					    } else {
                                    					        $hours = isset($value['time'])?$value['time']:array();
                                    					        $isObject = false;
                                    					    }    
                                    					    $index = 0;
                                    					?>
                                    					@if (!empty($hours) && count($hours) > 0)
                                        					<div class="col-xs-8 pl0">
                                            					@foreach($hours as $hour) 
                                            						<?php 
                                                					    $start = 0;
                                                					    $end = 0;
                                                					    $inventory = 0;
                                                					    if ($isObject) {
                                                					        $start = isset($hour->start) ? $hour->start : '';
                                                					        $end = isset($hour->end) ? $hour->end : '';
                                                					        $inventory = isset($hour->time_inventory) ? $hour->time_inventory : '';
                                                					    } else {
                                                					        $start = isset($hour['start']) ? $hour['start'] : '';
                                                					        $end = isset($hour['end']) ? $hour['end'] : '';
                                                					        $inventory = isset($hour['time_inventory']) ? $hour['time_inventory'] : '';
                                                					    }    
                                                					?>
                                            						<input type="hidden" id="time-start-{{$stt}}-{{$index}}" name="date[{{$stt}}][time][{{$index}}][start]" value="{{$isObject?$hour->start:$hour['start']}}">
                                            						<input type="hidden" id="time-end-{{$stt}}-{{$index}}" name="date[{{$stt}}][time][{{$index}}][end]" value="{{$isObject?$hour->end:$hour['end']}}">
                                            						<input type="hidden" id="time-inventory-{{$stt}}-{{$index}}" name="date[{{$stt}}][time][{{$index}}][time_inventory]" value="{{$inventory}}">
                                            						@if (0 == $index)
                                                                		<div>: {{$start}} -> {{$end}}.&nbsp;&nbsp;&nbsp;&nbsp;Limit inventory: <span class="show_time_inventory">{{$inventory}}</span></div>
                                                        			@else
                                                        				<div>&nbsp;&nbsp;{{$start}} -> {{$end}}.&nbsp;&nbsp;&nbsp;&nbsp;Limit inventory: <span class="show_time_inventory">{{$inventory}}</span></div>
                                                        			@endif
                                                        			<?php $index++; ?>
                                            					@endforeach
                                            				</div>	
                                        				@endif
                                    				</div>
                                    				<div class="form-group">
                                						<label class="col-xs-4 fw_normal">Daily Inventory</label>
                                						<div class="show_daily_inventory col-xs-8 pl0">: {{$value['daily_inventory']}}</div>
                            						</div>
                                    				<div class="form-group">
                                    					<label class="col-xs-4 fw_normal">Frequency Cap</label>
                            							<div class="col-xs-8 pl0">: {{$value['frequency_cap']}}</div>
                            						</div>

                            						<div class="form-group">
                            							<label class="col-xs-4 fw_normal">Frequency Cap Time (mins)</label>
                            							<div class="col-xs-8 pl0">: {{$value['frequency_cap_time']}}</div>
                            						</div>
                            						
                            					</div>
                                                
                                            </div>
                                    <?php $stt++;}?>
                                        
                                    <?php } ?>
                                </div>
                             </div>
                        </div>    
            
                        <!-- DAY -->
                        <div class="form-group form-group-sm">
                            <label class="col-md-2">{{trans('text.days')}}</label>
                            <div class="col-md-4">
                                <input type="text" class="no-border" id="day" value="{{{ $item->day or Input::get('day') }}}" name="day" readonly>
                            </div>
                        </div>
            
        			</div>
    				<div class="tab-pane" id="tab4">
    					<!--Start-- Add by Phuong-VM 06-05-2015 -->
                        <!-- SELECT COUNTRY -->
            
                        <div class="form-group form-group-sm">             
                            <label class="col-md-2">{{trans('text.select_country')}}</label>                       
                            <div class="col-sm-10">
                                <?php $listSelected =  ( isset( $countrySelected ) ) ? $countrySelected :  Input::get('selected_country', array()); ?>                                            
                                <select multiple="multiple" data-title="country" data-value="index" data-text="name" size="10" data-name="country[]" id="country" class="form-control">
                                    @foreach($countryList as $country)
                                        <?php
                                            $selected =''; 
                                            if( in_array($country->country_code, $listSelected) ){
                                                $selected ='selected';
                                            }
                                        ?>
                                        <option {{$selected}}  value="{{$country->country_code}}">{{ $country->country_name }}</option>                                                
                                    @endforeach
                                </select>                                            
                            </div>
                        </div>
                        <!--End-- Add by Phuong-VM 06-05-2015 -->
                        
                        <!-- SELECT PROVINCE -->
            
                        <div class="form-group form-group-sm">             
                            <label class="col-md-2">{{trans('text.select_province')}}</label>                       
                            <div class="col-sm-10">
                                <?php $listSelected =  ( isset( $provinceSelected ) ) ? $provinceSelected :  Input::get('selected_province', array()); ?>                                            
                                <select multiple="multiple" data-title="province" data-value="index" data-text="name" size="10" data-name="province[]" id="province" class="form-control">
                                    @if(!empty($provinceLists))
                                        @foreach($provinceLists as $province)
                                            <?php
                                                $selected =''; 
                                                $region = "{$province->country_code}:{$province->region}";
                                                if( in_array($region, $listSelected) ){
                                                    $selected ='selected';
                                                }
                                            ?>
                                            <option {{$selected}}  value="{{$region}}">{{ $province->region}} @if(isset($province->country_name))({{$province->country_name}})@endif</option>                                                
                                        @endforeach
                                    @endif
                                </select>                                            
                            </div>
                        </div>
    			    </div>
    				<!-- <div class="tab-pane" id="tab5"> -->
    					<!-- SELECT AGE -->
                        <!-- <div class="form-group form-group-sm">             
                            <label class="col-md-2">{{trans('text.age')}}</label>                       
                            <div class="col-sm-10">
                                <?php $listSelected =  ( isset( $ageSelected ) ) ? $ageSelected :  Input::get('selected_age', array()); ?>                                            
                                <select multiple="multiple" data-title="age" data-value="index" data-text="name" size="10" data-name="age[]" id="age" class="form-control">
                                    <?php for( $i=1; $i<=100; $i++ ){ ?>
                                        <?php
                                            $selected =''; 
                                            if( in_array($i, $listSelected) ){
                                                $selected ='selected';
                                            }
                                        ?>
                                        <option {{$selected}}  value="{{$i}}">{{$i}}</option>                                                
                                    <?php } ?>
                                </select>                                            
                            </div>
                        </div> -->
            
                        <!-- SELECT SEX -->
                        <!-- <div class="form-group form-group-sm">
                            <label class="col-md-2">{{trans('text.sex')}}</label>
                            <div class="col-md-10">
                                <label class="radio-inline">
                                    {{ Form::radio('sex', '', '' == Input::get('sex') || ( !empty($item->sex) && '' == $item->sex) )}}
                                    All
                                </label>
                                <label class="radio-inline">
                                    {{ Form::radio('sex', 'male', 'male' == Input::get('sex') || ( !empty($item->sex) && 'male' == $item->sex) )}}
                                    Male
                                </label>
                                <label class="radio-inline">
                                    {{ Form::radio('sex', 'female', 'female' == Input::get('sex') || ( !empty($item->sex) && 'female' == $item->sex) )}}
                                    Female
                                </label>
                            </div>
                        </div>
    			    </div> -->
    			    <div class="tab-pane" id="tab5">
    			    <!-- KEYWORD -->
    			    	<div class="form-group form-group-sm">
                            <label class="col-md-2">Tag</label>
                            <div class="col-md-4">

                                <input type="text" class="form-control" id="keyword" value="{{ $item->filter or Input::get('keyword') }}" name="keyword">
                                 <span style="font-size:11px;">
                                 <i>Each tag is seperated by comma (,).<br/>
                                 Tag must be vietnamese, unsigned and adjacent<br/>
                                 Ex: tamly, phunu, gioitre
                                 </i>
                                 </span>
                            </div>
                           <!--  <div class="col-md-6">
                            	<div class="col-md-3">
                                	<a href="javascript:;" onclick="addKeyword();" class="btn btn-default btn-block btn-sm">{{trans('text.add')}}</a>
                                </div>
                            </div> -->
                        </div>
                        
    					<!-- LIST KEYWORD -->
                       <!--  <div class="form-group form-group-sm">             
                            <label class="col-md-2">{{trans('text.list_keyword')}}</label>                       
                            <div id="list-keyword" class="col-sm-10">  
                            @if (!empty($listKeyword)) {                                                                          
                                @foreach ($listKeyword as $val)
                                <div class="alert alert-success keyword  col-sm-1">
                                	{{$val}}
                                	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fa fa-times-circle-o"></i></button>
                                	<input type="hidden" name="list_keyword[]" value="{{$val}}">
                            	</div>        
                                @endforeach  
                            @endif                                
                            </div>
                        </div> -->
    			    </div>
    				<div class="tab-pane" id="tab6">                                                             
                        <!-- BASE MEDIA COST -->
                        <div class="form-group form-group-sm">
                            <label class="col-md-2">{{trans('text.base_media_cost')}}</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="base_media_cost" value="{{{ $item->base_media_cost or Input::get('base_media_cost') }}}" name="base_media_cost">
                                <input type="hidden" class="form-control" id="real_base_media_cost" value="{{{ $item->real_base_media_cost or Input::get('real_base_media_cost') }}}" name="real_base_media_cost">
                                <input type="hidden" class="form-control" id="real_media_cost" value="{{{ $item->real_media_cost or Input::get('real_media_cost') }}}" name="real_media_cost">
                            </div>
                        </div>                        
                        <!-- MEDIA COST -->
                        <div class="form-group form-group-sm">
                            <label class="col-md-2">{{trans('text.media_cost')}}</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="media_cost" value="{{{ $item->media_cost or Input::get('media_cost') }}}" name="media_cost">
                            </div>
                        </div>                        
                        <!-- DISCOUNT -->
                        <div class="form-group form-group-sm">
                            <label class="col-md-2">{{trans('text.discount')}}</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="discount" value="{{{ $item->discount or Input::get('discount') }}}" name="discount">
                            </div>
                            <div class="pull-left">%</div>
                        </div>                        
                        <!-- COST AFTER DISCOUNT -->
                        <div class="form-group form-group-sm">
                            <label class="col-md-2">{{trans('text.cost_after_discount')}}</label>
                            <div class="col-md-4">
                                <input type="text" class="no-border" id="cost_after_discount" value="{{{ $item->cost_after_discount or Input::get('cost_after_discount') }}}" name="cost_after_discount" readonly>
                            </div>
                        </div>                        
                        <!-- TOTAL COST AFTER DISCOUNT -->
                        <div class="form-group form-group-sm">
                            <label class="col-md-2">{{trans('text.total_cost_after_discount')}}</label>
                            <div class="col-md-4">
                                <input type="text" class="no-border" id="total_cost_after_discount" value="{{{ $item->total_cost_after_discount or Input::get('total_cost_after_discount') }}}" name="total_cost_after_discount" readonly>
                            </div>
                        </div>                        
                        <!-- AGENCY COMMISSION -->
                        <div class="form-group form-group-sm">
                            <label class="col-md-2">{{trans('text.agency_commission')}}</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="agency_commission" value="{{{ $item->agency_commission or Input::get('agency_commission') }}}" name="agency_commission">
                            </div>
                            <div class="pull-left">%</div>
                        </div>                        
                        <!-- COST AFTER AGENCY COMMISSION -->
                        <div class="form-group form-group-sm">
                            <label class="col-md-2">{{trans('text.cost_after_agency_commission')}}</label>
                            <div class="col-md-4">
                                <input type="text" class="no-border" id="cost_after_agency_commission" value="{{{ $item->cost_after_agency_commission or Input::get('cost_after_agency_commission') }}}" name="cost_after_agency_commission" readonly>
                            </div>
                        </div>    
                        <!-- ADVALUE COMMISSION -->
                        <div class="form-group form-group-sm">
                            <label class="col-md-2">{{trans('text.advalue_commission')}}</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="advalue_commission" value="{{{ $item->advalue_commission or Input::get('advalue_commission') }}}" name="advalue_commission">
                            </div>
                            <div class="pull-left">%</div>
                        </div>                        
                        <!-- PUBLISHER COST -->
                        <div class="form-group form-group-sm">
                            <label class="col-md-2">{{trans('text.publisher_cost')}}</label>
                            <div class="col-md-4">
                                <input type="text" class="no-border" id="publisher_cost" value="{{{ $item->publisher_cost or Input::get('publisher_cost') }}}" name="publisher_cost" readonly>
                            </div>
                        </div>  
    			    </div><br />
    				<ul class="pager wizard">
    					<li class="cancel"><a href="{{ URL::Route($moduleRoutePrefix.'ShowList') }}"  class="btn btn-default btn-sm">{{trans("text.cancel")}}</a></li>
    					<li id='previous' class="previous disabled"><a href="javascript:;">Previous</a></li>  
    				  	<li id='next' class="next"><a href="javascript:;">Next</a></li>
    				  	<li id='save' class="save"><button type="submit" name="save" value="save" class="btn btn-default btn-sm">{{trans("text.save")}}</button></li>
    				</ul>
    			</div>
			</div>
                                 
        </div>
    </div>
    <div class="row">
        <!-- <div class="col-md-12">
            @include("partials.save")
        </div> -->
    </div>
{{ Form::close() }}

<div id="loadSelectModal">
    @include("partials.select")
</div>
<!-- Start Phuong-VM 06-05-2015 -->
<div id="loadAddDateInfo"></div>
<!-- Start Phuong-VM 06-05-2015 -->
<script type="text/javascript"><!--
 
    var index = $(".date-range").length; 

    function embedDatePicker(){
        $('.input-daterange').datepicker({ format: 'dd-mm-yyyy'});
    }

    function dateDiff(start, end){
        return ((end - start)/1000/60/60/24) + 1;
    }

    function getCurrentDate(){
        return ($('#day').val() == '' ) ? 0 : $('#day').val();
    }

    function setDate(days){
        if( !isNaN(days) ){
            $('#day').val(days);  
        }
    }

    function addDate(){
        var startString = $('#start_date_range').val();
        var endString   = $('#end_date_range').val();

        if( startString == '' || endString == '' ) {
            return;
        }

        var start       = $('#start_date_range').datepicker('getDate');
        var end         = $('#end_date_range').datepicker('getDate');
        var diff        = dateDiff(start, end);
        if (diff < 0) {
			return;
        }
        var currentDate = getCurrentDate();
        
        days = parseInt(currentDate) + parseInt(diff);
        //setDate(days);

        Flight.getAddDateInfo('add', -1);
        
        /*$("#list-date-range").append(createDateRange(index,startString, endString, diff)); 
        $('#start_date_range').val('');
        $('#end_date_range').val('');
        $('.input-daterange').datepicker('remove');
        embedDatePicker();*/
        index++;
    }
    var indextime = $(".time-range").length;
    function addTime(){
        var startString = $('#start_hour').val();
        var endString   = $('#end_hour').val();
        if( startString == '' || endString == '' ) {
            return;
        }
        $("#list-time-range").append(createTimeRange(indextime,startString, endString));
        $('#start_hour').val('');
        $('#end_hour').val('');
        indextime++;
    }
    function createTimeRange(i,start, end){
        return '<div class="time-range">'
                +'<span class="label label-info"><a onclick="removeTime(\''+i+'\')" href="javascript:;"><i class="fa fa-times"></i></a>'+start+' -> '+end+'</span>'
                +'<input type="hidden" id="time-start-'+i+'" name="time['+i+'][start]" value="'+start+'">'
                +'<input type="hidden" id="time-end-'+i+'" name="time['+i+'][end]" value="'+end+'">'
                +'</div>';
    }
    function removeTime(index){
        var diff = $('#time-end-'+index);
        diff.parent().remove();
    }
    function removeDate(index,id){ 
        var diff = $('#diff-'+index);
        var diffValue = $('#diff-'+index).val();
        var currentDate  = getCurrentDate();
        var days = parseInt(currentDate) - parseInt(diffValue);
        setDate(days);
        diff.parent().remove();
    }

    function removeCampaignRetargeting(id){
        var LCR = Select.getListCampaignRetargeting();
        var index = LCR.indexOf(id);
        if (index > -1) {
            LCR.splice(index, 1);
            Select.setListCampaignRetargeting(LCR);
        }
        $('.campaign-retargeting-item-'+id).remove();
    }


    /*function createDateRange(i,start, end, diff){
        return '<div class="date-range">'
                +'<span class="label label-info"><a onclick="removeDate(\''+i+'\')" href="javascript:;"><i class="fa fa-times"></i></a>'+start+' -> '+end+'</span>'
                +'<input type="hidden" id="date-start-'+i+'" name="date['+i+'][start]" value="'+start+'">'
                +'<input type="hidden" id="end-start-'+i+'" name="date['+i+'][end]" value="'+end+'">'
                +'<input type="hidden" id="diff-'+i+'" name="date['+i+'][diff]" value="'+diff+'">'
            +'</div>';
    }*/


    function calculateRatio(value, percent){
        return value * ( 100-percent )/100;
    }

    function calculateCostAfterDiscount(){
        var mediaCost = $('#media_cost').val();
        var discount = $('#discount').val();

        var costAfterDiscount = calculateRatio(mediaCost, discount);
        var totalInventory = $('#total_inventory').val();
        var totalCostAfterDiscount = costAfterDiscount*totalInventory;

        $('#cost_after_discount').val(costAfterDiscount);
        $('#total_cost_after_discount').val(totalCostAfterDiscount);

        calculateCostAfterAgencyCommission();

    }

    function calculateCostAfterAgencyCommission(){
        var totalCostAfterDiscount  = $('#total_cost_after_discount').val();
        var agencyCommision         = $('#agency_commission').val();

        var costAfterAgencyComission =  calculateRatio(totalCostAfterDiscount, agencyCommision);

        $('#cost_after_agency_commission').val(costAfterAgencyComission);
        calculcatePublisherCost();

    }

    function calculcatePublisherCost(){
        var costAfterAgencyComission = $('#cost_after_agency_commission').val();
        var adValueCommission = $('#advalue_commission').val();
        var publisherCost = calculateRatio(costAfterAgencyComission, adValueCommission);
        $('#publisher_cost').val(publisherCost);
    }

    function calculateRealCost(){

        var baseMediaCost = $("#base_media_cost").val();
        var mediaCost = $('#media_cost').val();

        var discount          = $('#discount').val();
        var agencyCommision   = $('#agency_commission').val();
        var adValueCommission = $('#advalue_commission').val();

        var realBaseMediaCost = calculateRatio(baseMediaCost, discount);
        realBaseMediaCost = calculateRatio(realBaseMediaCost, agencyCommision);
        realBaseMediaCost = calculateRatio(realBaseMediaCost, adValueCommission);
        
        var realMediaCost = calculateRatio(mediaCost, discount);
        realMediaCost = calculateRatio(realMediaCost, agencyCommision);
        realMediaCost = calculateRatio(realMediaCost, adValueCommission);

        $("#real_base_media_cost").val(realBaseMediaCost);
        $("#real_media_cost").val(realMediaCost);

    }

    $().ready(function(){
        embedDatePicker();
        $('#base_media_cost,#media_cost,#discount,#total_inventory').change(function(){
            calculateCostAfterDiscount();
            calculateRealCost();
        });

        $('#agency_commission').change(function(){
            calculateCostAfterAgencyCommission();
        });

        $('#advalue_commission').change(function(){
            calculcatePublisherCost();
        });

        $("#total_cost_after_discount, #cost_after_agency_commission, #publisher_cost").number(true);

        $('#start_hour_picker').datetimepicker({
            pickDate: false,
            useSeconds: true,
            format: 'HH:mm:ss'
        });

        $('#end_hour_picker').datetimepicker({
            pickDate: false,
            useSeconds: true,
            format: 'HH:mm:ss'
        });

        $("#province").DualListBox();
        $("#age").DualListBox({
            'sort': false
        });

        /*--Start-- Add by Phuong-VM 06-05-2015 */
        $("#country").DualListBox();
        getProvince();
        //Event click select/unselect country
        $('#dual-list-box-country').find('button').bind('click', function() {
        	getProvince();
        	    
        });

        $('#rootwizard').bootstrapWizard({onTabShow: function(tab, navigation, index) {
			var $total = navigation.find('li').length;
			var $current = index+1;
			var $percent = ($current/$total) * 100;
			$('#rootwizard').find('.bar').css({width:$percent+'%'});
		}});
        var isUpdate = $(location).attr('href').indexOf("flight/update");
        if (isUpdate < 0) {
        	$('#save').hide();
        } else {
        	$('#save').show();
        }
      	/*--End-- Add by Phuong-VM 06-05-2015 */

        showRetargeting();

        $('.use_retargeting').click(function () {
        	showRetargeting();
        });

        $('.retargeting-show').click(function () {
        	showRetargetingNumber();
        });

        $('input[name="cost_type"]').click(function(){
			selectEvent($(this).val());
        });
    })
    
    function getProvince() {
    	$("#loading").stop().fadeIn();
    	var parent = null;
        var type = 'geo';
        var keyword = new Array();
        var countryList = new Array();
		var countrySelected = $('#dual-list-box-country .selected');
		var provinceUnselected = $('#dual-list-box-province .unselected');
		var i = 0;
		countrySelected.find('option').each(function () {
			keyword[i] = $(this).val();
			i++;
        });
        url = root+"tool/search";
		$.post(
			url,
			{
				parent  : parent,
				type 	: type,
				keyword : keyword
			},
			function(data){
				provinceUnselected.html(data);
				var provinceSelected = $('#dual-list-box-province .selected');
				provinceSelected.find('option').each(function () {
					if ($("#dual-list-box-province .unselected option[value='"+$(this).val()+"']").length) {
						$("#dual-list-box-province .unselected option[value='"+$(this).val()+"']").remove();
					} else {
						$("#dual-list-box-province .selected option[value='"+$(this).val()+"']").remove();
					}
		        });
		        var parentElement = '#dual-list-box-province';
		        
				if ($(parentElement + ' .unselected').has('option').length == 0) {
	                $(parentElement + ' .atr').prop('disabled', true);
	                $(parentElement + ' .str').prop('disabled', true);
	            } else {
	                $(parentElement + ' .atr').prop('disabled', false);
	            }

				if ($(parentElement + ' .selected').has('option').length == 0) {
	                $(parentElement + ' .atl').prop('disabled', true);
	                $(parentElement + ' .stl').prop('disabled', true);
	            } else {
	                $(parentElement + ' .atl').prop('disabled', false);
	            }
				$("#loading").stop().fadeOut();
			}
		)
    }

    function showRetargeting() {
    	var retargeting_1 = $('#retargeting_1');

        if (retargeting_1.is(":checked")) {
        	$(".retargeting").removeClass("hidden");
        	$(".retargeting").addClass("show");
        } else {
        	$(".retargeting").removeClass("show");
        	$(".retargeting").addClass("hidden");
        }

        showRetargetingNumber();
    }

    function showRetargetingNumber() {
    	var retargeting_show1 = $('#retargeting_show1');
    	var retargeting_1 = $('#retargeting_1');
		
        if (retargeting_show1.is(":checked") && retargeting_1.is(":checked")) {
        	$(".retargeting-number").removeClass("hidden");
        	$(".retargeting-number").addClass("show");
        } else {
        	$(".retargeting-number").removeClass("show");
        	$(".retargeting-number").addClass("hidden");
        }
    }

    function selectEvent(event) {
        var select = null;
		switch(event) {
			case 'cpm':
				select = 'impression';
			break;
			case 'cpc':
				select = 'click';
			break;
		}

		$('#event').val(select);
    }

    function reCalculateInventory() {
		var totalInventory = parseInt($('#total_inventory').val());
		var totalDay = parseInt($('#day').val());
		if (isNaN(totalInventory) || isNaN(totalDay) || totalDay <= 0 || totalInventory < 0) {
			return;
		}

		var avgInventory = Math.ceil(totalInventory/(totalDay))

		$('input[id^="daily-inventory-"]').each(function(){
			$(this).val(avgInventory);
		});

		$('.show_daily_inventory').each(function(){
			$(this).html(': ' + avgInventory);
		});
		

		$('input[id^="time-inventory-"]').each(function(){
			$(this).val('');
		});

		$('.show_time_inventory').each(function(){
			$(this).html('');
		});
    }

    function addKeyword() {
		var keyword = $('#keyword').val();
		if ('' != keyword) {
			var html = '<div class="alert alert-success keyword  col-sm-1">'+keyword+'<input type="hidden" name="list_keyword[]" value="'+keyword+'"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fa fa-times-circle-o"></i></button></div>';
			$('#list-keyword').append(html);
			$('#keyword').val('');
		}
    }

    function showAudience(){
        var campaign_id = $("#campaign_id").val();
        if(campaign_id==''){
            campaign_id = 0;
        }
        var flight_id = "{{isset($item->id)?$item->id:0}}";
        $.ajax({
            type:'get',
            url:'/control-panel/advertiser-manager/flight/get-list-audiences/'+campaign_id+"/"+flight_id,
            success: function(data){
                $("#audience").html(data);
            }
        })
    }

    $(document).ready(function(){
        retargeting = "{{ isset($item->use_retargeting) ? $item->use_retargeting:2}}";
        if(retargeting==1){
            showAudience();
        }else{
             $("#retargeting_1").click(function(){
                showAudience();
            })
        }
    })
    
--></script>
</div>

