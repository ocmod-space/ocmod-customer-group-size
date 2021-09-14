<?php

/*
This file is subject to the terms and conditions defined in the "LICENSE.txt"
file, which is part of this source code package and is also available on the
page: https://raw.githubusercontent.com/ocmod-space/license/main/LICENSE.txt.
*/

class ControllerExtensionModuleCustomerGroupSize extends Controller {
	private $error = array();

	public function __construct($params) {
		parent::__construct($params);

		if (strcmp(VERSION,'3.0.0.0') >= 0) {
			$this->ver = 3;
		} elseif (strcmp(VERSION,'2.2.0.0') >= 0) {
			$this->ver = 2;
		} else {
			throw new Exception('Unsupported OpenCart version!');
		}

		$this->type = 'module';
		$this->name = 'customer_group_size';

		$this->module = $this->type . '_' . $this->name;

		$this->route = 'extension/' . $this->type . '/' . $this->name;
		$this->class = 'model_' . str_replace('/', '_', $this->route);
	}

	public function index() {
		$this->load->language($this->route);

		$this->document->setTitle($this->language->get('heading_title'));

		if ($this->ver == 3) {
			$user_token = 'user_token=' . $this->session->data['user_token'];
			$extension_route = 'marketplace/extension';
		} elseif ($this->ver == 2) {
			$user_token = 'token=' . $this->session->data['token'];
			$extension_route = 'extension/extension';

			// load language variables
			foreach ($this->language->all() as $key => $value) {
				$data[$key] = $value;
			}
		}

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->load->model('setting/setting');
			$this->model_setting_setting->editSetting($this->module, $this->request->post);

			if (!isset($this->request->get['submit'])) {
				$redirect_to = $this->url->link($extension_route, $user_token . '&type=' . $this->type, true);
			} else {
				$redirect_to = $this->url->link($this->route, $user_token . '&type=' . $this->type, true);
			}

			$this->response->redirect($redirect_to);
			$this->session->data['success'] = $this->language->get('text_success');
		}

		if (isset($this->error['permission'])) {
			$data['error_permission'] = $this->error['permission'];
		} else {
			$data['error_permission'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', $user_token, true),
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link($extension_route, $user_token . '&type=' . $this->type, true),
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link($this->route, $user_token, true),
		);

		$data['action'] = $this->url->link($this->route, $user_token, true);
		$data['submit'] = $this->url->link($this->route, $user_token . '&submit=1', true);
		$data['cancel'] = $this->url->link($extension_route, $user_token . '&type=' . $this->type, true);

		if (isset($this->request->post[$this->module . '_status'])) {
			$data['status'] = $this->request->post[$this->module . '_status'];
		} else {
			$data['status'] = $this->config->get($this->module . '_status');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view($this->route, $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', $this->route)) {
			$this->error['permission'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function install() {
		$this->uninstall();

		$this->load->model('user/user_group');
		// $this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', $this->route);
		// $this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', $this->route);

		if ($this->ver == 3) {
			$event_route = 'setting/event';
			$event_class = 'model_setting_event';
		} elseif ($this->ver == 2) {
			$event_route = 'extension/event';
			$event_class = 'model_extension_event';
		} else {
			return;
		}

		$this->load->model($event_route);

		// Add events
		$event = $this->name . '_admin';
		$trigger = 'admin/view/customer/customer_group_list/before';
		$action = $this->route . '/before_customer_group_list';
		$this->{$event_class}->addEvent($event, $trigger, $action);
	}

	public function uninstall() {
		if ($this->ver == 3) {
			$event_route = 'setting/event';
			$event_class = 'model_setting_event';
			$delete_method = 'deleteEventByCode';
		} elseif ($this->ver == 2) {
			$event_route = 'extension/event';
			$event_class = 'model_extension_event';
			$delete_method = 'deleteEvent';
		} else {
			return;
		}

		$this->load->model($event_route);

		$events = array(
			$this->name . '_admin',
		);

		// Delete events
		foreach ($events as $event) {
			$this->{$event_class}->{$delete_method}($event);
		}

		$this->load->model('user/user_group');
		// $this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', $this->route);
		// $this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', $this->route);
	}

	// admin/view/customer/customer_group_list/before
	public function before_customer_group_list(&$route, &$data) {
		if ($this->config->get($this->module . '_status')) {
			$data['customer_group_size']  = true;

			$this->load->model($this->route);

			$this->load->language($this->route);
			$data['column_size'] = $this->language->get('column_size');

			foreach ($data['customer_groups'] as &$customer_group) {
				$customer_group_id = $customer_group['customer_group_id'];

				$customer_group['size'] = $this->{$this->class}->getCustomerGroupSize($customer_group_id);
			}
		}
	}
}
