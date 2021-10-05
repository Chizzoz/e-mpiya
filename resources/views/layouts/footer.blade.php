	</div>
	<!-- Footer -->
    <footer>
        <div class="row">
			<div class="medium-12 column footer-links">
				<ul class="footer menu">
					<li><a href="{{ url('terms') }}" title="Terms and Conditions">Terms and Conditions</a></li>
					<li><a href="{{ url('about') }}" title="About">About</a></li>
					<li><a href="{{ url('credits') }}" title="Credits">Credits</a></li>
					<li><a href="{{ url('contact') }}" title="Contact Us">Contact Us</a></li>
				</ul>
			</div>
			<div class="medium-12 column base">
				<div class="small-8 column copyright">
					<a href="http://oneziko.com" title="One Ziko Homepage" target="_blank">e-Mpiya OMPS &copy; One Ziko 2016</a>
				</div>
				<div>
					<ul class="social">
						<li class="facebook"><a href="https://www.facebook.com/OneZiko" alt="facebook" title="One Ziko facebook page" target="_blank"></a></li>
						<li class="twitter"><a href="https://twitter.com/oneziko" alt="twitter" title="One Ziko twitter page" target="_blank"></a></li>
					</ul>
				</div>
			</div>
        </div>
    </footer>

    <!-- Scripts -->
	<script src="{{ asset('js/vendor/jquery.min.js') }}"></script>
	<script src="{{ asset('js/masonry.pkgd.min.js') }}"></script>
	<script src="{{ asset('js/vendor/what-input.min.js') }}"></script>
	<script src="{{ asset('js/foundation.min.js') }}"></script>
	<script src="{{ asset('js/app.js') }}"></script>
	<script src="{{ asset('js/jquery.chained.min.js') }}"></script>
	<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
	<script src='{{ asset("js/jquery.mobile.customized.min.js") }}'></script>
	<script src='{{ asset("js/jquery.easing.1.3.js") }}'></script> 
	<script src='{{ asset("js/camera.min.js") }}'></script>
	<script>
		jQuery(function(){

			jQuery('#camera_random').camera({
				height: '400px',
				thumbnails: false,
				loader: 'bar',
				pagination: false,
				time: 3000
			});

		});
	</script>
	@if (isset($company_specifics) || isset($group_specifics) || isset($individual_specifics))
		<script>
			$(function() {
				var companySpecifics = <?php echo $company_specifics ?>;
				$("#company_specialisation").autocomplete({
					source: companySpecifics,
					autoFocus:true
				});
			});
		</script>
		<script>
			$(function() {
				var groupSpecifics = <?php echo $group_specifics ?>;
				$("#group_type").autocomplete({
					source: groupSpecifics,
					autoFocus:true
				});
			});
		</script>
		<script>
			$(function() {
				var individualSpecifics = <?php echo $individual_specifics ?>;
				$("#occupation").autocomplete({
					source: individualSpecifics,
					autoFocus:true
				});
			});
		</script>
	@endif
	@if (isset($usernames_and_account_numbers))
		<script>
			$(function() {
				var usernamesAndAccountNumbers = <?php echo $usernames_and_account_numbers ?>;
				$("#receiver_empiya_account").autocomplete({
					source: usernamesAndAccountNumbers,
					autoFocus:true
				});
			});
		</script>
	@endif
	<script>
		$("#province").chainedTo("#country");
		$("#district").chainedTo("#province");
		$("#area").chainedTo("#district");
	</script>
	<script>
		$('.mobile-network').change(function(e){
			var selectedValue = $(this).val();
			document.getElementById('user-mobile').name = selectedValue;
			$('#mobile-number').html('<span class="prefix"><strong>'+selectedValue+' Number</strong></span>')
		});
	</script>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
</body>

</html>