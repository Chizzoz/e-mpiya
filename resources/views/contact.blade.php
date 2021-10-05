@extends('layouts.master')
@section('contact')
	<section id="contact">
		<div class="row">
			<div class="large-12 columns contact-contents">

				<div class="text-center">
					<h2>Contacts Us</h2>
					<?php
						// define variables and set to empty values
						$nameErr = $emailErr = $phoneErr = $inquiryErr = "";
						$name = $email = $phone = $inquiry = $email_message = "";
						$submitted = 0;

						if ($_SERVER["REQUEST_METHOD"] == "POST") {
						   if (empty($_POST["name"])) {
							 $nameErr = "Name is required";
						   } else {
							 $name = test_input($_POST["name"]);
							 $fill["name"] = $name;
							 // check if name only contains letters and whitespace
							 if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
							   $nameErr = "Only letters and white space allowed"; 
							 }
						   }
						   
						   if (empty($_POST["email"])) {
							 $emailErr = "Email is required";
						   } else {
							 $email = test_input($_POST["email"]);
							 $fill["email"] = $email;
							 // check if e-mail address is well-formed
							 if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
							   $emailErr = "Invalid email format"; 
							 }
						   }
							 
						   if (empty($_POST["phone"])) {
							 $phone = "";
						   } else {
							 $phone = test_input($_POST["phone"]);
							 $fill["phone"] = $phone;
							 // check if phone number format is valid
							 if (ctype_alpha(preg_replace('/[0-9]+/', '',$phone))) {
							   $phoneErr = "Phone Number Cannot Include Letters"; 
							 }
							 if (!ctype_digit(preg_replace('~[^0-9]~', '',$phone))) {
							   $phoneErr = "Your Phone Number Does Not Include Digits"; 
							 }
						   }

						   if (empty($_POST["inquiry"])) {
							 $inquiryErr = "You Cannot Submit an Empty Inquiry";
						   } else {
							 $inquiry = test_input($_POST["inquiry"]);
							 $fill["inquiry"] = $inquiry;
						   }
						}

						function test_input($data) {
						   $data = trim($data);
						   $data = stripslashes($data);
						   $data = htmlspecialchars($data);
						   return $data;
						}
						// Send email if no errors
						if (isset($fill)) {
							if (empty($nameErr) && empty($emailErr) && empty($phoneErr) && empty($inquiryErr)) {
								// Inquiry sent from address below
								$email_from = "no-reply@oneziko.com";
								
								// Send form contents to address below
								$email_to = "info@oneziko.com";
								
								// Email message subject
								$today = date("j F, Y. H:i:s");
								$email_subject = "One Ziko Website Submission [$today]";
								
								function clean_string($string) {

									$bad = array("content-type","bcc:","to:","cc:","href");

									return Str::replace($bad,"",$string);

								}

								$email_message .= "Name: ".clean_string($name)."\n";

								$email_message .= "Email: ".clean_string($email)."\n";

								$email_message .= "Phone: ".clean_string($phone)."\n";

								$email_message .= "Inquiry: ".clean_string($inquiry)."\n";
								
								// create email headers
								$headers = 'From: '.$email_from."\r\n".
								 
								'Reply-To: '.$email_from."\r\n" .
								 
								'X-Mailer: PHP/' . phpversion();
								 
								@mail($email_to, $email_subject, $email_message, $headers);
								
								$submitted = 1;
							}
						}
					?>
					<div class="small-12 medium-8 large-8 columns">
						<form name="contactus" method="post" action="{{ url('contact') }}">
							<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
							<span class="error">Name, Email and Inquiry are required fields.</span>
							<div class="row collapse prefix-radius">
								<div class="small-2 columns">
									<span class="prefix">Name</span>
								</div>
								<div class="small-10 columns">
									<input type="text" name="name" placeholder="Name" value="<?php
										if (isset($fill["name"]) && $submitted == 0) {
											echo $fill["name"];
										}?>">
									<span class="<?php
										if (empty($nameErr)) {
											 echo "hidden";
										   } else {
											 echo "error";
										}
									?>"><?php echo $nameErr;?></span>
								</div>
							</div>
							<div class="row collapse prefix-radius">
								<div class="small-2 columns">
									<span class="prefix">Email</span>
								</div>
								<div class="small-10 columns">
									<input type="text" name="email" placeholder="Email Address" value="<?php
										if (isset($fill["email"]) && $submitted == 0) {
											echo $fill["email"];
										}?>">
									<span class="<?php
										if (empty($emailErr)) {
											 echo "hidden";
										   } else {
											 echo "error";
										}
									?>"><?php echo $emailErr;?></span>
								</div>
							</div>
							<div class="row collapse prefix-radius">
								<div class="small-2 columns">
									<span class="prefix">Phone</span>
								</div>
								<div class="small-10 columns">
									<input type="text" name="phone" placeholder="Phone Number" value="<?php
										if (isset($fill["phone"]) && $submitted == 0) {
											echo $fill["phone"];
										}?>">
									<span class="<?php
										if (empty($phoneErr)) {
											 echo "hidden";
										   } else {
											 echo "error";
										}
									?>"><?php echo $phoneErr;?></span>
								</div>
							</div>
							<label>Inquiry
								<textarea name="inquiry" placeholder="Enter Your Query Here"><?php
									if (isset($fill["inquiry"]) && $submitted == 0) {
										echo $fill["inquiry"];
									}?></textarea>
							</label>
							<span class="<?php
										if (empty($inquiryErr)) {
											 echo "hidden";
										   } else {
											 echo "error";
										}
									?>"><?php echo $inquiryErr;?></span>
							<input type="submit" value="Submit" class="large expanded button" />
						</form>
								
						<!-- Success message -->
						<span class="success <?php if ($submitted == 0) { echo "hidden"; } ?>" >You have <strong>successfully sent</strong> an inquiry to <strong>One Ziko</strong>. We appreciate your interest and will get back to you as soon as we can.</span>
					</div>
					<div class="small-12 medium-4 large-4 column">
						<ul class="contact-details">
							<li>
								<img src="{{ asset('/img/email-32.gif') }}" alt="email" />  <a href="mailto:info@oneziko.com">info@oneziko.com</a>
							</li>
						</ul>
						<ul class="projects">
							<li><strong>Services</strong></li>
							<li><a href="http://maliketi.oneziko.com/" target="_blank">Maliketi eXchange</a></li>
							<li><a href="http://creative.oneziko.com/" target="_blank">Zambian Creatives</a></li>
							<li><a href="http://facts.oneziko.com/" target="_blank">Zambian Facts</a></li>
							<li><a href="http://headlines.oneziko.com/" target="_blank">Zambian Headlines</a></li>
							<li><a href="http://lyrics.oneziko.com/" target="_blank">Zambian Lyrics</a></li>
							<li><a href="http://timeline.oneziko.com/" target="_blank">Zambian Music Timeline</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
@stop