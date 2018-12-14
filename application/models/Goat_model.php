<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Goat_model extends CI_Model {

		public function __construct(){

			parent::__construct();
			//$this->load->dbforge();

			if(!$this->session->userdata('user_id')) redirect(base_url());
			
		}

		public function breeding_record(){

			$activity_id = self::activity_record("breeding");

			if(!empty($_POST)){

				$data = array(

					"sire_id"		=> $this->input->post("partner_id", TRUE),
					"is_pregnant" 	=> $this->input->post("is_pregnant", TRUE),
					"activity_id"	=> $activity_id,

				);

				return self::add_record("breeding_record",$data);

			}

			return FALSE;

		}

		public function health_check($checkup_type){

			if(!empty($_POST)){
				$act_id = self::activity_record("Health Check");
				
				$data = array(

					"checkup_type" 	=> $checkup_type,
					"prescription"	=> $this->input->post("prescription", TRUE),
					"quantity"		=> $this->input->post("quantity", TRUE),
					"activity_id"	=> $act_id,

				);

			}
		}

		public function loss_record(){

			if(!empty($_POST)){

				$act_id = self::activity_record("Loss");

				$data = array(
					"cause"			=> $this->input->post("cause", TRUE),
					"activity_id"	=> $act_id,
				);

				return self::add_record("loss_management", $data);

			}

		}

		public function activity_record($activity_type){
			
			$this->eartag_id = $this->input->post("eartag_id", TRUE);

			if(!empty($_POST)){

				$data = array(

					"user_id"		=> $this->session->userdata("user_id"),
					"date_perform"	=> $this->input->post("perform_date", TRUE),
					"activity_type"	=> $activity_type,
					"eartag_id"		=> $this->eartag_id,
					"remarks"		=> $this->input->post("remarks", TRUE),

				);

				self::add_record("activity", $data);

				return $this->db->insert_id();

			}

		}

		public function add_goat($category, $edit = FALSE){

			if(!empty($_POST)){

				$eartag_id 	= $this->input->post("eartag_id", TRUE);
				$gender 	= $this->input->post("gender", TRUE);

				$data = array(

					"eartag_id"		=> $eartag_id,
					"eartag_color"	=> $this->input->post("eartag_color", TRUE),
					"gender"		=> $gender,
					"body_color"	=> $this->input->post("body_color", TRUE),
					"is_castrated"	=> $gender === "female" ? "N/A" : ($this->input->post('is_castrated',TRUE) ? "Yes" : "No"),
					"category"		=> $category,
				);

				$table_name = "goat_profile";

				self::add_record($table_name,$data);	

				if($category == "birth"){
					
					echo "<h1>BIRTH</h1>";

					$data = array(

						"eartag_id"		=> $eartag_id,
						"birth_date"	=> $this->input->post("birth_date", TRUE),
						"sire_id"		=> $this->input->post("sire_id", TRUE),
						"dam_id"		=> $this->input->post("dam_id", TRUE)

					);
						
					$table_name = "birth_record";

				}else if($category == "purchase"){
					
					echo "<h1>PURCHASE</h1>";

					$data = array(
							
						"eartag_id"			=> $eartag_id,
						"purchase_weight"	=> $this->input->post("purchase_weight", TRUE),
						"purchase_price"	=> $this->input->post("purchase_price", TRUE),
						"purchase_date"		=> $this->input->post("purchase_date", TRUE),
						"purchase_from"		=> $this->input->post("purchase_from", TRUE),
						"user_id"			=> $this->session->userdata("user_id"),

					);

					$table_name = "purchase_record";

				}else{

					return 0;

				}
						
				return self::add_record($table_name,$data);

			}

			return 0;

		}
			
		

		public function goat_sales(){
			
			if(!empty($_POST)){
				
				$eartag_id = $this->input->post("eartag_id", TRUE);

				$data = array("status"	=> "sold");
				if(self::edit_record("goat_profile", $data, "eartag_id = {$eartag_id}")){

					$data = array(

						"user_id"			=> $this->session->userdata("user_id"),
						"price_per_kilo"	=> $this->input->post("price_per_kilo", TRUE),
						"weight"			=> $this->input->post("weight", TRUE),
						"transact_date"		=> $this->input->post("transact_date", TRUE),
						"sold_to"			=> $this->input->post("sold_to", TRUE),
						"remarks"			=> $this->input->post("remarks", TRUE),
						"eartag_id"			=> $eartag_id,

					);


					return self::add_record("goat_sales", $data);

				}

			}

			return FALSE;

		}

	
	/*
	*	C.R.U.D
	*/	

		//retrieve
		public function show_record($table_name, $where = "", $field = ""){

			if($field != '*') $this->db->select($field);
			
			if($where) $this->db->where($where);
			

			return $this->db->get($table_name)->result();

		}

		//create
		public function add_record($table_name, $data){

			$this->db->insert($table_name,$data);
			return $this->db->insert_id();

		}

		//update
		public function edit_record($table_name, $data = array(), $where = ""){

			$this->db->where($where);
			return $this->db->update($table,$data);

		}

		//delete
		public function delete_record($table_name, $where){
			$this->db->where($where);
			return $this->db->delete($table_name);
		}

		//num_rows
		public function count_rows($table_name, $where = "", $field = ""){
			
			if($field != '*') $this->db->select($field);
			
			if($where) $this->db->where($where);
			

			return $this->db->get($table_name)->num_rows();

		}

	}
?>
