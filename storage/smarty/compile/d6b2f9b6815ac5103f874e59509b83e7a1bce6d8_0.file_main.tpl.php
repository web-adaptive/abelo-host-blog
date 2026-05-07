<?php
/* Smarty version 5.8.0, created on 2026-05-07 11:34:36
  from 'file:layouts/main.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69fc78cccd7e67_95356475',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd6b2f9b6815ac5103f874e59509b83e7a1bce6d8' => 
    array (
      0 => 'layouts/main.tpl',
      1 => 1778153042,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:partials/header.tpl' => 1,
    'file:partials/footer.tpl' => 1,
  ),
))) {
function content_69fc78cccd7e67_95356475 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/var/www/html/resources/views/layouts';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, false);
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_163667618869fc78ccbc4a92_17105064', 'title');
?>
</title>
    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>
<?php $_smarty_tpl->renderSubTemplate('file:partials/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<div class="container">
    <?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_159585940169fc78cccd4ab9_23841730', 'content');
?>

</div>

<?php $_smarty_tpl->renderSubTemplate('file:partials/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>
</body>
</html>
<?php }
/* {block 'title'} */
class Block_163667618869fc78ccbc4a92_17105064 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/var/www/html/resources/views/layouts';
echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('title') ?? null)===null||$tmp==='' ? 'Blog' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);
}
}
/* {/block 'title'} */
/* {block 'content'} */
class Block_159585940169fc78cccd4ab9_23841730 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/var/www/html/resources/views/layouts';
}
}
/* {/block 'content'} */
}
