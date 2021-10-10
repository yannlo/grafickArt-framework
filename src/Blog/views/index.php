<?= $renderer -> render("header") ?>
<h1>Bienvenue sur le blog</h1>
<ul>
    <li><a href="<?= $router -> generateUri('blog.show', ["slug" => "mon-article1"]) ?>">article1</a></li>
    <li>article 1</li>
    <li>article 1</li>
    <li>article 1</li>
    <li>article 1</li>
    <li>article 1</li>
    <li>article 1</li>
    <li>article 1</li>
    <li>article 1</li>
    <li>article 1</li>
</ul>
<?= $renderer -> render("footer") ?>