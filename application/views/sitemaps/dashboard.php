<?php if($this->session->userdata('username') != "") {?>
<div class="container-fluid bg-light col-12 col-sm-12 col-md-12" style="position: fixed;">
	<div class="row">
    <?php $this->load->view('includes/user_header'); ?>
    <?php $this->load->view('includes/sidebar'); ?>

    
    <main class="col-12 col-md-11 col-lg-10 mt-5" role="main" style="position: fixed; padding-left: 16.333333%; min-width: 83.333333%; max-width: 100%;">
      <section class="col-12 mt-1">

        &emsp;
       
      </section>

      <section class="col-12 bg-light px-2" style="margin-top: 80px !important;">
        <?= ($this->session->flashdata('item') ? $this->session->flashdata('item') : ''); ?>
      </section>

      <section class="col-12 p-0">
        <?= ($this->session->flashdata('goat') ? $this->session->flashdata('goat') : ''); ?>
      </section>

      <section class="p-0 col-12 text-dark" id="body-content" style="height: 100vh;">
        
        <!--iframe class="p-0 w-100 h-100" src="<?= base_url();?>welcome" id="ui_view" frameborder="0" scrolling="yes"></iframe-->

      <iframe class="p-0 w-100 mh-100 h-100" src="<?php echo base_url('sitemap/landing_page');?>" id="ui_view" frameborder="0" scrolling="yes"></iframe>        

      </section>
    </main>
	</div>
</div>

<?php } else {  show_404(); } ?>