<!DOCTYPE html>
<html lang="vi">

    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title><?php echo $title ?? 'VINALED HRM System' ?></title>
        <?php $this->load->view('inc/head') ?>
    </head>

    <body>
        <div class="wrapper">
            <?php $this->load->view('inc/nav_top') ?>
            <?php if ($breadcrumb) : ?>
                <?php $this->load->view('inc/breadcrumb', $breadcrumb) ?>
            <?php endif; ?>
            <!--Loader init page-->
            <div id="initPageLoader" class="text-center text-success">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <!--End loader-->
            <div id="content" class="mb-2" style="display: <?php echo ENVIRONMENT == 'development' ? 'block' : 'none'; ?>">
                <?php if ($view) : ?>
                    <?php $this->load->view($view, $content) ?>
                <?php endif; ?>
            </div>
            <?php $this->load->view('footer') ?>
        </div>
    </body>

</html>
