<?php
/* Smarty version 5.8.0, created on 2026-05-07 11:44:37
  from 'file:post.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69fc7b25cfa4e0_56555027',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3e59c3ef4ca17043bb2da51f69904f28ac9e86a6' => 
    array (
      0 => 'post.tpl',
      1 => 1778153490,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69fc7b25cfa4e0_56555027 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/var/www/html/resources/views';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_129906985769fc7b25bf8d12_72158192', 'title');
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_63394878269fc7b25c45c43_78369087', 'content');
?>

<?php $_smarty_tpl->getInheritance()->endChild($_smarty_tpl, 'layouts/main.tpl', $_smarty_current_dir);
}
/* {block 'title'} */
class Block_129906985769fc7b25bf8d12_72158192 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/var/www/html/resources/views';
echo htmlspecialchars((string)$_smarty_tpl->getValue('title'), ENT_QUOTES, 'UTF-8', true);
}
}
/* {/block 'title'} */
/* {block 'content'} */
class Block_63394878269fc7b25c45c43_78369087 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/var/www/html/resources/views';
?>

<h1><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('post')->title, ENT_QUOTES, 'UTF-8', true);?>
</h1>
<p>ID: <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('post')->id, ENT_QUOTES, 'UTF-8', true);?>
</p>
<p><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('post')->description, ENT_QUOTES, 'UTF-8', true);?>
</p>
<article><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('post')->text, ENT_QUOTES, 'UTF-8', true);?>
</article>
<?php if ($_smarty_tpl->getValue('post')->img) {?>
    <p><img src="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('post')->img, ENT_QUOTES, 'UTF-8', true);?>
" alt="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('post')->title, ENT_QUOTES, 'UTF-8', true);?>
" style="max-width: 280px; height: auto;"></p>
<?php } else { ?>
    <p>Изображение: -</p>
<?php }?>
<p>Просмотры: <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('post')->viewsCount, ENT_QUOTES, 'UTF-8', true);?>
</p>
<p>Сортировка: <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('post')->sort, ENT_QUOTES, 'UTF-8', true);?>
</p>
<p>Статус: <?php echo htmlspecialchars((string)$_smarty_tpl->getValue('post')->status, ENT_QUOTES, 'UTF-8', true);?>
</p>
<p>Опубликовано: <?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('post')->createdAt ?? null)===null||$tmp==='' ? '-' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
</p>
<p>Обновлено: <?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('post')->updatedAt ?? null)===null||$tmp==='' ? '-' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
</p>

<h2>Похожие статьи</h2>
<?php if ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('relatedPosts')) > 0) {?>
    <ul>
        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('relatedPosts'), 'related');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('related')->value) {
$foreach0DoElse = false;
?>
            <li>
                <a href="/post/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('related')->id, ENT_QUOTES, 'UTF-8', true);?>
"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('related')->title, ENT_QUOTES, 'UTF-8', true);?>
</a>
                <small>(<?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('related')->createdAt ?? null)===null||$tmp==='' ? '-' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
)</small>
            </li>
        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
    </ul>
<?php } else { ?>
    <p>Похожие статьи не найдены.</p>
<?php }?>
<p><a href="/">На главную</a></p>
<?php
}
}
/* {/block 'content'} */
}
