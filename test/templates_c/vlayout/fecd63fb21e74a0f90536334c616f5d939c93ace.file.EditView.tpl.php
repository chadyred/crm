<?php /* Smarty version Smarty-3.1.7, created on 2014-11-24 20:46:03
         compiled from "/home/www/crm.lipinterim.fr/htdocs/includes/runtime/../../layouts/vlayout/modules/EmailTemplates/EditView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1311051745473990bafe409-86577391%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fecd63fb21e74a0f90536334c616f5d939c93ace' => 
    array (
      0 => '/home/www/crm.lipinterim.fr/htdocs/includes/runtime/../../layouts/vlayout/modules/EmailTemplates/EditView.tpl',
      1 => 1415013552,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1311051745473990bafe409-86577391',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE' => 0,
    'USER_MODEL' => 0,
    'RECORD_ID' => 0,
    'SINGLE_MODULE_NAME' => 0,
    'RECORD' => 0,
    'WIDTHTYPE' => 0,
    'ALL_FIELDS' => 0,
    'MODULENAME' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5473990bc35b5',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5473990bc35b5')) {function content_5473990bc35b5($_smarty_tpl) {?>

<div class='editViewContainer'><form class="form-horizontal recordEditView" id="EditView" name="EditView" method="post" action="index.php"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
<?php $_tmp1=ob_get_clean();?><?php $_smarty_tpl->tpl_vars['QUALIFIED_MODULE_NAME'] = new Smarty_variable($_tmp1, null, 0);?><?php $_smarty_tpl->tpl_vars['WIDTHTYPE'] = new Smarty_variable($_smarty_tpl->tpl_vars['USER_MODEL']->value->get('rowheight'), null, 0);?><input type="hidden" name="module" value="<?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
" /><input type="hidden" name="action" value="Save" /><input type="hidden" name="record" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_ID']->value;?>
" /><div class="contentHeader row-fluid"><?php $_smarty_tpl->tpl_vars['SINGLE_MODULE_NAME'] = new Smarty_variable(('SINGLE_').($_smarty_tpl->tpl_vars['MODULE']->value), null, 0);?><?php if ($_smarty_tpl->tpl_vars['RECORD_ID']->value!=''){?><span class="span8 font-x-x-large textOverflowEllipsis" title="<?php echo vtranslate('LBL_EDITING',$_smarty_tpl->tpl_vars['MODULE']->value);?>
 <?php echo vtranslate($_smarty_tpl->tpl_vars['SINGLE_MODULE_NAME']->value,$_smarty_tpl->tpl_vars['MODULE']->value);?>
 <?php echo decode_html($_smarty_tpl->tpl_vars['RECORD']->value->get('templatename'));?>
"><?php echo vtranslate('LBL_EDITING',$_smarty_tpl->tpl_vars['MODULE']->value);?>
 <?php echo vtranslate($_smarty_tpl->tpl_vars['SINGLE_MODULE_NAME']->value,$_smarty_tpl->tpl_vars['MODULE']->value);?>
 - <?php echo decode_html($_smarty_tpl->tpl_vars['RECORD']->value->get('templatename'));?>
</span><?php }else{ ?><span class="span8 font-x-x-large textOverflowEllipsis"><?php echo vtranslate('LBL_CREATING_NEW',$_smarty_tpl->tpl_vars['MODULE']->value);?>
 <?php echo vtranslate($_smarty_tpl->tpl_vars['SINGLE_MODULE_NAME']->value,$_smarty_tpl->tpl_vars['MODULE']->value);?>
</span><?php }?><span class="pull-right"><button class="btn btn-success" type="submit"><strong><?php echo vtranslate('LBL_SAVE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></button><a class="cancelLink" type="reset" onclick="javascript:window.history.back();"><?php echo vtranslate('LBL_CANCEL',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</a></span></div><table class="table table-bordered blockContainer showInlineTable"><tr><th class="blockHeader" colspan="4"><?php echo vtranslate('SINGLE_EmailTemplates',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</th></tr><tr><td class="fieldLabel <?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><span class="redColor">*</span><?php echo vtranslate('LBL_TEMPLATE_NAME',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</td><td class="fieldValue <?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><input id="<?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
_editView_fieldName_templatename" type="text" class="input-large" data-validation-engine="validate[required]" name="templatename" value="<?php echo decode_html($_smarty_tpl->tpl_vars['RECORD']->value->get('templatename'));?>
"></tr><tr><td class="fieldLabel <?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><?php echo vtranslate('LBL_DESCRIPTION',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</td><td class="fieldValue <?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><textarea class="row-fluid" id="description" name="description"><?php echo decode_html($_smarty_tpl->tpl_vars['RECORD']->value->get('description'));?>
</textarea></td></tr></table><table class="table table-bordered blockContainer showInlineTable"><tr><th class="blockHeader" colspan="4"><?php echo vtranslate('LBL_EMAIL_TEMPLATE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
 <?php echo vtranslate('LBL_DESCRIPTION',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</th></tr><tr><td class="fieldLabel <?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><span class="redColor">*</span><?php echo vtranslate('LBL_SUBJECT',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</td><td class="fieldValue <?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><input id="<?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
_editView_fieldName_subject" type="text" class="input-large" data-validation-engine="validate[required]" name="subject" value="<?php echo decode_html($_smarty_tpl->tpl_vars['RECORD']->value->get('subject'));?>
"></td></tr><tr><td class="fieldLabel <?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><?php echo vtranslate('LBL_SELECT_FIELD_TYPE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</td><td class="fieldValue <?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><span class="filterContainer" ><input type=hidden name="moduleFields" data-value='<?php echo ZEND_JSON::encode($_smarty_tpl->tpl_vars['ALL_FIELDS']->value);?>
' /><span class="span4 conditionRow"><select class="chzn-select" name="modulename" ><option value="none"><?php echo vtranslate('LBL_SELECT_MODULE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</option><?php  $_smarty_tpl->tpl_vars['FILEDS'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['FILEDS']->_loop = false;
 $_smarty_tpl->tpl_vars['MODULENAME'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['ALL_FIELDS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['FILEDS']->key => $_smarty_tpl->tpl_vars['FILEDS']->value){
$_smarty_tpl->tpl_vars['FILEDS']->_loop = true;
 $_smarty_tpl->tpl_vars['MODULENAME']->value = $_smarty_tpl->tpl_vars['FILEDS']->key;
?><?php if ($_smarty_tpl->tpl_vars['MODULENAME']->value=='0'){?><option value="generalFields"><?php echo vtranslate('LBL_GENERAL_FIELDS',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</option><?php }else{ ?><option value="<?php echo $_smarty_tpl->tpl_vars['MODULENAME']->value;?>
"><?php echo vtranslate($_smarty_tpl->tpl_vars['MODULENAME']->value,$_smarty_tpl->tpl_vars['MODULENAME']->value);?>
</option><?php }?><?php } ?></select></span>&nbsp;&nbsp;<span class="span6"><select class="chzn-select span5" id="templateFields" name="templateFields"><option value=""><?php echo vtranslate('LBL_NONE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</option></select></span></span></td></tr></table><div class="row-fluid padding-bottom1per"><textarea id="templatecontent" name="templatecontent"><?php echo $_smarty_tpl->tpl_vars['RECORD']->value->get('body');?>
</textarea></div><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path("EditViewActions.tpl",$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</form><?php }} ?>