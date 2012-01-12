<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<div class="container" id="page">
	<div>
		<?php $this->widget('ext.CDropDownMenu.CDropDownMenu',array(
			'items'=>array(
				array('label'=>'Home', 'url'=>array('/site/index')),
				array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
				array('label'=>'Contact', 'url'=>array('/site/contact')),
				//array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Search Tips', 'url'=>array('/site/page', 'view'=>'searchtips'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Search Screen', 'url'=>array('/employees/admin'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Import data', 'url'=>array('/imports/admin'), 'visible'=>!Yii::app()->user->isGuest),
				array(
						'label'=>'Clients', 
						'url'=>array('/clients/admin'), 
						'visible'=>!Yii::app()->user->isGuest,
						'items' => array(array('label'=>'Create Client', 'url'=>array('/clients/create'))
				)),
				array('label'=>'Instances', 'url'=>array('/instances/admin'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Users', 'url'=>array('/users/admin'), 'visible'=>!Yii::app()->user->isGuest),
			),
		)); ?>
	</div><!-- mainmenu -->
	<div id="header">
		<div id="logo-tag">
			CLIENT: <strong>Demo</strong><br />
			DEVELOPER: Cory Coman<br />
			cory@innovatorscircle.com<br />
			Please do not hesitate to write
		</div>
		<div id="application-title"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	
	<?php //if(isset($this->breadcrumbs)):?>
		<?php //$this->widget('zii.widgets.CBreadcrumbs', array(
			//'links'=>$this->breadcrumbs,
		//)); ?><!-- breadcrumbs -->
	<?php //endif?>
	
	<div class="clear"></div>
	
	<?php echo $content; ?>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by Cory Coman. - All Rights Reserved. - developed by Magnify Sight
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>