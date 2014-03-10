<?php

/**
 * Template Layout
 *
 * Two ways to enact the template layout:
 *   1) Create a view in views/<controller>/<action>.php
 *   2) Set this variable in your action: $this->template->content = 'output';
 *
 * Custom formats work with the template layout:
 *   1) Create a view: views/<controller>/<action>.txt.php
 *   2) Create a template: views/template.txt.php
 *   3) Enable formats in the route (<controller>(/<action>(/<id>(.<format>))))
 *   4) Enable the format in your controller: public $enabled_formats = array('txt');
 *
 * @package default
 * @author Jamie Isaacs
 * @since 2011-10-14
 */
class Controller_Template extends Kohana_Controller_Template {
	public $template = 'template';
	public $data = array();
	public $auth_required = FALSE;
	public $view_path = NULL;
	public $format = NULL;
	public $enabled_formats = array();

	public function before() {
		if ($this->auto_render) {
			$this->format = $this->request->param('format');

			if ($this->format !== NULL) {
				if ( ! in_array($this->format, $this->enabled_formats)) {
					throw HTTP_Exception::factory(404);
				}

				$this->template .= '.' . $this->format;
			}
		}

		parent::before();
	}

	public function after() {
		if ($this->auto_render) {
			if ($this->view_path === NULL) {
				$view_path = implode('/', array_diff(
					array(strtolower($this->request->directory()), strtolower($this->request->controller()), $this->request->action()),
					array('')
				));
			} else {
				$view_path = $this->view_path;
			}

			if ($this->format !== NULL) {
				if ($this->format === 'txt') {
					$this->response->headers('Content-Type', 'text/plain');
				}

				$view_path .= '.' . $this->format;
			}

			$view = View::factory($view_path);
			foreach ($this->data as $k => $v) {
				$view->set_global($k, $v);
			}

			$this->template->content = $view->render();
		}

		parent::after();
	}
}
