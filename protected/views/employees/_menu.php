<!-- TABS MENU: START -->
<div class="tabmenu">
	<ul>
		<li <?php echo ($action == 'search_screen' ? 'class="active"' : ''); ?>>
			<?php echo CHtml::link('Search Screen', array('employees/admin')); ?>
		</li>
		<li <?php echo ($action == 'search_result' ? 'class="active"' : '');?>>
			<?php echo CHtml::link('Search Result', array('employees/admin')); ?>
		</li>
		<li <?php echo ($action == 'selected_profile' ? 'class="active"' : '');?>>
			<?php echo CHtml::link('Selected Profile', array('id'=>1)); ?>
		</li>
		<li <?php echo ($action == 'companies_data' ? 'class="active"' : '');?>>
			<?php echo CHtml::link('Companies Data', array('companies/admin')); ?>
		</li>
	</ul>
</div>
<!-- TABS MENU: END -->