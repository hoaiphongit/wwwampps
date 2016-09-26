<form method="get" id="searchform" class="search-form" action="<?php echo home_url(); ?>" _lpchecked="1">
	<fieldset>
		<input type="text" name="s" id="s" value="Search this site..." onblur="if (this.value == '') {this.value = 'Search this site...';}" onfocus="if (this.value == 'Search this site...') {this.value = '';}" >
		<input type="submit" value="Search" onclick="if(this.value=='Search this Site...')this.value='';" />
	</fieldset>
</form>