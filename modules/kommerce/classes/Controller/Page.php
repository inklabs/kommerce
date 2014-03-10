<?php

class Controller_Page extends Controller_Template {

	public function action_available() {
		$this->auto_render = FALSE;

		echo 'Up';
	}
}
