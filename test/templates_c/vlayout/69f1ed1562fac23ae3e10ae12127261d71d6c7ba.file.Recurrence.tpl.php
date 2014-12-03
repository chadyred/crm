<?php /* Smarty version Smarty-3.1.7, created on 2014-11-21 15:38:23
         compiled from "/home/www/crm.lipinterim.fr/htdocs/includes/runtime/../../layouts/vlayout/modules/Vtiger/uitypes/Recurrence.tpl" */ ?>
<?php /*%%SmartyHeaderCode:898525090546f5c6f55d3c6-11150964%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '69f1ed1562fac23ae3e10ae12127261d71d6c7ba' => 
    array (
      0 => '/home/www/crm.lipinterim.fr/htdocs/includes/runtime/../../layouts/vlayout/modules/Vtiger/uitypes/Recurrence.tpl',
      1 => 1398442051,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '898525090546f5c6f55d3c6-11150964',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'RECURRING_INFORMATION' => 0,
    'MODULE' => 0,
    'FREQUENCY' => 0,
    'USER_MODEL' => 0,
    'TOMORROWDATE' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_546f5c6f665b9',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_546f5c6f665b9')) {function content_546f5c6f665b9($_smarty_tpl) {?>
<div class="row-fluid"><div class="span"><input type="checkbox" name="recurringcheck" value="" <?php if ($_smarty_tpl->tpl_vars['RECURRING_INFORMATION']->value['recurringcheck']=='Yes'){?>checked<?php }?>/>&nbsp;&nbsp;</div><div class="<?php if ($_smarty_tpl->tpl_vars['RECURRING_INFORMATION']->value['recurringcheck']=='Yes'){?>show<?php }else{ ?>hide<?php }?> span" id="repeatUI" style="width:90%;"><div class="row-fluid"><span class="span" style="width:150px;"><span class="alignMiddle" style="margin-right: 6%"><?php echo vtranslate('LBL_REPEATEVENT',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</span><select class="select2 input-mini" name="repeat_frequency"><?php $_smarty_tpl->tpl_vars['FREQUENCY'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['FREQUENCY']->step = 1;$_smarty_tpl->tpl_vars['FREQUENCY']->total = (int)ceil(($_smarty_tpl->tpl_vars['FREQUENCY']->step > 0 ? 14+1 - (1) : 1-(14)+1)/abs($_smarty_tpl->tpl_vars['FREQUENCY']->step));
if ($_smarty_tpl->tpl_vars['FREQUENCY']->total > 0){
for ($_smarty_tpl->tpl_vars['FREQUENCY']->value = 1, $_smarty_tpl->tpl_vars['FREQUENCY']->iteration = 1;$_smarty_tpl->tpl_vars['FREQUENCY']->iteration <= $_smarty_tpl->tpl_vars['FREQUENCY']->total;$_smarty_tpl->tpl_vars['FREQUENCY']->value += $_smarty_tpl->tpl_vars['FREQUENCY']->step, $_smarty_tpl->tpl_vars['FREQUENCY']->iteration++){
$_smarty_tpl->tpl_vars['FREQUENCY']->first = $_smarty_tpl->tpl_vars['FREQUENCY']->iteration == 1;$_smarty_tpl->tpl_vars['FREQUENCY']->last = $_smarty_tpl->tpl_vars['FREQUENCY']->iteration == $_smarty_tpl->tpl_vars['FREQUENCY']->total;?><option value="<?php echo $_smarty_tpl->tpl_vars['FREQUENCY']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['FREQUENCY']->value==$_smarty_tpl->tpl_vars['RECURRING_INFORMATION']->value['repeat_frequency']){?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['FREQUENCY']->value;?>
</option><?php }} ?></select></span><span class="span"><select class="select2 input-medium" style="width:100px;" name="recurringtype" id="recurringType"><option value="Daily" <?php if ($_smarty_tpl->tpl_vars['RECURRING_INFORMATION']->value['eventrecurringtype']=='Daily'){?> selected <?php }?>><?php echo vtranslate('LBL_DAYS_TYPE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</option><option value="Weekly" <?php if ($_smarty_tpl->tpl_vars['RECURRING_INFORMATION']->value['eventrecurringtype']=='Weekly'){?> selected <?php }?>><?php echo vtranslate('LBL_WEEKS_TYPE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</option><option value="Monthly" <?php if ($_smarty_tpl->tpl_vars['RECURRING_INFORMATION']->value['eventrecurringtype']=='Monthly'){?> selected <?php }?>><?php echo vtranslate('LBL_MONTHS_TYPE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</option><option value="Yearly" <?php if ($_smarty_tpl->tpl_vars['RECURRING_INFORMATION']->value['eventrecurringtype']=='Yearly'){?> selected <?php }?>><?php echo vtranslate('LBL_YEAR_TYPE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</option></select></span><span class="span"><span class="alignMiddle displayInlineBlock" style="margin-right:10px;"><?php echo vtranslate('LBL_UNTIL',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</span><span class="input-append date pull-right"><input type="text" id="calendar_repeat_limit_date" class="dateField input-small" name="calendar_repeat_limit_date" data-date-format="<?php echo $_smarty_tpl->tpl_vars['USER_MODEL']->value->get('date_format');?>
"value="<?php if ($_smarty_tpl->tpl_vars['RECURRING_INFORMATION']->value['recurringcheck']!='Yes'){?><?php echo $_smarty_tpl->tpl_vars['TOMORROWDATE']->value;?>
<?php }elseif($_smarty_tpl->tpl_vars['RECURRING_INFORMATION']->value['recurringcheck']=='Yes'){?><?php echo $_smarty_tpl->tpl_vars['RECURRING_INFORMATION']->value['recurringenddate'];?>
<?php }?>"data-validation-engine='validate[required,funcCall[Vtiger_Date_Validator_Js.invokeValidation]]' style="width:100px;"/><span class="add-on"><i class="icon-calendar"></i></span></span></span></div><div class="row-fluid <?php if ($_smarty_tpl->tpl_vars['RECURRING_INFORMATION']->value['eventrecurringtype']=='Weekly'){?>show<?php }else{ ?>hide<?php }?>"  id="repeatWeekUI" style="margin-top:10px;"><span class="span2"><span class="pull-right medium"><?php echo vtranslate('LBL_ON',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</span></span><span class="span10"><label class="checkbox inline" style="margin-left: 8px;"><input name="sun_flag" value="sunday" <?php echo $_smarty_tpl->tpl_vars['RECURRING_INFORMATION']->value['week0'];?>
 type="checkbox"/><?php echo vtranslate('LBL_SM_SUN',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</label><label class="checkbox inline" style="margin-left: 8px;"><input name="mon_flag" value="monday" <?php echo $_smarty_tpl->tpl_vars['RECURRING_INFORMATION']->value['week1'];?>
 type="checkbox"><?php echo vtranslate('LBL_SM_MON',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</label><label class="checkbox inline" style="margin-left: 8px;"><input name="tue_flag" value="tuesday" <?php echo $_smarty_tpl->tpl_vars['RECURRING_INFORMATION']->value['week2'];?>
 type="checkbox"><?php echo vtranslate('LBL_SM_TUE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</label><label class="checkbox inline" style="margin-left: 8px;"><input name="wed_flag" value="wednesday" <?php echo $_smarty_tpl->tpl_vars['RECURRING_INFORMATION']->value['week3'];?>
 type="checkbox"><?php echo vtranslate('LBL_SM_WED',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</label><label class="checkbox inline" style="margin-left: 8px;"><input name="thu_flag" value="thursday" <?php echo $_smarty_tpl->tpl_vars['RECURRING_INFORMATION']->value['week4'];?>
 type="checkbox"><?php echo vtranslate('LBL_SM_THU',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</label><label class="checkbox inline" style="margin-left: 8px;"><input name="fri_flag" value="friday" <?php echo $_smarty_tpl->tpl_vars['RECURRING_INFORMATION']->value['week5'];?>
 type="checkbox"><?php echo vtranslate('LBL_SM_FRI',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</label><label class="checkbox inline" style="margin-left: 8px;"><input name="sat_flag" value="saturday" <?php echo $_smarty_tpl->tpl_vars['RECURRING_INFORMATION']->value['week6'];?>
 type="checkbox"><?php echo vtranslate('LBL_SM_SAT',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</label></span></div><div class="<?php if ($_smarty_tpl->tpl_vars['RECURRING_INFORMATION']->value['eventrecurringtype']=='Monthly'){?>show<?php }else{ ?>hide<?php }?>" id="repeatMonthUI" style="margin-top:10px;"RCa><div class="row-fluid"><span class="span4"><span class="pull-right"><input type="radio" id="repeatDate" name="repeatMonth" checked value="date" <?php if ($_smarty_tpl->tpl_vars['RECURRING_INFORMATION']->value['repeatMonth']=='date'){?> checked <?php }?>/><span class="alignMiddle" style="margin-left: 0.8em;"><?php echo vtranslate('LBL_ON',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</span></span></span><span class="span8"><input type="text" id="repeatMonthDate" class="input-mini" name="repeatMonth_date" data-validation-engine='validate[funcCall[Calendar_RepeatMonthDate_Validator_Js.invokeValidation]]' value="<?php if ($_smarty_tpl->tpl_vars['RECURRING_INFORMATION']->value['repeatMonth_date']==''){?>2<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['RECURRING_INFORMATION']->value['repeatMonth_date'];?>
<?php }?>"/><span class="alignMiddle" style="margin-left: 0.8em;"><?php echo vtranslate('LBL_DAY_OF_THE_MONTH',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</span></span><div class="clearfix"></div></div><div class="row-fluid" id="repeatMonthDayUI" style="margin-top: 10px;"><span class="span4"><span class="pull-right"><input type="radio" id="repeatDay" name="repeatMonth" value="day" <?php if ($_smarty_tpl->tpl_vars['RECURRING_INFORMATION']->value['repeatMonth']=='day'){?> checked <?php }?>/><span class="alignMiddle" style="margin-left: 0.8em;"><?php echo vtranslate('LBL_ON',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</span></span></span><span class="span3"><select id="repeatMonthDayType" class="select2 input-small" name="repeatMonth_daytype"><option value="first" <?php if ($_smarty_tpl->tpl_vars['RECURRING_INFORMATION']->value['repeatMonth_daytype']=='first'){?> selected <?php }?>><?php echo vtranslate('LBL_FIRST',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</option><option value="last" <?php if ($_smarty_tpl->tpl_vars['RECURRING_INFORMATION']->value['repeatMonth_daytype']=='last'){?> selected <?php }?>><?php echo vtranslate('LBL_LAST',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</option></select></span><span class="span5 margin0px"><select id="repeatMonthDay" class="select2 input-medium" name="repeatMonth_day"><option value=0 <?php if ($_smarty_tpl->tpl_vars['RECURRING_INFORMATION']->value['repeatMonth_day']==0){?> selected <?php }?>><?php echo vtranslate('LBL_DAY0',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</option><option value=1 <?php if ($_smarty_tpl->tpl_vars['RECURRING_INFORMATION']->value['repeatMonth_day']==1){?> selected <?php }?>><?php echo vtranslate('LBL_DAY1',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</option><option value=2 <?php if ($_smarty_tpl->tpl_vars['RECURRING_INFORMATION']->value['repeatMonth_day']==2){?> selected <?php }?>><?php echo vtranslate('LBL_DAY2',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</option><option value=3 <?php if ($_smarty_tpl->tpl_vars['RECURRING_INFORMATION']->value['repeatMonth_day']==3){?> selected <?php }?>><?php echo vtranslate('LBL_DAY3',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</option><option value=4 <?php if ($_smarty_tpl->tpl_vars['RECURRING_INFORMATION']->value['repeatMonth_day']==4){?> selected <?php }?>><?php echo vtranslate('LBL_DAY4',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</option><option value=5 <?php if ($_smarty_tpl->tpl_vars['RECURRING_INFORMATION']->value['repeatMonth_day']==5){?> selected <?php }?>><?php echo vtranslate('LBL_DAY5',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</option><option value=6 <?php if ($_smarty_tpl->tpl_vars['RECURRING_INFORMATION']->value['repeatMonth_day']==6){?> selected <?php }?>><?php echo vtranslate('LBL_DAY6',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</option></select></span></div></div></div></div><?php }} ?>