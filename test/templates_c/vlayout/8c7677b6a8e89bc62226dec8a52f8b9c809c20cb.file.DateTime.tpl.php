<?php /* Smarty version Smarty-3.1.7, created on 2014-11-07 12:08:26
         compiled from "/home/www/crm.lipinterim.fr/htdocs/includes/runtime/../../layouts/vlayout/modules/Events/uitypes/DateTime.tpl" */ ?>
<?php /*%%SmartyHeaderCode:279567671545cb63a6d4c63-11457467%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8c7677b6a8e89bc62226dec8a52f8b9c809c20cb' => 
    array (
      0 => '/home/www/crm.lipinterim.fr/htdocs/includes/runtime/../../layouts/vlayout/modules/Events/uitypes/DateTime.tpl',
      1 => 1373768345,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '279567671545cb63a6d4c63-11457467',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'FIELD_MODEL' => 0,
    'RECORD_STRUCTURE_MODEL' => 0,
    'MODULE_MODEL' => 0,
    'DATE_TIME_VALUE' => 0,
    'DATE_TIME_COMPONENTS' => 0,
    'TIME_FIELD' => 0,
    'DATE_TIME_CONVERTED_VALUE' => 0,
    'DATE_FIELD' => 0,
    'MODULE' => 0,
    'BLOCK_FIELDS' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_545cb63a76df6',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_545cb63a76df6')) {function content_545cb63a76df6($_smarty_tpl) {?>
<?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getName()=='date_start'){?><?php $_smarty_tpl->tpl_vars['DATE_FIELD'] = new Smarty_variable($_smarty_tpl->tpl_vars['FIELD_MODEL']->value, null, 0);?><?php $_smarty_tpl->tpl_vars['MODULE_MODEL'] = new Smarty_variable($_smarty_tpl->tpl_vars['RECORD_STRUCTURE_MODEL']->value->getModule(), null, 0);?><?php $_smarty_tpl->tpl_vars['TIME_FIELD'] = new Smarty_variable($_smarty_tpl->tpl_vars['MODULE_MODEL']->value->getField('time_start'), null, 0);?><?php }elseif($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getName()=='due_date'){?><?php $_smarty_tpl->tpl_vars['DATE_FIELD'] = new Smarty_variable($_smarty_tpl->tpl_vars['FIELD_MODEL']->value, null, 0);?><?php $_smarty_tpl->tpl_vars['MODULE_MODEL'] = new Smarty_variable($_smarty_tpl->tpl_vars['RECORD_STRUCTURE_MODEL']->value->getModule(), null, 0);?><?php $_smarty_tpl->tpl_vars['TIME_FIELD'] = new Smarty_variable($_smarty_tpl->tpl_vars['MODULE_MODEL']->value->getField('time_end'), null, 0);?><?php }?><?php $_smarty_tpl->tpl_vars['DATE_TIME_VALUE'] = new Smarty_variable($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('fieldvalue'), null, 0);?><?php $_smarty_tpl->tpl_vars['DATE_TIME_COMPONENTS'] = new Smarty_variable(explode(' ',$_smarty_tpl->tpl_vars['DATE_TIME_VALUE']->value), null, 0);?><?php $_smarty_tpl->tpl_vars['TIME_FIELD'] = new Smarty_variable($_smarty_tpl->tpl_vars['TIME_FIELD']->value->set('fieldvalue',$_smarty_tpl->tpl_vars['DATE_TIME_COMPONENTS']->value[1]), null, 0);?><?php $_smarty_tpl->tpl_vars['DATE_TIME_CONVERTED_VALUE'] = new Smarty_variable(DateTimeField::convertToUserTimeZone($_smarty_tpl->tpl_vars['DATE_TIME_VALUE']->value)->format('Y-m-d H:i:s'), null, 0);?><?php $_smarty_tpl->tpl_vars['DATE_TIME_COMPONENTS'] = new Smarty_variable(explode(' ',$_smarty_tpl->tpl_vars['DATE_TIME_CONVERTED_VALUE']->value), null, 0);?><?php $_smarty_tpl->tpl_vars['DATE_FIELD'] = new Smarty_variable($_smarty_tpl->tpl_vars['DATE_FIELD']->value->set('fieldvalue',$_smarty_tpl->tpl_vars['DATE_TIME_COMPONENTS']->value[0]), null, 0);?><div><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('uitypes/Date.tpl',$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('BLOCK_FIELDS'=>$_smarty_tpl->tpl_vars['BLOCK_FIELDS']->value,'FIELD_MODEL'=>$_smarty_tpl->tpl_vars['DATE_FIELD']->value), 0);?>
</div><div><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('uitypes/Time.tpl',$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('BLOCK_FIELDS'=>$_smarty_tpl->tpl_vars['BLOCK_FIELDS']->value,'FIELD_MODEL'=>$_smarty_tpl->tpl_vars['TIME_FIELD']->value), 0);?>
</div><?php }} ?>