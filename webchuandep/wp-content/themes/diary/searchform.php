<form method="get" id="searchform" class="form-wrapper cf" action="<?php echo home_url(); ?>" _lpchecked="1">
		<input type="text" name="s" id="s" value="" onfocus="if(this.value=='Search this Site...')this.value='';" x-webkit-speech onwebkitspeechchange="transcribe(this.value)"> 
<button type="submit">Search</button>
</form>