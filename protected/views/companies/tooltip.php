<?php
$employee = $model->employee;
$contact = Yii::app()->format->html(nl2br($employee[0]->contact_info));
$products =  Yii::app()->format->html(nl2br($model->products));
$companyInfo = "<h3>Company name: $model->name</h3>
<p>
	<strong>Contact information:</strong><br />
	$contact
</p>
<p>
	<strong>Company products:</strong><br />
	$products
</p>";

?>
<span class="ttip" title="<?php echo $companyInfo?>"><?php echo $model->name?></span>


