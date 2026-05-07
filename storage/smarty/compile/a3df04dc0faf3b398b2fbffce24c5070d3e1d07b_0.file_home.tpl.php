<?php
/* Smarty version 5.8.0, created on 2026-05-07 11:44:18
  from 'file:home.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69fc7b12f26b53_50940242',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a3df04dc0faf3b398b2fbffce24c5070d3e1d07b' => 
    array (
      0 => 'home.tpl',
      1 => 1778153556,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69fc7b12f26b53_50940242 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/var/www/html/resources/views';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_48378141169fc7b12cc5e98_25210156', 'title');
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_209458882269fc7b12dc45d8_33287815', 'content');
?>

<?php $_smarty_tpl->getInheritance()->endChild($_smarty_tpl, 'layouts/main.tpl', $_smarty_current_dir);
}
/* {block 'title'} */
class Block_48378141169fc7b12cc5e98_25210156 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/var/www/html/resources/views';
echo htmlspecialchars((string)$_smarty_tpl->getValue('title'), ENT_QUOTES, 'UTF-8', true);
}
}
/* {/block 'title'} */
/* {block 'content'} */
class Block_209458882269fc7b12dc45d8_33287815 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/var/www/html/resources/views';
?>

<?php if ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('categories')) > 0) {?>
    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('categories'), 'category');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('category')->value) {
$foreach0DoElse = false;
?>
        <section class="category-section">
            <div class="category-head">
                <h2><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('category')['title'], ENT_QUOTES, 'UTF-8', true);?>
</h2>
                <a href="/category/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('category')['id'], ENT_QUOTES, 'UTF-8', true);?>
" class="all-link">View All</a>
            </div>

            <div class="posts-grid">
                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('category')['posts'], 'post');
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('post')->value) {
$foreach1DoElse = false;
?>
                    <article class="post-card">
                        <a href="/post/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('post')['id'], ENT_QUOTES, 'UTF-8', true);?>
" class="post-image-link">
                            <img src="<?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('post')['img'] ?? null)===null||$tmp==='' ? '/assets/images/posts/cat-1.png' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
" alt="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('post')['title'], ENT_QUOTES, 'UTF-8', true);?>
" class="post-image">
                        </a>
                        <h3><a href="/post/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('post')['id'], ENT_QUOTES, 'UTF-8', true);?>
"><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('post')['title'], ENT_QUOTES, 'UTF-8', true);?>
</a></h3>
                        <small><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('post')['created_at'], ENT_QUOTES, 'UTF-8', true);?>
</small>
                        <p><?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('post')['description'] ?? null)===null||$tmp==='' ? 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
</p>
                        <a href="/post/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('post')['id'], ENT_QUOTES, 'UTF-8', true);?>
" class="read-more">Continue Reading</a>
                    </article>
                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
            </div>
        </section>
    <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);
} else { ?>
    <p>Категории со статьями пока не добавлены.</p>
<?php }
}
}
/* {/block 'content'} */
}
