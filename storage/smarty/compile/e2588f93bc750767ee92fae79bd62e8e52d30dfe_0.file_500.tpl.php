<?php
/* Smarty version 5.8.0, created on 2026-05-07 11:34:36
  from 'file:errors/500.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69fc78cc9bdf76_60825732',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e2588f93bc750767ee92fae79bd62e8e52d30dfe' => 
    array (
      0 => 'errors/500.tpl',
      1 => 1778153102,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69fc78cc9bdf76_60825732 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/var/www/html/resources/views/errors';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_110661594069fc78cc7716c0_33301611', 'title');
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_183460294969fc78cc86d705_64760232', 'content');
?>

<?php $_smarty_tpl->getInheritance()->endChild($_smarty_tpl, 'layouts/main.tpl', $_smarty_current_dir);
}
/* {block 'title'} */
class Block_110661594069fc78cc7716c0_33301611 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/var/www/html/resources/views/errors';
?>
500 Internal Server Error<?php
}
}
/* {/block 'title'} */
/* {block 'content'} */
class Block_183460294969fc78cc86d705_64760232 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/var/www/html/resources/views/errors';
?>

<h1>500</h1>
<p><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('message'), ENT_QUOTES, 'UTF-8', true);?>
</p>
<p><a href="/">На главную</a></p>
<?php
}
}
/* {/block 'content'} */
}
