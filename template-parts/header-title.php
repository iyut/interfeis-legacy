<!-- AFTER HEADER -->
<div id="outerafterheader">
    <div class="container">
        <div id="afterheader" class="row">
            <?php
            /***** file : engine/header-functions.php
            - lavista_output_breadcrumb - 30
            *****/
            do_action("ifs_legacy_upper_titlecontainer");
            ?>
            <section id="pagetitlecontainer" class="col-md-12">
                <?php
                do_action("ifs_legacy_upper_title");

                do_action("ifs_legacy_the_title");

                do_action("ifs_legacy_below_title");
                ?>
            </section>

            <?php do_action("ifs_legacy_below_titlecontainer"); ?>

            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- END AFTER HEADER -->
