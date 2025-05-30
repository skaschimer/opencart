<?php
namespace Opencart\Admin\Controller\Customer;
/**
 * Class Customer Group
 *
 * @package Opencart\Admin\Controller\Customer
 */
class CustomerGroup extends \Opencart\System\Engine\Controller {
	/**
	 * Index
	 *
	 * @return void
	 */
	public function index(): void {
		$this->load->language('customer/customer_group');

		$this->document->setTitle($this->language->get('heading_title'));

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('customer/customer_group', 'user_token=' . $this->session->data['user_token'] . $url)
		];

		$data['add'] = $this->url->link('customer/customer_group.form', 'user_token=' . $this->session->data['user_token'] . $url);
		$data['delete'] = $this->url->link('customer/customer_group.delete', 'user_token=' . $this->session->data['user_token']);

		$data['list'] = $this->getList();

		$data['user_token'] = $this->session->data['user_token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('customer/customer_group', $data));
	}

	/**
	 * List
	 *
	 * @return void
	 */
	public function list(): void {
		$this->load->language('customer/customer_group');

		$this->response->setOutput($this->getList());
	}

	/**
	 * Get List
	 *
	 * @return string
	 */
	public function getList(): string {
		if (isset($this->request->get['sort'])) {
			$sort = (string)$this->request->get['sort'];
		} else {
			$sort = 'cgd.name';
		}

		if (isset($this->request->get['order'])) {
			$order = (string)$this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['action'] = $this->url->link('customer/customer_group.list', 'user_token=' . $this->session->data['user_token'] . $url);

		// Customer Groups
		$data['customer_groups'] = [];

		$filter_data = [
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_pagination_admin'),
			'limit' => $this->config->get('config_pagination_admin')
		];

		$this->load->model('customer/customer_group');

		$results = $this->model_customer_customer_group->getCustomerGroups($filter_data);

		foreach ($results as $result) {
			$data['customer_groups'][] = [
				'name' => $result['name'],
				'edit' => $this->url->link('customer/customer_group.form', 'user_token=' . $this->session->data['user_token'] . '&customer_group_id=' . $result['customer_group_id'] . $url)
			] + $result;
		}

		// Default
		$data['customer_group_id'] = $this->config->get('config_customer_group_id');

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		// Sorts
		$data['sort_name'] = $this->url->link('customer/customer_group.list', 'user_token=' . $this->session->data['user_token'] . '&sort=cgd.name' . $url);
		$data['sort_sort_order'] = $this->url->link('customer/customer_group.list', 'user_token=' . $this->session->data['user_token'] . '&sort=cg.sort_order' . $url);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		// Total Customer Groups
		$customer_group_total = $this->model_customer_customer_group->getTotalCustomerGroups();

		// Pagination
		$data['pagination'] = $this->load->controller('common/pagination', [
			'total' => $customer_group_total,
			'page'  => $page,
			'limit' => $this->config->get('config_pagination_admin'),
			'url'   => $this->url->link('customer/customer_group.list', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}')
		]);

		$data['results'] = sprintf($this->language->get('text_pagination'), ($customer_group_total) ? (($page - 1) * $this->config->get('config_pagination_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_pagination_admin')) > ($customer_group_total - $this->config->get('config_pagination_admin'))) ? $customer_group_total : ((($page - 1) * $this->config->get('config_pagination_admin')) + $this->config->get('config_pagination_admin')), $customer_group_total, ceil($customer_group_total / $this->config->get('config_pagination_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		return $this->load->view('customer/customer_group_list', $data);
	}

	/**
	 * Form
	 *
	 * @return void
	 */
	public function form(): void {
		$this->load->language('customer/customer_group');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['text_form'] = !isset($this->request->get['customer_group_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('customer/customer_group', 'user_token=' . $this->session->data['user_token'] . $url)
		];

		$data['save'] = $this->url->link('customer/customer_group.save', 'user_token=' . $this->session->data['user_token']);
		$data['back'] = $this->url->link('customer/customer_group', 'user_token=' . $this->session->data['user_token'] . $url);

		// Customer Group
		if (isset($this->request->get['customer_group_id'])) {
			$this->load->model('customer/customer_group');

			$customer_group_info = $this->model_customer_customer_group->getCustomerGroup($this->request->get['customer_group_id']);
		}

		if (!empty($customer_group_info)) {
			$data['customer_group_id'] = $customer_group_info['customer_group_id'];
		} else {
			$data['customer_group_id'] = 0;
		}

		// Languages
		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (!empty($customer_group_info)) {
			$data['customer_group_description'] = $this->model_customer_customer_group->getDescriptions($customer_group_info['customer_group_id']);
		} else {
			$data['customer_group_description'] = [];
		}

		if (!empty($customer_group_info)) {
			$data['approval'] = $customer_group_info['approval'];
		} else {
			$data['approval'] = '';
		}

		if (!empty($customer_group_info)) {
			$data['sort_order'] = $customer_group_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('customer/customer_group_form', $data));
	}

	/**
	 * Save
	 *
	 * @return void
	 */
	public function save(): void {
		$this->load->language('customer/customer_group');

		$json = [];

		if (!$this->user->hasPermission('modify', 'customer/customer_group')) {
			$json['error']['warning'] = $this->language->get('error_permission');
		}

		$required = [
			'customer_group_description' => [],
			'approval'                   => 0,
			'sort_order'                 => 0
		];

		$post_info = $this->request->post + $required;

		foreach ($post_info['customer_group_description'] as $language_id => $value) {
			if (!oc_validate_length($value['name'], 3, 32)) {
				$json['error']['name_' . $language_id] = $this->language->get('error_name');
			}
		}

		if (!$json) {
			// Customer Group
			$this->load->model('customer/customer_group');

			if (!$post_info['customer_group_id']) {
				$json['customer_group_id'] = $this->model_customer_customer_group->addCustomerGroup($post_info);
			} else {
				$this->model_customer_customer_group->editCustomerGroup($post_info['customer_group_id'], $post_info);
			}

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	/**
	 * Delete
	 *
	 * @return void
	 */
	public function delete(): void {
		$this->load->language('customer/customer_group');

		$json = [];

		if (isset($this->request->post['selected'])) {
			$selected = (array)$this->request->post['selected'];
		} else {
			$selected = [];
		}

		if (!$this->user->hasPermission('modify', 'customer/customer_group')) {
			$json['error'] = $this->language->get('error_permission');
		}

		// Setting
		$this->load->model('setting/store');

		// Customer
		$this->load->model('customer/customer');

		foreach ($selected as $customer_group_id) {
			if ($this->config->get('config_customer_group_id') == $customer_group_id) {
				$json['error'] = $this->language->get('error_default');
			}

			$store_total = $this->model_setting_store->getTotalStoresByCustomerGroupId($customer_group_id);

			if ($store_total) {
				$json['error'] = sprintf($this->language->get('error_store'), $store_total);
			}

			// Total Customers
			$customer_total = $this->model_customer_customer->getTotalCustomersByCustomerGroupId($customer_group_id);

			if ($customer_total) {
				$json['error'] = sprintf($this->language->get('error_customer'), $customer_total);
			}
		}

		if (!$json) {
			// Customer Group
			$this->load->model('customer/customer_group');

			foreach ($selected as $customer_group_id) {
				$this->model_customer_customer_group->deleteCustomerGroup($customer_group_id);
			}

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
