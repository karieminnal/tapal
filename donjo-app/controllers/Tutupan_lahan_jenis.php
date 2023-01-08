<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tutupan_lahan_jenis extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		session_start();
		$this->load->model('header_model');
		$this->load->model('tutupan_lahan_jenis_model');
		$this->modul_ini = 7;
		$this->sub_modul_ini = 215;
	}

	public function index($p = 1, $o = 0)
	{
		$this->tab_ini = 17;
		$data['p'] = $p;
		$data['o'] = $o;

		if (isset($_POST['per_page']))
			$_SESSION['per_page'] = $_POST['per_page'];

		$data['per_page'] = $_SESSION['per_page'];
		$data['paging'] = $this->tutupan_lahan_jenis_model->paging($p, $o);
		$data['main'] = $this->tutupan_lahan_jenis_model->list_data($o, $data['paging']->offset, $data['paging']->per_page);

		$header = $this->header_model->get_data();
		$header['minsidebar'] = 1;
		$nav['tip'] = 5;

		$this->load->view('header', $header);
		$this->load->view('nav', $nav);
		$this->load->view('tutupan_lahan_jenis/table', $data);
		$this->load->view('footer');
	}

	public function form($p = 1, $o = 0, $id = '')
	{
		$this->tab_ini = 17;
		$data['p'] = $p;
		$data['o'] = $o;

		if ($id)
		{
			$data['tutupan_lahan_jenis'] = $this->tutupan_lahan_jenis_model->get_tutupan_lahan_jenis($id);
			$data['form_action'] = site_url("tutupan_lahan_jenis/update/$id/$p/$o");
		}
		else
		{
			$data['tutupan_lahan_jenis'] = NULL;
			$data['form_action'] = site_url("tutupan_lahan_jenis/insert");
		}

		$header = $this->header_model->get_data();
		$header['minsidebar'] = 1;
		$nav['tip'] = 5;

		$this->load->view('header', $header);
		$this->load->view('nav', $nav);
		$this->load->view('tutupan_lahan_jenis/form', $data);
		$this->load->view('footer');
	}

	public function search()
	{
		$cari = $this->input->post('cari');
		if ($cari != '')
			$_SESSION['cari'] = $cari;
		else unset($_SESSION['cari']);
		redirect('polygon');
	}

	public function filter()
	{
		$filter = $this->input->post('filter');
		if ($filter != 0)
			$_SESSION['filter'] = $filter;
		else unset($_SESSION['filter']);
		redirect('tutupan_lahan_jenis');
	}

	public function insert($tip = 1)
	{
		$this->tutupan_lahan_jenis_model->insert($tip);
		redirect("tutupan_lahan_jenis/index/$tip");
	}

	public function update($id = '', $p = 1, $o = 0)
	{
		$this->tutupan_lahan_jenis_model->update($id);
		redirect("tutupan_lahan_jenis/index/$p/$o");
	}

	public function delete($p = 1, $o = 0, $id = '')
	{
		$this->redirect_hak_akses('h', "tutupan_lahan_jenis/index/$p/$o");
		$this->tutupan_lahan_jenis_model->delete($id);
		redirect("tutupan_lahan_jenis/index/$p/$o");
	}

	public function delete_all($p = 1, $o = 0)
	{
		$this->redirect_hak_akses('h', "tutupan_lahan_jenis/index/$p/$o");
		$this->tutupan_lahan_jenis_model->delete_all();
		redirect("tutupan_lahan_jenis/index/$p/$o");
	}
}
