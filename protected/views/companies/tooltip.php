<?php
$employee = $model->employee;
if(isset($employee[0]->contact_info)){
	$contact = Yii::app()->format->html(nl2br($employee[0]->contact_info));
} else {
	$contact = null;
}

if(isset($model->products)){
	$products =  Yii::app()->format->html(nl2br($model->products));
} else {
	$products = null;
}

$companyInfo = "<h3>Company name: $model->name</h3>";
if (!empty($contact)) {
	$companyInfo .="
<p>
	<strong>Contact information:</strong><br />
	$contact
</p>";
}
if (!empty($products)) {
	$companyInfo .="
<p>
	<strong>Company products:</strong><br />
	$products
</p>";
}
?>
<?php if (isset($aTextReplace)) :?>
<span class="ttip" title="<?php echo $companyInfo?>">
	<?php echo CHtml::link(ucwords($model->name), array('/companies/'.$model->id))?>
</span>
<?php else: ?>
<span class="ttip" title="<?php echo $companyInfo?>"><?php echo $model->name?></span>
<?php endif;?>
