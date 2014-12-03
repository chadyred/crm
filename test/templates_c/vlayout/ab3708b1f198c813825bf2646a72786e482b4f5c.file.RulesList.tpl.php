<?php /* Smarty version Smarty-3.1.7, created on 2014-11-06 19:52:38
         compiled from "/home/www/crm.lipinterim.fr/htdocs/includes/runtime/../../layouts/vlayout/modules/Settings/MailConverter/RulesList.tpl" */ ?>
<?php /*%%SmartyHeaderCode:992757849545bd1863a1fd2-25231153%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ab3708b1f198c813825bf2646a72786e482b4f5c' => 
    array (
      0 => '/home/www/crm.lipinterim.fr/htdocs/includes/runtime/../../layouts/vlayout/modules/Settings/MailConverter/RulesList.tpl',
      1 => 1398442051,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '992757849545bd1863a1fd2-25231153',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE' => 0,
    'QUALIFIED_MODULE' => 0,
    'RECORD_EXISTS' => 0,
    'SCANNER_ID' => 0,
    'MAILBOXES' => 0,
    'SCANNER' => 0,
    'CRON_RECORD_MODEL' => 0,
    'QUALIFIED_MODULE_NAME' => 0,
    'FOLDERS_SCANNED' => 0,
    'FOLDER' => 0,
    'RECORD' => 0,
    'LINK' => 0,
    'SCANNER_MODEL' => 0,
    'RULE_MODELS_LIST' => 0,
    'RULE_MODEL' => 0,
    'RULE_COUNT' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_545bd1864af47',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_545bd1864af47')) {function content_545bd1864af47($_smarty_tpl) {?>
<div class="listViewPageDiv"><h3><?php echo vtranslate($_smarty_tpl->tpl_vars['MODULE']->value,$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</h3><hr><?php if (!$_smarty_tpl->tpl_vars['RECORD_EXISTS']->value){?><div class="mailConveterDesc"><center> <br /><br /><div><?php echo vtranslate('LBL_MAILCONVERTER_DESCRIPTION',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</div><img src="layouts/vlayout/skins/images/MailConverter.png" alt="Mail Converter"> <br /><br /><a onclick="window.location.href = 'index.php?module=MailConverter&parent=Settings&view=Edit&mode=step1&create=new';"><u class="cursorPointer" style="font-size:12pt;"><?php echo vtranslate('LBL_CREATE_MAILBOX_NOW',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</u></a><br><br></center></div><?php }else{ ?><input type="hidden" id="scannerId" value="<?php echo $_smarty_tpl->tpl_vars['SCANNER_ID']->value;?>
"/><div><div class="span5"><label class="span2" id="mailBoxLabel"><?php echo vtranslate('LBL_MAILBOX',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label><div class="mailBoxDropdownWrapper"><select class="mailBoxDropdown"><?php  $_smarty_tpl->tpl_vars['SCANNER'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['SCANNER']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['MAILBOXES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['SCANNER']->key => $_smarty_tpl->tpl_vars['SCANNER']->value){
$_smarty_tpl->tpl_vars['SCANNER']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['SCANNER']->value['scannerid'];?>
" <?php if ($_smarty_tpl->tpl_vars['SCANNER_ID']->value==$_smarty_tpl->tpl_vars['SCANNER']->value['scannerid']){?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['SCANNER']->value['scannername'];?>
</option><?php } ?></select></div></div><div class="span4" id="mailConverterStats"><?php if ($_smarty_tpl->tpl_vars['CRON_RECORD_MODEL']->value->isEnabled()){?><?php if ($_smarty_tpl->tpl_vars['CRON_RECORD_MODEL']->value->hadTimedout){?><?php echo vtranslate('LBL_LAST_SCAN_TIMED_OUT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE_NAME']->value);?>
.<?php }elseif($_smarty_tpl->tpl_vars['CRON_RECORD_MODEL']->value->getLastEndDateTime()!=''){?><?php echo vtranslate('LBL_LAST_SCAN_AT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE_NAME']->value);?>
<?php echo $_smarty_tpl->tpl_vars['CRON_RECORD_MODEL']->value->getLastEndDateTime();?>
<br /><?php echo vtranslate('LBL_FOLDERS_SCANNED',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE_NAME']->value);?>
&nbsp;:&nbsp;<?php  $_smarty_tpl->tpl_vars['FOLDER'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['FOLDER']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['FOLDERS_SCANNED']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['FOLDER']->key => $_smarty_tpl->tpl_vars['FOLDER']->value){
$_smarty_tpl->tpl_vars['FOLDER']->_loop = true;
?><strong><?php echo $_smarty_tpl->tpl_vars['FOLDER']->value;?>
&nbsp;&nbsp;</strong><?php } ?><?php }?><?php }?></div><div class="btn-toolbar pull-right"><div class="btn-group"><button class="btn dropdown-toggle" data-toggle="dropdown"><?php echo vtranslate('LBL_ACTIONS',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE_NAME']->value);?>
&nbsp;<span class="caret"></span></button><ul class="dropdown-menu"><?php  $_smarty_tpl->tpl_vars['LINK'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['LINK']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['RECORD']->value->getRecordLinks(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['LINK']->key => $_smarty_tpl->tpl_vars['LINK']->value){
$_smarty_tpl->tpl_vars['LINK']->_loop = true;
?><li><a style="text-shadow: none"<?php if (strpos($_smarty_tpl->tpl_vars['LINK']->value->getUrl(),'javascript:')===0){?> href='javascript:void(0);' onclick='<?php echo substr($_smarty_tpl->tpl_vars['LINK']->value->getUrl(),strlen("javascript:"));?>
;'<?php }else{ ?> href=<?php echo $_smarty_tpl->tpl_vars['LINK']->value->getUrl();?>
 <?php }?>><?php echo vtranslate($_smarty_tpl->tpl_vars['LINK']->value->getLabel(),$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</a></li><?php } ?></ul></div><div class="btn-group"><button class="btn addButton" onclick="javascript:Settings_MailConverter_List_Js.checkMailBoxMaxLimit('index.php?module=MailConverter&parent=Settings&action=CheckMailBoxMaxLimit&mode=step1&create=new');"><i class="icon-plus"></i>&nbsp;<strong><?php echo vtranslate('LBL_ADD_RECORD',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE_NAME']->value);?>
</strong></button></div></div><div class="row-fluid"><div id="mailConverterBody" class="span12"><div class="row-fluid"><div class="span2" id="addRuleButton"><button class="btn addButton" <?php if (stripos($_smarty_tpl->tpl_vars['SCANNER_MODEL']->value->getCreateRuleRecordUrl(),'javascript:')===0){?> onclick='<?php echo substr($_smarty_tpl->tpl_vars['SCANNER_MODEL']->value->getCreateRuleRecordUrl(),strlen("javascript:"));?>
'<?php }else{ ?> onclick='window.location.href="<?php echo $_smarty_tpl->tpl_vars['SCANNER_MODEL']->value->getCreateRuleRecordUrl();?>
"' <?php }?>><i class="icon-plus"></i>&nbsp;&nbsp;<strong><?php echo vtranslate('LBL_ADD_RULE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></button></div><div class="row-fluid padding-bottom1per"><div class="pull-right" id="mailConverterDragIcon"><i class="icon-info-sign"></i>&nbsp;&nbsp;<?php echo vtranslate('LBL_DRAG_AND_DROP_BLOCK_TO_PRIORITISE_THE_RULE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</div></div><div class="clearfix"></div></div><br><div id="rulesList"><?php $_smarty_tpl->tpl_vars['RULE_COUNT'] = new Smarty_variable(1, null, 0);?><?php  $_smarty_tpl->tpl_vars['RULE_MODEL'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['RULE_MODEL']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['RULE_MODELS_LIST']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['RULE_MODEL']->key => $_smarty_tpl->tpl_vars['RULE_MODEL']->value){
$_smarty_tpl->tpl_vars['RULE_MODEL']->_loop = true;
?><div class="row-fluid padding-bottom1per rule" data-id="<?php echo $_smarty_tpl->tpl_vars['RULE_MODEL']->value->get('ruleid');?>
" data-blockid="block_<?php echo $_smarty_tpl->tpl_vars['RULE_MODEL']->value->get('ruleid');?>
"><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path("Rule.tpl",$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('RULE_COUNT'=>$_smarty_tpl->tpl_vars['RULE_COUNT']->value), 0);?>
</div><?php $_smarty_tpl->tpl_vars['RULE_COUNT'] = new Smarty_variable($_smarty_tpl->tpl_vars['RULE_COUNT']->value+1, null, 0);?><?php } ?></div></div></div></div><?php }?>
<?php }} ?>