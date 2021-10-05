@extends('layouts.master')
@section('user_profile_edit')
	<div class="large-9 medium-9 small-12 columns main">
		<br>
		<div class="user-profile-edit">
			<form action="{{ route('update-user-profile', $user->username_slug) }}" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
				<!-- Username -->
				<div class="large-12 medium-12 small-12 columns">
					<div class="row collapse prefix-radius">
						<div class="medium-3 columns">
							<span class="prefix"><strong>Username*</strong></span>
						</div>
						<div class="medium-9 column">
							<input type="text" name="username" placeholder="Username" value="{{ $user->username }}" />
						</div>
					</div>
					@if (count($errors) > 0)
						@foreach ($errors->get('username') as $error)
							<span class="error">{{ $error }}</span>
						@endforeach
					@endif
					<span class="required">(Required) Your Username</span>
				</div>
				<!-- User type -->
				<div class="large-12 medium-12 small-12 columns">
					<span class="prefix"><strong>User Type</strong></span>
					<div>
						<!-- Company <input type="radio" name="user_type" value="1" <?php if ($user->user_type_id == 1) echo 'checked' ?> />
						Group <input type="radio" name="user_type" value="2" <?php if ($user->user_type_id == 2) echo 'checked' ?> />
						Individual <input type="radio" name="user_type" value="3" <?php if ($user->user_type_id == 3) echo 'checked' ?> />
						<div class="large-12 medium-12 small-12 columns"><span class="optional">(Required) Your user type</span></div> -->
						<p>
							@if ($user->user_type_id == 1)
								Company
							@elseif ($user->user_type_id == 2)
								Group
							@elseif ($user->user_type_id == 3)
								Individual
							@endif
						</p>
						@if ($user->user_type_id == 1)
						<!-- Company user specific -->
						<div class="large-12 medium-12 small-12 columns">
							<!-- Company name
							<div class="large-12 medium-12 small-12 columns">
								<div class="row collapse prefix-radius">
									<div class="medium-3 columns">
										<span class="prefix"><strong>Company Name*</strong></span>
									</div>
									<div class="medium-9 column">
										<input type="text" name="company_name" placeholder="Company Name" value="{{ $user_type->company_name }}" />
									</div>
								</div>
								@if (count($errors) > 0)
									@foreach ($errors->get('company_name') as $error)
										<span class="error">{{ $error }}</span>
									@endforeach
								@endif
								<span class="required">(Required) Your Company Name</span>
							</div> -->
							<!-- Company Specialty -->
							<div class="large-12 medium-12 small-12 columns">
								<div class="row collapse prefix-radius">
									<div class="medium-3 columns">
										<span class="prefix"><strong>Company Specialisation</strong></span>
									</div>
									<div class="medium-9 column">
										<input id="company_specialisation" type="text" name="company_specialisation" placeholder="Company Specialisation" value="{{ $user_type->company_user_specific }}" />
									</div>
								</div>
								<span class="optional">(Optional) Your specialisation. Add your own if not listed.</span>
							</div>
							<!-- Established -->
							<div class="large-12 medium-12 small-12 columns">
								<div class="row collapse prefix-radius">
									<div class="medium-4 columns">
										<span class="prefix"><strong>Date Established (dd-mm-yyyy)</strong></span>
									</div>
									<?php $date_established = explode('-', $user_type->dateEstablished) ?>
									<div class="medium-8 column">
										<input class="day" type="text" name="day_established" placeholder="dd" value="{{ $date_established[2] }}" /> - 
										<input class="month" type="text" name="month_established" placeholder="mm" value="{{ $date_established[1] }}" /> - 
										<input class="year" type="text" name="year_established" placeholder="yyyy" value="{{ $date_established[0] }}" />
									</div>
									<input type="hidden" name="date_established" />
								</div>
								@if (count($errors) > 0)
									@foreach ($errors->get('day_established') as $error)
										<span class="error">{{ $error }}</span>
									@endforeach
								@endif
								@if (count($errors) > 0)
									@foreach ($errors->get('month_established') as $error)
										<span class="error">{{ $error }}</span>
									@endforeach
								@endif
								@if (count($errors) > 0)
									@foreach ($errors->get('year_established') as $error)
										<span class="error">{{ $error }}</span>
									@endforeach
								@endif
								@if (count($errors) > 0)
									@foreach ($errors->get('date_established') as $error)
										<span class="error">{{ $error }}</span>
									@endforeach
								@endif
								<span class="optional">(Optional) Date Established</span>
							</div>
						</div>
						@elseif ($user->user_type_id == 2)
						<!-- Group user specific -->
						<div class="large-12 medium-12 small-12 columns">
							<!-- Group Type -->
							<div class="large-12 medium-12 small-12 columns">
								<div class="row collapse prefix-radius">
									<div class="medium-3 columns">
										<span class="prefix"><strong>Group Type</strong></span>
									</div>
									<div class="medium-9 column">
										<input id="group_type" type="text" name="group_type" placeholder="Group Type" value="{{ $user_type->group_user_specific }}" />
									</div>
								</div>
								<span class="optional">(Optional) Your Group Type e.g: Band, Colaboration, Joint Venture, etc. Add your own if not listed.</span>
							</div>
							<!-- Date formed -->
							<div class="large-12 medium-12 small-12 columns">
								<div class="row collapse prefix-radius">
									<div class="medium-4 columns">
										<span class="prefix"><strong>Date Formed (dd-mm-yyyy)</strong></span>
									</div>
									<?php $date_formed = explode('-', $user_type->established) ?>
									<div class="medium-8 column">
										<input class="day" type="text" name="day_formed" placeholder="dd" value="{{ $date_formed[2] }}" /> - 
										<input class="month" type="text" name="month_formed" placeholder="mm" value="{{ $date_formed[1] }}" /> - 
										<input class="year" type="text" name="year_formed" placeholder="yyyy" value="{{ $date_formed[0] }}" />
									</div>
									<input type="hidden" name="date_formed" />
								</div>
								@if (count($errors) > 0)
									@foreach ($errors->get('day_formed') as $error)
										<span class="error">{{ $error }}</span>
									@endforeach
								@endif
								@if (count($errors) > 0)
									@foreach ($errors->get('month_formed') as $error)
										<span class="error">{{ $error }}</span>
									@endforeach
								@endif
								@if (count($errors) > 0)
									@foreach ($errors->get('year_formed') as $error)
										<span class="error">{{ $error }}</span>
									@endforeach
								@endif
								@if (count($errors) > 0)
									@foreach ($errors->get('date_formed') as $error)
										<span class="error">{{ $error }}</span>
									@endforeach
								@endif
								<span class="optional">(Optional) Date Group was Formed, Founded or Established</span>
							</div>
							<!-- Group Members -->
							<div class="large-12 medium-12 small-12 columns">
								<div class="row collapse prefix-radius">
									<div class="medium-3 columns">
										<span class="prefix"><strong>Group Members</strong></span>
									</div>
									<div class="medium-9 column">
										<input id="group_members" type="text" name="group_members" placeholder="Group Members" value="{{ $user_type->group_members }}" />
									</div>
								</div>
								<span class="optional">(Optional) Group Members. Type in comma seperated names or select from "Associate" hints.</span>
							</div>
						</div>
						@elseif ($user->user_type_id == 3)
						<!-- Individual user specific -->
						<div class="large-12 medium-12 small-12 columns">
							Female <input type="radio" name="gender" value="1" <?php if ($user_type->gender_id == 1) echo 'checked' ?> />
							Male <input type="radio" name="gender" value="2" <?php if ($user_type->gender_id == 2) echo 'checked' ?> />
							<!-- Individual occupation -->
							<div class="large-12 medium-12 small-12 columns">
								<div class="row collapse prefix-radius">
									<div class="medium-3 columns">
										<span class="prefix"><strong>Occupation</strong></span>
									</div>
									<div class="medium-9 column">
										<input id="occupation" type="text" name="occupation" placeholder="Occupation" value="{{ $user_type->individual_user_specific }}" />
									</div>
								</div>
								<span class="optional">(Optional) Your Occupation e.g. Artist, Consultant, Student, etc. Add your own if not listed.</span>
							</div>
							<!-- DOB -->
							<div class="large-12 medium-12 small-12 columns">
								<div class="row collapse prefix-radius">
									<div class="medium-4 columns">
										<span class="prefix"><strong>Date of Birth (dd-mm-yyyy)</strong></span>
									</div>
									<?php $date_of_birth = explode('-', $user_type->date_of_birth) ?>
									<div class="medium-8 column">
										<input class="day" type="text" name="day_of_birth" placeholder="dd" value="{{ $date_of_birth[2] or '' }}" /> - 
										<input class="month" type="text" name="month_of_birth" placeholder="mm" value="{{ $date_of_birth[1] or '' }}" /> - 
										<input class="year" type="text" name="year_of_birth" placeholder="yyyy" value="{{ $date_of_birth[0] or '' }}" />
									</div>
									<input type="hidden" name="date_of_birth" />
								</div>
								@if (count($errors) > 0)
									@foreach ($errors->get('day_of_birth') as $error)
										<span class="error">{{ $error }}</span>
									@endforeach
								@endif
								@if (count($errors) > 0)
									@foreach ($errors->get('month_of_birth') as $error)
										<span class="error">{{ $error }}</span>
									@endforeach
								@endif
								@if (count($errors) > 0)
									@foreach ($errors->get('year_of_birth') as $error)
										<span class="error">{{ $error }}</span>
									@endforeach
								@endif
								@if (count($errors) > 0)
									@foreach ($errors->get('date_of_birth') as $error)
										<span class="error">{{ $error }}</span>
									@endforeach
								@endif
								<span class="optional">(Optional) Your Date of Birth</span>
							</div>
						</div>
						</div>
						@endif
					</div>
					@if (count($errors) > 0)
						@foreach ($errors->get('user_type') as $error)
							<span class="error">{{ $error }}</span>
						@endforeach
					@endif
				</div>
				<!-- Profile Picture -->
				<div class="small-12 medium-12 columns">
					<fieldset>
						<legend><strong>Profile Picture</strong></legend>
						<div class="row collapse prefix-radius">
							<div class="medium-3 columns">
								<span class="prefix">Profile Picture Link</span>
							</div>
							<div class="medium-9 column">
								<input type="text" name="profile_picture_link"  placeholder="Profile Picture link (http://*.* or www.*.*)" value="{{ $user->user_profile_picture }}" />
							</div>
						</div>
						<span class="optional">(Option 1) A web link to the image you wish to set as a profile picture</span>
						<center><h5>OR</h5></center>
						<div class="medium-12 column">
							<input type="file" name="profile_picture_upload"  accept="image/*" />
							<span class="optional">(Option 2) Upload an image</span>
						</div>
						<img src="<?php
						if (!(Auth::user()->user_profile_picture == "")) {
							echo Str::replace('users', 'small', $user->user_profile_picture);
						} else {
							echo asset('/images/small/default-user-profile-picture.png');
						} ?>" title="{{ Auth::user()->username }}" alt="{{ Auth::user()->username }}">
					</fieldset>
				</div>
				<!-- Password -->
				<div class="large-12 medium-12 small-12 columns">
					<div class="row collapse prefix-radius">
						<div class="medium-3 columns">
							<span class="prefix"><strong>Password*</strong></span>
						</div>
						<div class="medium-9 column">
							<input type="password" name="password" placeholder="Password" value="{{ $user->password }}" />
						</div>
					</div>
					<div class="row collapse prefix-radius">
						<div class="medium-3 columns">
							<span class="prefix"><strong>Password Confirm*</strong></span>
						</div>
						<div class="medium-9 column">
							<input type="password" name="password_confirm" placeholder="Password Confirm" value="{{ $user->password }}" />
						</div>
					</div>
					@if (count($errors) > 0)
						@foreach ($errors->get('password') as $error)
							<span class="error">{{ $error }}</span>
						@endforeach
					@endif
					@if (count($errors) > 0)
						@foreach ($errors->get('password_confirm') as $error)
							<span class="error">{{ $error }}</span>
						@endforeach
					@endif
					<span class="required">(Required) Your password, minimum length of 6 characters</span>
				</div>
				<!-- Mobile Network Operator -->
				<div class="large-12 medium-12 small-12 columns">
					<span class="prefix"><strong>Mobile Network</strong></span>
					<div>
						Airtel <input type="radio" name="mobile_network" id="mobile-network" class="mobile-network" value="Airtel" <?php if ($user_mobile->mobile_service_provider_id == 1) echo 'checked' ?> />
						MTN <input type="radio" name="mobile_network" id="mobile-network" class="mobile-network" value="MTN" <?php if ($user_mobile->mobile_service_provider_id == 2) echo 'checked' ?> />
						Zamtel <input type="radio" name="mobile_network" id="mobile-network" class="mobile-network" value="Zamtel" <?php if ($user_mobile->mobile_service_provider_id == 3) echo 'checked' ?> />
						Other <input type="radio" name="mobile_network" id="mobile-network" class="mobile-network" value="Other" <?php if ($user_mobile->mobile_service_provider_id == 4) echo 'checked' ?> />
					</div>
					@if (count($errors) > 0)
						@foreach ($errors->get('mobile_network') as $error)
							<span class="error">{{ $error }}</span>
						@endforeach
					@endif
					<span class="optional">(Optional) Your Mobile Network Provider</span>
				</div>
				<!-- Mobile Number -->
				<div class="large-12 medium-12 small-12 columns">
					<div class="row collapse prefix-radius">
						<div class="medium-3 columns">
							<span id="mobile-number" class="prefix"><strong>Mobile Number</strong></span>
						</div>
						<div class="medium-9 column">
							<input id="user-mobile" type="text" name="<?php if ($user_mobile->mobile_service_provider_id == 1) {
								echo "Airtel";
							} elseif ($user_mobile->mobile_service_provider_id == 2) {
								echo "MTN";
							} elseif ($user_mobile->mobile_service_provider_id == 3) {
								echo "Zamtel";
							} elseif ($user_mobile->mobile_service_provider_id == 4) {
								echo "Other";
							} else {
								echo "Number";
							} ?>" placeholder="Mobile Number" value="{{ $user_mobile->user_mobile_number }}" />
							<input type="hidden" name="MobileNetwork" />
						</div>
					</div>
					@if (count($errors) > 0)
						@foreach ($errors->get('Airtel') as $error)
							<span class="error">{{ $error }}</span>
						@endforeach
					@endif
					@if (count($errors) > 0)
						@foreach ($errors->get('MTN') as $error)
							<span class="error">{{ $error }}</span>
						@endforeach
					@endif
					@if (count($errors) > 0)
						@foreach ($errors->get('Zamtel') as $error)
							<span class="error">{{ $error }}</span>
						@endforeach
					@endif
					@if (count($errors) > 0)
						@foreach ($errors->get('Other') as $error)
							<span class="error">{{ $error }}</span>
						@endforeach
					@endif
					@if (count($errors) > 0)
						@foreach ($errors->get('MobileNetwork') as $error)
							<span class="error">{{ $error }}</span>
						@endforeach
					@endif
					<span class="optional">(Optional) Your Mobile Number, e.g. 095xxxxxxx or 096xxxxxxx or 097xxxxxxx</span>
				</div>
				<!-- eMail Address -->
				<div class="large-12 medium-12 small-12 columns">
					<div class="row collapse prefix-radius">
						<div class="medium-3 columns">
							<span class="prefix"><strong>eMail Address*</strong></span>
						</div>
						<div class="medium-9 column">
							<input type="text" name="email" placeholder="eMail Address" value="{{ $user->email }}" />
						</div>
					</div>
					@if (count($errors) > 0)
						@foreach ($errors->get('email') as $error)
							<span class="error">{{ $error }}</span>
						@endforeach
					@endif
					<span class="required">(Required) Your eMail Address</span>
				</div>
				<!-- Website -->
				<div class="large-12 medium-12 small-12 columns">
					<div class="row collapse prefix-radius">
						<div class="medium-3 columns">
							<span class="prefix"><strong>Website</strong></span>
						</div>
						<div class="medium-9 column">
							<input type="text" name="website" placeholder="Website" value="{{ $user->website }}" />
						</div>
					</div>
					<span class="optional">(Optional) Your website</span>
				</div>
				<!-- Location -->
				<div class="large-12 medium-12 small-12 columns">
					<fieldset>
						<legend><strong>Location</strong></legend>
						<div class="row">
							<div class="large-3 medium-3 small-12 columns">
								<select id="country" name="country">
									@if (!is_null($user_location))
										@if ($user_location->country_id == 0)
											<option value='{{ $user_location->country_id }}'>--</option>
										@else
											<option value='{{ $user_location->country_id }}'>{{ $user_location->country }}</option>
											<option value='0'>--</option>
										@endif
									@else
										<option value='0'>--</option>
									@endif
									@foreach($countries as $country)
										<option value='{{ $country->id }}'>{{ $country->country }}</option>
									@endforeach
								</select>
							</div>
							<div class="large-3 medium-3 small-12 columns">
								<select id="province" name="province">
									@if (!is_null($user_location))
										@if ($user_location->province_id == 0)
											<option value='{{ $user_location->province_id }}' class='0'>--</option>
										@else
											<option value='{{ $user_location->province_id }}' class='{{ $user_location->country_id }}'>{{ $user_location->province }}</option>
											<option value='0' class='0'>--</option>
										@endif
									@else
										<option value='0' class='0'>--</option>
									@endif
									@foreach($countries as $country)
										<option value='0' class='{{ $country->id }}'>--</option>
									@endforeach
									@foreach($provinces as $province)
										<option value='{{ $province->id }}' class='{{ $province->country_id }}'>{{ $province->province }}</option>
									@endforeach
								</select>
							</div>
							<div class="large-3 medium-3 small-12 columns">
								<select id="district" name="district">
									@if (!is_null($user_location))
										@if ($user_location->district_id == 0)
											<option value='{{ $user_location->district_id }}' class='0'>--</option>
										@else
											<option value='{{ $user_location->district_id }}' class='{{ $user_location->province_id }}'>{{ $user_location->district }}</option>
											<option value='0' class='0'>--</option>
										@endif
									@else
										<option value='0' class='0'>--</option>
									@endif
									@foreach($provinces as $province)
										<option value='0' class='{{ $province->id }}'>--</option>
									@endforeach
									@foreach($districts as $district)
										<option value='{{ $district->id }}' class='{{ $district->province_id }}'>{{ $district->district }}</option>
									@endforeach
								</select>
							</div>
							<div class="large-3 medium-3 small-12 columns">
								<select id="area" name="area">
									@if (!is_null($user_location))
										@if ($user_location->area_id == 0)
											<option value='{{ $user_location->area_id }}' class='0'>--</option>
										@else
											<option value='{{ $user_location->area_id }}' class='{{ $user_location->district_id }}'>{{ $user_location->area_name }}</option>
											<option value='0' class='0'>--</option>
										@endif
									@else
										<option value='0' class='0'>--</option>
									@endif
									@foreach($districts as $district)
										<option value='0' class='{{ $district->id }}'>--</option>
									@endforeach
									@foreach($areas as $area)
										<option value='{{ $area->id }}' class='{{ $area->district_id }}'>{{ $area->area_name }}</option>
									@endforeach
								</select>
							</div>
						</div>
					</fieldset>
				</div>
				<!-- Slogan -->
				<div class="medium-12 column">
					<label><strong><strong>Slogan (Optional):</strong></strong></label>
				</div>
				<div class="medium-12 column">
					<textarea name="slogan" placeholder="Your slogan or favourite quote." >{{ $user->slogan }}</textarea>
				</div>
				<!-- About -->
				<div class="medium-12 column">
					<label><strong><strong>About (Optional):</strong></strong></label>
				</div>
				<div class="medium-12 column">
					<textarea name="about" placeholder="About Yourself" >{{ $user->about }}</textarea>
				</div>
				<div class="medium-12 column text-center">
					<input type="submit" value="Save" class="small button" />
					<a href="{{ route('view-user-profile', Auth::user()->username_slug) }}" class="small button">Cancel</a>
				</div>
			</form>
		</div>
	</div>
</div>
@stop