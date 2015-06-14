<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Twitter API</title>

		<!-- Bootstrap CSS -->
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">

		<!-- jQuery -->
		<script src="//code.jquery.com/jquery.js"></script>
		<script type="text/javascript">
			function goTo(what)
			{
				if ($('#keyword_search').val() == '')
				{
					alert('Please enter twitter handle');
					$('#keyword_search').focus();
					return false;	
				} else {
					var cursor_value = '';
					if(what == 'next') {
						cursor_value = $('#next_cursor_0').val();
					} else {
						cursor_value = $('#previous_cursor_0').val();
					}
					var search_keyword = $('#keyword_search').val();
		         	var data = "keyword_search="+search_keyword + "&cursor="+cursor_value;
		         	$("table tbody").html('<img src="https://cdnjs.cloudflare.com/ajax/libs/file-uploader/3.7.0/loading.gif" style="width:initial">');
		         	$.ajax({

				      	url : "ajaxData.php",
				      	type: 'post',
				      	data: data,
				      	success : function(data) {
				        	//console.log(data);
				        	var html = data;
				            // append the "ajax'd" data to the table body

				            $("table tbody").html(''); 
				            $("table tbody").append(html); 
				            // let the plugin know that we made a update 
				            $("table").trigger("update"); 

				            select_source();

				            var next_cursor = $('#next_cursor_0').val();
							var prev_cursor = $('#previous_cursor_0').val();

							if(next_cursor > 0) {
								$('#next_record').show();
							} else {
								$('#next_record').hide();
							}

							if(prev_cursor < 0) {
								$('#prev_record').show();
							} else {
								$('#prev_record').hide();
							}
				      	},
			            error: function(data) {
			              	console.log(data);
			              	alert('Failed');
			            }
				    });	
				}
			}

			function select_source(){
				$('.multi-field-wrapper').each(function() {
				    var $wrapper = $('.multi-fields', this);
				    $(".add-field", $(this)).click(function(e) {
				        $('.tag:first-child', $wrapper).clone(true).appendTo($wrapper);

				    });
				    $('.tag .remove-field', $wrapper).click(function() {
				        if ($('.tag', $wrapper).length > 1)
				            $(this).parent('.tag').remove();
				    });
				});

				$("input[name*='twitter']").change(function(){
					var value = $(this).val();
					var wrapper = $('.multi-fields');
					if($(this).attr('name') == 'twitter'){
						var direct_url = 'http://twitter.com/'+value;
					}

					if(this.checked){
						$('<div class="tag" id="'+value+'"><input type="checkbox"><a href="'+direct_url+'" target="_blank"><label for="">'+value+'</label></a><i class="fa fa-plus"></i><i class="fa fa-check remove-field" name="'+value+'"></i></div>').appendTo(wrapper);

						process_sources();
					}else{
						$('#'+value).remove();
					}

					$('.tag .remove-field').click(function() {
				        var checkbox_value = $(this).attr('name');
				        $("input[value*='"+checkbox_value +"']").prop('checked', false);

				        $(this).parent('.tag').remove();

				        process_sources();
				    });
				});
			}

			function process_sources(){
				if($('.multi-fields .tag').length > 0){
					$('#process_source').show();
				}else{
					$('#process_source').hide();
				}
			}
		</script>	
		<link rel="stylesheet" href="css/theme.blue.css">

		<style type="text/css">
			body{margin: 50px 20px}
			table{margin-top: 50px;}
			tbody td{font-size: 12px}
			
		</style>
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					
						<div class="form-group">
							<input type="text" name="keyword_search" placeholder="Enter Twitter Handle" id="keyword_search" class="form-control">
						</div>
					
				</div>	
			</div>
		</div>
		<div> 
			<a id="prev_record" href="javascript:void(0)" onclick="goTo('prev')" style="margin-right:20px; display:none">Prev</a>
			<a id="next_record" href="javascript:void(0)" onclick="goTo('next')" style="display:none">Next</a>
		</div>
		<div class="clearfix"></div>
		<table class="table table-hover tablesorter">
			<thead>
				<tr>
					<th>Select</th>
					<th>Pic</th>
					<th>Name</th>
					<th>Bio</th>
					<th>Tweets</th>
					<th>Following</th>
					<th>Follower</th>
					<th>Day Old</th>
					<th>Social Authority</th>
				</tr>
			</thead>
			<tbody></tbody>
			<tfoot>
				<tr>
					<th>Select</th>
					<th>Pic</th>
					<th>Name</th>
					<th>Bio</th>
					<th>Tweets</th>
					<th>Following</th>
					<th>Follower</th>
					<th>Day Old</th>
					<th>Social Authority</th>
				</tr>
			</tfoot>
		</table>
		<div class="pager"> 
			<span class="left">
				# per page:
				<a href="#">10</a> |
				<a href="#">25</a> |
				<a href="#">50</a> |
				<a href="#" class="current">200</a>
			</span>
			<span class="right">
				<span class="prev">
					<img src="http://mottie.github.com/tablesorter/addons/pager/icons/prev.png" /> Prev&nbsp;
				</span>
				<span class="pagecount"></span>
				&nbsp;<span class="next">Next
					<img src="http://mottie.github.com/tablesorter/addons/pager/icons/next.png" />
				</span>
			</span>
		</div>
		
		<!-- Bootstrap JavaScript -->
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

		<!-- Tablesorter: required -->
		<script src="js/jquery.tablesorter.js"></script>
		<script src="js/jquery.tablesorter.widgets.js"></script>
		<script src="js/jquery.tablesorter.pager.js"></script>
		<script src="js/pager-custom-controls.js"></script>
		<script id="js">
			$(function(){
				var $table = $('table'),
					$pager = $('.pager');

				$.tablesorter.customPagerControls({
					table          : $table,                   // point at correct table (string or jQuery object)
					pager          : $pager,                   // pager wrapper (string or jQuery object)
					pageSize       : '.left a',                // container for page sizes
					currentPage    : '.right a',               // container for page selectors
					ends           : 2,                        // number of pages to show of either end
					aroundCurrent  : 1,                        // number of pages surrounding the current page
					link           : '<a href="#">{page}</a>', // page element; use {page} to include the page number
					currentClass   : 'current',                // current page class name
					adjacentSpacer : ' | ',                    // spacer for page numbers next to each other
					distanceSpacer : ' \u2026 ',               // spacer for page numbers away from each other (ellipsis &amp;hellip;)
					addKeyboard    : true                      // add left/right keyboard arrows to change current page
				});

				// initialize tablesorter & pager
				$table
					.tablesorter({
						theme: 'blue',
						widgets: [ 'reorder', 'zebra', 'filter' ],
						widgetOptions: {
						reorder_axis        : 'x', // 'x' or 'xy'
						reorder_delay       : 300,
						reorder_helperClass : 'tablesorter-reorder-helper',
						reorder_helperBar   : 'tablesorter-reorder-helper-bar',
						reorder_noReorder   : 'reorder-false',
						reorder_blocked     : 'reorder-block-left reorder-block-end',
						reorder_complete    : null // callback
						}
					})
					.tablesorterPager({
						// target the pager markup - see the HTML block below
						container: $pager,
						size: 200,
						output: 'showing: {startRow} to {endRow} ({filteredRows})'
					});

				});
				
				$(document).ready(function() { 
					
					// SETUP
				    $("table").tablesorter();
				    select_source();

				    // CLICK
					$('#keyword_search').keypress(function(e) {
			    		if(e.which == 13) {
							var search_keyword = $('#keyword_search').val();
				         	var data = "keyword_search="+search_keyword;
				         	$("table tbody").html('<img src="https://cdnjs.cloudflare.com/ajax/libs/file-uploader/3.7.0/loading.gif" style="width:initial">');
				         	$.ajax({

						      	url : "ajaxData.php",
						      	type: 'post',
						      	data: data,
						      	success : function(data) {
						        	//console.log(data);
						        	var html = data;
						            // append the "ajax'd" data to the table body

						            $("table tbody").html(''); 
						            $("table tbody").append(html); 
						            // let the plugin know that we made a update 
						            $("table").trigger("update"); 

						            select_source();

						            var next_cursor = $('#next_cursor_0').val();
									var prev_cursor = $('#previous_cursor_0').val();

									if(next_cursor > 0) {
										$('#next_record').show();
									} else {
										$('#next_record').hide();
									}

									if(prev_cursor < 0) {
										$('#prev_record').show();
									} else {
										$('#prev_record').hide();
									}
						      	},
					            error: function(data) {
					              	console.log(data);
					              	alert('Failed');
					            }
						    });
				        }
				    });

					// SUBMIT
					$('.submit_btn').on('click', function(){
					  swal({   title: "Ready to start gathering data?",   text: "Finding Story Angles for your content.",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Yes.",   closeOnConfirm: false }, 
					    function(){
					      swal({
					        title: "Awesome!",   
					        text: "We will contact your email as soon as possible to help you set up a dedicated source list.",   
					        type: "input",
					        showCancelButton: true,
					        cancelButtonText: 'Nevermind...', 
					        closeOnConfirm: false,
					        confirmButtonText: 'Yep! Let me know!',
					        animation: "slide-from-top",
					        inputPlaceholder: "Enter Your Email"
					      }, 
					      function(inputValue){
					      	var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
					      	if (inputValue === false) return false;

					      	if(testEmail.test(inputValue)){

						      	swal({
							        title: "Success!",
						        	type: 'success',  
							        text: "Thank you! Will let you know when your dataset is ready.",
							        closeOnConfirm: true,
							        confirmButtonText: 'Cool!',
							        animation: "slide-from-top"
						      	});
						      	var print_src = '';
								$('.multi-fields .tag a').each(function () {
									var new_src = $(this).attr("href");
									print_src += new_src + '\n';
								});
						      	var user_name = inputValue;

						          // SEND EMAIL
						          $.ajax({
						          type: "POST",
						          data: {'email': user_name, 'source': print_src},
						          url: "form_email.php",
						          success: function(data){
						          	console.log(data);
						            console.log(user_name + ' Success on ' + print_src);
						          },
						          error: function(data) {
						              	console.log(data);
						              	alert('Failed');
						          }
				        		  });
				        	}else{
				        		swal.showInputError("You need to write your email!");     return false
				        	}
					      }); 
					  });
				});
			});

			
		</script>
	</body>
</html>