	{if $is_logged_in}
		<a href="{shop_url('profile')}" rel="nofollow" class="items">Личный кабинет</a>
	{else:}
		<a href="/auth" class="items" rel="nofollow">Авторизация</a>
	{/if}
	<a href="{shop_url('cart')}" rel="nofollow" class="items">
		{echo ShopCore::app()->SCart->totalItems()}
		{echo SStringHelper::Pluralize(ShopCore::app()->SCart->totalItems(), array(lang('товар', 'newLevel'),lang('товара', 'newLevel'),lang('товаров', 'newLevel')))}
	</a>
	<span class="prices">{echo ShopCore::app()->SCart->totalPrice()} {$CS}
		<a href="{shop_url('cart')}" class="image" rel="nofollow"><img src="{$SHOP_THEME}style/images/myitems.jpg" width="22" height="18" border="0" alt="mycart" /></a>
	</span>