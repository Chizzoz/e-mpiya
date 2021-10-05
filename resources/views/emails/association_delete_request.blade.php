<p>Hi {{ $acceptor->username }},</p>
<br>
<p>You have a pending request to delete your association with {{ $requestor->username }}.</p>
<br>
<p>You can visit <a href="{{ route('view-user-profile', $requestor->username_slug) }}" alt="{{ $requestor->username }}" title="{{ $requestor->username }}'s profile" target="_blank">{{ $requestor->username }}'s profile page</a> and "Accept" or "Decline" the delete association request.</p>
<br>
<p>By accepting {{ $requestor->username }}'s delete association request, you will be removing them from your "Associates List".</p>
<br>
<p>Feel free to reply to this email for any queries, we will respond as soon as possible.</p>
<br>
<p>Cheerfully yours,</p>
<p>The One Ziko Team</p>
<br>
<p><a href="https://www.facebook.com/OneZiko" alt="facebook" title="One Ziko facebook page" target="_blank">One Ziko Facebook Page</a></p>
<br>
<p><a href="https://twitter.com/oneziko" alt="twitter" title="One Ziko twitter page" target="_blank">@OneZiko on twitter</a></p>