<?= $this->extend('layout/main_layout') ?>



<?= $this->section('content') ?>


<style>
    .container {
        display: grid;
        grid-template-columns: repeat(10, 1fr);
        grid-template-rows: repeat(10, 1fr);
        /* grid-auto-rows: minmax(100px,auto); */
        height: 100vh;
    }


    .container>.header-container {
        grid-column: 2/11;
        grid-row: 1;
        /* justify-content: center; */
    }

    .container>.sidebar-container {
        grid-row: 1/11;
        grid-column: 1;
    }

    .container>.main-container {
        grid-column: 2/11;
        grid-row: 2/11;
    }
</style>


<div class="container">
    <div class="header-container bg-gray"> <?= view_cell('App\Libraries\Header::viewHeader');?></div>
    <div class="sidebar-container bg-dark"><?= view_cell('App\Libraries\Sidebar::viewSidebar');?></div>
    <div class="main-container bg-gray">
        <?= view_cell('App\Libraries\SearchBar::index');?>
        <?= view_cell('App\Libraries\Content::viewMainContainer');?>
        
    </div>
</div>



<?= view_cell('App\Libraries\NewProduct::viewModal');?>
<?= view_cell('App\Libraries\Register::index');?>
<?= view_cell('App\Libraries\Logout::index');?>
<?= $this->endSection() ?>