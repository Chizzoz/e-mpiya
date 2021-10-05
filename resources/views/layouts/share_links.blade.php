<!-- Share Links -->
<div class="social-share-links row medium-up-4">
	<div class="one-ziko-check column">
		<?php $checks = App\models\ContentUserFavourite::whereContentId($content->content_id)->count() ?>
		<div id="check-content-<?php echo $content->content_id; ?>">
			<input type="hidden" id="checks-<?php echo $content->content_id; ?>" value="{{ $checks }}">
			<?php
			$user_checked = '';
			if (!Auth::guest()) {
				$user_id = Auth::user()->id;
				$user_checked = App\models\ContentUserFavourite::whereContentId($content->content_id)->whereUserId($user_id)->count();
			}
			$str_check = "check";
			if(!empty($user_checked)) {
			$str_check = "uncheck";
			}
			?>
			<div class="checks-button">
				<div><input type="button" title="<?php echo ucwords($str_check); ?>" class="<?php echo $str_check; ?>" onClick="addChecks(<?php echo $content->content_id; ?>,'<?php echo $str_check; ?>',<?php if (Auth::user()) { echo 1; } else { echo 0; } ?>)" /></div>
			</div>
			<div class="checks-label"><?php if(!empty($checks)) {
				if($checks==1) {
					echo $checks . " check";
				} else {
					echo $checks . " check(s)";
				}
			} else { echo "Check"; } ?></div>
		</div>
	</div>
	<div class="fb-share-button column" data-href="{{ route('view-creative-content', $content->title_slug) }}" data-layout="button_count"></div>
	<div class="twitter column"><a href="https://twitter.com/share" class="twitter-share-button" target="_blank" data-url="{{ route('view-creative-content', $content->title_slug) }}" data-text="{{ $content->title }}" data-via="oneziko" data-hashtags="ZambianCreatives">Share</a>
	</div>
	<div class="whatsapp-share-button column">
		<a href="whatsapp://send" data-text="{{ $content->title }}" data-href="{{ route('view-creative-content', $content->title_slug) }}" class="wa_btn wa_btn_m" style="display:none">Share</a>
	</div>
</div>
