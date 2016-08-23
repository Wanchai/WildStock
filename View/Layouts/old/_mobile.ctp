<!doctype html>
<html>
<?php echo $this->Facebook->html();?>
<head>
    <title>
        <?php echo __('Wild Stocks').$title_for_layout; ?>
        <?php echo $title_for_layout; ?>
    </title>

    <?php echo $this->Html->meta('icon'); ?>
    <?php echo $this->Html->css('mobile'); ?>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css">
    <script src="https://code.jquery.com/jquery-1.8.2.min.js"></script>
    <script src="https://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
</head>

<body>

    <div data-role="page" id="home" data-theme="a">
<?php echo $this->Session->flash(); ?>
        <div data-role="header" data-id="menu" data-position="fixed">
            <div data-role="navbar">
                <ul>
                    <li><a id="btn1" href="#home" class="ui-btn-active ui-state-persist">Home</a></li>
                    <li><a id="btn2" href="#test">Test</a></li>
                    <li><a id="btn3" href="#">Three</a></li>
                </ul>
            </div><!-- /navbar -->
        </div><!-- /header -->

        <div data-role="content">
            Home
        </div><!-- /content -->

        <div data-role="footer">
            <h4>My Footer</h4>
        </div><!-- /footer -->

    </div><!-- /page -->

    <div data-role="page" id="test" data-theme="a">
<?php echo $this->Session->flash(); ?>
<?php echo $this->flash(); ?>
        <div data-role="header" data-id="menu" data-position="fixed">
            <div data-role="navbar">
                <ul>
                    <li><a id="btn1" href="#home">Home</a></li>
                    <li><a id="btn2" href="#test" class="ui-btn-active ui-state-persist">Test</a></li>
                    <li><a id="btn3" href="#">Three</a></li>
                </ul>
            </div><!-- /navbar -->
        </div><!-- /header -->

        <div data-role="content">
            <?php

			?>

            Test
        </div><!-- /content -->

        <div data-role="footer">
            <h4>My Footer</h4>
        </div><!-- /footer -->

    </div><!-- /page -->

    <?php //echo $this->element('sql_dump'); ?>
    <?php echo $this->Facebook->init(); ?>
	<?php echo $this->Js->writeBuffer(); // write cached scripts ?>
</body>
</html>