<?php /* Smarty version Smarty-3.1.7, created on 2014-11-06 19:54:30
         compiled from "/home/www/crm.lipinterim.fr/htdocs/includes/runtime/../../layouts/vlayout/modules/Settings/Vtiger/ConfigEditorEdit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1062644809545bd1f63edd74-32987718%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '35c39bd7f5238cb4ae802a4e331e28c7001c1694' => 
    array (
      0 => '/home/www/crm.lipinterim.fr/htdocs/includes/runtime/../../layouts/vlayout/modules/Settings/Vtiger/ConfigEditorEdit.tpl',
      1 => 1410782148,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1062644809545bd1f63edd74-32987718',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODEL' => 0,
    'QUALIFIED_MODULE' => 0,
    'CURRENT_USER_MODEL' => 0,
    'WIDTHTYPE' => 0,
    'FIELD_DETAILS' => 0,
    'FIELD_NAME' => 0,
    'optionLabel' => 0,
    'FIELD_DATA' => 0,
    'optionName' => 0,
    'FIELD_VALIDATION' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_545bd1f64d2b0',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_545bd1f64d2b0')) {function content_545bd1f64d2b0($_smarty_tpl) {?>
<div class="container-fluid"><div class="contents"><form id="ConfigEditorForm" class="form-horizontal" data-detail-url="<?php echo $_smarty_tpl->tpl_vars['MODEL']->value->getDetailViewUrl();?>
" method="POST"><div class="widget_header row-fluid"><div class="span8"><h3><?php echo vtranslate('LBL_CONFIG_EDITOR',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</h3>&nbsp;<?php echo vtranslate('LBL_CONFIG_DESCRIPTION',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</div><div class="span4 btn-toolbar"><div class="pull-right"><button class="btn btn-success saveButton" type="submit" title="<?php echo vtranslate('LBL_SAVE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"><strong><?php echo vtranslate('LBL_SAVE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></button><a type="reset" class="cancelLink" title="<?php echo vtranslate('LBL_CANCEL',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"><?php echo vtranslate('LBL_CANCEL',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</a></div></div></div><hr><?php $_smarty_tpl->tpl_vars['WIDTHTYPE'] = new Smarty_variable($_smarty_tpl->tpl_vars['CURRENT_USER_MODEL']->value->get('rowheight'), null, 0);?><?php $_smarty_tpl->tpl_vars['FIELD_VALIDATION'] = new Smarty_variable(array('HELPDESK_SUPPORT_EMAIL_ID'=>array('name'=>'Email'),'upload_maxsize'=>array('name'=>'NumberRange5'),'history_max_viewed'=>array('name'=>'NumberRange5'),'listview_max_textlength'=>array('name'=>'NumberRange100'),'list_max_entries_per_page'=>array('name'=>'NumberRange100')), null, 0);?><table class="table table-bordered table-condensed themeTableColor"><thead><tr class="blockHeader"><th colspan="2" class="<?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><?php echo vtranslate('LBL_CONFIG_FILE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</th></tr></thead><tbody><?php $_smarty_tpl->tpl_vars['FIELD_DATA'] = new Smarty_variable($_smarty_tpl->tpl_vars['MODEL']->value->getViewableData(), null, 0);?><?php  $_smarty_tpl->tpl_vars['FIELD_DETAILS'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['FIELD_DETAILS']->_loop = false;
 $_smarty_tpl->tpl_vars['FIELD_NAME'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['MODEL']->value->getEditableFields(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['FIELD_DETAILS']->key => $_smarty_tpl->tpl_vars['FIELD_DETAILS']->value){
$_smarty_tpl->tpl_vars['FIELD_DETAILS']->_loop = true;
 $_smarty_tpl->tpl_vars['FIELD_NAME']->value = $_smarty_tpl->tpl_vars['FIELD_DETAILS']->key;
?><tr><td width="30%" class="<?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><label class="muted pull-right marginRight10px"><?php echo vtranslate($_smarty_tpl->tpl_vars['FIELD_DETAILS']->value['label'],$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label></td><td style="border-left: none;" class="row-fluid <?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><?php if ($_smarty_tpl->tpl_vars['FIELD_DETAILS']->value['fieldType']=='picklist'){?><span class="span3"><select class="select2 row-fluid" name="<?php echo $_smarty_tpl->tpl_vars['FIELD_NAME']->value;?>
"><?php  $_smarty_tpl->tpl_vars['optionLabel'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['optionLabel']->_loop = false;
 $_smarty_tpl->tpl_vars['optionName'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['MODEL']->value->getPicklistValues($_smarty_tpl->tpl_vars['FIELD_NAME']->value); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['optionLabel']->key => $_smarty_tpl->tpl_vars['optionLabel']->value){
$_smarty_tpl->tpl_vars['optionLabel']->_loop = true;
 $_smarty_tpl->tpl_vars['optionName']->value = $_smarty_tpl->tpl_vars['optionLabel']->key;
?><?php if ($_smarty_tpl->tpl_vars['FIELD_NAME']->value!='default_module'){?><option <?php if ($_smarty_tpl->tpl_vars['optionLabel']->value==$_smarty_tpl->tpl_vars['FIELD_DATA']->value[$_smarty_tpl->tpl_vars['FIELD_NAME']->value]){?> selected <?php }?>><?php echo vtranslate($_smarty_tpl->tpl_vars['optionLabel']->value,$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</option><?php }else{ ?><option value="<?php echo $_smarty_tpl->tpl_vars['optionName']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['optionLabel']->value==$_smarty_tpl->tpl_vars['FIELD_DATA']->value[$_smarty_tpl->tpl_vars['FIELD_NAME']->value]){?> selected <?php }?>><?php echo vtranslate($_smarty_tpl->tpl_vars['optionLabel']->value,$_smarty_tpl->tpl_vars['optionLabel']->value);?>
</option><?php }?><?php } ?></select></span><?php }elseif($_smarty_tpl->tpl_vars['FIELD_NAME']->value=='USE_RTE'){?><input type="hidden" name="<?php echo $_smarty_tpl->tpl_vars['FIELD_NAME']->value;?>
" value="false" /><input type="checkbox" name="<?php echo $_smarty_tpl->tpl_vars['FIELD_NAME']->value;?>
" value="true" <?php if ($_smarty_tpl->tpl_vars['FIELD_DATA']->value[$_smarty_tpl->tpl_vars['FIELD_NAME']->value]=='true'){?> checked <?php }?> /><?php }else{ ?><input type="text" name="<?php echo $_smarty_tpl->tpl_vars['FIELD_NAME']->value;?>
" data-validation-engine="validate[required, funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" <?php if ($_smarty_tpl->tpl_vars['FIELD_VALIDATION']->value[$_smarty_tpl->tpl_vars['FIELD_NAME']->value]){?> data-validator=<?php echo Zend_Json::encode(array($_smarty_tpl->tpl_vars['FIELD_VALIDATION']->value[$_smarty_tpl->tpl_vars['FIELD_NAME']->value]));?>
 <?php }?> value="<?php echo $_smarty_tpl->tpl_vars['FIELD_DATA']->value[$_smarty_tpl->tpl_vars['FIELD_NAME']->value];?>
" /><?php if ($_smarty_tpl->tpl_vars['FIELD_NAME']->value=='upload_maxsize'){?>&nbsp;<?php echo vtranslate('LBL_MB',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
<?php }?><?php }?></td></tr><?php } ?></tbody></table></form></div></div><?php }} ?>