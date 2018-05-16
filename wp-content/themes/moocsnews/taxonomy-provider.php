<?php 
$term = get_queried_object();
$courses = get_post_by_taxonomy('course', 'provider', $term->slug, -1);
$subjects = get_terms( array(
    'taxonomy' => 'subject',
    'hide_empty' => false,
) );
?>

<!-- Get Header -->
<?php get_header(); ?>

<section class="courses">
	<div class="container">
		<!-- BEGIN: Breadcrumb -->
		<div class="row">
			<div class="col-md-12"><?php the_breadcrumb(); ?></div>
		</div>
		<!-- END: Breadcrumb -->
		<div class="row content">
			<div class="col-md-3">
				<div class="left-filter">
					<h3>
						<span class="number-courses">Showing</span>
						<strong class="text-bold">
							<span class="text--bold" id="number-of-courses"><?php echo $term->count; ?></span> 
							courses
						</strong>
					</h3>
					<div class="category-filter">
						<ul class="filter-nav">
							<li class="bg-white padding-horz-small padding-vert-xsmall radius">
								<a href="javascript:;">
									<span>By start date</span>
									<span class="icon"><i class="fas fa-chevron-down"></i></span>
								</a>
								<ul class="main-filter-dropdown ">
									<li>
										<label class="check-item">
											Recently started or starting soon
											<input type="checkbox" class="check-box status" value="recently_soon">
											<span class="checkmark"></span>
										</label>
									</li>
									<li>
										<label class="check-item">
											Courses in Process
											<input type="checkbox" class="check-box status" value="process">
											<span class="checkmark"></span>
										</label>
									</li>
									<li>
										<label class="check-item">
											Future Courses
											<input type="checkbox" class="check-box status" value="upcoming">
											<span class="checkmark"></span>
										</label>
									</li>
									<li>
										<label class="check-item">
											Self-Paced
											<input type="checkbox" class="check-box status" value="self_paced">
											<span class="checkmark"></span>
										</label>
									</li>
									<li>
										<label class="check-item">
											Unknown
											<input type="checkbox" class="check-box status" value="unknown">
											<span class="checkmark"></span>
										</label>
									</li>
								</ul>
							</li>

							<li class="bg-white padding-horz-small padding-vert-xsmall radius">
								<a href="javascript:;">
									<span>By subjects</span>
									<span class="icon"><i class="fas fa-chevron-down"></i></span>
								</a>
								<ul class="main-filter-dropdown ">
									<?php foreach ($subjects as $key => $value) { ?>
									<li>
										<label class="check-item">
											<?php echo $value->name; ?>
											<input type="checkbox" class="check-box subject" value="<?php echo $value->slug; ?>">
											<span class="checkmark"></span>
										</label>
									</li>
									<?php } ?>
								</ul>
							</li>

							<li class="bg-white padding-horz-small padding-vert-xsmall radius">
								<a href="javascript:;">
									<span>By language</span>
									<span class="icon"><i class="fas fa-chevron-down"></i></span>
								</a>
								<ul class="main-filter-dropdown ">
									<li>
										<label class="check-item">
											English
											<input type="checkbox" class="check-box language" value="English">
											<span class="checkmark"></span>
										</label>
									</li>
									<li>
										<label class="check-item">
											Chinese
											<input type="checkbox" class="check-box language" value="Chinese">
											<span class="checkmark"></span>
										</label>
									</li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-md-9">
				<div class="right-content">
					<div style="overflow-x:auto;">
						<table class="table table-condensed tbl-courses datatable">
						<col width="5%">
						<col width="55%">
						<col width="20%">
						<col width="20%">
						<thead>
							<tr>
								<th></th>
								<th>Course Name</th>
								<th>Start Date</th>
								<th>Rating</th>
								<th>Language</th>
								<th>Status</th>
								<th>Subjects</th>
							</tr>
						</thead>
						<tbody>

							<?php if ( $courses->have_posts() ) : while ( $courses->have_posts() ) : $courses->the_post(); 
							$meta = get_post_meta( $post->ID, 'course_fields', true ); 
							$institutions = wp_get_post_terms( $post->ID, 'institution' );
							$course_subjects = wp_get_post_terms( $post->ID, 'subject' ); 
							?>

							<tr>
								<td><span><i class="fas fa-list"></i></span></td>
								<td>
									<ul class="institution">
										<?php if(count($institutions) > 0){ ?>
										<?php foreach ($institutions as $key => $value) { ?>
										<?php if( (count($institutions)-1) == $key ) {?>
										<?php echo '<li><a href="'.get_term_link($value).'">'.$value->name.'</a></li>'; ?>
										<?php } ?>
										<?php } ?>
										<?php } ?>
									</ul>
									<div class="tbl-course-title"><a  href="<?php the_permalink(); ?>">
										<?php echo $post->post_title; ?>
									</a></div>
									<span class="block">
										via
											<?php if(count($course_subjects) > 0){ ?>
											<?php foreach ($course_subjects as $key => $value) { ?>
											<?php if( (count($course_subjects)-1) == $key ) {?>
											<?php echo '<a href="'.get_term_link($value).'">'.$value->name.'</a>'; ?>
											<?php }else{ ?>
											<?php echo '<a href="'.get_term_link($value).'">'.$value->name.'</a>, '; ?>
											<?php } ?>
											<?php } ?>
											<?php } ?>
										
										<?php if( $meta['effort'] ){ ?>
										<span class="block ml5">
											<span class="icon">
												<i class="far fa-clock"></i>
											</span>
											<?php echo $meta['effort']; ?>
										</span>
										<?php } ?>
									</span>
								</td>
								<td><span class="start-date"><?php echo $meta['start_date']; ?></span></td>
								<td>
									<div class="rating">
										<span class="review-ratings">
											<span class="icon-rating"><i class="fas fa-star"></i></span>
											<span class="icon-rating"><i class="fas fa-star"></i></span>
											<span class="icon-rating"><i class="fas fa-star"></i></span>
											<span class="icon-rating"><i class="fas fa-star"></i></span>
											<span class="icon-rating"><i class="fas fa-star"></i></span>
										</span>
										<span class="review-number">14 Reviews</span>
									</div>
								</td>
								<td><?php echo $meta['language']; ?></td>
								<td><?php echo $meta['session']; ?></td>
								<td>
									<?php if(count($course_subjects) > 0){ ?>
									<?php foreach ($course_subjects as $key => $value) { ?>
									<?php if( (count($course_subjects)-1) == $key ) {?>
									<?php echo $value->slug; ?>
									<?php }else{ ?>
									<?php echo $value->slug.','; ?>
									<?php } ?>
									<?php } ?>
									<?php } ?>
								</td>
							</tr>

						<?php endwhile; endif; 
						wp_reset_postdata(); ?>

						

						</tbody>
					</table>
					</div>
				<div class="input-group mb-3 col-md-4 pull-right" id="tb-search" >
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1"><i class="fa fa-search"></i></span>
					</div>
					<input type="text" class="form-control" aria-describedby="basic-addon1" id="myInputTextField">
				</div>
			</div>
		</div>
	</div>
