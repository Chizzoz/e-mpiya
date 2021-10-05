@extends('layouts.master')
@section('specific_account_info')
	<div class="large-12 medium-12 small-12 column">
		<div class="large-9 medium-9 small-12 column contents">
			<div class="large-12 medium-12 small-12 column select-provider-header my-callout">
				<h4>{{ $account_type_slug->account_type }} {{ $specific_account_info_heading }}</h4>
			</div>
			<div class="large-12 medium-12 small-12 transaction-providers-list column">
				<table class="stack hover">
					<thead>
						<tr>
							<th>Table Header</th>
							<th>Table Header</th>
							<th>Table Header</th>
							<th>Table Header</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Content Goes Here</td>
							<td>This is longer content Donec id elit non mi porta gravida at eget metus.</td>
							<td>Content Goes Here</td>
							<td>Content Goes Here</td>
						</tr>
						<tr>
							<td>Content Goes Here</td>
							<td>This is longer Content Goes Here Donec id elit non mi porta gravida at eget metus.</td>
							<td>Content Goes Here</td>
							<td>Content Goes Here</td>
						</tr>
						<tr>
							<td>Content Goes Here</td>
							<td>This is longer Content Goes Here Donec id elit non mi porta gravida at eget metus.</td>
							<td>Content Goes Here</td>
							<td>Content Goes Here</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		@yield('left_sidebar')
		@yield('right_sidebar')
	</div>
@stop


			