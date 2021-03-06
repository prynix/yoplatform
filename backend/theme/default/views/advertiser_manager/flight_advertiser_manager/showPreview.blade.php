<div class="modal fade bs-contact-modal" id="loadPreviewModal" tabindex="-1" role="dialog" aria-labelledby="selectModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
            	<h4 class="modal-title">Preview Flight</h4>
        	</div>
            <div class="modal-body">
                <div class="">
					<style>
						.blue {
							color: blue;
                      	}
                      	.popover {
                  			max-width: 600px;
                      		width: auto;
                      	}
                      	.mb20{margin-bottom:20px;}
                      	.mt20{margin-top:20px;}
                      	.bg-default{font-weight: bold; width:20%;}
                   	</style>
					<div>
						<div class="box">
                            <div class="head">Flight</div>
								<table class="campaign table table-striped table-hover table-condensed ">
                               		<tbody>
                                		<tr>
                                     		<td class="bg-default">Flight Name</td>
                                     		<td width="30%">({{$flight->id}}) {{$flight->name}}</td>
                                     		<td class="bg-default">Campaign</td>
                                     		<td width="30%">({{$flight->campaign->id}}) {{$flight->campaign->name}}</td>
                                  		</tr>
                                  		<tr>
                                     		<td class="bg-default">Cost Type</td>
                                     		<td width="30%">{{strtoupper($flight->cost_type)}}</td>
                                     		<td class="bg-default">Duration</td>
                                     		<td width="30%">
											    @if ($flight->flight_date)											    
												    @foreach ($flight->flight_date as $date)												    
													    <?php
													        $start_date = date('d-m-Y', strtotime($date->start));
													        $end_date = date('d-m-Y', strtotime($date->end));
													        if (isset($date->hour)) {
													            $arrHour = json_decode($date->hour);
													        }
													    ?>
													    {{$start_date}} -> {{$end_date}}<br />
													    @if (!empty($arrHour))
													    	@foreach ($arrHour as $hour)
    													    	<?php 
        													    	$start_time = $hour->start;
        													    	$end_time = $hour->end;
    													    	?>
    													    	&nbsp;&nbsp;&nbsp;<i>{{$start_time}} -> {{$end_time}} <br /></i>
													    	@endforeach
													    @endif
												    @endforeach
											    @endif												
											</td>
                                  		</tr>
                                  		<tr>
                                     		<td class="bg-default" width="25%">Total Inventory</td>
                                     		<td width="30%"><span class="badge badge-info">{{number_format($flight->total_inventory)}}</span></td>
                                  		<?php
                                            $totalImpression = $totalUniqueImpression = $totalClick = $totalUniqueClick = $totalImpressionOver = $totalClickOver = $totalUniqueImpressionOver = $totalUniqueClickOver = $totalByEvent = 0;

                                            if(!empty($flightTracking)) {
                                                $totalImpression = $flightTracking['total_impression'];
                                                $totalUniqueImpression = $flightTracking['total_unique_impression'];
                                                $totalClick = $flightTracking['total_click'];
                                                $totalUniqueClick = $flightTracking['total_unique_click'];
                                                //over report
                                                $totalImpressionOver = $flightTracking['total_impression_over'];
                                                $totalUniqueImpressionOver = $flightTracking['total_unique_impression_over'];
                                                $totalClickOver = $flightTracking['total_click_over'];
                                                $totalUniqueClickOver = $flightTracking['total_unique_click_over'];
                                                
                                                $TrackingInventory      = new TrackingInventory;
                                                if (isset($flight->event) && $flight->event != '') {
                                                    $event = $flight->event;
                                                } else {
                                                    $event = Tracking::getTrackingEventType($flight->cost_type);
                                                }
                                                $key = "total_{$event}";
                                                $keyOver = "total_{$event}_over";
                                                $totalByEvent = $flightTracking[$key] + $flightTracking[$keyOver];
                                            }
                                        ?>
                                     		<td class="bg-default">Total Impression</td>
                                     		<td width="30%">
                                     			<span class="badge badge-info">{{number_format($totalImpression + $totalImpressionOver)}}</span>
                                     			@if ($totalImpressionOver)
													<span class="blue">({{number_format($totalImpressionOver)}})</span>
												@endif
											</td>
                                  		</tr>
                                  		<tr>
											<td class="bg-default">Total Unique Impression</td>
                                     		<td width="30%">
												<span class="badge badge-info">{{number_format($totalUniqueImpression + $totalUniqueImpressionOver)}}</span>
												@if ($totalUniqueImpressionOver)
													<span class="blue">({{number_format($totalUniqueImpressionOver)}})</span>
												@endif
											</td>
                                         	<td class="bg-default">Total Clicks</td>
                                         	<td width="30%">
												<span class="badge badge-info">{{number_format($totalClick + $totalClickOver)}}</span>
												@if ($totalClickOver)
													<span class="blue">({{number_format($totalClickOver)}})</span>
												@endif												
											</td>
                                      	</tr>
                                      	<tr>
                                         	<td class="bg-default">Total Unique Clicks</td>
                                         	<td width="30%">
												<span class="badge badge-info">{{number_format($totalUniqueClick + $totalUniqueClickOver)}}</span>
												@if ($totalUniqueClickOver)
													<span class="blue">({{number_format($totalUniqueClickOver)}})</span>
												@endif												
											</td>
                                    		<td class="bg-default">Process</td>
                                     		<td width="30%">
                                        		<div class="progress">
                                               		<?php
                                                        $process = 0;
                                
                                                        $process = $flight->getProcessPreview($totalByEvent);
                                
                                                        $processtype = 'danger';
                                                        if ($process > 40 && $process < 80) {
                                                            $processtype = 'info';
                                                        }
                                                        if ($process > 80) {
                                                            $processtype = 'success';
                                                        }
                                                    ?>
                                                        
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-{{ $processtype }}  progress-bar-striped"
                                                             role="progressbar" aria-valuenow="{{ $process }}" aria-valuemin="0" aria-valuemax="100"
                                                             style="width: {{$process}}0%">
                                                            {{$process}}%
                                                        </div>
                                                    </div>
                                    			</div>
                                     		</td>
                                  		</tr>                                  		
                               		</tbody>
                            	</table>
                         	</div>
						</div>
                   	<div class="mt20">
                    	<div class="box">
                        	<div class="head">List Ad Of Flight</div>
                        	<table class="table table-striped table-hover table-condensed ">
                        		<tr class="bg-primary fs12">
                             		<th>Ad</th>
                          		</tr>
                          		@if (!empty($flight->ad))
                              		<tr>
                              			<td>
                              				<a href="{{ URL::Route('AdAdvertiserManagerShowView',$flight->ad->id) }}" target="_blank">({{$flight->ad->id}}) {{$flight->ad->name}}</a>
                              			</td>
                              		</tr>
                          		@endif
                        	</table>                        
                     	</div>
                  	</div>
            	</div>
        	</div>
        	<div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('text.close')}}</button>
            </div>
    	</div>
	</div>
</div>