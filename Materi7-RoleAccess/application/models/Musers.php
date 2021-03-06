<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Musers extends CI_model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
	}
	public function getUsers()
	{
		$query = $this->db->select('*')
		->from('users')
		->where(
			array('level'=>'admin')
		)
		->or_where(
			array('level'=>'user')
		)
		->get();
		return $query->result();
	}
	public function getUser($id)
	{
		$query = $this->db->select('*')
		->from('users')
		->where(
			array('id'=>'$id')
		)
		->get();
		return $query->result();
	}
	public function setUser($name,$pass,$level)
	{
		$data = array(
			'name' => $name,
			'pass' => $pass,
			'level' => $level
		);
		$this->db->insert('users', $data);
	}
	public function setSesi($name,$pass)
	{
		$query = $this->db->select('*')
		->from('users')
		->where(
			array('name'=>$name,'pass'=>$pass)
		)
		->get();
		//return $query->result();
		if ($query->result() !== null) {
			foreach ($query->result() as $key) {
				$this->session->set_userdata(
					array(
						"id"=>$key->id,
						"name"=>$key->name,
						"pass"=>$key->pass,
						"level"=>$key->level,
					));
			}

		}
	}
	public function getId()
	{
		return $this->session->userdata("id");
	}
	public function getName()
	{
		return $this->session->userdata("name");
	}
	public function getPassword()
	{
		return $this->session->userdata("pass");
	}
	public function getLevel()
	{
		return $this->session->userdata("level");
	}
	
}