<div id="page-content">
    <div class='container page'>
        <div class='row'>
            <div class='col-xs-12 col-md-offset-2 col-md-8 text-center'>
                <h1 class='page-title'><?php echo $page->title ?></h1>
                <hr class="star-primary">
                <?php if (!empty($page->full_name)): ?>
                    <div class='post-by'>
                        <i>Post by</i> <strong><?php echo $page->full_name ?></strong> <i>on</i>
                        <?php echo date('m-d-Y H:i:s', strtotime($page->created_at)) ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class='col-xs-12 col-md-offset-2 col-md-8 page-content'>
                <?php echo $page->content ?>
            </div>
        </div>
    </div>
</div>