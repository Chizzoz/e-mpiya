@extends('layouts.master')
@section('about')
	<section id="about">
		<div class="medium-12 columns about text-center">
			<h2>What is e-Mpiya OMPS?</h2>
			<p>e-Mpiya is a word derived from the bemba tribe of Zambia, meaning money. OMPS is an acronym for Online and Mobile Payment System. e-Mpiya provides a bridge between your money in the real world and the virtual web, online and mobile world.</p>
			<p>e-Mpiya breaks the walls between different money providers and financial institution by acting as a third party payments provider.</p>
			<p><img src="{{ asset('img/empiya_logo.png') }}" alt="Zambian Lyrics Logo" title="Zambian Lyrics Logo"></p>
		</div>
	</section>
	
	<section id="features">
		<div class="small-12 medium-12 large-12 columns features text-center">
			<div class="small-12 medium-6 large-6 columns">
				<h3>For Financial Institutions and Mobile Money Providers</h3>
				<p><img src="{{ asset('img/artist.png') }}" alt="Read"></p>
				<ul class="vertical menu">
					<li class="bullet-item-odd">A lyrics platform dedicated to promoting Zambian songs and poetry</li>
					<li class="bullet-item-even">A relevant audience and user base</li>
					<li class="bullet-item-odd">Integration with Sound Cloud and YouTube, allowing embedding of already existing media to lyrics*</li>
					<li class="bullet-item-even">Sharing options to Facebook, Twitter and WhatsApp**</li>
					<li class="bullet-item-odd">Insights, such as clicks and views</li>
					<li class="bullet-item-even">Once you register on Zambian Lyrics, you also get instant access to all other One Ziko services, such as Zambian Music Timeline, Zambian Headlines, Zambian Facts and other future services.</li>

				</ul>
			</div>
			<div class="small-12 medium-6 large-6 columns">
				<h3>For Merchants</h3>
				<p><img src="{{ asset('img/fans.png') }}" alt="Post"></p>
				<ul class="vertical menu">
					<li class="bullet-item-odd">Do you think you know your favourite song lyrics better than anyone else? You are free to express yourself, post lyrics and see what other users think.</li>
					<li class="bullet-item-even">A dedicated platform to find lyrics, to your favourite Zambian songs, by your favourite artists and to discover lyrics to songs by other artists</li>
					<li class="bullet-item-odd">A dedicated platform to find and discover poem lyrics and Zambian poets</li>
					<li class="bullet-item-even">Sharing interesting content with friends on Facebook, Twitter and WhatsApp**</li>
					<li class="bullet-item-odd">Once you register on Zambian Lyrics, you also get instant access to all other One Ziko services, such as Zambian Music Timeline, Zambian Headlines, Zambian Facts and other future services.</li>
				</ul>
			</div>
		</div>
	</section>
	
	<section id="more-features">
		<div class="medium-12 columns more-features text-center">
			<div class="small-12 medium-12 large-12 columns">
				<h3>For Consumers</h3>
				<p><img src="{{ asset('img/more-user-features.png') }}" alt="Share"></p>
				<ul class="vertical menu">
					<li class="bullet-item-odd">Send money across your accounts on different platforms or to family, friends and other obligations.</li>
					<li class="bullet-item-even">Conveniently buy from various e-Commerce platforms with our payment option.</li>
				</ul>
			</div>
		</div>
	</section>
	
	<section id="fine-print">
		<div class="small-12 medium-12 large-12 columns">
			<ul class="vertical menu">
				<li><small>*	Integration with other services can be added on request</small></li>
				<li><small>**	Other sharing options can be added on request</small></li>
			</ul>
		</div>
	</section>
	
	<section id="register-now">
		<div class="medium-12 columns register-now text-center">
			<h1>Register Now</h1>
			<p><strong><a href="{{ url('/register') }}" alt="REGISTER" title="REGISTER">REGISTER</a></strong> now to start using e-Mpiya.</p>
			<p>Feel free to <strong><a href="{{ url('contact') }}" alt="Contact Us" title="Contact Us">CONTACT US</a></strong> for any queries. Thank you!</p>
		</div>
	</section>
@stop