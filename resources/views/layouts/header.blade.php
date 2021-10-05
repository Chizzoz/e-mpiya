<!doctype html>
<html class="no-js" lang="en">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title><?php if (isset($heading)) echo $heading . " | "; ?>e-Mpiya OMPS (Online & Mobile Payments System) | One Ziko</title>
		<!-- unflurl -->
			<!-- TODO -->
		<!-- favicon -->
		<link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
		<link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
		<!-- Styling sheets -->
		<link href="{{ asset('css/foundation.css') }}" rel="stylesheet">
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<link href="{{ asset('css/camera.css') }}" rel="stylesheet"> 
		<link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet">
		<link href="{{ asset('js/skins/flat/editor.css') }}" rel="stylesheet">
		<link href="{{ asset('css/f5-forms.css') }}" rel="stylesheet">
		<!-- font -->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<!-- Load Soundcloud SDK -->
		<script src="//connect.soundcloud.com/sdk.js"></script>
		<!-- WhatsApp Share -->
		<script type="text/javascript">	if(typeof wabtn4fg==="undefined")	{wabtn4fg=1;h=document.head||document.getElementsByTagName("head")[0],s=document.createElement("script");s.type="text/javascript";s.src="{{ asset('js/dist/whatsapp-button.js') }}";h.appendChild(s)}</script>
		<!-- wysiwyg editor -->
		<script type="text/javascript" src="{{ asset('/js/ckeditor.js') }}"></script>
		<script type="text/javascript" src="{{ asset('/js/config.js') }}"></script>
		<!-- CSRF Script -->
		<script>
			window.Laravel = <?php echo json_encode([
				'csrfToken' => csrf_token(),
			]); ?>
		</script>
		<!-- Analytics JS -->
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-25495841-1', 'auto');
		  ga('send', 'pageview');

		</script>
	</head>
	<body>
		<!-- fb share JS-->
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
		<!-- One Ziko Menu Bar -->
		<?php $path = Request::path() ?>
		<div data-sticky-container>
			<div class="top-bar" data-sticky data-options="marginTop:0;" style="width:100%">
				<div class="row">
					<div class="top-bar-title">
						<span data-responsive-toggle="responsive-menu" data-hide-for="small">
							<span class="menu-icon dark" data-toggle></span>
						</span>
						<a href="{{ url('/') }}"><img src="{{ asset('img/zambian_creatives_logo_text.gif') }}" alt="icon"></a>
					</div>
					<div id="responsive-menu">
						<div class="top-bar-left">
							<ul class="menu">
								<li></li>
							</ul>
						</div>
						<div class="top-bar-right">
							<ul class="dropdown menu" data-dropdown-menu>
								<li class="divider"></li>
								<li @if ($path === '/' or $path === 'home') class="active" @endif>
									<a href="{{ url('/') }}">Home</a>
								</li>
								<!-- <li class="divider"></li>
								<li @if ($path === 'random') class="active" @endif>
									<a href="{{ url('random') }}">Random</a>
								</li> -->
								<li class="divider"></li>
								@if (Auth::guest())
									<li @if ($path === 'login') class="has-form active" @endif><a href="{{ url('/login') }}" class="medium login button">Login</a></li>
									<li class="divider"></li>
									<li @if ($path === 'register') class="active" @endif><a href="{{ url('/register') }}" class="medium register button">Register</a></li>
									<li class="divider"></li>
									<li class="<?php
										if (isset($path)) {
											if ($path == "about") {
												echo "active";
											}
										}
										?>" ><a href="{{ url('about') }}">About</a></li>
								@else
									<?php $user_admin_access = App\models\UserAccess::whereUserRoleId(1)->whereUserId(Auth::user()->id)->orderBy('user_role_id', 'ASC')->first() ?>
									<li>
										<a href="{{ route('view-user-profile', Auth::user()->username_slug) }}"><img src="<?php
											if (!(Auth::user()->user_profile_picture == "")) {
												echo Str::replace('users', 'small', Auth::user()->user_profile_picture);
											} else {
												echo asset('images/small/default-user-profile-picture.png');
											} ?>" title="{{ Auth::user()->username }}" alt="{{ Auth::user()->username }}"></a>
										<ul class="menu">
											<li><a href="{{ route('select-transaction-type') }}">New Transaction</a></li>
											<li><a href="{{ route('manage-content', array(Auth::user()->username_slug, 'empiya-content')) }}">Manage Content</a></li>
											@if (isset($user_admin_access))
												<li><a href="{{ route('manage-users', Auth::user()->username_slug) }}">Manage Users</a></li>
											@endif
											<li><a href="{{ route('edit-user-profile', Auth::user()->username_slug) }}">Edit Profile</a></li>
											<li><a href="{{ url('/logout') }}">Logout</a></li>
										</ul>
									</li>
								@endif
								<li class="divider"></li>
								<li class="<?php
									if (isset($path)) {
										if ($path == "contact") {
											echo "active";
										}
									}
									?>" ><a href="{{ url('contact') }}">Contact Us</a></li>
								<li class="divider"></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row main">