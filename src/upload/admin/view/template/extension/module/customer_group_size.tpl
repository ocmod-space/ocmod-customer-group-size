<!--
This file is subject to the terms and conditions defined in the "LICENSE.txt"
file, which is part of this source code package and is also available on the
page: https://raw.githubusercontent.com/ocmod-space/license/main/LICENSE.txt.
-->

<?php $links = array(
    'Opencart Marketplace' => 'https://www.opencart.com/index.php?route=marketplace/extension/info&amp;extension_id=OPENCART_ID',
    'GitHub' => 'https://github.com/ocmod-space/ocmod-customer-group-size',
    'License' => 'https://raw.githubusercontent.com/ocmod-space/license/main/LICENSE.txt'
); ?>

<?php $copyright = '© Copyright 2021-' . date('Y') . ' Andrii Burkatskyi aka underr'; ?>
<?php $email = '<a href="mailto:ocmod.space@gmail.com?Subject=[OpenCart] Customer Group Size">ocmod.space@gmail.com</a>'; ?>

<?php echo $header; ?>
<?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button class="btn btn-primary" data-toggle="tooltip" form="form-module"
                    title="<?php echo $button_save; ?>"
                    type="submit"><i class="fa fa-save"></i>
                </button>
                <a class="btn btn-success" data-toggle="tooltip"
                    onclick="$('#form-module').attr('action', '<?php echo $submit; ?>'); $('#form-module').submit();"
                    title="<?php echo $button_submit; ?>"><i
                        class="fa fa-check"></i>
                </a>
                <a class="btn btn-default" data-toggle="tooltip"
                    href="<?php echo $cancel; ?>"
                    title="<?php echo $button_back; ?>"><i
                        class="fa fa-reply"></i>
                </a>
            </div>
            <h1>
                <?php echo $heading_title; ?>
            </h1>
            <br />
            <ul class="breadcrumb"><?php foreach ($breadcrumbs as $_key => $breadcrumb) { ?>
                <li>
                    <a
                        href="<?php echo $breadcrumb['href']; ?>">
                        <?php echo $breadcrumb['text']; ?>
                    </a>
                </li><?php } ?>
            </ul>
        </div>
    </div>

    <div class="container-fluid">
        <?php if ($error_permission) { ?>
        <div class="alert alert-danger alert-dismissible">
            <i class="fa fa-exclamation-circle"></i><?php echo $error_permission; ?>
            <button class="close" data-dismiss="alert" type="button">&times;</button>
        </div><?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i><?php echo $text_edit; ?></h3>
            </div>
            <div class="panel-body">
                <form
                    action="<?php echo $action; ?>"
                    class="form-horizontal"
                    enctype="multipart/form-data"
                    id="form-module"
                    method="post">
                    <div class="form-group">
                        <div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons" id="input-status">
                            <label
                                class="btn btn-default btn-enabled<?php if ($status) { ?> active btn-success<?php } ?>">
                                <input
                                    autocomplete="off"
                                    name="module_customer_group_size_status"
                                    type="radio"
                                    value="1"
                                    <?php if ($status) { ?>checked<?php } ?>/><?php echo $text_enabled; ?>
                            </label>
                            <label
                                class="btn btn-default btn-disabled<?php if ( !$status) { ?> active btn-danger<?php } ?>">
                                <input
                                    autocomplete="off"
                                    name="module_customer_group_size_status"
                                    type="radio"
                                    value="0"
                                    <?php if ( !$status) { ?>checked<?php } ?> /><?php echo $text_disabled; ?>
                            </label>
                        </div>
                    </div>

                    <div class="tab-content">
                        <div class="col-sm-12 text-center"><?php echo $text_about; ?></div>
                        <div class="text-center">
                            <?php $i = 1; ?>
                            <?php foreach ($links as $name => $url) { ?>
                            <a href="<?php echo $url; ?>" target="_blank"><?php echo $name; ?></a>
                            <?php if ($i < count($links)) { ?> | <?php } ?>
                            <?php $i++; ?>
                            <?php } ?>
                        </div>
                        <hr/>
                        <div class="text-center"><?php echo $copyright; ?>, <?php echo $email; ?></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    <!--
    $('input[type="text"]').on('input', function() {
        $(this).attr('value', $(this).val());
    });

    $('#input-status .btn.btn-default').click(function() {
        if (!$(this).hasClass('active')) {
            if ($(this).hasClass('btn-enabled')) {
                $('#input-status .btn.btn-default').removeClass('btn-danger');
                $(this).addClass('btn-success');
            }

            if ($(this).hasClass('btn-disabled')) {
                $('#input-status .btn.btn-default').removeClass('btn-success');
                $(this).addClass('btn-danger');
            }
        }
    });

    -->
</script>
<?php echo $footer;
