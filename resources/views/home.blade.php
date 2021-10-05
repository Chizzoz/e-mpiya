@extends('layouts.master')
@section('home')
	<?php
		$path = Request::path();
	?>
	<div class="fluid_container">
		<div class="camera_wrap camera_azure_skin" id="camera_random">
			<?php
				$slides = array(
					'<div data-thumb="images/slides/thumbs/bridge.jpg" data-src="images/slides/empiya-logo.jpg">
						<div class="camera_caption fadeFromBottom">
							e-Mpiya OMPS <em>(Online and Mobile Payment System)</em>
						</div>
					</div>',
					'<div data-thumb="images/slides/thumbs/leaf.jpg" data-src="images/slides/empiya-platforms.jpg">
						<div class="camera_caption fadeFromBottom">
							Take your pick! We offer a wide range and access platforms.
						</div>
					</div>',
					'<div data-thumb="images/slides/thumbs/leaf.jpg" data-src="images/slides/empiya-api.jpg">
						<div class="camera_caption fadeFromBottom">
							Connect your online or mobile platform with e-Mpiya to provide a convenient payment option to your customers
						</div>
					</div>',
					'<div data-thumb="images/slides/thumbs/road.jpg" data-src="images/slides/empiya-providers.jpg">
						<div class="camera_caption fadeFromBottom">
							Do you provide money services? Partner with, we will increase your deposits and help you reach further
						</div>
					</div>',
					'<div data-thumb="images/slides/thumbs/sea.jpg" data-src="images/slides/empiya-social.jpg">
						<div class="camera_caption fadeFromBottom">
							We are Social! With just one click, you can register seamlessly with Facebook, Google+ and Twitter
						</div>
					</div>'
				);
				foreach ($slides as $slides) {
					echo "$slides\n";
				}
			?>
		</div><!-- #camera_random -->
	</div><!-- .fluid_container -->
	<div class="large-9 medium-9 small-12 column contents">
		<div class="large-12 medium-12 small-12 columns my-callout">
			<h3>{{ $heading }}</h3>
		</div>
		<div class="large-12 medium-12 small-12 main column">
			<p>Contents here</p>
		</div>
	</div>
	@yield('right_sidebar')
@stop