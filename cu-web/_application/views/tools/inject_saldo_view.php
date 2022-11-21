<div class="page-title">
    <div class="title_left">
        <h3>Inject Saldo</h3>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Form Upload Excel Inject Saldo</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form action="<?php echo site_url('tools/act_inject_saldo'); ?>" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="file" name="excel">
                        <button class="btn btn-default btn-round">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>