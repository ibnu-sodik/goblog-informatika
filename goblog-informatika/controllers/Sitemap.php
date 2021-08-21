<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Example use of the CodeIgniter Sitemap Generator Model
 * 
 * @author Gerard Nijboer <me@gerardnijboer.com>
 * @version 1.0
 * @access public
 *
 */
class Sitemap extends CI_Controller {

	public function __construct() {
		parent::__construct();
		// We load the url helper to be able to use the base_url() function
		$this->load->helper('url');
		
		$this->load->model('Sitemap_model', 'sitemap_model');
		$this->load->model('Artikel_model', 'artikel_model');
		$this->load->model('Agenda_model', 'agenda_model');
		$this->load->model('Berita_model', 'berita_model');
		$this->load->model('Personil_model', 'personil_model');
		$this->load->model('Halaman_model', 'halaman_model');
		$this->load->model('Label_model', 'label_model');
		$this->load->model('kategori_model', 'kategori_model');
	}
	
	/**
	 * Generate a sitemap index file
	 * More information about sitemap indexes: http://www.sitemaps.org/protocol.html#index
	 */
	public function index() {
		$this->sitemap_model->add(base_url(), NULL, 'monthly', 1);
		$this->sitemap_model->add(base_url('beranda'), NULL, 'monthly', 1);
		$this->sitemap_model->add(base_url('galeri'), NULL, 'monthly', 1);
		$this->sitemap_model->add(base_url('kontak'), NULL, 'monthly', 0.9);
		$this->sitemap_model->add(base_url('testimoni'), NULL, 'monthly', 1);

		$this->artikel();
		$this->agenda();
		$this->berita();
		$this->halaman();
		$this->personil();
		$this->label();
		$this->kategori();

		$this->sitemap_model->output('sitemapindex');
	}

	public function label()
	{
		$data_label = $this->label_model->get_label();
		foreach ($data_label->result_array() as $row) {
			$this->sitemap_model->add(site_url('label/'.$row['slug_label']), NULL, 'weekly', 1);
		}
		$this->sitemap_model->output();
	}

	public function kategori()
	{
		$data_kategori = $this->kategori_model->get_kategori();
		foreach ($data_kategori->result_array() as $row) {
			$this->sitemap_model->add(site_url('kategori/'.$row['slug_kategori']), NULL, 'weekly', 1);
		}
		$this->sitemap_model->output();
	}

	public function artikel() {
		$this->sitemap_model->add(base_url('artikel'), NULL, 'monthly', 1);

		$data_artikel = $this->artikel_model->get_artikel();
		foreach ($data_artikel->result_array() as $row) {
			$this->sitemap_model->add(site_url('artikel/'.$row['slug_artikel']), date('c', strtotime($row['tanggal_up_artikel'])), 'weekly', 1);
		}
		$this->sitemap_model->output();
	}

	public function agenda() {
		$this->sitemap_model->add(base_url('agenda'), NULL, 'monthly', 1);
		
		$data_agenda = $this->agenda_model->get_all_agenda();
		foreach ($data_agenda->result_array() as $row) {
			$this->sitemap_model->add(site_url('agenda/'.$row['slug_agenda']), date('c', strtotime($row['agenda_postdate'])), 'weekly', 1);
		}
		$this->sitemap_model->output();
	}

	public function berita() {
		$this->sitemap_model->add(base_url('berita'), NULL, 'monthly', 1);
		
		$data_berita = $this->berita_model->get_all_berita();
		foreach ($data_berita->result_array() as $row) {
			$this->sitemap_model->add(site_url('berita/'.$row['slug_berita']), date('c', strtotime($row['berita_postdate'])), 'weekly', 1);
		}
		$this->sitemap_model->output();
	}

	public function halaman() {		
		$data_halaman = $this->halaman_model->get_all_halaman();
		foreach ($data_halaman->result_array() as $row) {
			$this->sitemap_model->add(site_url('halaman/'.$row['slug_halaman']), date('c', strtotime($row['halaman_date'])), 'weekly', 1);
		}
		$this->sitemap_model->output();
	}

	public function personil() {		
		$this->sitemap_model->add(base_url('personil'), NULL, 'monthly', 1);
		
		$data_personil = $this->personil_model->get_personil();
		foreach ($data_personil->result_array() as $row) {
			$this->sitemap_model->add(site_url('personil/'.$row['username']), date('c', strtotime($row['last_login'])), 'daily', 0.5);
		}
		$this->sitemap_model->output();
	}
	
}