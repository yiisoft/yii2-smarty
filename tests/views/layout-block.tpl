{$this->beginPage()}
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="{$app->charset}"/>
        <title>{$this->title|escape}</title>
        {$this->head()}
    </head>
    <body>
        {$this->beginBody()}
        {$content}
        {$this->endBody()}
    </body>
    {$this->endPage()}
</html>
