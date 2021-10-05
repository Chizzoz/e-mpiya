<p>Hi {{ $user->username }},</p>

<p>Welcome to Zambian Creatives! Thank you for showing interest and signing up.</p>

<p>Zambian Creatives is the result of a need, the need for a place to find Zambian creative content. We feel that there are few available resources, if any at all, to the public, providing a platform to view, contribute and share; creative content. Our goal is to provide a platform to meet this need in an intuitive and convenient manner.</p>

<p>You can now go to <a href="http://creatives.oneziko.com" alt="Zambian Creatives" title="Zambian Creatives Website" target="_blank">Zambian Creatives</a> and "check" <img src="{{ asset('/img/check.png') }}" title="check" alt="check" > creative content that interest you. For a better experience, go to your <a href="{{ route('edit-user-profile', Auth::user()->username_slug) }}">Edit Profile</a> page and update your personal information.</p>

<p>Feel free to reply to this email for any queries, we will respond as soon as possible.</p>
<p>We are on Facebook, like our page and let's interact: <a href="https://www.facebook.com/OneZiko" alt="facebook" title="One Ziko facebook page" target="_blank">One Ziko Facebook Page</a></p>
<p>We are also on Twitter, follow us and get latest updates: <a href="https://twitter.com/oneziko" alt="twitter" title="One Ziko twitter page" target="_blank">@OneZiko</a></p>

<p>Cheerfully yours,</p>
<p>The One Ziko Team</p>