<?php

      class Migration_GoatProfile extends CI_Migration {

        public function up() {

          $this->dbforge->add_field(array(

            'eartag_id' => array(
              'type' => 'INT',
              'constraint' => 11,
              'unique' => TRUE,
            ),
            'eartag_color' => array(
              'type' => 'VARCHAR',
              'constraint' => '64',
            ),
            'gender' => array(
              'type' => 'VARCHAR',
              'constraint' => '64',
            ),
            'body_color' => array(
              'type' => 'VARCHAR',
              'constraint' => '64',
            ),
            'birth_date' => array(
              'type' => 'DATE',
            ),
            'sire_id' => array(
              'type' => 'INT',
              'constraint' => 11,
            ),
            'dam_id' => array(
              'type' => 'INT',
              'constraint' => 11,
            ),
            'is_castrated' => array(
              'type' => 'INT',
              'constraint' => 1,
              'null' => TRUE,
            ),
          ));

          $this->dbforge->add_key('eartag_id', TRUE);
           $this->dbforge->create_table('goat_profile',TRUE);

        }

        public function down() {
          $this->dbforge->drop_table('goat_profile');
        }

      }