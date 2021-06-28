<?php
/**
 * Generate PhpStorm meta file for Cake models
 *
 * php -f ./utilities/PhpStorm/metaCreator.php
 */

function getAllModels(): array
{
    $excluded = array('AppModel', 'Behavior', 'Interface');
    $directory = __DIR__ . '/../../app/Model/';

    $scanned_directory = array_diff(scandir($directory), array('..', '.'));
    $models = [];

    foreach ($scanned_directory as $file) {
        $modelName = pathinfo($file)['filename'];

        if (! in_array($modelName, $excluded)) {
            $models[] = $modelName;
        }
    }

    return $models;
}

$models = getAllModels();
$metafile = fopen(__DIR__ . '/../../.phpstorm.meta.php', 'w');

/** @var string[] $functions */
$functions = array(
    "",
    // CakePHP
    "exitPoint(\CakeObject::_stop());",
    "exitPoint(\Controller::redirect());"
);


fwrite($metafile, "<?php\n");
fwrite($metafile, "/* THIS FILE IS GENERATED BY: ./utilities/PhpStorm/metaCreator.php */\n");
fwrite($metafile, "\n");
fwrite($metafile, "namespace PHPSTORM_META {\n");
foreach ($functions as $line) {
    fwrite($metafile, sprintf("    %s\n", $line));
}

// ClassRegistry init model => model
fwrite($metafile, "\n");
fwrite($metafile, "    override(\ClassRegistry::init(0),\n");
fwrite($metafile, "        map([\n");
foreach($models as $model){
    fwrite($metafile, sprintf("            '%s' => \\%s::class,\n", $model, $model));
}
fwrite($metafile, "        ])\n");
fwrite($metafile, "    );\n");

// Factory Compose model argument
fwrite($metafile, "\n");
fwrite($metafile, "    expectedArguments(\Factory::compose(),\n");
fwrite($metafile, "        0,\n");
foreach($models as $model){
    fwrite($metafile, sprintf("        '%s',\n", $model));
}
fwrite($metafile, "    );\n");

fwrite($metafile, "}\n");
fclose($metafile);
