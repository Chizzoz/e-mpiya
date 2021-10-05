<p>Hi {{ $associator->username }},</p>
<br>
<p>{{ $associated->username }} has accepted your association request.</p>
<br>
<p>You can visit <a href="{{ route('view-user-profile', $associated->username_slug) }}" alt="{{ $associated->username }}" title="{{ $associated->username }}'s profile" target="_blank">{{ $associated->username }}'s profile page.</a> {{ $associated->username }} has now been added to your "Associates List" and you can easily access their "Profile Page", "Associates List" and "Check List".</p>
<br>
<p>Feel free to reply to this email for any queries, we will respond as soon as possible.</p>
<br>
<p>Cheerfully yours,</p>
<p>The One Ziko Team</p>
<br>
<p><a href="https://www.facebook.com/OneZiko" alt="facebook" title="One Ziko facebook page" target="_blank">One Ziko Facebook Page</a></p>
<br>
<p><a href="https://twitter.com/oneziko" alt="twitter" title="One Ziko twitter page" target="_blank">@OneZiko on twitter</a></p>