<?php

foreach (glob(get_template_directory() . "/src/*.php") as $file) {
    include_once $file;
}

new App\Setup();
new App\Theme();