</div>
</section>

<script type="text/javascript">
	var $ = jQuery;
	$(document).ready(function() {
		var languages = [];
		var statuses = [];
		var subjects = [];
		var dtTable = $('table.datatable').on( 'processing.dt', function ( e, settings, processing ) {
		    if (!processing) {
		    }
		} ).DataTable({
			"dom": '<"top"i>rt<"bottom clearfix"lp><"clear">',
			"columnDefs": [
	            {
	                "targets": [ 3,4,5,6 ],
	                "visible": false,
	                "searchable": true
	            }
	        ]
		});

	    // Event listener to the two range filtering inputs to redraw on input
	    $('.check-box').change( function() {
	        update_languages_filter();
	        update_status_filter();
	        update_subjects_filter();
	        dtTable.draw();
			$('#number-of-courses').html(dtTable.page.info().recordsDisplay);
	    } );
	
		// Add checked language to array checked_cats
		function update_languages_filter() {
			var data = [];
		    $('.language').each(function(i){
			    if(this.checked){
			        data.push(this.value);
			    }
		    });
		    languages = data;
		};
	
		// Add checked language to array checked_cats
		function update_status_filter() {
			var data = [];
		    $('.status').each(function(i){
			    if(this.checked){
			        data.push(this.value);
			    }
		    });
		    $('.start-date').each(function(i){
			    if(this.checked){
			        data.push(this.value);
			    }
		    });
		    statuses = data;
		};
	
		// Add checked language to array checked_cats
		function update_subjects_filter() {
			var data = [];
		    $('.subject').each(function(i){
			    if(this.checked){
			        data.push(this.value);
			    }
		    });
		    subjects = data;
		};

	    /* Custom filtering function which will search data in column four between two values */
		$.fn.dataTable.ext.search.push(
		    function( settings, data, dataIndex ) {
		    	var language = data[4];
		    	var status = data[5];
			    var start_date = data[2];
			    var subject = data[6].split(',');
			    var status_start_date;
				var currentDate = new Date();
				var seven_date_before = new Date();
				var seven_date_after = new Date();
				seven_date_before.setDate(seven_date_before.getDate() - 7);
				seven_date_after.setDate(seven_date_after.getDate() + 7);

				function validate_subjects_field(){
					var result = false;
					$.each(subject, function(index, value){
						if( $.inArray($.trim(value), subjects) != -1 ){
							result = true;
						}
					});
					return result;
				}

			    // Parse start_date to status value
			    // upcoming > cur_date, process < cur_date, recently_soon > cur_date - 7
			    if( start_date != '0000-00-00' ){
			    	if( start_date = new Date(start_date) ){
			    		if ( start_date < currentDate ) {
					    	status_start_date = 'process';
					    }

					    if ( start_date > seven_date_before ) {
					    	status_start_date = 'recently_soon';
					    }

					    if ( start_date > seven_date_after ) {
					    	status_start_date = 'upcoming';
					    }
			    	}else{
				    	status_start_date = 'unknown';
				    }
			    }else{
			    	status_start_date = 'unknown';
			    }

		      	if ( languages.length > 0 || statuses.length > 0  || subjects.length > 0 ) {
		      		 if ( ( languages.length > 0 && $.inArray(language, languages) != -1 ) ||
			        	  ( statuses.length > 0  && ( $.inArray(status, statuses) != -1 || $.inArray(status_start_date, statuses) != -1 ) ) ||
			        	  ( subjects.length > 0 && validate_subjects_field() ) ){

			        	if( languages.length > 0 && statuses.length > 0 && subjects.length > 0 ){
			        		if ( $.inArray(language, languages) != -1 && ( $.inArray(status, statuses) != -1 || $.inArray(status_start_date, statuses) != -1 ) && validate_subjects_field() ) {
			        			return true;
			        		}
			            	return false;
			        	}

			        	if( languages.length > 0 && statuses.length > 0 ){
			        		if ( $.inArray(language, languages) != -1 && ( $.inArray(status, statuses) != -1 || $.inArray(status_start_date, statuses) != -1 ) ) {
			        			return true;
			        		}
			            	return false;
			        	}

			        	if( statuses.length > 0 && subjects.length > 0 ){
			        		if ( ( $.inArray(status, statuses) != -1 || $.inArray(status_start_date, statuses) != -1 ) && validate_subjects_field() ) {
			        			return true;
			        		}
			            	return false;
			        	}

			        	if( languages.length > 0 && subjects.length > 0 ){
			        		if ( $.inArray(language, languages) != -1 && validate_subjects_field() ) {
			        			return true;
			        		}
			            	return false;
			        	}

			        	return true;
			        }
			        return false;
		      	}
		        return true;
		    }
		);

		$('#myInputTextField').keyup(function(){
			dtTable.search($(this).val()).draw() ;
			$('#number-of-courses').html(dtTable.page.info().recordsDisplay);
		})
		$('.dataTables_wrapper .top').append($('#tb-search'));
	} );
</script>
<!-- Get Footer -->
<?php get_footer(); ?>